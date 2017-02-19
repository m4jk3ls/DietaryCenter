<?php
session_start();

require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

if(isset($_SESSION['login']))
{
	$helper_login = $_SESSION['login'];
	try
	{
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		$connection->set_charset('utf8');
		if($connection->connect_errno != 0)
			throw new Exception($connection->connect_error);
		else
		{
			if(!($result = $connection->query("select userID from user where login like '$helper_login'")))
				throw new Exception($connection->connect_error);
			else
			{
				$row = $result->fetch_assoc();
				$helper_userID = $row['userID'];

				$connection->query("START TRANSACTION");
				if($connection->query("delete from patient where userID like '$helper_userID'") &&
					$connection->query("delete from user where userID like '$helper_userID'")
				)
					$connection->query("COMMIT");
				else
					throw new Exception($connection->connect_error);
				$result->free_result();
			}
			$connection->close();
		}
	}
	catch (Exception $e)
	{
		$connection->query("ROLLBACK");
		echo '<span style="color:red;">Błąd serwera! Prosimy spróbować jeszcze raz!</span>';
		//echo '<br/>Informacja developerska: '.$e;
	}
}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<meta http-equiv="Refresh" content="10; url=index.php"/>
	<title>Błąd "multiclick"</title>
	<link rel="stylesheet" href="css_files/multiclickError.css" type="text/css"/>
	<link href="https://fonts.googleapis.com/css?family=Great+Vibes|Playfair+Display:400,700&amp;subset=latin-ext"
		  rel="stylesheet">
	<noscript><div id="infoAboutNoScript">Twoja przeglądarka nie obsługuje skryptów JavaScript!</div></noscript>
</head>

<body>
<div id="headline">Dane wprowadzone do formularza można zatwierdzić tylko jeden raz! Włącz obsługę JavaScript, aby uniknąć tego problemu. Za chwilę zostaniesz przekierowany na stronę główną!</div>
</body>
</html>