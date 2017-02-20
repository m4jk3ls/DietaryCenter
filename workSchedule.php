<?php
session_start();

if(!isset($_COOKIE["dieticianLogged"]))
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
	<title>Twój panel dietetyka</title>
	<link href="css_files/card.css" rel="stylesheet" type="text/css"/>
	<link href="css_files/workSchedule.css" rel="stylesheet" type="text/css"/>
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
		<li><a href="dieticianCard.php">Strona główna</a></li>
		<li><a href="workSchedule.php">Ustal grafik</a></li>
		<li><a href="#">Wizyta</a></li>
		<li><a href="#">Badania</a></li>
		<li><a href="logOut.php">Wyloguj</a></li>
	</ol>
	<div id="topbarPackage">
		<div id="topbar">
			<div id="topbarL"><img id="topbarL-img" src="img/plate.jpg"/></div>
			<div id="topbarR">
				<div id="quotation">"Optymalne żywienie jest medycyną jutra".</div>
				<div id="signature">dr Linus Pauling</div>
			</div>
		</div>
	</div>
	<div id="content">
		<div class="dayOfTheWeek" id="mon">
			Poniedziałek
			<div class="choice">
				<div class="checkboxDiv"><label><input type="checkbox"/>Wybieram</label></div>
				<div class="hoursDiv">
					<div class="lists">
						<div class="list">
							Od: <select title="startsAt_title" name="startsAt">
								<option>---brak---</option>
								<optgroup label="08:00">
									<option>08:00</option>
									<option>08:15</option>
									<option>08:30</option>
									<option>08:45</option>
								</optgroup>
								<optgroup label="09:00">
									<option>09:00</option>
									<option>09:15</option>
									<option>09:30</option>
									<option>09:45</option>
								</optgroup>
								<optgroup label="10:00">
									<option>10:00</option>
									<option>10:15</option>
									<option>10:30</option>
									<option>10:45</option>
								</optgroup>
								<optgroup label="11:00">
									<option>11:00</option>
									<option>11:15</option>
									<option>11:30</option>
									<option>11:45</option>
								</optgroup>
								<optgroup label="12:00">
									<option>12:00</option>
									<option>12:15</option>
									<option>12:30</option>
									<option>12:45</option>
								</optgroup>
								<optgroup label="13:00">
									<option>13:00</option>
									<option>13:15</option>
									<option>13:30</option>
									<option>13:45</option>
								</optgroup>
								<optgroup label="14:00">
									<option>14:00</option>
									<option>14:15</option>
									<option>14:30</option>
									<option>14:45</option>
								</optgroup>
								<optgroup label="15:00">
									<option>15:00</option>
									<option>15:15</option>
									<option>15:30</option>
									<option>15:45</option>
								</optgroup>
								<optgroup label="16:00">
									<option>16:00</option>
									<option>16:15</option>
									<option>16:30</option>
									<option>16:45</option>
								</optgroup>
							</select>
						</div>
						<div class="list">
							Do: <select title="endsAt_title" name="endsAt">
								<option>---brak---</option>
								<optgroup label="08:00">
									<option>08:00</option>
									<option>08:15</option>
									<option>08:30</option>
									<option>08:45</option>
								</optgroup>
								<optgroup label="09:00">
									<option>09:00</option>
									<option>09:15</option>
									<option>09:30</option>
									<option>09:45</option>
								</optgroup>
								<optgroup label="10:00">
									<option>10:00</option>
									<option>10:15</option>
									<option>10:30</option>
									<option>10:45</option>
								</optgroup>
								<optgroup label="11:00">
									<option>11:00</option>
									<option>11:15</option>
									<option>11:30</option>
									<option>11:45</option>
								</optgroup>
								<optgroup label="12:00">
									<option>12:00</option>
									<option>12:15</option>
									<option>12:30</option>
									<option>12:45</option>
								</optgroup>
								<optgroup label="13:00">
									<option>13:00</option>
									<option>13:15</option>
									<option>13:30</option>
									<option>13:45</option>
								</optgroup>
								<optgroup label="14:00">
									<option>14:00</option>
									<option>14:15</option>
									<option>14:30</option>
									<option>14:45</option>
								</optgroup>
								<optgroup label="15:00">
									<option>15:00</option>
									<option>15:15</option>
									<option>15:30</option>
									<option>15:45</option>
								</optgroup>
								<optgroup label="16:00">
									<option>16:00</option>
									<option>16:15</option>
									<option>16:30</option>
									<option>16:45</option>
								</optgroup>
							</select>
						</div>
					</div>
				</div>
				<div style="clear: both"></div>
			</div>
		</div>
		<div class="dayOfTheWeek" id="tue">Wtorek</div>
		<div class="dayOfTheWeek" id="wed">Środa</div>
		<div class="dayOfTheWeek" id="thu">Czwartek</div>
		<div class="dayOfTheWeek" id="fri">Piątek</div>
		<div class="dayOfTheWeek" id="sat">Sobota</div>
		<div style="clear: both"></div>
	</div>
	<div id="footer">NaturHouse - Twój osobisty dietetyk. Strona w sieci od 2017 r. &copy;
					 Wszelkie prawa zastrzeżone</div>
</div>
</body>
</html>
