<?php
session_start();

if(!isset($_COOKIE['adminLogged']))
{
	header("Location: index.php");
	exit();
}
require_once "connect.php";

function showAllPatients()
{
	global $host, $db_user, $db_password, $db_name;
	mysqli_report(MYSQLI_REPORT_STRICT);
	try
	{
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		$connection->set_charset('utf8');

		if($connection->connect_errno != 0)
			throw new Exception($connection->connect_error);
		else
		{
			if(!($result = $connection->query("select concat(u.lastName, ' ', u.firstName) as ourPatient, u.login, u.email
				from patient p join user u on(p.userID = u.userID) order by ourPatient asc"))
			)
				throw new Exception($connection->error);

			echo
			'<table>
				<tr class="firstRow">
					<td>Nazwisko i imię</td>
					<td>Login</td>
					<td>Adres e-mail</td>
					<td>Czy usunąć?</td>
				</tr>';

			while ($row = $result->fetch_assoc())
			{
				echo
					'<tr class="anotherRow">
						<td>' . $row['ourPatient'] . '</td>
						<td>' . $row['login'] . '</td>
						<td>' . $row['email'] . '</td>
						<td>
							<button type="button" value="' . $row['login'] . '" class="removingButton"/>Usuń</button>
						</td>
					</tr>';
			}

			echo
			'</table>';

			$result->free_result();
			$connection->close();
		}
	}
	catch (Exception $e)
	{
		header("Location: html_files/serverError_goToLogout.html");
		//echo '<br/>Informacja developerska: '.$e;
		exit();
	}
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
	<link href="css_files/tablesForAdmin.css" rel="stylesheet" type="text/css"/>
	<link href="https://fonts.googleapis.com/css?family=Great+Vibes|Playfair+Display:400,700&amp;subset=latin-ext"
		  rel="stylesheet">
	<script src="javascript_files/jquery-3.1.1.min.js"></script>
	<script src="javascript_files/ajax/removePatient.js"></script>
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

		td
		{
			width: calc(100% / 4);
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
		<?php showAllPatients(); ?>
	</div>
	<div id="footer">NaturHouse - Twój osobisty dietetyk. Strona w sieci od 2017 r. &copy;
					 Wszelkie prawa zastrzeżone</div>
</div>
</body>
</html>
