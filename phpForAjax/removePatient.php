<?php
if(!isset($_POST['login']))
	echo 'Nie przesłano wartości przycisku usuwającego pacjenta!';
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
			$login = $_POST['login'];
			if($connection->query("delete from user where login like '$login'"))
				echo "refresh";
			else
				throw new Exception($connection->connect_error);
			$connection->close();
		}
	}
	catch (Exception $e)
	{
		header("Location: ../html_files/serverError_goToLogout.html");
		//echo '<br/>Informacja developerska: '.$e;
	}
}