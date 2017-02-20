<?php
if(!isset($_POST['passwd']))
	echo 'Nie przesłano zmiennej "haslo"';
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
			$passwd = $_POST['passwd'];
			if(strlen($passwd) < 8)
				echo 'Hasło jest zbyt krótkie (min. 8 znaków)!';
			else if(strlen($passwd) > 20)
				echo 'Hasło jest zbyt długie (max. 20 znaków)!';
			$connection->close();
		}
	}
	catch (Exception $e)
	{
		header("Location: ../html_files/serverError.html");
		//echo '<br/>Informacja developerska: '.$e;
	}
}