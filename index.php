<?php
	session_start();
	if(isset($_COOKIE["zalogowany"]))
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
	<link rel="stylesheet" href="index_style.css" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Great+Vibes|Playfair+Display:400,700&amp;subset=latin-ext" rel="stylesheet">
</head>

<body>
	<div id="container">
		<div id="header">Witaj w świecie NaturHouse!</div>

		<div id="log_form">

			<form action="zaloguj.php" method="post">
				<input type="text" name="login" placeholder="login"/>
				<input type="password" name="haslo" placeholder="hasło"/>
				<input type="submit" value="Zaloguj się"/>
			</form>

			<div id="tekst_lub">-------- lub --------</div>
			<div id="link_rejestracji"><a href="rejestracja.php">Zarejestruj się i dołącz do nas!</a></div>

		</div>
	</div>
<?php
	if(isset($_SESSION['blad']))	echo $_SESSION['blad'];
?>
</body>
</html>