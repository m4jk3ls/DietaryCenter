<?php
session_start();

// Przekierowanie jesli pola formularza nie zostaly ustawione
if((!isset($_POST['login'])) || (!isset($_POST['passwd'])))
{
	header('Location: index.php');
	exit();
}

// Funkcja do generowania token'a
function generateToken()
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < 100; $i++)
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	return $randomString;
}

// Funkcja zdobywajaca kilka potrzebnych informacji, ktore trzeba wrzucic do bazy danych lub, ktore potem beda jakos potrzebne
function necessaryData(&$IPAddress, &$allAboutBrowser, &$browserName, &$userID, &$login, &$token, $row)
{
	$IPAddress = $_SERVER['REMOTE_ADDR'];
	// http://php.net/manual/en/function.get-browser.php PAMIETAC O PLIKU browscap.ini !!!
	$allAboutBrowser = get_browser(null, true);
	$browserName = $allAboutBrowser['browser'];
	$userID = $row['userID'];
	$login = $row['login'];
	$_SESSION['userID'] = (int)$row['userID'];
	$_SESSION['login'] = $row['login'];
	$token = generateToken();
}

// Transakcja wykonujaca sie w momencie, w ktorym nie ma aktywnej sesji usera, na konto ktorego chce sie zalogowac
function activeSessionIs($userID, $login, $IPAddress, $browserName, $token)
{
	$GLOBALS['connection']->query("START TRANSACTION");
	if($GLOBALS['connection']->query("insert into active_sessions values ('$userID', '$IPAddress', '$browserName', now(), '$token')") &&
		$GLOBALS['connection']->query("insert into archive_logs values ('$userID', '$login', '$IPAddress', '$browserName', now())")
	)
		return true;
	else
		return false;
}

// Transakcja wykonujaca sie w momencie, w ktorym jest juz aktywna sesja usera, na konto ktorego chce sie zalogowac ('zepsucie' ciasteczka)
function activeSessionIsnt($userID, $login, $IPAddress, $browserName, $token)
{
	$GLOBALS['connection']->query("START TRANSACTION");
	if($GLOBALS['connection']->query("update active_sessions set token='$token' where userID like '$userID'") &&
		$GLOBALS['connection']->query("insert into archive_logs values ('$userID', '$login', '$IPAddress', '$browserName', now())")
	)
		return true;
	else
		return false;
}

// Ustawienie ciasteczek oraz wpisanie ciut potrzebnych danych do sesji
function cookies($token, $who)
{
	switch ($who)
	{
		case "patient":
		{
			setcookie("patientLogged", true, time() + 86400);
			break;
		}
		case "dietician":
		{
			setcookie("dieticianLogged", true, time() + 86400);
			break;
		}
		case "admin":
		{
			setcookie("adminLogged", true, time() + 86400);
			break;
		}
	}
	setcookie("token", $token);
}

// Funkcja sprawdzajaca czy aby juz nie istnieje sesja uzytkownika, na konto ktorego probujemy sie zalogowac
function checkActiveSessions($userID, $login, $IPAddress, $browserName, $token)
{
	if(!$dupa = $GLOBALS['connection']->query("select * from active_sessions where userID like '$userID'"))
		return false;
	else if(!$dupa->num_rows)    // Jesli nie ma aktywnej sesji uzytkownika, na konto ktorego chce sie zalogowac...
	{
		// ...to wykonuje transakcje nr 1...
		if(activeSessionIs($userID, $login, $IPAddress, $browserName, $token))
			$GLOBALS['connection']->query("COMMIT");
		else
			return false;
	}
	// ...w przeciwnym wypadku wykonuje transakcje nr 2
	else if(activeSessionIsnt($userID, $login, $IPAddress, $browserName, $token))
		$GLOBALS['connection']->query("COMMIT");
	else
		return false;
	return true;
}

