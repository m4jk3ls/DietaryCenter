<?php
if(!isset($_POST['login']))
	echo 'Nie przesłano zmiennej "login"';
else
{
	$login = $_POST['login'];
	if(strlen($login) < 1)
		echo 'Nie podałeś loginu!';
	else if(strlen($login) < 3)
		echo 'Login jest zbyt krótki (min. 3 znaki)!';
	else if(strlen($login) > 20)
		echo 'Login jest zbyt długi (max. 20 znaków)!';
	else if(!ctype_alnum($login))
		echo 'Login może składać się tylko z liter i cyfr (bez polskich znaków)!';
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
			if($connection->connect_errno != 0)
				throw new Exception($connection->connect_error);
			else
			{
				//Walidacja i sanityzacja loginu
				$login = htmlentities($login, ENT_QUOTES, "UTF-8");
				if($result = $connection->query(sprintf("select * from user where login='%s'", mysqli_real_escape_string($connection, $login))))
				{
					// Sprawdzenie, czy sa w bazie uzytkownicy o podanym loginie
					$howManyUsers = $result->num_rows;
					if($howManyUsers > 0)
					{
						echo 'Login zajęty!';
						$result->free_result();
					}
					else
						$result->free_result();
				}
				else
					throw new Exception($connection->error);
				$connection->close();
			}
		}
		catch (Exception $e)
		{
			header("Location: ../html_files/serverError_goToLogout.html");
			//echo '<br/>Informacja developerska: '.$e;
		}
	}
}