<?php
session_start();

function convertMonthToNumber($month)
{
	switch ($month)
	{
		case "Styczeń":
			return "01";
		case "Luty":
			return "02";
		case "Marzec":
			return "03";
		case "Kwiecień":
			return "04";
		case "Maj":
			return "05";
		case "Czerwiec":
			return "06";
		case "Lipiec":
			return "07";
		case "Sierpień":
			return "08";
		case "Wrzesień":
			return "09";
		case "Październik":
			return "10";
		case "Listopad":
			return "11";
		case "Grudzień":
			return "12";
		default:
			return null;
	}
}

if(!isset($_POST['userID']) || !isset($_POST['year']) || !isset($_POST['month']) || !isset($_POST['day']))
	echo 'Nie przesłano wszystkich potrzebnych danych!';
else if($_POST['year'] == "---rok---" || $_POST['month'] == "---miesiąc---" || $_POST['day'] == "---dzień---" || $_POST['day'] == null)
	echo "Podaj poprawną datę!";
else
{
	$userID = $_POST['userID'];
	$year = $_POST['year'];
	$month = $_POST['month'];
	$day = $_POST['day'];
	$date = $year . '-' . convertMonthToNumber($month) . '-' . $day;

	require_once "../connect.php";
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
			if(!($result = $connection->query("select Name, visitDate, visitHour from visits where dieticianID =
											  (select dieticianID from dieticians where userID like '$userID') and visitDate like '$date'"))
			)
				throw new Exception($connection->error);
			else
			{
				$visits = array(array());
				$i = 0;
				while ($row = $result->fetch_assoc())
				{
					$visits[$i][] = $row['Name'];
					$visits[$i][] = $row['visitDate'];
					$visits[$i][] = substr($row['visitHour'], -8, 5);
					$i++;
				}
			}
			$connection->close();
		}

		$table = '<table><tr class="firstRow"><td>Pacjent</td><td>Dzień</td><td>Godzina</td></tr>';
		for ($j = 0; $j < $i; $j++)
		{
			if(($visits[$j][1] . ' ' . $visits[$j][2]) < date("Y-m-d H:i"))
				$table .= '<tr class="redRow"><td>' . $visits[$j][0] . '</td><td>' . $visits[$j][1] . '</td><td>' . $visits[$j][2] . '</td></tr>';
			else
				$table .= '<tr class="greenRow"><td>' . $visits[$j][0] . '</td><td>' . $visits[$j][1] . '</td><td>' . $visits[$j][2] . '</td></tr>';
		}
		$table .= '</table>';

		echo $table;
	}
	catch (Exception $e)
	{
		header("Location: ../html_files/serverError_goToLogout.html");
		//echo '<br/>Informacja developerska: '.$e;
	}
}