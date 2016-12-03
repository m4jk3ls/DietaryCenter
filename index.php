<?php
	session_start();
	if((isset($_SESSION['zalogowany']))&&($_SESSION['zalogowany'] == true))
	{
		header('Location: twoja_karta.php');
		exit();
	}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta name="description" content="Oficjalna aplikacja centrum dietetycznego NaturHouse"/>
	<meta name="keywords" content="naturhouse, dietetyk, najlepszy dietetyk, dieta cud, jak schudnąć do wakacji, jak być zdrowym, zdrowe odżywianie, plan dietetyczny, organizacja posiłków, metamorfoza"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>NaturHouse - dietetyk na wyciągnięcie ręki</title>
</head>

<body>
	<a href="rejestracja.php">Zarejestruj się i dołącz do nas!</a>
	<br/><br/>
	
	<form action="zaloguj.php" method="post">
		Login: <br/> <input type="text" name="login"/> <br/>
		Hasło: <br/> <input type="password" name="haslo"/> <br/> <br/>
		<input type="submit" value="Zaloguj się"/>
	</form>
<?php
	if(isset($_SESSION['blad']))	echo $_SESSION['blad'];
?>	

</body>
</html>