// Funkcja sprawdzajaca jaki typ uzytkownika chce sie aktualnie zalogowac
function whoIsLogging($userID, &$who)
{
	//Loguje sie pacjent, dietetyk czy moze admin?
	if(!$result1 = $GLOBALS['connection']->query("select * from user u join patient p on(p.userID = u.userID) where (p.userID = '$userID')"))
		return false;
	else if($result1->num_rows)    //Logujacym sie uzytkownikem jest pacjent
	{
		$who = "patient";
		header('Location: yourCard.php');
	}
	else if(!$result2 = $GLOBALS['connection']->query("select * from user u join dietician d on(d.userID = u.userID) where (d.userID = '$userID')"))
		return false;
	else if($result2->num_rows)    //Logujacym sie uzytkownikem jest dietetyk
	{
		$who = "dietician";
		header('Location: dieticianCard.php');
	}
	else if(!($result3 = $GLOBALS['connection']->query("select login from user where login like 'admin'")))
		return false;
	else if($result3->num_rows)    // Logujacym sie uzytkownikiem jest sam admin :D
	{
		$who = "admin";
		header('Location: adminPanel.php');
	}
	else
	{
		echo '<span style="color:red;">Twoje konto zostało przed chwilą usunięte :(</span>';
		exit();
	}
	return true;
}

function letsLogIn()
{
	global $host, $db_user, $db_password, $db_name;
	mysqli_report(MYSQLI_REPORT_STRICT);
	try
	{
		require_once "connect.php";

		// Proba polaczenia sie z baza
		$GLOBALS['connection'] = new mysqli($host, $db_user, $db_password, $db_name);
		$GLOBALS['connection']->set_charset('utf8');

		// Jesli powyzsza proba zawiedzie, to rzuc wyjatkiem
		if($GLOBALS['connection']->connect_errno != 0)
			throw new Exception($GLOBALS['connection']->connect_error);
		else
		{
			$login = $_POST['login'];
			$passwd = $_POST['passwd'];

			//Walidacja i sanityzacja loginu
			$login = htmlentities($login, ENT_QUOTES, "UTF-8");
			if($result = $GLOBALS['connection']->query(sprintf("select * from user where login='%s'", mysqli_real_escape_string($GLOBALS['connection'], $login))))
			{
				// Sprawdzenie, czy sa w bazie uzytkownicy o podanym loginie
				$howManyUsers = $result->num_rows;
				if($howManyUsers > 0)
				{
					// Czy podane haslo sie zgadza
					$row = $result->fetch_assoc();
					if(!strcmp(sha1($passwd . $row['salt']), $row['password']))
					{
						// Zebranie potrzebnych danych
						necessaryData($IPAddress, $allAboutBrowser, $browserName, $helper_userID, $helper_login, $token, $row);
						$who = "somebody";

						// Wykonanie zapytania do bazy o aktywne sesje
						if(!(checkActiveSessions($helper_userID, $helper_login, $IPAddress, $browserName, $token) &&
							whoIsLogging($helper_userID, $who))
						)
							throw new Exception($GLOBALS['connection']->error);

						//Ustawiamy ciasteczko i zwalniamy dotychczasowo uzywana pamiec
						cookies($token, $who);
						unset($_SESSION['error']);
						$result->free_result();
					}
					else
					{
						$_SESSION['error'] = "Nieprawidłowy login lub hasło!";
						header('Location: index.php');
					}
				}
				else
				{
					$_SESSION['error'] = "Nieprawidłowy login lub hasło!";
					header('Location: index.php');
				}
			}
			else
				throw new Exception($GLOBALS['connection']->error);
			$GLOBALS['connection']->close();
		}
	}
	catch (Exception $e)
	{
		$GLOBALS['connection']->query("ROLLBACK");
		header("Location: html_files/serverError_goToLogout.html");
		//echo '<br/>Informacja developerska: '.$e;
	}
}

/**************************ZABEZPIECZENIE PRZED MULTI CLICK'IEM**************************/

require_once('multiClickPrevent.php');

// Sprawdzenie, czy formularz zostal wyslany
$postedToken = filter_input(INPUT_POST, 'token');
if(!empty($postedToken))
{
	if(isTokenValid($postedToken))
		letsLogIn();
	else
	{
		header("Location: html_files/multiclickError_logIn.html");
		exit();
	}
}