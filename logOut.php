<?php
session_start();

require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

try
{
	$GLOBALS['connection'] = new mysqli($host, $db_user, $db_password, $db_name);
	$GLOBALS['connection']->set_charset('utf8');

	if($GLOBALS['connection']->connect_errno != 0)
		throw new Exception($GLOBALS['connection']->connect_error);
	else
	{
		$helper_userID = $_SESSION['userID'];
		if(!$GLOBALS['connection']->query("delete from active_sessions where userID like '$helper_userID'"))
			throw new Exception($GLOBALS['connection']->error);
		$GLOBALS['connection']->close();
	}
}
catch (Exception $e)
{
	$GLOBALS['connection']->query("ROLLBACK");
	session_unset();
	setcookie("patientLogged", false, time() - 1);
	setcookie("dieticianLogged", false, time() - 1);
	setcookie("token", null, time() - 1);
	header("Location: html_files/serverError_goToIndex.html");
	//echo '<br/>Informacja developerska: '.$e;
	exit();
}
session_unset();
setcookie("patientLogged", false, time() - 1);
setcookie("dieticianLogged", false, time() - 1);
setcookie("token", null, time() - 1);
header('Location: index.php');