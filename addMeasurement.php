<?php
session_start();

if(!isset($_COOKIE["dieticianLogged"]))
{
	header('Location: index.php');
	exit();
}

/**************************ZABEZPIECZENIE PRZED MULTI CLICK'IEM**************************/

require_once('multiClickPrevent.php');

// Sprawdzenie, czy formularz zostal wyslany
$postedToken = filter_input(INPUT_POST, 'token');
if(!empty($postedToken))
{
	if(!isset($_POST['radioButton']))
	{
		header("Location: html_files/patientDidntSelected.html");
		exit();
	}
}
else
{
	header("Location: measurement.php");
	exit();
}
$token = getToken();
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>Twój panel dietetyka</title>
	<link rel="stylesheet" href="css_files/basic.css" type="text/css"/>
	<link href="css_files/card.css" rel="stylesheet" type="text/css"/>
	<link href="css_files/contentCenter.css" rel="stylesheet" type="text/css"/>
	<link href="css_files/measurement.css" rel="stylesheet" type="text/css"/>
	<link href="css_files/addMeasurement.css" rel="stylesheet" type="text/css"/>
	<link href="css_files/submitButton.css" rel="stylesheet" type="text/css"/>
	<link href="https://fonts.googleapis.com/css?family=Great+Vibes|Playfair+Display:400,700&amp;subset=latin-ext"
		  rel="stylesheet">
	<script src="javascript_files/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="javascript_files/stickyMenu.js"></script>
	<link rel="stylesheet" type="text/css"
		  href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css"/>
	<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
	<script src="javascript_files/cookiesBanner.js"></script>
	<noscript><div id="infoAboutNoScript">Twoja przeglądarka nie obsługuje skryptów JavaScript!</div></noscript>
	<style>
		input[type=submit]
		{
			display: block;
			margin: 30px auto 0 auto;
		}
	</style>
</head>

<body>
<div id="container">
	<div id="logo"><img id="logo-img" src="img/logo.jpg"/></div>
	<ol class="menu">
		<li><a href="dieticianCard.php">Strona główna</a></li>
		<li><a href="workSchedule.php">Ustal grafik</a></li>
		<li><a href="dieticianVisit.php">Wizyta</a></li>
		<li><a href="measurement.php">Badania</a></li>
		<li><a href="logOut.php">Wyloguj</a></li>
	</ol>
	<div id="topbarPackage">
		<div id="topbar">
			<div id="topbarL"><img id="topbarL-img" src="img/heart-vegetable.png"/></div>
			<div id="topbarR">
				<div id="quotation">"Optymalne żywienie jest medycyną jutra".</div>
				<div id="signature">dr Linus Pauling</div>
			</div>
		</div>
	</div>
	<div id="content">
		<h1>Wprowadź pomiary</h1>
		<input type="text" name="bodyMass" id="bodyMassID" placeholder="Masa ciała"/>
		<input type="text" name="fat" id="fatID" placeholder="Ilość tłuszczu [%]"/>
		<input type="text" name="water" id="waterID" placeholder="Ilość wody [%]"/>
		<input type="submit" id="saveMeasurement" value="Zapisz"
			   onclick="this.disabled=true; this.value='Wczytuję...'; this.form.submit();"/>

		<!--Input przechowujacy token, ktory zapobiega multiclick'owi-->
		<input type="hidden" name="token" value="<?php echo $token; ?>"/>
	</div>
	<div id="footer">NaturHouse - Twój osobisty dietetyk. Strona w sieci od 2017 r. &copy;
					 Wszelkie prawa zastrzeżone</div>
</div>
</body>
</html>
