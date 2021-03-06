<?php
session_start();

require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

if(isset($_SESSION['newUserLogin']))
{
	// Pomocniczy zapis loginu, ktory pomoze w znalezieniu odpowiedniego wiersza w bazie danych
	$helper_login = $_SESSION['newUserLogin'];
	unset($_SESSION['newUserLogin']);
	try
	{
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		$connection->set_charset('utf8');
		if($connection->connect_errno != 0)
			throw new Exception($connection->connect_error);
		else
		{
			// Kasujemy zapisanego za pomoca pierwszego click'u pacjenta
			if(!$connection->query("delete from user where login like '$helper_login'"))
				throw new Exception($connection->connect_error);
			$connection->close();
		}
	}
	catch (Exception $e)
	{
		header("Location: html_files/serverError_goToIndex.html");
		//echo '<br/>Informacja developerska: '.$e;
	}
}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<meta http-equiv="Refresh" content="5; url=index.php"/>
	<title>Błąd "multiclick"</title>
	<link rel="stylesheet" href="css_files/basic.css" type="text/css"/>
	<link rel="stylesheet" href="css_files/statement.css" type="text/css"/>
	<link href="https://fonts.googleapis.com/css?family=Great+Vibes|Playfair+Display:400,700&amp;subset=latin-ext"
		  rel="stylesheet">
	<noscript><div id="infoAboutNoScript">Twoja przeglądarka nie obsługuje skryptów JavaScript!</div></noscript>
</head>

<body>
<div id="headline">Dane wprowadzone do formularza można zatwierdzić tylko jeden raz! Poczekaj i spróbuj ponownie...</div>
</body>
</html>