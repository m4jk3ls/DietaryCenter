<?php
session_start();

if(!isset($_COOKIE["patientLogged"]))
{
	header('Location: index.php');
	exit();
}

require_once('multiClickPrevent.php');
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
	<link href="css_files/yourVisit.css" rel="stylesheet" type="text/css"/>
	<link href="css_files/contentCenter.css" rel="stylesheet" type="text/css"/>
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
			width: 400px;
			margin-left: auto;
			margin-right: auto;
			border: solid 1px black;
			border-collapse: collapse;
			font-size: 18px;
			margin-bottom: 60px;
		}

		.firstRow
		{
			font-size: 20px;
			color: #fff;
			font-weight: bold;
			background-color: #808080;
		}

		.anotherRow
		{
			font-family: 'Calibri', serif;
			font-style: italic;
		}

		td
		{
			width: calc(100% / 2);
			text-align: center;
			vertical-align: middle;
			border: solid 1px #000;
			padding: 5px;
		}

		input[type=submit]
		{
			display: block;
			margin: 20px auto 0 auto;
		}
	</style>
</head>

<body>
<div id="container">
	<div id="logo"><img id="logo-img" src="img/logo.jpg"/></div>
	<ol class="menu">
		<li><a href="yourCard.php">Strona główna</a></li>
		<li><a href="yourVisit.php" style="background-color: #CCBD87;">Twoja wizyta</a></li>
		<li><a href="yourResults.php">Twoje rezultaty</a></li>
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
		<h1 style="margin-bottom: 35px;">Nadchodzące wizyty</h1>
		<?php
		require_once("connect.php");
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
				if(!($result = $connection->query("call incomingVisits('$helper_userID')"))
				)
					throw new Exception($connection->connect_error);
				else
				{
					echo
					'<table>
						<tr class="firstRow">
							<td>Data</td>
							<td>Godzina</td>
						</tr>';

					while ($row = $result->fetch_assoc())
					{
						echo
							'<tr class="anotherRow">
								<td>' . $row['visitDate'] . '</td>
								<td>' . substr($row['visitHour'], -8, 5) . '</td>
							</tr>';
					}

					echo '</table>';
					$result->free_result();
				}
				$connection->close();
			}
		}
		catch (Exception $e)
		{
			header("Location: html_files/serverError_goToLogout.html");
			//echo '<br/>Informacja developerska: '.$e;
			exit();
		}
		?>


		<h1>Rezerwuj wizytę</h1>
		<form action="selectDate.php" method="post">
			<?php
			require_once("connect.php");
			mysqli_report(MYSQLI_REPORT_STRICT);
			try
			{
				$connection = new mysqli($host, $db_user, $db_password, $db_name);
				$connection->set_charset('utf8');

				if($connection->connect_errno != 0)
					throw new Exception($connection->connect_error);
				else if(!($result = $connection->query("call bookVisit()")))
					throw new Exception($connection->connect_error);
				else
				{
					while ($row = $result->fetch_assoc())
					{
						echo
							'<div class="dietician">
									<div class="nameHeadline">' . $row['firstName'] . ' ' . $row['lastName'] . '</div>
									<img src="' . $row['pathToImage'] . '" class="dieticianImage"/>
										<div class="divWithRadio">
											<label><input type="radio" name="radioButton" value="' . $row['dieticianID'] . '"/>Wybieram</label>
										</div>
							</div>';
					}
					$result->free_result();
				}
				$connection->close();
			}
			catch (Exception $e)
			{
				header("Location: html_files/serverError_goToLogout.html");
				//echo '<br/>Informacja developerska: '.$e;
				exit();
			}
			?>
			<input type="submit" id="dieticianChoiceButton" value="Zatwierdź"
				   onclick="this.disabled=true; this.value='Zapisuję...'; this.form.submit();"/>

			<!--Input przechowujacy token, ktory zapobiega multiclick'owi-->
			<input type="hidden" name="token" value="<?php echo $token; ?>"/>
		</form>
	</div>
	<div id="footer">NaturHouse - Twój osobisty dietetyk. Strona w sieci od 2017 r. &copy;
					 Wszelkie prawa zastrzeżone</div>
</div>
</body>
</html>