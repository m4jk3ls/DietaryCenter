<?php
session_start();
if(!isset($_SESSION['registrationIsOK']))
{
	header('Location: index.php');
	exit();
}
else
	unset($_SESSION['registrationIsOK']);

if(isset($_SESSION['firstNameSaved'])) unset($_SESSION['firstNameSaved']);
if(isset($_SESSION['lastNameSaved'])) unset($_SESSION['lastNameSaved']);
if(isset($_SESSION['peselSaved'])) unset($_SESSION['peselSaved']);
if(isset($_SESSION['loginSaved'])) unset($_SESSION['loginSaved']);
if(isset($_SESSION['emailSaved'])) unset($_SESSION['emailSaved']);
if(isset($_SESSION['passwd1Saved'])) unset($_SESSION['passwd1Saved']);
if(isset($_SESSION['passwd2Saved'])) unset($_SESSION['passwd2Saved']);

if(isset($_SESSION['firstNameError'])) unset($_SESSION['firstNameError']);
if(isset($_SESSION['lastNameError'])) unset($_SESSION['lastNameError']);
if(isset($_SESSION['peselError'])) unset($_SESSION['peselError']);
if(isset($_SESSION['loginError'])) unset($_SESSION['loginError']);
if(isset($_SESSION['emailError'])) unset($_SESSION['emailError']);
if(isset($_SESSION['passwdError'])) unset($_SESSION['passwdError']);
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<meta http-equiv="Refresh" content="5; url=index.php"/>
	<title>NaturHouse - dietetyk na wyciągnięcie ręki</title>
	<link rel="stylesheet" href="css_files/basic.css" type="text/css"/>
	<link rel="stylesheet" href="css_files/welcome.css" type="text/css"/>
	<link href="https://fonts.googleapis.com/css?family=Great+Vibes|Playfair+Display:400,700&amp;subset=latin-ext"
		  rel="stylesheet">
	<script src="javascript_files/jquery-3.1.1.min.js"></script>
	<script src="javascript_files/getDivsSizes.js"></script>
	<link rel="stylesheet" type="text/css"
		  href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css"/>
	<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
	<script src="javascript_files/cookiesBanner.js"></script>
	<noscript><div id="infoAboutNoScript">Twoja przeglądarka nie obsługuje skryptów JavaScript!</div></noscript>
</head>

<body>
<div id="headline">Dziękujemy za rejestrację w serwisie! Za chwilę zostaniesz przekierowany do formularza logowania!</div>
</body>
</html>