<?php
session_start();

// Przekierowanie jesli zalogowany
if(isset($_COOKIE["patientLogged"]))
{
	header('Location: yourCard.php');
	exit();
}
else if(isset($_COOKIE["dieticianLogged"]))
{
	header('Location: dieticianCard.php');
	exit();
}

// Funkcja do generowania soli
function generateSalt()
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < 10; $i++)
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	return $randomString;
}

// Walidacja imienia
function firstName()
{
	$GLOBALS['firstName'] = $_POST['firstName'];
	if(strlen($GLOBALS['firstName']) < 1)
	{
		$GLOBALS['everythingOK'] = false;
		$_SESSION['firstNameError'] = "Nie podałeś swojego imienia!";
	}
	// Zapisuje wartosc, aby przy niepoprawnej walidacji nie wpisywac jej od nowa
	$_SESSION['firstNameSaved'] = $GLOBALS['firstName'];
}

// Walidacja nazwiska
function lastName()
{
	$GLOBALS['lastName'] = $_POST['lastName'];
	if(strlen($GLOBALS['lastName']) < 1)
	{
		$GLOBALS['everythingOK'] = false;
		$_SESSION['lastNameError'] = "Nie podałeś swojego nazwiska!";
	}
	// Zapisuje wartosc, aby przy niepoprawnej walidacji nie wpisywac jej od nowa
	$_SESSION['lastNameSaved'] = $GLOBALS['lastName'];
}

//Walidacja loginu
function login()
{
	$GLOBALS['login'] = $_POST['login'];
	if((strlen($GLOBALS['login']) < 3) || (strlen($GLOBALS['login']) > 20))
	{
		$GLOBALS['everythingOK'] = false;
		$_SESSION['loginError'] = "Login musi posiadać od 3 do 20 znaków!";
	}
	if(!ctype_alnum($GLOBALS['login']))
	{
		$GLOBALS['everythingOK'] = false;
		$_SESSION['loginError'] = "Login może składać się tylko z liter i cyfr (bez polskich znaków)";
	}
	// Zapisuje wartosc, aby przy niepoprawnej walidacji nie wpisywac jej od nowa
	$_SESSION['loginSaved'] = $GLOBALS['login'];
}

//Walidacja i sanityzacja email'a
function email()
{
	$GLOBALS['email'] = $_POST['email'];
	$emailB = filter_var($GLOBALS['email'], FILTER_SANITIZE_EMAIL);
	if(!filter_var($emailB, FILTER_VALIDATE_EMAIL) || ($emailB != $GLOBALS['email']))
	{
		$GLOBALS['everythingOK'] = false;
		$_SESSION['emailError'] = "Podaj poprawny adres email!";
	}
	// Zapisuje wartosc, aby przy niepoprawnej walidacji nie wpisywac jej od nowa
	$_SESSION['emailSaved'] = $GLOBALS['email'];
}

//Walidacja hasel
function passwds()
{
	$GLOBALS['passwd1'] = $_POST['passwd1'];
	$passwd2 = $_POST['passwd2'];
	if(strlen($GLOBALS['passwd1']) < 8 || strlen($GLOBALS['passwd1']) > 20)
	{
		$GLOBALS['everythingOK'] = false;
		$_SESSION['passwdError'] = "Hasło musi posiadać od 8 do 20 znaków!";
	}
	if($GLOBALS['passwd1'] != $passwd2)
	{
		$GLOBALS['everythingOK'] = false;
		$_SESSION['passwdError'] = "Podane hasła nie są identyczne!";
	}
	// Zapisuje wartosci, aby przy niepoprawnej walidacji nie wpisywac ich od nowa
	$_SESSION['passwd1Saved'] = $GLOBALS['passwd1'];
	$_SESSION['passwd2Saved'] = $passwd2;
}

// Sprawdzanie liczby tozsamych adresow email z podanym w formularzu
function howManyEmails($result)
{
	$howMany = $result->num_rows;
	if($howMany > 0)
	{
		$GLOBALS['everythingOK'] = false;
		$_SESSION['emailError'] = "Istnieje już użytkownik o takim adresie email!";
	}
}

// Sprawdzanie liczby tozsamych loginow z podanym w formularzu
function howManyLogins($result)
{
	$howMany = $result->num_rows;
	if($howMany > 0)
	{
		$GLOBALS['everythingOK'] = false;
		$_SESSION['loginError'] = "Istnieje już użytkownik o takim loginie! Wybierz inny.";
	}
}

