<?php
	session_start();
	if(isset($_COOKIE["zalogowany"]))
	{
		header('Location: twoja_karta.php');
		exit();
	}

	function generateRandomString()
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < 10; $i++)
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		return $randomString;
	}
	
	if(isset($_POST['email']))
	{
		$wszystko_OK=true;
		
		$imie = $_POST['imie'];
		if(strlen($imie)<1)
		{
			$wszystko_OK=false;
			$_SESSION['e_imie']="Nie podałeś swojego imienia!";
		}
		
		
		$nazwisko = $_POST['nazwisko'];
		if(strlen($nazwisko)<1)
		{
			$wszystko_OK=false;
			$_SESSION['e_nazwisko']="Nie podałeś swojego nazwiska!";
		}
		
		
		$login = $_POST['login'];
		if((strlen($login)<3) || (strlen($login)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_login']="Login musi posiadać od 3 do 20 znaków!";
		}
		if(ctype_alnum($login)==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_login']="Login może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
		
		
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		if((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email))
		{
			$wszystko_OK = false;
			$_SESSION['e_email'] = "Podaj poprawny adres email!";
		}
		
		
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		if(strlen($haslo1)<8 || strlen($haslo1)>20)
		{
			$wszystko_OK = false;
			$_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków!";
		}
		if($haslo1 != $haslo2)
		{
			$wszystko_OK = false;
			$_SESSION['e_haslo']="Podane hasła nie są identyczne!";
		}


		$salt = generateRandomString();
		//$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);	//Po Zelentowemu
		$haslo_hash = sha1($haslo1.$salt);
		
		
		$sekret = "6LdueQwUAAAAAP3YdoBKWrUuynRkVouPmL0D_hPo";
		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
		$odpowiedz = json_decode($sprawdz);
		if(!($odpowiedz->success))
		{
			$wszystko_OK=false;
			$_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
		}
		
		
		$_SESSION['fr_imie']=$imie;
		$_SESSION['fr_nazwisko']=$nazwisko;
		$_SESSION['fr_login']=$login;
		$_SESSION['fr_email']=$email;
		$_SESSION['fr_haslo1']=$haslo1;
		$_SESSION['fr_haslo2']=$haslo2;
	
	
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		try
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			$polaczenie->set_charset('utf8');
			
			if($polaczenie->connect_errno != 0)
				throw new Exception($polaczenie->connect_error);
			else
			{
				$rezultat = $polaczenie->query("select p.id_pacjent from pacjent p
												join uzytkownik u on (p.id_uzytkownik=u.id_uzytkownik)
												where u.email='$email'");
				
				if(!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili > 0)
				{
					$wszystko_OK = false;
					$_SESSION['e_email']="Istnieje już użytkownik o takim adresie email!";
				}
				
				$rezultat = $polaczenie->query("select id_uzytkownik from uzytkownik where login='$login'");
				
				if(!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_loginow = $rezultat->num_rows;
				if($ile_takich_loginow > 0)
				{
					$wszystko_OK = false;
					$_SESSION['e_login']="Istnieje już użytkownik o takim loginie! Wybierz inny.";
				}
				
				if($wszystko_OK==true)
				{
					try
					{
						$polaczenie->query("START TRANSACTION");

						if($polaczenie->query("insert into uzytkownik values (null, '$imie', '$nazwisko', '$email', '$login', '$haslo_hash', '$salt')") &&
							$polaczenie->query("insert into pacjent values (null, LAST_INSERT_ID())"))
							$polaczenie->query("COMMIT");
						else
							throw new Exception($polaczenie->error);
							
						$_SESSION['udana_rejestracja']=true;
						header('Location: witamy.php');
					}
					catch(Exception $e)
					{
						$polaczenie->query("ROLLBACK");
						echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
						//echo '<br/>Informacja developerska: '.$e;
					}
				}
				$polaczenie->close();
			}
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			//echo '<br/>Informacja developerska: '.$e;
		}
	}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>Załóż darmowe NH-konto!</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<link rel="stylesheet" href="rejestracja_style.css" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Great+Vibes|Playfair+Display:400,700&amp;subset=latin-ext" rel="stylesheet">
	
	<style>
		.error
		{
			color:red;
			margin-top: 10px;
			margin-bottom: 10px;
		}
	</style>
</head>

<body>
	<div id="header">Rejestrujemy się!</div>

	<div id="sign_form">
		<form method="post">
			<input type="text" placeholder="imię" value="<?php						//Imie
				if(isset($_SESSION['fr_imie']))
				{
					echo $_SESSION['fr_imie'];
					unset($_SESSION['fr_imie']);
				}
			?>" name="imie"/><br/>
			<?php
				if(isset($_SESSION['e_imie']))
				{
					echo '<div class="error">'.$_SESSION['e_imie'].'</div>';
					unset($_SESSION['e_imie']);
				}
			?>

			<input type="text" placeholder="nazwisko" value="<?php					//Nazwisko
				if(isset($_SESSION['fr_nazwisko']))
				{
					echo $_SESSION['fr_nazwisko'];
					unset($_SESSION['fr_nazwisko']);
				}
			?>" name="nazwisko"/><br/>
			<?php
				if(isset($_SESSION['e_nazwisko']))
				{
					echo '<div class="error">'.$_SESSION['e_nazwisko'].'</div>';
					unset($_SESSION['e_nazwisko']);
				}
			?>

			<input type="text" placeholder="login" value="<?php						//Login
				if(isset($_SESSION['fr_login']))
				{
					echo $_SESSION['fr_login'];
					unset($_SESSION['fr_login']);
				}
			?>" name="login"/><br/>
			<?php
				if(isset($_SESSION['e_login']))
				{
					echo '<div class="error">'.$_SESSION['e_login'].'</div>';
					unset($_SESSION['e_login']);
				}
			?>

			<input type="text" placeholder="e-mail" value="<?php					//E-mail
				if(isset($_SESSION['fr_email']))
				{
					echo $_SESSION['fr_email'];
					unset($_SESSION['fr_email']);
				}
			?>" name="email"/><br/>
			<?php
				if(isset($_SESSION['e_email']))
				{
					echo '<div class="error">'.$_SESSION['e_email'].'</div>';
					unset($_SESSION['e_email']);
				}
			?>

			<input type="password" placeholder="hasło" value="<?php					//Haslo
				if(isset($_SESSION['fr_haslo1']))
				{
					echo $_SESSION['fr_haslo1'];
					unset($_SESSION['fr_haslo1']);
				}
			?>" name="haslo1"/><br/>
			<?php
				if(isset($_SESSION['e_haslo']))
				{
					echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
					unset($_SESSION['e_haslo']);
				}
			?>

			<input type="password" placeholder="powtórz hasło" value="<?php			//Powtorz haslo
				if(isset($_SESSION['fr_haslo2']))
				{
					echo $_SESSION['fr_haslo2'];
					unset($_SESSION['fr_haslo2']);
				}
			?>" name="haslo2"/><br/>

			<div class="g-recaptcha" data-sitekey="6LdueQwUAAAAABd8TPKqvaYg3EA3A38NPabROrOZ"></div>
			<?php
				if(isset($_SESSION['e_bot']))
				{
					echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
					unset($_SESSION['e_bot']);
				}
			?>

			<input type="submit" value="Zarejestruj się"/>

			<div id="txt_lub">-------- lub --------</div>
			<div id="link_logowania"><a href="index.php">Wróć do strony logowania!</a></div>
		</form>
	</div>
</body>
</html>