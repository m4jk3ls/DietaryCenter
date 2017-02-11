<?php
	session_start();

	if(!isset($_COOKIE["zalogowany_dietetyk"]))
	{
		header('Location: index.php');
		exit();
	}
	else
	{
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		try
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			$polaczenie->set_charset('utf8');

			if ($polaczenie->connect_errno != 0)
				throw new Exception($polaczenie->connect_error);
			else
			{
				$ID_help = $_SESSION['id_uzytkownik'];
				$token_help = $_COOKIE['token'];

				if (!($rezultat = $polaczenie->query("select count(Token) from aktywne_sesje where `Numer ID` like '$ID_help' and Token like '$token_help'")))
					throw new Exception($polaczenie->error);
				if(!$rezultat->fetch_assoc()['count(Token)'])	//Jesli w bazie nie ma pasujacego do ciastka token'a (zostal zwrocony wiersz z wartoscia count(Token)=0)
				{
					if(!$polaczenie->query("delete from aktywne_sesje where `Numer ID` like '$ID_help'"))
						throw new Exception($polaczenie->error);

					$polaczenie->close();
					$rezultat->free_result();
					header('Location: logout.php');
					exit();
				}

				$rezultat->free_result();
				$polaczenie->close();
			}
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Prosimy o ponowne zalogowanie się później!</span>';
			//echo '<br/>Informacja developerska: '.$e;
			header('Location: logout.php');
			exit();
		}
	}
?>