// Transakcja, ktora ostatecznie wprowadza dane nowego uzytkownika-pacjenta do bazy
function saveNewUser($passwdHash, $salt)
{
	global $firstName, $lastName, $login, $email;

	$GLOBALS['connection']->query("START TRANSACTION");
	if($GLOBALS['connection']->query("insert into user values (null, '$firstName', '$lastName', '$email', '$login', '$passwdHash', '$salt')") &&
		$GLOBALS['connection']->query("insert into patient values (null, LAST_INSERT_ID())")
	)
		return true;
	else
		return false;
}

// Glowna funkcja, obslugujaca polaczenie z baza danych
function dbConnection()
{
	global $login, $email, $passwd1, $host, $db_user, $db_password, $db_name;

	if($GLOBALS['everythingOK'])
	{
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		try
		{
			// Proba polaczenia sie z baza
			$GLOBALS['connection'] = new mysqli($host, $db_user, $db_password, $db_name);
			$GLOBALS['connection']->set_charset('utf8');

			// Jesli powyzsza proba zawiedzie, to rzuc wyjatkiem
			if($GLOBALS['connection']->connect_errno != 0)
				throw new Exception($GLOBALS['connection']->connect_error);
			else
			{
				// Poszukaj, czy w bazie istnieje juz podany adres email
				$result = $GLOBALS['connection']->query("select p.patientID from patient p join user u on (p.userID = u.userID) where u.email = '$email'");
				if(!$result) throw new Exception($GLOBALS['connection']->error);
				howManyEmails($result);

				// Poszukaj, czy w bazie istnieje juz podany login
				$result = $GLOBALS['connection']->query("select userID from user where login = '$login'");
				if(!$result) throw new Exception($GLOBALS['connection']->error);
				howManyLogins($result);

				//Jesli do tej pory wszystko przebieglo pomyslnie...
				if($GLOBALS['everythingOK'])
				{
					try
					{
						// ...to wygeneruj sol, hash'uj haslo i wprowadz dane do bazy za pomoca transakcji
						$salt = generateSalt();
						$passwdHash = sha1($passwd1 . $salt);
						if(saveNewUser($passwdHash, $salt))
							$GLOBALS['connection']->query("COMMIT");
						else
							throw new Exception($GLOBALS['connection']->error);

						// Ustaw prawdziwosc zmiennej 'udana_rejestracja' i prowadz do strony powitalnej
						$_SESSION['registrationIsOK'] = true;
						header('Location: welcome.php');
					}
					catch (Exception $e)
					{
						$GLOBALS['connection']->query("ROLLBACK");
						header("Location: html_files/serverError_goToIndex.html");
						//echo '<br/>Informacja developerska: '.$e;
					}
				}
				$GLOBALS['connection']->close();
			}
		}
		catch (Exception $e)
		{
			header("Location: html_files/serverError_goToIndex.html");
			//echo '<br/>Informacja developerska: '.$e;
		}
	}
}

// Glowna funkcja walidacyjna (uruchamia walidacje wszystkich pol)
function validation()
{
	firstName();
	lastName();
	login();
	email();
	passwds();
	dbConnection();
}

/**************************ZABEZPIECZENIE PRZED MULTI CLICK'IEM**************************/

// Funkcja generujaca token, ktory jest uzywany w formularzu
function getToken()
{
	$token = sha1(mt_rand());
	if(!isset($_SESSION['tokensPreventMulticlickInSignIn']))
		$_SESSION['tokensPreventMulticlickInSignIn'] = array($token => 1);
	else
		$_SESSION['tokensPreventMulticlickInSignIn'][$token] = 1;
	return $token;
}

// Sprawdzanie poprawnosci tokenu oraz usuwanie go z listy poprawnych token'ow
function isTokenValid($token)
{
	if(!empty($_SESSION['tokensPreventMulticlickInSignIn'][$token]))
	{
		unset($_SESSION['tokensPreventMulticlickInSignIn'][$token]);
		return true;
	}
	return false;
}

// Sprawdzenie, czy formularz zostal wyslany
$postedToken = filter_input(INPUT_POST, 'token');
if(!empty($postedToken))
{
	if(isTokenValid($postedToken))
	{
		// Wszystko w porzadku, mozna przystapic do walidacji
		$GLOBALS['everythingOK'] = true;
		validation();
	}
	else
	{
		$helper_login = $_POST['login'];
		if(strlen($helper_login) >= 3 && strlen($helper_login) <= 20 && ctype_alnum($helper_login))
			$_SESSION['login'] = $helper_login;
		header("Location: multiclickError_signIn.php");
		exit();
	}
}

