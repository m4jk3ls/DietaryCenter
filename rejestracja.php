<?php
	session_start();

	// Przekierowanie jesli zalogowany
	if(isset($_COOKIE["zalogowany_pacjent"]))
	{
		header('Location: twoja_karta.php');
		exit();
	}
	else if(isset($_COOKIE["zalogowany_dietetyk"]))
	{
		header('Location: panel_dietetyka.php');
		exit();
	}

	// Funkcja do generowania soli
	function generateRandomString()
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < 10; $i++)
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		return $randomString;
	}

	// Walidacja imienia
	function imie()
	{
		$GLOBALS['imie'] = $_POST['imie'];
		if(strlen($GLOBALS['imie']) < 1)
		{
			$GLOBALS['wszystko_OK'] = false;
			$_SESSION['e_imie'] = "Nie podałeś swojego imienia!";
		}
		// fr - formularz logowania. Zapisuje wartosc, aby przy niepoprawnej walidacji nie wpisywac jej od nowa
		$_SESSION['fr_imie'] = $GLOBALS['imie'];
	}

	// Walidacja nazwiska
	function nazwisko()
	{
		$GLOBALS['nazwisko'] = $_POST['nazwisko'];
		if(strlen($GLOBALS['nazwisko']) < 1)
		{
			$GLOBALS['wszystko_OK'] = false;
			$_SESSION['e_nazwisko'] = "Nie podałeś swojego nazwiska!";
		}
		// fr - formularz logowania. Zapisuje wartosc, aby przy niepoprawnej walidacji nie wpisywac jej od nowa
		$_SESSION['fr_nazwisko'] = $GLOBALS['nazwisko'];
	}

	//Walidacja loginu
	function login()
	{
		$GLOBALS['login'] = $_POST['login'];
		if((strlen($GLOBALS['login']) < 3 ) || (strlen($GLOBALS['login']) > 20))
		{
			$GLOBALS['wszystko_OK'] = false;
			$_SESSION['e_login'] = "Login musi posiadać od 3 do 20 znaków!";
		}
		if(!ctype_alnum($GLOBALS['login']))
		{
			$GLOBALS['wszystko_OK'] = false;
			$_SESSION['e_login'] = "Login może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
		// fr - formularz logowania. Zapisuje wartosc, aby przy niepoprawnej walidacji nie wpisywac jej od nowa
		$_SESSION['fr_login'] = $GLOBALS['login'];
	}

	//Walidacja i sanityzacja email'a
	function email()
	{
		$GLOBALS['email'] = $_POST['email'];
		$emailB = filter_var($GLOBALS['email'], FILTER_SANITIZE_EMAIL);
		if(!filter_var($emailB, FILTER_VALIDATE_EMAIL) || ($emailB != $GLOBALS['email']))
		{
			$GLOBALS['wszystko_OK'] = false;
			$_SESSION['e_email'] = "Podaj poprawny adres email!";
		}
		// fr - formularz logowania. Zapisuje wartosc, aby przy niepoprawnej walidacji nie wpisywac jej od nowa
		$_SESSION['fr_email'] = $GLOBALS['email'];
	}

	//Walidacja hasel
	function hasla()
	{
		$GLOBALS['haslo1'] = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		if(strlen($GLOBALS['haslo1']) < 8 || strlen($GLOBALS['haslo1']) > 20)
		{
			$GLOBALS['wszystko_OK'] = false;
			$_SESSION['e_haslo'] = "Hasło musi posiadać od 8 do 20 znaków!";
		}
		if($GLOBALS['haslo1'] != $haslo2)
		{
			$GLOBALS['wszystko_OK'] = false;
			$_SESSION['e_haslo'] = "Podane hasła nie są identyczne!";
		}
		// fr - formularz logowania. Zapisuje wartosci, aby przy niepoprawnej walidacji nie wpisywac ich od nowa
		$_SESSION['fr_haslo1'] = $GLOBALS['haslo1'];
		$_SESSION['fr_haslo2'] = $haslo2;
	}

	// Sprawdzanie liczby tozsamych adresow email z podanym w formularzu
	function ile_takich_maili($rezultat)
	{
		$ile = $rezultat->num_rows;
		if ($ile > 0)
		{
			$GLOBALS['wszystko_OK'] = false;
			$_SESSION['e_email'] = "Istnieje już użytkownik o takim adresie email!";
		}
	}

	// Sprawdzanie liczby tozsamych loginow z podanym w formularzu
	function ile_takich_loginow($rezultat)
	{
		$ile = $rezultat->num_rows;
		if ($ile > 0)
		{
			$GLOBALS['wszystko_OK'] = false;
			$_SESSION['e_login'] = "Istnieje już użytkownik o takim loginie! Wybierz inny.";
		}
	}

	// Transakcja, ktora ostatecznie wprowadza dane nowego uzytkownika-pacjenta do bazy
	function wykonaj_transakcje($haslo_hash, $salt)
	{
		global $imie, $nazwisko, $login, $email;

		$GLOBALS['polaczenie']->query("START TRANSACTION");
		if ($GLOBALS['polaczenie']->query("insert into uzytkownik values (null, '$imie', '$nazwisko', '$email', '$login', '$haslo_hash', '$salt')") &&
			$GLOBALS['polaczenie']->query("insert into pacjent VALUES (null, LAST_INSERT_ID())"))
			return true;
		else
			return false;
	}

	// Glowna funkcja, obslugujaca polaczenie z baza danych
	function polaczenie_z_baza()
	{
		global $login, $email, $haslo1, $host, $db_user, $db_password, $db_name;

		if($GLOBALS['wszystko_OK'])
		{
			require_once "connect.php";
			mysqli_report(MYSQLI_REPORT_STRICT);
			try
			{
				// Proba polaczenia sie z baza
				$GLOBALS['polaczenie'] = new mysqli($host, $db_user, $db_password, $db_name);
				$GLOBALS['polaczenie']->set_charset('utf8');

				// Jesli powyzsza proba zawiedzie, to rzuc wyjatkiem
				if ($GLOBALS['polaczenie']->connect_errno != 0)
					throw new Exception($GLOBALS['polaczenie']->connect_error);
				else
				{
					// Poszukaj, czy w bazie istnieje juz podany adres email
					$rezultat = $GLOBALS['polaczenie']->query("select p.id_pacjent from pacjent p join uzytkownik u on (p.id_uzytkownik = u.id_uzytkownik) where u.email = '$email'");
					if (!$rezultat) throw new Exception($GLOBALS['polaczenie']->error);
					ile_takich_maili($rezultat);

					// Poszukaj, czy w bazie istnieje juz podany login
					$rezultat = $GLOBALS['polaczenie']->query("select id_uzytkownik from uzytkownik where login = '$login'");
					if (!$rezultat) throw new Exception($GLOBALS['polaczenie']->error);
					ile_takich_loginow($rezultat);

					//Jesli do tej pory wszystko przebieglo pomyslnie...
					if ($GLOBALS['wszystko_OK'])
					{
						try
						{
							// ...to wygeneruj sol, hash'uj haslo i wprowadz dane do bazy za pomoca transakcji
							$salt = generateRandomString();
							$haslo_hash = sha1($haslo1.$salt);
							if(wykonaj_transakcje($haslo_hash, $salt))
								$GLOBALS['polaczenie']->query("COMMIT");
							else
								throw new Exception($GLOBALS['polaczenie']->error);

							// Ustaw prawdziwosc zmiennej 'udana_rejestracja' i prowadz do strony powitalnej
							$_SESSION['udana_rejestracja'] = true;
							header('Location: witamy.php');
						}
						catch (Exception $e)
						{
							$GLOBALS['polaczenie']->query("ROLLBACK");
							echo '<span style="color:red;">Błąd serwera! Prosimy o rejestrację w innym terminie!</span>';
							//echo '<br/>Informacja developerska: '.$e;
						}
					}
					$GLOBALS['polaczenie']->close();
				}
			}
			catch (Exception $e)
			{
				echo '<span style="color:red;">Błąd serwera! Prosimy o rejestrację w innym terminie!</span>';
				//echo '<br/>Informacja developerska: '.$e;
			}
		}
	}

	// Glowna funkcja walidacyjna (uruchamia walidacje wszystkich pol)
	function walidacja()
	{
		imie();
		nazwisko();
		login();
		email();
		hasla();
		polaczenie_z_baza();
	}

	// Walidacja uruchomi sie, jezeli cokolwiek zostalo przeslane do formularza (nawet puste pole), np. email
	if(isset($_POST['email']))
	{
		$GLOBALS['wszystko_OK'] = true;
		walidacja();
	}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>Załóż darmowe NH-konto!</title>
	<link rel="stylesheet" href="css_files/rejestracja_style.css" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Great+Vibes|Playfair+Display:400,700&amp;subset=latin-ext" rel="stylesheet">
	<script src="javascript_files/jquery-3.1.1.min.js"></script>
	<script src="javascript_files/getDivsSizes.js"></script>
	<script src="javascript_files/ajaxForName.js"></script>
	<script src="javascript_files/ajaxForSurname.js"></script>
	<script src="javascript_files/ajaxForLogin_rej.js"></script>
	<script src="javascript_files/ajaxForEmail.js"></script>
	<script src="javascript_files/ajaxForPass_rej.js"></script>
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
	<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
	<script src="javascript_files/cookiesBanner.js"></script>
	<noscript><div id="noscript_info">Twoja przeglądarka nie obsługuje skryptów JavaScript!</div></noscript>
</head>

<body>
	<div id="header">Rejestrujemy się!</div>

	<div id="sign_form">
		<form method="post">
			<input type="text" id="imie_id" name="imie" placeholder="imię" value="<?php									//Imie
				if(isset($_SESSION['fr_imie']))
				{
					echo $_SESSION['fr_imie'];
					unset($_SESSION['fr_imie']);
				}
			?>"/>
			<div class="komunikat" id="komunikat1"></div>
			<?php
				if(isset($_SESSION['e_imie']))
				{
					echo '<div class="glowny_komunikat">'.$_SESSION['e_imie'].'</div>';
					unset($_SESSION['e_imie']);
				}
			?>

			<input type="text" id="nazwisko_id" name="nazwisko" placeholder="nazwisko" value="<?php						//Nazwisko
				if(isset($_SESSION['fr_nazwisko']))
				{
					echo $_SESSION['fr_nazwisko'];
					unset($_SESSION['fr_nazwisko']);
				}
			?>"/>
			<div class="komunikat" id="komunikat2"></div>
			<?php
				if(isset($_SESSION['e_nazwisko']))
				{
					echo '<div class="glowny_komunikat">'.$_SESSION['e_nazwisko'].'</div>';
					unset($_SESSION['e_nazwisko']);
				}
			?>

			<input type="text" id="login_id" name="login" placeholder="login" value="<?php								//Login
				if(isset($_SESSION['fr_login']))
				{
					echo $_SESSION['fr_login'];
					unset($_SESSION['fr_login']);
				}
			?>"/>
			<div class="komunikat" id="komunikat3"></div>
			<?php
				if(isset($_SESSION['e_login']))
				{
					echo '<div class="glowny_komunikat">'.$_SESSION['e_login'].'</div>';
					unset($_SESSION['e_login']);
				}
			?>

			<input type="text" id="email_id" name="email" placeholder="e-mail" value="<?php								//E-mail
				if(isset($_SESSION['fr_email']))
				{
					echo $_SESSION['fr_email'];
					unset($_SESSION['fr_email']);
				}
			?>"/>
			<div class="komunikat" id="komunikat4"></div>
			<?php
				if(isset($_SESSION['e_email']))
				{
					echo '<div class="glowny_komunikat">'.$_SESSION['e_email'].'</div>';
					unset($_SESSION['e_email']);
				}
			?>

			<input type="password" id="passwd1" name="haslo1" placeholder="hasło" value="<?php							//Haslo
				if(isset($_SESSION['fr_haslo1']))
				{
					echo $_SESSION['fr_haslo1'];
					unset($_SESSION['fr_haslo1']);
				}
			?>"/>

			<input type="password" id="passwd2" name="haslo2" placeholder="powtórz hasło" value="<?php					//Powtorz haslo
				if(isset($_SESSION['fr_haslo2']))
				{
					echo $_SESSION['fr_haslo2'];
					unset($_SESSION['fr_haslo2']);
				}
			?>"/>
			<div class="komunikat" id="komunikat5"></div>
			<?php
				if(isset($_SESSION['e_haslo']))
				{
					echo '<div class="glowny_komunikat">'.$_SESSION['e_haslo'].'</div>';
					unset($_SESSION['e_haslo']);
				}
			?>

			<input type="submit" value="Zarejestruj się"/>
		</form>

		<div id="txt_lub">-------- lub --------</div>
		<div id="link_logowania"><a href="index.php">Wróć do strony logowania!</a></div>
	</div>
</body>
</html>