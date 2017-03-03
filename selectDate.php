<?php
session_start();
if(!isset($_COOKIE["patientLogged"]))
{
	header('Location: index.php');
	exit();
}
require_once "connect.php";

// Funkcja, ktora sprawdza, czy aby nie zaznaczono wiecej anizeli jeden checkbox (w koncu zarejestrowac sie mozna tylko do 1 dietetyka)
function oneCheckboxChecked()
{
	if(!empty($_POST['CBgroup']) && isset($_POST['CBgroup'][1]))
		return false;
	else if(!empty($_POST['CBgroup']))
		return true;
	return false;
}

// Funkcja, ktora wyjmuje z bazy informacje o godzinach pracy dietetyka
function getInfoFromDb()
{
	global $host, $db_user, $db_password, $db_name;
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
			echo 'Bangla :)';
		}
	}
	catch(Exception $e)
	{
		header("Location: html_files/serverError_goToLogout.html");
		//echo '<br/>Informacja developerska: '.$e;
	}
}

/**************************ZABEZPIECZENIE PRZED MULTI CLICK'IEM**************************/

require_once('multiClickPrevent.php');

// Sprawdzenie, czy formularz zostal wyslany
$postedToken = filter_input(INPUT_POST, 'token');
if(!empty($postedToken))
{
	if(isTokenValid($postedToken) && oneCheckboxChecked())
		getInfoFromDb();
	else if(!oneCheckboxChecked())
	{
		header("Location: html_files/manyChecksChecked.html");
		exit();
	}
}