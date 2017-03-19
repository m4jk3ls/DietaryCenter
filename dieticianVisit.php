<?php
session_start();

if(!isset($_COOKIE["dieticianLogged"]))
{
	header('Location: index.php');
	exit();
}

function showYears()
{
	$year = date("Y") - 1;
	for ($i = 0; $i < 3; $i++)
		echo '<option>' . $year++ . '</option>';
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
	<title>Twój panel dietetyka</title>
	<link rel="stylesheet" href="css_files/basic.css" type="text/css"/>
	<link href="css_files/card.css" rel="stylesheet" type="text/css"/>
	<link href="css_files/contentCenter.css" rel="stylesheet" type="text/css"/>
	<link href="css_files/dieticianVisit.css" rel="stylesheet" type="text/css"/>
	<link href="https://fonts.googleapis.com/css?family=Great+Vibes|Playfair+Display:400,700&amp;subset=latin-ext"
		  rel="stylesheet">
	<script src="javascript_files/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="javascript_files/stickyMenu.js"></script>
	<script type="text/javascript" src="javascript_files/ajax/dayInSelectTag.js"></script>
	<script type="text/javascript" src="javascript_files/ajax/showDieticianVisits.js"></script>
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
		<li><a href="dieticianVisit.php">Wizyta</a></li>
		<li><a href="#">Badania</a></li>
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
		<h1>Wybierz dowolny dzień ...</h1>
		<h3>... i zobacz swoje wizyty</h3>

		<div id="date">
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

		<div id="error"></div>
		<button type="button" id="haveALook" value="<?php echo $_SESSION['userID']; ?>">Looknij</button>
	</div>
	<div id="footer">NaturHouse - Twój osobisty dietetyk. Strona w sieci od 2017 r. &copy;
					 Wszelkie prawa zastrzeżone</div>
</div>
</body>
</html>