<?php
	function generateRandomString()
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < 100; $i++)
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		return $randomString;
	}

	session_start();

	if((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
	{
		header('Location: index.php');
		exit();
	}
	
	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);
	try
	{
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		$polaczenie->set_charset('utf8');
		
		if($polaczenie->connect_errno != 0)
			throw new Exception($polaczenie->connect_error);
		else
		{
			$login = $_POST['login'];
			$haslo = $_POST['haslo'];
			
			$login = htmlentities($login, ENT_QUOTES, "UTF-8");
			
			if($rezultat = $polaczenie->query(
			sprintf("select * from uzytkownik where login='%s'",
			mysqli_real_escape_string($polaczenie, $login))))
			{
				$ilu_userow = $rezultat->num_rows;
				if($ilu_userow > 0)
				{
					$wiersz = $rezultat->fetch_assoc();
					
					if(!strcmp(sha1($haslo.$wiersz['salt']), $wiersz['haslo']))
					//if(password_verify($haslo, $wiersz['haslo']))	//Po Zelentowemu
					{
						$IP = $_SERVER['REMOTE_ADDR'];
						$wszystko_o_przegladarce = get_browser(null, true);	//http://php.net/manual/en/function.get-browser.php PAMIETAC O PLIKU browscap.ini !!!
						$nazwa_i_wersja_przegladarki = $wszystko_o_przegladarce['parent'];
						$ID_help = $wiersz['id_uzytkownik'];
						$login_help = $wiersz['login'];

						$token = generateRandomString();


						$polaczenie->query("START TRANSACTION");

						if($polaczenie->query("insert into logowanie_archiwum values ('$ID_help', '$login_help', '$IP', '$nazwa_i_wersja_przegladarki', now())") &&
							$polaczenie->query("update uzytkownik set token='$token' WHERE login='$login_help'"))
							$polaczenie->query("COMMIT");
						else
							throw new Exception($polaczenie->error);


						setcookie("zalogowany", true, time() + 86400);
						setcookie("token", $token);


						$_SESSION['id_uzytkownik'] = $wiersz['id_uzytkownik'];
						$_SESSION['login'] = $wiersz['login'];
						

						unset($_SESSION['blad']);
						$rezultat->free_result();
						header('Location: twoja_karta.php');
					}
					else
					{
						$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
						header('Location: index.php');
					}
				}
				else
				{
					$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
					header('Location: index.php');
				}
			}
			else
				throw new Exception($polaczenie->error);
			$polaczenie->close();
		}
	}
	catch(Exception $e)
	{
		$polaczenie->query("ROLLBACK");
		echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
		//echo '<br/>Informacja developerska: '.$e;
	}
?>