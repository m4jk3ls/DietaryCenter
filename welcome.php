<?php
session_start();
if (!isset($_SESSION['udana_rejestracja']))
{
	header('Location: index.php');
	exit();
}
else
{
	unset($_SESSION['udana_rejestracja']);
}

if (isset($_SESSION['fr_imie'])) unset($_SESSION['fr_imie']);
if (isset($_SESSION['fr_nazwisko'])) unset($_SESSION['fr_nazwisko']);
if (isset($_SESSION['fr_login'])) unset($_SESSION['fr_login']);
if (isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
if (isset($_SESSION['fr_haslo1'])) unset($_SESSION['fr_haslo1']);
if (isset($_SESSION['fr_haslo2'])) unset($_SESSION['fr_haslo2']);

if (isset($_SESSION['e_imie'])) unset($_SESSION['e_imie']);
if (isset($_SESSION['e_nazwisko'])) unset($_SESSION['e_nazwisko']);
if (isset($_SESSION['e_login'])) unset($_SESSION['e_login']);
if (isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
if (isset($_SESSION['e_haslo'])) unset($_SESSION['e_haslo']);
if (isset($_SESSION['e_bot'])) unset($_SESSION['e_bot']);
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>NaturHouse - dietetyk na wyciągnięcie ręki</title>
	<link rel="stylesheet" href="css_files/welcome.css" type="text/css"/>
	<link href="https://fonts.googleapis.com/css?family=Great+Vibes|Playfair+Display:400,700&amp;subset=latin-ext"
		  rel="stylesheet">
	<script src="javascript_files/jquery-3.1.1.min.js"></script>
	<script src="javascript_files/getDivsSizes.js"></script>
	<meta http-equiv="Refresh" content="5; url=index.php"/>
	<link rel="stylesheet" type="text/css"
		  href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css"/>
	<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
	<script src="javascript_files/cookiesBanner.js"></script>
	<noscript><div id="noscript_info">Twoja przeglądarka nie obsługuje skryptów JavaScript!</div></noscript>
</head>

<body>
	<div id="header">Dziękujemy za rejestrację w serwisie! Za chwilę zostaniesz przekierowany do formularza logowania!</div>
</body>
</html>