$token = getToken();
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>Załóż darmowe NH-konto!</title>
	<link rel="stylesheet" href="css_files/signIn.css" type="text/css"/>
	<link href="https://fonts.googleapis.com/css?family=Great+Vibes|Playfair+Display:400,700&amp;subset=latin-ext"
		  rel="stylesheet">
	<script src="javascript_files/jquery-3.1.1.min.js"></script>
	<script src="javascript_files/getDivsSizes.js"></script>
	<script src="javascript_files/ajax/firstName.js"></script>
	<script src="javascript_files/ajax/lastName.js"></script>
	<script src="javascript_files/ajax/signIn_login.js"></script>
	<script src="javascript_files/ajax/email.js"></script>
	<script src="javascript_files/ajax/signIn_passwords.js"></script>
	<link rel="stylesheet" type="text/css"
		  href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css"/>
	<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
	<script src="javascript_files/cookiesBanner.js"></script>
	<noscript><div id="infoAboutNoScript">Twoja przeglądarka nie obsługuje skryptów JavaScript!</div></noscript>
</head>

<body>
<div id="headline">Rejestrujemy się!</div>
<div id="signInForm">
	<form method="post">
		<!--Imie-->
		<input type="text" id="firstNameID" name="firstName" placeholder="imię" value="<?php
		if(isset($_SESSION['firstNameSaved']))
		{
			echo $_SESSION['firstNameSaved'];
			unset($_SESSION['firstNameSaved']);
		}
		?>"/>
		<div class="errorFromAjax" id="firstNameError"></div>
		<?php
		if(isset($_SESSION['firstNameError']))
		{
			echo '<div class="errorAfterSubmit" id="firstName_errorAfterSubmit">' . $_SESSION['firstNameError'] . '</div>';
			unset($_SESSION['firstNameError']);
		}
		?>


		<!--Nazwisko-->
		<input type="text" id="lastNameID" name="lastName" placeholder="nazwisko" value="<?php
		if(isset($_SESSION['lastNameSaved']))
		{
			echo $_SESSION['lastNameSaved'];
			unset($_SESSION['lastNameSaved']);
		}
		?>"/>
		<div class="errorFromAjax" id="lastNameError"></div>
		<?php
		if(isset($_SESSION['lastNameError']))
		{
			echo '<div class="errorAfterSubmit" id="lastName_errorAfterSubmit">' . $_SESSION['lastNameError'] . '</div>';
			unset($_SESSION['lastNameError']);
		}
		?>


		<!--Login-->
		<input type="text" id="loginID" name="login" placeholder="login" value="<?php
		if(isset($_SESSION['loginSaved']))
		{
			echo $_SESSION['loginSaved'];
			unset($_SESSION['loginSaved']);
		}
		?>"/>
		<div class="errorFromAjax" id="loginError"></div>
		<?php
		if(isset($_SESSION['loginError']))
		{
			echo '<div class="errorAfterSubmit" id="login_errorAfterSubmit">' . $_SESSION['loginError'] . '</div>';
			unset($_SESSION['loginError']);
		}
		?>


		<!--Email-->
		<input type="text" id="emailID" name="email" placeholder="e-mail" value="<?php
		if(isset($_SESSION['emailSaved']))
		{
			echo $_SESSION['emailSaved'];
			unset($_SESSION['emailSaved']);
		}
		?>"/>
		<div class="errorFromAjax" id="emailError"></div>
		<?php
		if(isset($_SESSION['emailError']))
		{
			echo '<div class="errorAfterSubmit" id="email_errorAfterSubmit">' . $_SESSION['emailError'] . '</div>';
			unset($_SESSION['emailError']);
		}
		?>


		<!--Haslo-->
		<input type="password" id="passwd1ID" name="passwd1" placeholder="hasło" value="<?php
		if(isset($_SESSION['passwd1Saved']))
		{
			echo $_SESSION['passwd1Saved'];
			unset($_SESSION['passwd1Saved']);
		}
		?>"/>


		<!--Powtorzone haslo-->
		<input type="password" id="passwd2ID" name="passwd2" placeholder="powtórz hasło" value="<?php
		if(isset($_SESSION['passwd2Saved']))
		{
			echo $_SESSION['passwd2Saved'];
			unset($_SESSION['passwd2Saved']);
		}
		?>"/>
		<div class="errorFromAjax" id="passwdError"></div>
		<?php
		if(isset($_SESSION['passwdError']))
		{
			echo '<div class="errorAfterSubmit" id="passwd_errorAfterSubmit">' . $_SESSION['passwdError'] . '</div>';
			unset($_SESSION['passwdError']);
		}
		?>


		<!--Submit zatwierdzajacy-->
		<input type="submit" value="Zarejestruj się"
			   onclick="this.disabled=true; this.value='Wczytuję...'; this.form.submit();"/>


		<!--Input przechowujacy token, ktory zapobiega multiclick'owi-->
		<input type="hidden" name="token" value="<?php echo $token;?>"/>
	</form>
	<div id="alternative">-------- lub --------</div>
	<div id="linkToLogIn"><a href="index.php">Wróć do strony logowania!</a></div>
</div>
</body>
</html>