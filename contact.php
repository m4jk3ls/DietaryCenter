<?php
session_start();

if(!isset($_COOKIE["patientLogged"]))
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
	<title>Twoja karta pacjenta</title>
	<link rel="stylesheet" href="css_files/basic.css" type="text/css"/>
	<link href="css_files/card.css" rel="stylesheet" type="text/css"/>
	<link href="css_files/contact.css" rel="stylesheet" type="text/css"/>
	<link href="css_files/contentCenter.css" rel="stylesheet" type="text/css"/>
	<link href="https://fonts.googleapis.com/css?family=Great+Vibes|Playfair+Display:400,700&amp;subset=latin-ext"
		  rel="stylesheet">
	<script src="javascript_files/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="javascript_files/stickyMenu.js"></script>
	<link rel="stylesheet" type="text/css"
		  href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css"/>
	<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
	<script src="javascript_files/cookiesBanner.js"></script>
	<noscript><div id="infoAboutNoScript">Twoja przeglądarka nie obsługuje skryptów JavaScript!</div></noscript>
</head>

<body>
<div id="container">
	<div id="logo"><img id="logo-img" src="img/logo.jpg"/></div>
	<ol class="menu">
		<li><a href="yourCard.php">Strona główna</a></li>
		<li><a href="yourVisit.php">Twoja wizyta</a></li>
		<li><a href="#">Twoje rezultaty</a></li>
		<li><a href="contact.php">Kontakt</a></li>
		<li><a href="logOut.php">Wyloguj</a></li>
	</ol>
	<div id="topbarPackage">
		<div id="topbar">
			<div id="topbarL"><img id="topbarL-img" src="img/man-vegetable.png"/></div>
			<div id="topbarR">
				<div id="quotation">"Granice? Nigdy żadnej nie widziałem, ale słyszałem, że istnieją w umysłach niektórych ludzi".</div>
				<div id="signature">Thor Heyerdahl</div>
			</div>
		</div>
	</div>
	<div id="content">
		<h1>Centrala</h1>
		<p><strong>NATURHOUSE SP. Z O.O.</strong><br/></p>
		<p>ul. Dostawcza 12<br/>93-231 Łódź<br/>NIP: 579-209-74-36, KRS: 0000250651<br/>Wys. kapit. zakład. 375 000,00 zł<br/></p>
		<p><strong>Justyna Woźniak</strong><br/>tel.: + 48 42 640 02 08<br/>e-mail: <a
					href="mailto:biuro@naturhouse-polska.com" target="_blank">biuro@naturhouse-polska.com</a></p>

		<h1>Dyrektor NATURHOUSE SP. Z O.O.</h1>
		<p><strong>Andrzej Gładysz</strong><br/>e-mail: <a href="mailto:poland@naturhouse.com" target="_blank">poland@naturhouse.com</a></p>

		<h1>Dyrektor administracyjno-finansowy</h1>
		<p><strong>Anna Strzemecka</strong><br/>tel. + 48 662 218 096<br/>e-mail: <a
					href="mailto:anna.strzemecka@naturhouse-polska.com" target="_blank">anna.strzemecka@naturhouse-polska.com</a></p>

		<h1>Kierownicy regionalni</h1>
		<p><strong>STREFA PÓŁNOCNA</strong><br/></p>
		<p><strong>Artur Kwiatkowski</strong><br/>tel. + 48 730 602 740<br/>e-mail: <a
					href="mailto:artur.kwiatkowski@naturhouse-polska.com" target="_blank">artur.kwiatkowski@naturhouse-polska.com</a></p>
		<p><strong>STREFA ZACHODNIA</strong><br/></p>
		<p><strong>Rafał Kamieniak</strong><br/>tel. + 48 600 331 681<br/>e-mail: <a
					href="mailto:rafal.kamieniak@naturhouse-polska.com" target="_blank">rafal.kamieniak@naturhouse-polska.com</a></p>
		<p><strong>STREFA WSCHODNIA</strong><br/></p>
		<p><strong>Marcin Leszczyński</strong><br/>tel. + 48 668 643 739<br/>e-mail: <a
					href="mailto:marcin.leszczynski@naturhouse-polska.com" target="_blank">marcin.leszczynski@naturhouse-polska.com</a></p>
		<p><strong>STREFA POŁUDNIOWA</strong><br/></p>
		<p><strong>Rafał Miller</strong><br/>tel. + 48 608 471 681<br/>e-mail: <a
					href="mailto:rafal.miller@naturhouse-polska.com"
					target="_blank">rafal.miller@naturhouse-polska.com</a></p>
		<p><strong>STREFA CENTRALNA</strong><br/></p>
		<p><strong>Maciej Stec</strong><br/>tel. + 48 692 692 959<br/>e-mail: <a
					href="mailto:maciej.stec@naturhouse-polska.com"
					target="_blank">maciej.stec@naturhouse-polska.com</a></p>

		<h1>Dietetyka</h1>
		<p><strong>Zofia Urbańczyk</strong><br/>tel. +48 692 692 898<br/>e-mail: <a
					href="mailto:zofia.urbanczyk@naturhouse-polska.com" target="_blank">zofia.urbanczyk@naturhouse-polska.com</a></p>
		<p><strong>Beata Prusińska</strong><br/>tel. +48 535 558 430<br/>e-mail: <a
					href="mailto:beata.prusinska@naturhouse-polska.com" target="_blank">beata.prusinska@naturhouse-polska.com</a></p>
		<p><strong>Dominika Sikora</strong><br/>tel. +48 784 997 353<br/>e-mail: <a
					href="mailto:dominika.sikora@naturhouse-polska.com" target="_blank">dominika.sikora@naturhouse-polska.com</a></p>
		<p><strong>Joanna Sobczak</strong><br/>tel. +48 728 536 175<br/>e-mail: <a
					href="mailto:joanna.sobczak@naturhouse-polska.com" target="_blank">joanna.sobczak@naturhouse-polska.com</a></p>

		<h1>Marketing</h1>
		<p><strong>Natalia Pietraszczyk</strong><br/>tel. + 48 734 459 871<br/>e-mail: <a
					href="mailto:natalia.pietraszczyk@naturhouse-polska.com" target="_blank">natalia.pietraszczyk@naturhouse-polska.com</a></p>
		<p><strong>Gabriela Chuberska</strong><br/>tel. + 48 42 649 00 00<br/>e-mail: <a
					href="mailto:gabriela.chuberska@naturhouse-polska.com" target="_blank">gabriela.chuberska@naturhouse-polska.com</a></p>

		<h1>Księgowość</h1>
		<p><strong>Biuro księgowe</strong><br/>e-mail: <a href="mailto:controlling@naturhouse-polska.com"
														  target="_blank">controlling@naturhouse-polska.com</a></p>

		<h1>Magazyn</h1>
		<p><strong>Centrum Logistyczne Naturhouse</strong><br/>tel. + 48 42 649 22 66<br/>e-mail: <a
					href="mailto:magazyn@naturhouse-polska.com" target="_blank">magazyn@naturhouse-polska.com</a></p>

	</div>
	<div id="footer">NaturHouse - Twój osobisty dietetyk. Strona w sieci od 2017 r. &copy;
					 Wszelkie prawa zastrzeżone</div>
</div>
</body>
</html>