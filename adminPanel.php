<?php
session_start();

if(!isset($_COOKIE['adminLogged']))
{
	header("Location: index.php");
	exit();
}
else
{
	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);
	try
	{
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		$connection->set_charset('utf8');

		if($connection->connect_errno != 0)
			throw new Exception($connection->connect_error);
		else
		{
			$helper_userID = $_SESSION['userID'];
			$helper_token = $_COOKIE['token'];

			if(!($result = $connection->query("select count(token) from active_sessions where userID like '$helper_userID' and token like '$helper_token'")))
				throw new Exception($connection->error);
			// Jesli w bazie nie ma pasujacego do ciastka token'a (zostal zwrocony wiersz z wartoscia count(token)=0)
			if(!$result->fetch_assoc()['count(token)'])
			{
				if(!$connection->query("delete from active_sessions where userID like '$helper_userID'"))
					throw new Exception($connection->error);
				$connection->close();
				$result->free_result();
				header('Location: logOut.php');
				exit();
			}
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
	<link href="css_files/startPage.css" rel="stylesheet" type="text/css"/>
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
		<li><a href="adminPanel.php" style="background-color: #CCBD87;">Strona główna</a></li>
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
		<h1>Witaj <?php
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
					$userID = $_SESSION['userID'];
					if(!($result = $connection->query("select userName('$userID') as name")))
						throw new Exception($connection->error);
					echo $result->fetch_assoc()['name'];
					$connection->close();
				}
			}
			catch (Exception $e)
			{
				header("Location: ../html_files/serverError_goToLogout.html");
				//echo '<br/>Informacja developerska: '.$e;
			}
			?>! Miło znów Cię widzieć!</h1>
		<h3>Zobacz co się zmieniło od Twojej ostatniej nieobecności ;)</h3>
	</div>
	<div id="footer">NaturHouse - Twój osobisty dietetyk. Strona w sieci od 2017 r. &copy;
					 Wszelkie prawa zastrzeżone</div>
</div>
</body>
</html>