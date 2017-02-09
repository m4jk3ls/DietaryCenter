<?php
if(!isset($_POST['haslo']))
	echo 'Nie przesłano zmiennej "haslo"';
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
			$haslo = $_POST['haslo'];

			if(strlen($haslo) < 8)
				echo 'Hasło jest zbyt krótkie (min. 8 znaków)!';
			else if(strlen($haslo) > 20)
				echo 'Hasło jest zbyt długie (max. 20 znaków)!';

			$polaczenie->close();
		}
	}
	catch(Exception $e)
	{
		echo 'Błąd serwera! Przepraszamy za niedogodności i prosimy zalogować się ponownie później!';
		//echo '<br/>Informacja developerska: '.$e;
	}
}