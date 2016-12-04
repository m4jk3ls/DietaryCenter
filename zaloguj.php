<?php
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
					
					if(password_verify($haslo, $wiersz['haslo']))
					{
						$IP = $_SERVER['REMOTE_ADDR'];
						$wszystko_o_przegladarce = get_browser(null, true);
						$nazwa_i_wersja_przegladarki = $wszystko_o_przegladarce['parent'];
						
						if(!($polaczenie->query("insert into logowanie_archiwum values ('$IP', '$nazwa_i_wersja_przegladarki', now())")))
							throw new Exception($polaczenie->error);
						
						$_SESSION['zalogowany'] = true;
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
		echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
		//echo '<br/>Informacja developerska: '.$e;
	}
?>