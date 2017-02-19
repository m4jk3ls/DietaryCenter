<?php
if (!isset($_POST['login']))
	echo 'Nie przesłano zmiennej "login"';
else
{
	require_once "../connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);
	try
	{
		// Proba polaczenia sie z baza
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		$connection->set_charset('utf8');

		// Jesli powyzsza proba zawiedzie, to rzuc wyjatkiem
		if ($connection->connect_errno != 0)
			throw new Exception($connection->connect_error);
		else
		{
			$login = $_POST['login'];
			//Walidacja i sanityzacja loginu
			$login = htmlentities($login, ENT_QUOTES, "UTF-8");
			if ($result = $connection->query(sprintf("SELECT * FROM user WHERE login='%s'", mysqli_real_escape_string($connection, $login))))
			{
				// Sprawdzenie, czy sa w bazie uzytkownicy o podanym loginie
				$howManyUsers = $result->num_rows;
				if ($howManyUsers > 0)
					$result->free_result();
				else
				{
					$result->free_result();
					echo 'Niepoprawny login!';
				}
			}
			else
				throw new Exception($connection->error);
			$connection->close();
		}
	}
	catch (Exception $e)
	{
		echo 'Błąd serwera! Prosimy zalogować się ponownie później!';
		//echo '<br/>Informacja developerska: '.$e;
	}
}