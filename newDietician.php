<?php
session_start();

if(!isset($_COOKIE['adminLogged']))
{
	header("Location: index.php");
	exit();
}

function showYears()
{
	$year = date("Y") - 18;
	for($i = 0; $i < 100; $i++)
		echo '<option>' . $year-- . '</option>';
}

function showMonths()
{
	echo
	'<option>Styczeń</option>
	<option>Luty</option>
	<option>Marzec</option>
	<option>Kwiecień</option>
	<option>Maj</option>
	<option>Czerwiec</option>
	<option>Lipiec</option>
	<option>Sierpień</option>
	<option>Wrzesień</option>
	<option>Październik</option>
	<option>Listopad</option>
	<option>Grudzień</option>';
}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>Panel admina NaturHouse</title>
	<link rel="stylesheet" href="css_files/basic.css" type="text/css"/>
	<link href="css_files/card.css" rel="stylesheet" type="text/css"/>
	<link href="css_files/newDietician.css" rel="stylesheet" type="text/css"/>
	<link href="css_files/submitButton.css" rel="stylesheet" type="text/css"/>
	<link href="css_files/contentCenter.css" rel="stylesheet" type="text/css"/>
	<link href="https://fonts.googleapis.com/css?family=Great+Vibes|Playfair+Display:400,700&amp;subset=latin-ext"
		  rel="stylesheet">
	<script src="javascript_files/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="javascript_files/ajax/dayOfTheBirth.js"></script>
	<script type="text/javascript" src="javascript_files/stickyMenu.js"></script>
	<link rel="stylesheet" type="text/css"
		  href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css"/>
	<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
	<script src="javascript_files/cookiesBanner.js"></script>
	<noscript><div id="infoAboutNoScript">Twoja przeglądarka nie obsługuje skryptów JavaScript!</div></noscript>
	<style>
		.menu > li:first-child
		{
			width: 25%;
		}

		.menu > li:first-child + li
		{
			width: 25%;
		}

		.menu > li:first-child + li + li
		{
			width: 25%;
		}

		.menu > li:first-child + li + li + li
		{
			width: 25%;
		}
	</style>
</head>

<body>
<div id="container">
	<div id="logo"><img id="logo-img" src="img/logo.jpg"/></div>
	<ol class="menu">
		<li><a href="adminPanel.php">Strona główna</a></li>
		<li><a href="dieticiansManager.php">Dietetycy</a></li>
		<li><a href="patientsManager.php">Pacjenci</a></li>
		<li><a href="logOut.php">Wyloguj</a></li>
	</ol>
	<div id="topbarPackage">
		<div id="topbar">
			<div id="topbarL"><img id="topbarL-img" src="img/admin.png"/></div>
			<div id="topbarR">
				<div id="quotation">„Jesteśmy tym, co wciąż powtarzamy. Doskonałość nie jest zatem aktem, ale nawykiem".</div>
				<div id="signature">Arystoteles</div>
			</div>
		</div>
	</div>
	<div id="content">
		<h1>Dodajemy nowego dietetyka</h1>
		<div id="signInForm">
			<form method="post">
				<!--Imie-->
				<input type="text" id="firstName" placeholder="imię" value="<?php
				if(isset($_SESSION['firstNameSaved']))
				{
					echo $_SESSION['firstNameSaved'];
					unset($_SESSION['firstNameSaved']);
				}
				?>"/>

				<!--Nazwisko-->
				<input type="text" id="lastName" placeholder="nazwisko" value="<?php
				if(isset($_SESSION['lastNameSaved']))
				{
					echo $_SESSION['lastNameSaved'];
					unset($_SESSION['lastNameSaved']);
				}
				?>"/>

				<!--Data urodzenia-->
				<div id="dateOfTheBirth">
					<div id="dateHeadline">Data urodzenia</div>
					<select title="year_title" name="year">
						<option>---rok---</option>
						<?php showYears(); ?>
					</select>
					<select title="month_title" name="month">
						<option>---miesiąc---</option>
						<?php showMonths(); ?>
					</select>
					<select title="day_title" name="day">
						<option>---dzień---</option>
					</select>
				</div>

				<!--Numer PESEL-->
				<input type="text" id="pesel" placeholder="pesel" value="<?php
				if(isset($_SESSION['peselSaved']))
				{
					echo $_SESSION['peselSaved'];
					unset($_SESSION['peselSaved']);
				}
				?>"/>

				<!--Login-->
				<input type="text" id="login" placeholder="login" value="<?php
				if(isset($_SESSION['loginSaved']))
				{
					echo $_SESSION['loginSaved'];
					unset($_SESSION['loginSaved']);
				}
				?>"/>

				<!--Email-->
				<input type="text" id="email" placeholder="e-mail" value="<?php
				if(isset($_SESSION['emailSaved']))
				{
					echo $_SESSION['emailSaved'];
					unset($_SESSION['emailSaved']);
				}
				?>"/>

				<!--Haslo-->
				<input type="password" id="passwd1" placeholder="hasło" value="<?php
				if(isset($_SESSION['passwd1Saved']))
				{
					echo $_SESSION['passwd1Saved'];
					unset($_SESSION['passwd1Saved']);
				}
				?>"/>

				<!--Powtorzone haslo-->
				<input type="password" id="passwd2" placeholder="powtórz hasło" value="<?php
				if(isset($_SESSION['passwd2Saved']))
				{
					echo $_SESSION['passwd2Saved'];
					unset($_SESSION['passwd2Saved']);
				}
				?>"/>

				<!--Submit zatwierdzajacy-->
				<input type="submit" value="Rejestruj"
					   onclick="this.disabled=true; this.value='Wczytuję...'; this.form.submit();"/>
			</form>
		</div>
	</div>
	<div id="footer">NaturHouse - Twój osobisty dietetyk. Strona w sieci od 2017 r. &copy;
					 Wszelkie prawa zastrzeżone</div>
</div>
</body>
</html>