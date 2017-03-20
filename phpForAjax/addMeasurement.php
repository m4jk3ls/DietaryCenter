<?php
session_start();

if(!isset($_POST['patientID']) || !isset($_POST['bodyMass']) || !isset($_POST['fat']) || !isset($_POST['water']) || !isset($_POST['height']))
	echo 'Nie przesłano wszystkich potrzebnych danych!';
else if($_POST['bodyMass'] == "Masa ciała" || $_POST['fat'] == "Ilość tłuszczu" || $_POST['water'] == "Ilość wody" || $_POST['height'] == "Wzrost")
	echo "Wprowadź wszystkie pomiary!";
else
{
	$patientID = $_POST['patientID'];
	$bodyMass = substr($_POST['bodyMass'], 0, -3);
	$fat = substr($_POST['fat'], 0, -1);
	$water = substr($_POST['water'], 0, -1);
	$height = substr($_POST['height'], 0, -2);
	$bmi = round($bodyMass / ($height * $height), 2);
	$today = date("Y-m-d");

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
			if(!$connection->query("insert into measurement values(null, '$patientID', '$today', '$bodyMass', '$fat', '$water', '$bmi')"))
				throw new Exception($connection->error);
			echo "Zapisane!";
			$connection->close();
		}
	}
	catch (Exception $e)
	{
		header("Location: ../html_files/serverError_goToLogout.html");
		//echo '<br/>Informacja developerska: '.$e;
	}
}