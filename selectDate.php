<?php
session_start();
if(!isset($_COOKIE["patientLogged"]))
{
	header('Location: index.php');
	exit();
}
require_once "connect.php";

function draw()
{
	$polishDays = array("Poniedziałek", "Wtorek", "Środa", "Czwartek", "Piątek", "Sobota", "Niedziela");
	$datesCopy = array(array());
	$queryResults = array();
	$j = 1;
	$m = 0;
	$n = 0;
	while ($queryResults[$n++] = $GLOBALS['result']->fetch_assoc())
	{
	}

	// 3 iteracje, bo chcemy wyswietlic najblizsze 3 tygodnie (21 dni)
	for ($i = 0; $i < 3; $i++)
	{
		echo '<table><tr>';

		// Wypisanie najblizszych 21 dni
		for ($k = 0; $k < 7; $k++)
		{
			echo
				'<td>' .
				($datesCopy[$m][0] = date("Y-m-d", strtotime("+" . ($i + $j) . " day"))) .
				' <br/>' .
				$polishDays[($datesCopy[$m++][1] = date("N", strtotime("+" . ($i + (($k < 6) ? $j++ : $j)) . " day")) - 1)] .
				'</td >';
		}
		echo '</tr><tr>';

		// Wypisanie godzin przyjec w dany dzien
		for ($k = 0; $k < 7; $k++)
		{
			$flag = false;
			foreach ($queryResults as $z)
			{
				if($z['dayOfTheWeek'] != null && (int)$z['dayOfTheWeek'] == $datesCopy[$k + 7 * $i][1])
				{
					echo '<td>' . $z['starts_at'] . '<br/>-<br/>' . $z['ends_at'] . '</td>';
					$flag = true;
					break;
				}
			}
			if(!$flag)
				echo '<td>X</td>';
		}

		echo '</tr></table><br/>';
	}
}

// Funkcja, ktora wyjmuje z bazy informacje o godzinach pracy dietetyka
function drawCalendar()
{
	global $host, $db_user, $db_password, $db_name;
	mysqli_report(MYSQLI_REPORT_STRICT);
	try
	{
		// Proba polaczenia sie z baza
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		$connection->set_charset('utf8');

		// Jesli powyzsza proba zawiedzie, to rzuc wyjatkiem
		if($connection->connect_errno != 0)
			throw new Exception($connection->connect_error);
		else
		{
			$helper_dieticianID = (int)$_POST['radioButton'];
			if(!($GLOBALS['result'] = $connection->query("select oh.dayOfTheWeek, oh.starts_at, oh.ends_at from officehours oh
											   join dietician d on (oh.dieticianID = d.dieticianID)
											   where oh.dieticianID like '$helper_dieticianID' order by oh.dayOfTheWeek asc"))
			)
				throw new Exception($connection->connect_error);
			else
			{
				draw();

				$GLOBALS['result']->free_result();
				$connection->close();
			}
		}
	}
	catch (Exception $e)
	{
		header("Location: html_files/serverError_goToLogout.html");
		//echo '<br/>Informacja developerska: '.$e;
	}
}

/**************************ZABEZPIECZENIE PRZED MULTI CLICK'IEM**************************/

require_once('multiClickPrevent.php');

// Sprawdzenie, czy formularz zostal wyslany
$postedToken = filter_input(INPUT_POST, 'token');
if(!empty($postedToken))
{
	if(!isTokenValid($postedToken))
	{
		header("Location: html_files/multiclickError_dieticianChoice.html");
		exit();
	}
	else if(!isset($_POST['radioButton']))
	{
		header("Location: html_files/dieticianDidntSelected.html");
		exit();
	}
}
else
{
	header("Location: yourVisit.php");
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
		table
		{
			width: 100%;
			margin-left: auto;
			margin-right: auto;
			border: solid 1px black;
			border-collapse: collapse;
			font-size: 20px;
		}

		td
		{
			width: calc(100% / 7);
			text-align: center;
			vertical-align: middle;
			border: solid 1px #000;
			padding: 5px;
		}
	</style>
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
		<?php drawCalendar(); ?>
	</div>
	<div id="footer">NaturHouse - Twój osobisty dietetyk. Strona w sieci od 2017 r. &copy;
					 Wszelkie prawa zastrzeżone</div>
</div>
</body>
</html>
