<?php
	session_start();

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
			if(!($polaczenie->query("update uzytkownik set token=null WHERE login='$login_help'")))
				throw new Exception($polaczenie->error);
		}

		session_unset();
		setcookie("zalogowany", false, time() - 1);
		setcookie("token", null, time() - 1);
		header('Location: index.php');
	}
	catch(Exception $e)
	{
		echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o ponowienie próby wylogowania!</span>';
		//echo '<br/>Informacja developerska: '.$e;
		sleep(5);
		header('Location: twoja_karta.php');
	}
?>