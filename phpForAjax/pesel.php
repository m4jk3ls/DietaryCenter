<?php
function CheckPESEL($str)
{
	if(!preg_match('/^[0-9]{11}$/', $str)) //sprawdzamy czy ciąg ma 11 cyfr
		return false;

	$arrSteps = array(1, 3, 7, 9, 1, 3, 7, 9, 1, 3); // tablica z odpowiednimi wagami
	$intSum = 0;

	for ($i = 0; $i < 10; $i++)
		$intSum += $arrSteps[$i] * $str[$i]; //mnożymy każdy ze znaków przez wagć i sumujemy wszystko

	$int = 10 - $intSum % 10; //obliczamy sumć kontrolną
	$intControlNr = ($int == 10) ? 0 : $int;

	if($intControlNr == $str[10]) //sprawdzamy czy taka sama suma kontrolna jest w ciągu
		return true;
	return false;
}

if(!isset($_POST['pesel']))
	echo "Nie przesłano numeru PESEL!";
else if(!CheckPESEL($_POST['pesel']))
	echo "Numer PESEL jest niepoprawny!";
else
{
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
			$pesel = $_POST['pesel'];
			if($result = $connection->query("select personalIdentityNumber from dietician where personalIdentityNumber like '$pesel'"))
			{
				$howManyUsers = $result->num_rows;
				if($howManyUsers > 0)
				{
					echo 'To nie jest Twój numer PESEL!';
					$result->free_result();
				}
				else
					$result->free_result();
			}
			else
				throw new Exception($connection->error);
			$connection->close();
		}
	}
	catch (Exception $e)
	{
		header("Location: ../html_files/serverError_goToLogout.html");
		//echo '<br/>Informacja developerska: '.$e;
	}
}