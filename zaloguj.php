<?php
	session_start();

	// Przekierowanie jesli pola formularza nie zostaly ustawione
	if((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
	{
		header('Location: index.php');
		exit();
	}

	// Funkcja do generowania token'a
	function generateRandomString()
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < 100; $i++)
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		return $randomString;
	}

	// Funkcja zdobywajaca kilka potrzebnych informacji, ktore trzeba wrzucic do bazy danych
	function potrzebneDane(&$IP, &$wszystko_o_przegladarce, &$nazwa_i_wersja_przegladarki, &$ID_help, &$login_help, &$token, $wiersz)
	{
		$IP = $_SERVER['REMOTE_ADDR'];
		$wszystko_o_przegladarce = get_browser(null, true);	//http://php.net/manual/en/function.get-browser.php PAMIETAC O PLIKU browscap.ini !!!
		$nazwa_i_wersja_przegladarki = $wszystko_o_przegladarce['parent'];
		$ID_help = $wiersz['id_uzytkownik'];
		$login_help = $wiersz['login'];
		$token = generateRandomString();
	}

	// Transakcja wykonujaca sie w momencie, w ktorym nie ma aktywnej sesji usera, na konto ktorego chce sie zalogowac
	function transakcja1($ID_help, $login_help, $IP, $nazwa_i_wersja_przegladarki, $token)
	{
		$GLOBALS['polaczenie']->query("START TRANSACTION");

		if ($GLOBALS['polaczenie']->query("insert into aktywne_sesje values ('$ID_help', '$login_help', '$IP', '$nazwa_i_wersja_przegladarki', now(), '$token')") &&
			$GLOBALS['polaczenie']->query("insert into logowanie_archiwum values ('$ID_help', '$login_help', '$IP', '$nazwa_i_wersja_przegladarki', now())"))
			return true;
		else
			return false;
	}

	// Transakcja wykonujaca sie w momencie, w ktorym jest juz aktywna sesja usera, na konto ktorego chce sie zalogowac ('zepsucie' ciasteczka)
	function transakcja2($ID_help, $login_help, $IP, $nazwa_i_wersja_przegladarki, $token)
	{
		$GLOBALS['polaczenie']->query("START TRANSACTION");

		if ($GLOBALS['polaczenie']->query("update aktywne_sesje set Token='$token' where Login like '$login_help'") &&
			$GLOBALS['polaczenie']->query("insert into logowanie_archiwum values ('$ID_help', '$login_help', '$IP', '$nazwa_i_wersja_przegladarki', now())"))
			return true;
		else
			return false;
	}

	// Ustawienie ciasteczek oraz wpisanie ciut potrzebnych danych do sesji
	function cookies($token, $wiersz)
	{
		setcookie("zalogowany", true, time() + 86400);
		setcookie("token", $token);

		$_SESSION['id_uzytkownik'] = $wiersz['id_uzytkownik'];
		$_SESSION['login'] = $wiersz['login'];
		unset($_SESSION['blad']);
	}

	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);
	try
	{
		// Proba polaczenia sie z baza
		$GLOBALS['polaczenie'] = new mysqli($host, $db_user, $db_password, $db_name);
		$GLOBALS['polaczenie']->set_charset('utf8');

		// Jesli powyzsza proba zawiedzie, to rzuc wyjatkiem
		if($GLOBALS['polaczenie']->connect_errno != 0)
			throw new Exception($GLOBALS['polaczenie']->connect_error);
		else
		{
			$login = $_POST['login'];
			$haslo = $_POST['haslo'];
			
			//Walidacja i sanityzacja loginu
			$login = htmlentities($login, ENT_QUOTES, "UTF-8");
			if($rezultat = $GLOBALS['polaczenie']->query(sprintf("select * from uzytkownik where login='%s'", mysqli_real_escape_string($GLOBALS['polaczenie'], $login))))
			{
				// Sprawdzenie, czy sa w bazie uzytkownicy o podanym loginie
				$ilu_userow = $rezultat->num_rows;
				if($ilu_userow > 0)
				{
					// Czy podane haslo sie zgadza
					$wiersz = $rezultat->fetch_assoc();
					if(!strcmp(sha1($haslo.$wiersz['salt']), $wiersz['haslo']))
					{
						// Zebranie potrzebnych danych oraz wykonanie zapytania do bazy o aktywne_sesje
						potrzebneDane($IP, $wszystko_o_przegladarce, $nazwa_i_wersja_przegladarki, $ID_help, $login_help, $token, $wiersz);
						if(!($rezultat2 = $GLOBALS['polaczenie']->query("select * from aktywne_sesje where Login='$login_help'")))
							throw new Exception($GLOBALS['polaczenie']->error);



						// Jesli nie ma aktywnej sesji uzytkownika, na konto ktorego chce sie zalogowac...
						if(!$rezultat2->num_rows)
						{
							// ...to wykonuje transakcje nr 1...
							if(transakcja1($ID_help, $login_help, $IP, $nazwa_i_wersja_przegladarki, $token))
								$GLOBALS['polaczenie']->query("COMMIT");
							else
								throw new Exception($GLOBALS['polaczenie']->error);
						}
						// ...w przeciwnym wypadku wykonuje transakcje nr 2
						else if(transakcja2($ID_help, $login_help, $IP, $nazwa_i_wersja_przegladarki, $token))
							$GLOBALS['polaczenie']->query("COMMIT");
						else
							throw new Exception($GLOBALS['polaczenie']->error);



						// Ustawienie ciasteczek, uwolnienie pamieci oraz przekierowanie
						cookies($token, $wiersz);
						$rezultat->free_result();
						$rezultat2->free_result();
						header('Location: twoja_karta.php');
					}
					else
					{
						$_SESSION['blad'] = "Nieprawidłowy login lub hasło!";
						header('Location: index.php');
					}
				}
				else
				{
					$_SESSION['blad'] = "Nieprawidłowy login lub hasło!";
					header('Location: index.php');
				}
			}
			else
				throw new Exception($GLOBALS['polaczenie']->error);
			$GLOBALS['polaczenie']->close();
		}
	}
	catch(Exception $e)
	{
		$GLOBALS['polaczenie']->query("ROLLBACK");
		echo '<span style="color:red;">Błąd serwera! Prosimy zalogować się ponownie później!</span>';
		//echo '<br/>Informacja developerska: '.$e;
	}
?>