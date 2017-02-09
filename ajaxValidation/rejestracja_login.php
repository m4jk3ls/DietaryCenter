<?php
if(!isset($_POST['login']))
	echo 'Nie przesłano zmiennej "login"';
else
{
	require_once "../connect.php";
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
			if(strlen($login) < 1)
				echo 'Nie podałeś loginu!';
			else
			{
				//Walidacja i sanityzacja loginu
				$login = htmlentities($login, ENT_QUOTES, "UTF-8");
				if($rezultat = $polaczenie->query(sprintf("select * from uzytkownik where login='%s'", mysqli_real_escape_string($polaczenie, $login))))
				{
					// Sprawdzenie, czy sa w bazie uzytkownicy o podanym loginie
					$ilu_userow = $rezultat->num_rows;
					if($ilu_userow > 0)
					{
						echo 'Login zajęty!';
						$rezultat->free_result();
					}
					else
						$rezultat->free_result();
				}
				else
					throw new Exception($polaczenie->error);
			}
			$polaczenie->close();
		}
	}
	catch(Exception $e)
	{
		echo 'Błąd serwera! Przepraszamy za niedogodności i prosimy zalogować się ponownie później!';
		//echo '<br/>Informacja developerska: '.$e;
	}
}