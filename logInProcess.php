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
function necessaryData(&$IPAddress, &$allAboutBrowser, &$browserName, &$helper_userID, &$helper_login, &$token, $row)
{
	$IPAddress = $_SERVER['REMOTE_ADDR'];
	// http://php.net/manual/en/function.get-browser.php PAMIETAC O PLIKU browscap.ini !!!
	$allAboutBrowser = get_browser(null, true);
	$browserName = $allAboutBrowser['browser'];
	$helper_userID = $row['userID'];
	$helper_login = $row['login'];
	$_SESSION['userID'] = $row['userID'];
	$_SESSION['login'] = $row['login'];
	$token = generateToken();
}

// Transakcja wykonujaca sie w momencie, w ktorym nie ma aktywnej sesji usera, na konto ktorego chce sie zalogowac
function activeSessionIs($helper_userID, $helper_login, $IPAddress, $browserName, $token)
{
	$GLOBALS['connection']->query("START TRANSACTION");
	if($GLOBALS['connection']->query("insert into active_sessions values ('$helper_userID', '$IPAddress', '$browserName', now(), '$token')") &&
		$GLOBALS['connection']->query("insert into archive_logs values ('$helper_userID', '$helper_login', '$IPAddress', '$browserName', now())")
	)
		return true;
	else
		return false;
}

// Transakcja wykonujaca sie w momencie, w ktorym jest juz aktywna sesja usera, na konto ktorego chce sie zalogowac ('zepsucie' ciasteczka)
function activeSessionIsnt($helper_userID, $helper_login, $IPAddress, $browserName, $token)
{
	$GLOBALS['connection']->query("START TRANSACTION");
	if($GLOBALS['connection']->query("update active_sessions set token='$token' where userID like '$helper_userID'") &&
		$GLOBALS['connection']->query("insert into archive_logs values ('$helper_userID', '$helper_login', '$IPAddress', '$browserName', now())")
	)
		return true;
	else
		return false;
}

// Ustawienie ciasteczek oraz wpisanie ciut potrzebnych danych do sesji
function cookies($token, $who)
{
	if($who == "patient")
		setcookie("patientLogged", true, time() + 86400);
	else
		setcookie("dieticianLogged", true, time() + 86400);
	setcookie("token", $token);
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
						// Zebranie potrzebnych danych oraz wykonanie zapytania do bazy o aktywne_sesje
						necessaryData($IPAddress, $allAboutBrowser, $browserName, $helper_userID, $helper_login, $token, $row);
						if(!($result2 = $GLOBALS['connection']->query("select * from active_sessions where userID like '$helper_userID'")))
							throw new Exception($GLOBALS['connection']->error);


						// Jesli nie ma aktywnej sesji uzytkownika, na konto ktorego chce sie zalogowac...
						if(!$result2->num_rows)
						{
							// ...to wykonuje transakcje nr 1...
							if(activeSessionIs($helper_userID, $helper_login, $IPAddress, $browserName, $token))
								$GLOBALS['connection']->query("COMMIT");
							else
								throw new Exception($GLOBALS['connection']->error);
						}
						// ...w przeciwnym wypadku wykonuje transakcje nr 2
						else if(activeSessionIsnt($helper_userID, $helper_login, $IPAddress, $browserName, $token))
							$GLOBALS['connection']->query("COMMIT");
						else
							throw new Exception($GLOBALS['connection']->error);


						//Loguje sie pacjent, czy dietetyk?
						if(!$result3 = $GLOBALS['connection']->query("select * from user u join patient p on(p.userID = u.userID) where (p.userID = '$helper_userID')"))
							throw new Exception($GLOBALS['connection']->error);
						else if($result3->num_rows)    //Logujacym sie uzytkownikem jest pacjent
						{
							$who = "patient";
							header('Location: yourCard.php');
						}
						else if(!$result4 = $GLOBALS['connection']->query("select * from user u join dietician d on(d.userID = u.userID) where (d.userID = '$helper_userID')"))
							throw new Exception($GLOBALS['connection']->error);
						else if($result4->num_rows)    //Logujacym sie uzytkownikem jest dietetyk
						{
							$who = "dietician";
							header('Location: dieticianCard.php');
						}
						else
						{
							echo '<span style="color:red;">Twoje konto zostało przed chwilą usunięte :(</span>';
							exit();
						}


						//Ustawiamy ciasteczko i zwalniamy dotychczasowo uzywana pamiec
						cookies($token, $who);
						unset($_SESSION['error']);
						$result->free_result();
						$result2->free_result();
						$result3->free_result();
						if(isset($result4))
							$result4->free_result();
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