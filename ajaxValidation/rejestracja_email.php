<?php
if(!isset($_POST['email']))
	echo 'Nie przesłano zmiennej "email"';
else
{
	$email = $_POST['email'];
	$emailB = filter_var($GLOBALS['email'], FILTER_SANITIZE_EMAIL);

	if(strlen($email) < 1)
		echo 'Nie podałeś adresu email!';
	else if(!filter_var($emailB, FILTER_VALIDATE_EMAIL) || ($emailB != $email))
		echo 'Adres email jest niepoprawny!';
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
				// Poszukaj, czy w bazie istnieje juz podany adres email
				$rezultat = $polaczenie->query("select p.id_pacjent from pacjent p join uzytkownik u on (p.id_uzytkownik = u.id_uzytkownik) where u.email = '$email'");
				if (!$rezultat) throw new Exception($polaczenie->error);

				$ile = $rezultat->num_rows;
				if ($ile > 0)
					echo 'Adres email zajęty!';

				$polaczenie->close();
			}
		}
		catch(Exception $e)
		{
			echo 'Błąd serwera! Przepraszamy za niedogodności i prosimy zalogować się ponownie później!';
			//echo '<br/>Informacja developerska: '.$e;
		}
	}
}