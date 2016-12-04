<?php
	if(!isset($_COOKIE["zalogowany"]))
	{
		header('Location: index.php');
		exit();
	}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>NaturHouse - Twoja karta pacjenta</title>
</head>

<body>
<?php
	session_start();
	echo "<p>Witaj ".$_SESSION['login']." - jesteś zalogowany do swojego NH-konta".'! [<a href="logout.php">Wyloguj się</a>]</p>';
	
	$dataCzas = new DateTime();
	echo "Mamy dziś ".$dataCzas->format('Y-m-d').", godzinę ".$dataCzas->format('H:i:s')."<br/>";
?>
</body>
</html>