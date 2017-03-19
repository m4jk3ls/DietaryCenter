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
			if(!$result = $connection->query("select concat(u.lastName, ' ', u.firstName) as Patient, v.visitDate as Date, v.visitHour as Hour
											  from visit v join patient p on(v.patientID = p.patientID) join user u on(p.userID = u.userID)
											  where v.dieticianID = (select dieticianID from dietician where userID like '$userID') and v.visitDate like '$date'
											  order by v.visitDate asc, v.visitHour asc")
			)
				throw new Exception($connection->error);
			else
			{
				$visits = array(array());
				$i = 0;
				while ($row = $result->fetch_assoc())
				{
					$visits[$i][] = $row['Patient'];
					$visits[$i][] = $row['Date'];
					$visits[$i][] = substr($row['Hour'], -8, 5);
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