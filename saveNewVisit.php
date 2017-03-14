<?php
session_start();
if(!isset($_COOKIE["patientLogged"]))
{
	header('Location: index.php');
	exit();
}
if(!isset($_POST['hoursToChoice']))
{
	header('Location: yourVisit.php');
	exit();
}

require_once "connect.php";
function saveVisit()
{
	$chosenDay = $_POST['daysToChoose'];
	$chosenHour = $_POST['hoursToChoice'];

	global $host, $db_user, $db_password, $db_name;
	mysqli_report(MYSQLI_REPORT_STRICT);

	try
	{
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		$connection->set_charset('utf8');

		if($connection->connect_errno != 0)
			throw new Exception($connection->connect_error);
		else
		{
			// Mamy w sesji ID dietetyka oraz ID uzytkownika (ktory jest pacjentem), musimy z tego wyciagnac ID pacjenta
			$helper_userID = $_SESSION['userID'];
			if(!($result = $connection->query("select p.patientID from patient p join user u on(p.userID = u.userID) where p.userID like '$helper_userID'")))
				throw new Exception($GLOBALS['connection']->error);
			else
			{
				// Zapisanie potrzebnych danych do zapisania nowej wizyty
				$dieticianID = $_SESSION['dieticianID'];
				$patientID = (int)$result->fetch_assoc()['patientID'];
				if(isset($_SESSION['dieticianID'])) unset($_SESSION['dieticianID']);

				// Zapisanie nowej wizyty do bazy
				if(!($connection->query("insert into visit(patientID, dieticianID, visitDate, visitHour) values('$patientID', '$dieticianID', '$chosenDay', '$chosenHour')")))
					throw new Exception($GLOBALS['connection']->error);
				header("Location: html_files/visitSaved.html");

				$result->free_result();
			}
			$connection->close();
		}
	}
	catch (Exception $e)
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
	if(isTokenValid($postedToken) && isset($_POST['hoursToChoice']))
		saveVisit();

	/*Obsluzenie przypadku, w ktorym, nastepuje multiclick dla klikniec drugiego i kolejnego nie jest potrzebne, poniewaz
	zapis godzin wizyty jest wykonywany w transakcji (wykona sie w calosci, albo w ogole). Cofanie wprowadzonych i
	zatwierdzonych zmian byloby bez sensu, poniewaz zniszczylibysmy byc moze poprzednie dane, ktore byly dobre i zapisane
	w tym samym wierszu tabeli. Obecna sytuacja jest dobra, poniewaz dla klikniec drugiego i kolejnego nie dzieje sie nic
	(funkcja saveVisit() wywoluje sie tylko przy zgodnym token'ie, czyli tylko dla pierwszego klikniecia).*/
}