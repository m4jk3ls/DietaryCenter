<?php
	session_start();

	if(!isset($_COOKIE["zalogowany"]))
	{
		header('Location: index.php');
		exit();
	}
	else
	{
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		try
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			$polaczenie->set_charset('utf8');

			if ($polaczenie->connect_errno != 0)
				throw new Exception($polaczenie->connect_error);
			else
			{
				$login_help = $_SESSION['login'];
				$token_help = $_COOKIE['token'];

				if (!($rezultat = $polaczenie->query("select count(Token) from aktywne_sesje where Login like '$login_help' and Token like '$token_help'")))
					throw new Exception($polaczenie->error);
				if(!$rezultat->fetch_assoc()['count(Token)'])	//Jesli w bazie nie ma pasujacego do ciastka token'a (zostal zwrocony wiersz z wartoscia count(Token)=0)
				{
					if(!$polaczenie->query("delete from aktywne_sesje where Login like '$login_help'"))
						throw new Exception($polaczenie->error);

					$polaczenie->close();
					$rezultat->free_result();
					header('Location: logout.php');
					exit();
				}

				$rezultat->free_result();
				$polaczenie->close();
			}
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o ponowne zalogowanie się!</span>';
			//echo '<br/>Informacja developerska: '.$e;
			sleep(5);
			header('Location: logout.php');
			exit();
		}
	}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>NaturHouse - Twoja karta pacjenta</title>
</head>

<body>
<?php
	echo "<p>Witaj ".$_SESSION['login']." - jesteś zalogowany do swojego NH-konta".'! [<a href="logout.php">Wyloguj się</a>]</p>';
	
	$dataCzas = new DateTime();
	echo "Mamy dziś ".$dataCzas->format('Y-m-d').", godzinę ".$dataCzas->format('H:i:s')."<br/>";
?>
</body>
</html>