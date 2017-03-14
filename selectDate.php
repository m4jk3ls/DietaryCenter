<?php
session_start();
if(!isset($_COOKIE["patientLogged"]))
{
	header('Location: index.php');
	exit();
}
require_once "connect.php";

function draw7days($i)
{
	global $polishDays, $datesCopy, $j, $m;

	echo '<table><tr class="firstRow">';

	// Wypisanie najblizszych 7 dni
	for ($k = 0; $k < 7; $k++)
	{
		echo
			'<td>' .
			($datesCopy[$m][0] = date("Y-m-d", strtotime("+" . ($i + $j) . " day"))) .
			' <br/>' .
			$polishDays[($datesCopy[$m++][1] = date("N", strtotime("+" . ($i + (($k < 6) ? $j++ : $j)) . " day")) - 1)] .
			'</td >';
	}
	echo '</tr>';
}

function getMaxDifference()
{
	global $queryResults;

	// Obliczanie maksymalnej roznicy miedzy godzinami przyjec (trzeba wiedziec ile narysowac wierszy)
	$maxDifference = 0;
	foreach ($queryResults as $curr)
	{
		$startHour = (int)substr($curr['starts_at'], -8, 2);
		$endHour = (int)substr($curr['ends_at'], -8, 2);
		$difference = $endHour - $startHour;
		if($difference > $maxDifference)
			$maxDifference = $difference;
	}
	return $maxDifference;
}

function intermediateTime_initialization($i)
{
	global $intermediateTime, $datesCopy, $queryResults;

	// Inicjuje tablice $intermediateTime wartosciami poczatkowymi
	for ($j = 0; $j < 7; $j++)
	{
		$flag = false;
		foreach ($queryResults as $curr)
		{
			if($curr['dayOfTheWeek'] != null && (int)$curr['dayOfTheWeek'] == $datesCopy[$j + 7 * $i][1])
			{
				$startHour = substr($curr['starts_at'], -8, 5);
				$intermediateTime[$j] = strtotime($startHour);
				$flag = true;
				break;
			}
		}
		if(!$flag)
			$intermediateTime[$j] = null;
	}
}

