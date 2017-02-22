<?php
session_start();

if(!isset($_COOKIE["dieticianLogged"]))
{
	header('Location: index.php');
	exit();
}

require_once "connect.php";

// Funkcja, zapisujaca do bazy danych zmiany odnosnie grafiku dietetyka
function saveToDb($day, $hours)
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
			// Zapisanie do zmiennych identyfikatora uzytkownika oraz dietetyka (pomocniczo)
			$helper_userID = $_SESSION['userID'];
			if(!($result = $connection->query("select dieticianID from dietician where userID like '$helper_userID'")))
				throw new Exception($connection->error);
			$helper_dieticianID = $result->fetch_assoc()['dieticianID'];
			$result->free_result();

			$connection->query("START TRANSACTION");

			// Szukanie w bazie informacji, czy aby grafik dla danego dnia nie zostal juz ustalony
			if(!($result2 = $connection->query("select count(*) as count from officehours where (dieticianID like '$helper_dieticianID' and dayOfTheWeek = '$day')")))
				throw new Exception($connection->error);
			else if($result2->fetch_assoc()['count'] == 1)	// Grafik zostal juz wczesniej ustalony dla danego dnia...
			{
				switch($hours)	// ...wiec musimy zrobic update danych
				{
					case '08:00 - 12:00':
					{
						if(!($connection->query("update officehours set starts_at = '08:00:00', ends_at = '12:00:00'
								where (dieticianID like '$helper_dieticianID' and dayOfTheWeek = '$day')")))
							throw new Exception($connection->error);
						break;
					}
					case '12:00 - 16:00':
					{
						if(!($connection->query("update officehours set starts_at = '12:00:00', ends_at = '16:00:00'
								where (dieticianID like '$helper_dieticianID' and dayOfTheWeek = '$day')")))
							throw new Exception($connection->error);
						break;
					}
					case '16:00 - 20:00':
					{
						if(!($connection->query("update officehours set starts_at = '16:00:00', ends_at = '20:00:00'
								where (dieticianID like '$helper_dieticianID' and dayOfTheWeek = '$day')")))
							throw new Exception($connection->error);
						break;
					}
				}
				$result2->free_result();
			}
			else	// $result2->fetch_assoc()['count'] = 0, zatem grafik dla danego dnia jest ustalany po raz pierwszy
			{
				switch($hours)
				{
					case '08:00 - 12:00':
					{
						if(!($connection->query("insert into officehours values(null, '$helper_dieticianID', '$day', '08:00:00', '12:00:00')")))
							throw new Exception($connection->error);
						break;
					}
					case '12:00 - 16:00':
					{
						if(!($connection->query("insert into officehours values(null, '$helper_dieticianID', '$day', '12:00:00', '16:00:00')")))
							throw new Exception($connection->error);
						break;
					}
					case '16:00 - 20:00':
					{
						if(!($connection->query("insert into officehours values(null, '$helper_dieticianID', '$day', '16:00:00', '20:00:00')")))
							throw new Exception($connection->error);
						break;
					}
				}
				$result2->free_result();
			}

			$connection->query("COMMIT");
			$connection->close();
		}
	}
	catch (Exception $e)
	{
		$connection->query("ROLLBACK");
		header("Location: html_files/serverError_goToLogout.html");
		//echo '<br/>Informacja developerska: '.$e;
	}
}

function analyzeChanges()
{
	// Zapis do zmiennych info, ktore checkbox'y zostaly zaznaczone
	if(isset($_POST['monCheckbox'])) $monCheckbox = $_POST['monCheckbox'];
	else $monCheckbox = null;

	if(isset($_POST['tueCheckbox'])) $tueCheckbox = $_POST['tueCheckbox'];
	else $tueCheckbox = null;

	if(isset($_POST['wedCheckbox'])) $wedCheckbox = $_POST['wedCheckbox'];
	else $wedCheckbox = null;

	if(isset($_POST['thuCheckbox'])) $thuCheckbox = $_POST['thuCheckbox'];
	else $thuCheckbox = null;

	if(isset($_POST['friCheckbox'])) $friCheckbox = $_POST['friCheckbox'];
	else $friCheckbox = null;

	if(isset($_POST['satCheckbox'])) $satCheckbox = $_POST['satCheckbox'];
	else $satCheckbox = null;

	// Zapis do zmiennych wybranych godzin przyjec
	$monSelect = $_POST['monSelect'];
	$tueSelect = $_POST['tueSelect'];
	$wedSelect = $_POST['wedSelect'];
	$thuSelect = $_POST['thuSelect'];
	$friSelect = $_POST['friSelect'];
	$satSelect = $_POST['satSelect'];

	// Jesli checkbox zostal zaznaczony oraz godzina zostala wybrana, to wywolujemy funkcje saveToDb()
	if($monCheckbox != null && $monCheckbox == 'on' && $monSelect != '---brak---') saveToDb(0, $monSelect);
	if($tueCheckbox != null && $tueCheckbox == 'on' && $tueSelect != '---brak---') saveToDb(1, $tueSelect);
	if($wedCheckbox != null && $wedCheckbox == 'on' && $wedSelect != '---brak---') saveToDb(2, $wedSelect);
	if($thuCheckbox != null && $thuCheckbox == 'on' && $thuSelect != '---brak---') saveToDb(3, $thuSelect);
	if($friCheckbox != null && $friCheckbox == 'on' && $friSelect != '---brak---') saveToDb(4, $friSelect);
	if($satCheckbox != null && $satCheckbox == 'on' && $satSelect != '---brak---') saveToDb(5, $satSelect);
}

/**************************ZABEZPIECZENIE PRZED MULTI CLICK'IEM**************************/

// Funkcja generujaca token, ktory jest uzywany w formularzu
function getToken()
{
	$token = sha1(mt_rand());
	if(!isset($_SESSION['tokensPreventMulticlickInOfficehours']))
		$_SESSION['tokensPreventMulticlickInOfficehours'] = array($token => 1);
	else
		$_SESSION['tokensPreventMulticlickInOfficehours'][$token] = 1;
	return $token;
}

// Sprawdzanie poprawnosci tokenu oraz usuwanie go z listy poprawnych token'ow
function isTokenValid($token)
{
	if(!empty($_SESSION['tokensPreventMulticlickInOfficehours'][$token]))
	{
		unset($_SESSION['tokensPreventMulticlickInOfficehours'][$token]);
		return true;
	}
	return false;
}

// Sprawdzenie, czy formularz zostal wyslany
$postedToken = filter_input(INPUT_POST, 'token');
if(!empty($postedToken))
{
	if(isTokenValid($postedToken))
		analyzeChanges();

	/*Obsluzenie przypadku, w ktorym, nastepuje multiclick dla klikniec drugiego i kolejnego nie jest potrzebne, poniewaz
	zapis godzin przyjec jest wykonywany w transakcji (wykona sie w calosci, albo w ogole). Cofanie wprowadzonych i
	zatwierdzonych zmian byloby bez sensu, poniewaz zniszczylibysmy byc moze poprzednie dane, ktore byly dobre i zapisane
	w tym samym wierszu tabeli. Obecna sytuacja jest dobra, poniewaz dla klikniec drugiego i kolejnego nie dzieje sie nic
	(funkcja analyzeChanges() wywoluje sie tylko przy zgodnym token'ie, czyli tylko dla pierwszego klikniecia).*/
}

$token = getToken();
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>Twój panel dietetyka</title>
	<link rel="stylesheet" href="css_files/basic.css" type="text/css"/>
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
			<div id="topbarL"><img id="topbarL-img" src="img/heart-vegetable.png"/></div>
			<div id="topbarR">
				<div id="quotation">"Optymalne żywienie jest medycyną jutra".</div>
				<div id="signature">dr Linus Pauling</div>
			</div>
		</div>
	</div>
	<div id="content">
		<form method="post">
			<div id="daysOfTheWeekPackage">
				<div class="dayOfTheWeek" id="mon">
				Poniedziałek
					<img src="img/monday-img.png"/>
					<div class="choice">
						<div class="divWithCheckbox"><label><input type="checkbox" name="monCheckbox"/>Wybieram</label></div>
						<div class="divWithOfficehours">
							<div class="selectPackage">
								Godziny pracy:<select title="monSelect_title" name="monSelect">
									<option>---brak---</option>
									<optgroup label="Rano">
										<option>08:00 - 12:00</option>
									</optgroup>
									<optgroup label="Po południu">
										<option>12:00 - 16:00</option>
									</optgroup>
									<optgroup label="Wieczorem">
										<option>16:00 - 20:00</option>
									</optgroup>
								</select>
							</div>
						</div>
						<div style="clear: both"></div>
					</div>
				</div>
				<div class="dayOfTheWeek" id="tue">
					Wtorek
					<img src="img/tuesday-img.png"/>
					<div class="choice">
						<div class="divWithCheckbox"><label><input type="checkbox" name="tueCheckbox"/>Wybieram</label></div>
						<div class="divWithOfficehours">
							<div class="selectPackage">
								Godziny pracy:<select title="tueSelect_title" name="tueSelect">
									<option>---brak---</option>
									<optgroup label="Rano">
										<option>08:00 - 12:00</option>
									</optgroup>
									<optgroup label="Po południu">
										<option>12:00 - 16:00</option>
									</optgroup>
									<optgroup label="Wieczorem">
										<option>16:00 - 20:00</option>
									</optgroup>
								</select>
							</div>
						</div>
						<div style="clear: both"></div>
					</div>
				</div>
				<div class="dayOfTheWeek" id="wed">
					Środa
					<img src="img/wednesday-img.png"/>
					<div class="choice">
						<div class="divWithCheckbox"><label><input type="checkbox" name="wedCheckbox"/>Wybieram</label></div>
						<div class="divWithOfficehours">
							<div class="selectPackage">
								Godziny pracy:<select title="wedSelect_title" name="wedSelect">
									<option>---brak---</option>
									<optgroup label="Rano">
										<option>08:00 - 12:00</option>
									</optgroup>
									<optgroup label="Po południu">
										<option>12:00 - 16:00</option>
									</optgroup>
									<optgroup label="Wieczorem">
										<option>16:00 - 20:00</option>
									</optgroup>
								</select>
							</div>
						</div>
						<div style="clear: both"></div>
					</div>
				</div>
				<div class="dayOfTheWeek" id="thu">
					Czwartek
					<img src="img/thursday-img.png"/>
					<div class="choice">
						<div class="divWithCheckbox"><label><input type="checkbox" name="thuCheckbox"/>Wybieram</label></div>
						<div class="divWithOfficehours">
							<div class="selectPackage">
								Godziny pracy:<select title="thuSelect_title" name="thuSelect">
									<option>---brak---</option>
									<optgroup label="Rano">
										<option>08:00 - 12:00</option>
									</optgroup>
									<optgroup label="Po południu">
										<option>12:00 - 16:00</option>
									</optgroup>
									<optgroup label="Wieczorem">
										<option>16:00 - 20:00</option>
									</optgroup>
								</select>
							</div>
						</div>
						<div style="clear: both"></div>
					</div>
				</div>
				<div class="dayOfTheWeek" id="fri">
					Piątek
					<div class="choice">
						<div class="divWithCheckbox"><label><input type="checkbox" name="friCheckbox"/>Wybieram</label></div>
						<div class="divWithOfficehours">
							<div class="selectPackage">
								Godziny pracy:<select title="friSelect_title" name="friSelect">
									<option>---brak---</option>
									<optgroup label="Rano">
										<option>08:00 - 12:00</option>
									</optgroup>
									<optgroup label="Po południu">
										<option>12:00 - 16:00</option>
									</optgroup>
									<optgroup label="Wieczorem">
										<option>16:00 - 20:00</option>
									</optgroup>
								</select>
							</div>
						</div>
						<div style="clear: both"></div>
					</div>
				</div>
				<div class="dayOfTheWeek" id="sat">
					Sobota
					<div class="choice">
						<div class="divWithCheckbox"><label><input type="checkbox" name="satCheckbox"/>Wybieram</label></div>
						<div class="divWithOfficehours">
							<div class="selectPackage">
								Godziny pracy:<select title="satSelect_title" name="satSelect">
									<option>---brak---</option>
									<optgroup label="Rano">
										<option>08:00 - 12:00</option>
									</optgroup>
									<optgroup label="Po południu">
										<option>12:00 - 16:00</option>
									</optgroup>
									<optgroup label="Wieczorem">
										<option>16:00 - 20:00</option>
									</optgroup>
								</select>
							</div>
						</div>
						<div style="clear: both"></div>
					</div>
				</div>
				<div style="clear: both"></div>
			</div>
			<input type="submit" id="officeHoursButton" value="Zatwierdź"
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
