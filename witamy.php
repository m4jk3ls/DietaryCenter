<?php
	session_start();
	if(!isset($_SESSION['udana_rejestracja']))
	{
		header('Location: index.php');
		exit();
	}
	else
	{
		unset($_SESSION['udana_rejestracja']);
	}
	
	if(isset($_SESSION['fr_imie'])) unset($_SESSION['fr_imie']);
	if(isset($_SESSION['fr_nazwisko'])) unset($_SESSION['fr_nazwisko']);
	if(isset($_SESSION['fr_login'])) unset($_SESSION['fr_login']);
	if(isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
	if(isset($_SESSION['fr_haslo1'])) unset($_SESSION['fr_haslo1']);
	if(isset($_SESSION['fr_haslo2'])) unset($_SESSION['fr_haslo2']);
	if(isset($_SESSION['fr_regulamin'])) unset($_SESSION['fr_regulamin']);
	
	if(isset($_SESSION['e_imie'])) unset($_SESSION['e_imie']);
	if(isset($_SESSION['e_nazwisko'])) unset($_SESSION['e_nazwisko']);
	if(isset($_SESSION['e_login'])) unset($_SESSION['e_login']);
	if(isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
	if(isset($_SESSION['e_haslo'])) unset($_SESSION['e_haslo']);
	if(isset($_SESSION['e_regulamin'])) unset($_SESSION['e_regulamin']);
	if(isset($_SESSION['e_bot'])) unset($_SESSION['e_bot']);
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>NaturHouse - dietetyk na wyciągnięcie ręki</title>
</head>

<body>
	Dziękujemy za rejestrację w serwisie! Możesz już zalogować się na swoje konto! <br/><br/>
	<a href="index.php">Zaloguj się na swoje konto!</a>
	<br/><br/>
</body>
</html>