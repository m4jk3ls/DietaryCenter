<?php
session_start();

require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

// Funkcja usuwa dane, ktore zdazyly zostac wprowadzone po multiclick'u i przy wylaczonym JS'ie
function undoAllQueries($helper_userID)
{
	$GLOBALS['connection']->query("START TRANSACTION");
	if(!$GLOBALS['connection']->query("delete from active_sessions where userID like '$helper_userID'") ||
		!$GLOBALS['connection']->query("delete from archive_logs where userID like '$helper_userID' order by dateAndTime desc limit 1")
	)
		return false;
	return true;
}

try
{
	$GLOBALS['connection'] = new mysqli($host, $db_user, $db_password, $db_name);
	$GLOBALS['connection']->set_charset('utf8');

	if($GLOBALS['connection']->connect_errno != 0)
		throw new Exception($GLOBALS['connection']->connect_error);
	else
	{
		$helper_userID = $_SESSION['userID'];
		// $_SESSION['formSubmitted'] ma wartosc true <=> kiedy nie nastapil multiclick
		if($_SESSION['formSubmitted'])
		{
			if(!$GLOBALS['connection']->query("delete from active_sessions where userID like '$helper_userID'"))
				throw new Exception($GLOBALS['connection']->error);
		}
		// Nastapil multiclick i musimy posilkowac sie funkcja cofajaca zmiany w bazie danych
		else if(!undoAllQueries($helper_userID))
			throw new Exception($GLOBALS['connection']->error);
		else
			$GLOBALS['connection']->query("COMMIT");
	}
}
catch (Exception $e)
{
	$GLOBALS['connection']->query("ROLLBACK");
	echo '<span style="color:red;">Błąd serwera! Prosimy o ponowną próbę wylogowania się!</span>';
	//echo '<br/>Informacja developerska: '.$e;
}

session_unset();
setcookie("patientLogged", false, time() - 1);
setcookie("dieticianLogged", false, time() - 1);
setcookie("token", null, time() - 1);
header('Location: index.php');