<?php
session_start();

require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);
try
{
	$connection = new mysqli($host, $db_user, $db_password, $db_name);
	$connection->set_charset('utf8');

	if ($connection->connect_errno != 0)
		throw new Exception($connection->connect_error);
	else
	{
		$helper_userID = $_SESSION['userID'];
		if (!$connection->query("delete from active_sessions where userID like '$helper_userID'"))
			throw new Exception($connection->error);
	}
}
catch (Exception $e)
{
	echo '<span style="color:red;">Błąd serwera! Prosimy o ponowną próbę wylogowania się!</span>';
	//echo '<br/>Informacja developerska: '.$e;
}

session_unset();
setcookie("patientLogged", false, time() - 1);
setcookie("dieticianLogged", false, time() - 1);
setcookie("token", null, time() - 1);
header('Location: index.php');