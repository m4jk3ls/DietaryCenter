<?php
if (!isset($_POST['email']))
	echo 'Nie przesłano zmiennej "email"';
else
{
	$email = $_POST['email'];
	$emailB = filter_var($GLOBALS['email'], FILTER_SANITIZE_EMAIL);

	if (strlen($email) < 1)
		echo 'Nie podałeś adresu email!';
	else if (!filter_var($emailB, FILTER_VALIDATE_EMAIL) || ($emailB != $email))
		echo 'Adres email jest niepoprawny!';
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
				// Poszukaj, czy w bazie istnieje juz podany adres email
				$result = $connection->query("select p.patientID from patient p join user u on (p.userID = u.userID) where u.email = '$email'");
				if (!$result) throw new Exception($connection->error);
				$howMany = $result->num_rows;
				if ($howMany > 0)
					echo 'Adres email zajęty!';
				$connection->close();
			}
		}
		catch (Exception $e)
		{
			echo 'Błąd serwera! Prosimy zalogować się ponownie później!';
			//echo '<br/>Informacja developerska: '.$e;
		}
	}
}