// Wyswietla godzine wizyty w danej komorce i ustawia jej tlo w zaleznosci od zajetosci terminu
function letsColor($i, $j)
{
	global $intermediateTime, $datesCopy, $helper_dieticianID;

	// Zmienne, ktore poslemy do bazy w celu weryfikacji
	$checkingTime = date("H:i:s", $intermediateTime[$j]);
	$checkingDate = $datesCopy[$j + 7 * $i][0];

	// Zmienna pomocnicza
	$checkingTime_shorter = date("H:i", $intermediateTime[$j]);

	if(!($result = $GLOBALS['connection']->query("select visitHour from visit where visitHour like '$checkingTime' and
												  visitDate like '$checkingDate' and
												  dieticianID like '$helper_dieticianID' limit 1"))
	)
		throw new Exception($GLOBALS['connection']->connect_error);
	else if($result->num_rows == 1)
		echo '<td class="booked">' . $checkingTime_shorter . "</td>";
	else
	{
		echo '<td class="free">' . $checkingTime_shorter . "</td>";
		$_SESSION['freeHoursByDay'][$checkingDate][] = $checkingTime_shorter;
	}
}

function addColumns($i)
{
	global $intermediateTime, $datesCopy, $queryResults;

	// Petla, ktora dodaje 7 kolumn, w ktorych przechowywana jest godzina mozliwej wizyty
	for ($j = 0; $j < 7; $j++)
	{
		$flag = false;
		foreach ($queryResults as $curr)
		{
			// Jesli wynik z bazy zgadza sie z aktualnie obslugiwanym dniem tygodnia
			if($curr['dayOfTheWeek'] != null && (int)$curr['dayOfTheWeek'] == $datesCopy[$j + 7 * $i][1])
			{
				letsColor($i, $j);
				$intermediateTime[$j] = strtotime("+15 minutes", $intermediateTime[$j]);
				$flag = true;
				break;
			}
		}
		if(!$flag)
			echo '<td>X</td>';
	}
}

function createRows($i)
{
	// Petla, ktora tworzy wiersze
	for ($j = 0; $j < getMaxDifference() * 4; $j++)
	{
		echo '<tr>';
		addColumns($i);
		echo '</tr>';
	}
	echo '</table>';
}

function draw()
{
	// Utworzenie potrzebnych zmiennych globalnych
	global $polishDays, $datesCopy, $queryResults, $j, $m, $intermediateTime;
	$polishDays = array("Poniedziałek", "Wtorek", "Środa", "Czwartek", "Piątek", "Sobota", "Niedziela");
	$datesCopy = array(array());
	$queryResults = array();
	$j = 1;
	$m = 0;
	$intermediateTime = array();    // Tablica, ktora przechowuje godziny wizyty dla wiersza poprzedniego (podczas rysowania tabeli)

	// Wypelnienie tablicy $queryResults[] wartosciami ze zmiennej $GLOBALS['result'], przechowujacej wyniki zapytania do bazy
	$n = 0;
	while ($tmp = $GLOBALS['result']->fetch_assoc())
		$queryResults[$n++] = $tmp;

	// 3 iteracje, bo chcemy wyswietlic najblizsze 3 tygodnie (21 dni)
	for ($i = 0; $i < 3; $i++)
	{
		draw7days($i);
		intermediateTime_initialization($i);
		createRows($i);
	}
}

// Funkcja, ktora wyjmuje z bazy informacje o godzinach pracy dietetyka
function drawCalendar()
{
	// Wyczyszczenie rozpiski wolnych godzin w okreslone dni (zeby przy odswiezeniu zapisywac wszystko do "czystej" tablicy)
	if(isset($_SESSION['freeHoursByDay']))
		unset($_SESSION['freeHoursByDay']);

	global $host, $db_user, $db_password, $db_name;
	mysqli_report(MYSQLI_REPORT_STRICT);
	try
	{
		// Proba polaczenia sie z baza
		$GLOBALS['connection'] = new mysqli($host, $db_user, $db_password, $db_name);
		$GLOBALS['connection']->set_charset('utf8');

		// Jesli powyzsza proba zawiedzie, to rzuc wyjatkiem
		if($GLOBALS['connection']->connect_errno != 0)
			throw new Exception($GLOBALS['connection']->connect_error);
		else
		{
			// ID dietetyka zapisujemy do sesji, poniewaz jeszcze nam sie przyda
			global $helper_dieticianID;
			$helper_dieticianID = (int)$_POST['radioButton'];
			$_SESSION['dieticianID'] = $helper_dieticianID;

			if(!($GLOBALS['result'] = $GLOBALS['connection']->query("select oh.dayOfTheWeek, oh.starts_at, oh.ends_at from officehours oh
											   join dietician d on (oh.dieticianID = d.dieticianID)
											   where oh.dieticianID like '$helper_dieticianID' order by oh.dayOfTheWeek asc"))
			)
				throw new Exception($GLOBALS['connection']->connect_error);
			else
			{
				draw();

				$GLOBALS['result']->free_result();
				$GLOBALS['connection']->close();
			}
		}
	}
	catch (Exception $e)
	{
		header("Location: html_files/serverError_goToLogout.html");
		//echo '<br/>Informacja developerska: '.$e;
	}
}

function availableDays($weekNumber)
{
	global $queryResults, $datesCopy;
	$availableDays = array();
	$i = 7 * --$weekNumber;

	// Kopiowanie do $availableDays[] indeksow dni, w ktore dostepny jest dany dietetyk
	foreach ($queryResults as $curr)
		$availableDays[] = (int)$curr['dayOfTheWeek'];

	// Przegladaj elementy 0-6 albo 7-13 albo 14-20 (zalezne od $weekNumber) tablicy $datesCopy[][]
	for ($j = $i; $j < $i + 7; $j++)
	{
		foreach ($availableDays as $curr2)
		{
			// Sprawdzam, czy dany dzien w $datesCopy[][] jest na liscie dostepnych dni w $availableDays[]
			if($datesCopy[$j][1] == $curr2)
			{
				echo '<option>' . $datesCopy[$j][0] . '</option>';
				break;
			}
		}
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
$token = getToken();
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
	<link href="css_files/selectDate.css" rel="stylesheet" type="text/css"/>
	<script src="javascript_files/jquery-3.1.1.min.js"></script>
	<script src="javascript_files/ajax/freeHours.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Great+Vibes|Playfair+Display:400,700&amp;subset=latin-ext"
		  rel="stylesheet">
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
		<?php drawCalendar(); ?>

		<div id="formPackage">
			<form method="post" action="saveNewVisit.php">
				<select title="daysToChoose_title" name="daysToChoose">
					<option>Termin</option>
					<optgroup label="1. tydzień"><?php availableDays(1); ?></optgroup>
					<optgroup label="2. tydzień"><?php availableDays(2); ?></optgroup>
					<optgroup label="3. tydzień"><?php availableDays(3); ?></optgroup>
				</select>
				<select title="hoursToChoice_title" name="hoursToChoice"></select>

				<div>
					<input type="submit" id="visitDateButton" value="Zatwierdź"
						   onclick="this.disabled=true; this.value='Zapisuję...'; this.form.submit();"/>
				</div>

				<!--Input przechowujacy token, ktory zapobiega multiclick'owi-->
				<input type="hidden" name="token" value="<?php echo $token; ?>"/>
			</form>
		</div>
	</div>
	<div id="footer">NaturHouse - Twój osobisty dietetyk. Strona w sieci od 2017 r. &copy;
					 Wszelkie prawa zastrzeżone</div>
</div>
</body>
</html>
