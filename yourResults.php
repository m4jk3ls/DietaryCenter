<?php
session_start();

if(!isset($_COOKIE["patientLogged"]))
{
	header('Location: index.php');
	exit();
}

function drawTable()
{
	echo
	'<table>
		<tr class="firstRow">
			<td>Data</td>
			<td>Masa ciała</td>
			<td>Zawartość tłuszczu</td>
			<td>Zawartość wody</td>
			<td>Wskaźnik BMI</td>
		</tr>';

	while ($row = $GLOBALS['result']->fetch_assoc())
	{
		echo
			'<tr class="anotherRow">
				<td>' . $row['Date'] . '</td>
				<td>' . $row['bodyMass'] . ' kg</td>
				<td>' . $row['fat'] . ' %</td>
				<td>' . $row['water'] . ' %</td>
				<td>' . $row['BMI'] . '</td>
			</tr>';
	}

	echo '</table>';
	$GLOBALS['result']->free_result();
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
	<link href="css_files/contentCenter.css" rel="stylesheet" type="text/css"/>
	<link href="css_files/yourResults.css" rel="stylesheet" type="text/css"/>
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
		<li><a href="yourResults.php" style="background-color: #CCBD87;">Twoje rezultaty</a></li>
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
		<?php
		require_once "connect.php";
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
				$helper_userID = $_SESSION['userID'];
				if(!$GLOBALS['result'] = $connection->query("call yourResults('$helper_userID')")
				)
					throw new Exception($connection->error);
				drawTable();
				$connection->close();
			}
		}
		catch (Exception $e)
		{
			header("Location: ../html_files/serverError_goToLogout.html");
			//echo '<br/>Informacja developerska: '.$e;
		}
		?>
	</div>
	<div id="footer">NaturHouse - Twój osobisty dietetyk. Strona w sieci od 2017 r. &copy;
					 Wszelkie prawa zastrzeżone</div>
</div>
</body>
</html>