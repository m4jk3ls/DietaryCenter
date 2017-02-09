<?php
if(!isset($_POST['login']))
	echo 'Nie przeslano zmiennej "login"';
else
{
	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);
	try
	{
		// Proba polaczenia sie z baza
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		$polaczenie->set_charset('utf8');

		// Jesli powyzsza proba zawiedzie, to rzuc wyjatkiem
		if($polaczenie->connect_errno != 0)
			throw new Exception($polaczenie->connect_error);
		else
		{
			$login = $_POST['login'];

			//Walidacja i sanityzacja loginu
			$login = htmlentities($login, ENT_QUOTES, "UTF-8");
			if($rezultat = $polaczenie->query(sprintf("select * from uzytkownik where login='%s'", mysqli_real_escape_string($polaczenie, $login))))
			{
				// Sprawdzenie, czy sa w bazie uzytkownicy o podanym loginie
				$ilu_userow = $rezultat->num_rows;
				if($ilu_userow > 0)
					$rezultat->free_result();
				else
				{
					$rezultat->free_result();
					echo 'Niepoprawny login';
				}
			}
			else
				throw new Exception($polaczenie->error);
			$polaczenie->close();
		}
	}
	catch(Exception $e)
	{
		echo 'Blad serwera! Przepraszamy za niedogodnosci i prosimy zalogowac sie ponownie pozniej!';
		//echo '<br/>Informacja developerska: '.$e;
	}
}