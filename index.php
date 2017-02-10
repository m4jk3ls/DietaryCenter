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
	<link rel="stylesheet" href="css_files/index_style.css" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Great+Vibes|Playfair+Display:400,700&amp;subset=latin-ext" rel="stylesheet">
	<script src="javascript_files/jquery-3.1.1.min.js"></script>
	<script src="javascript_files/getDivsSizes.js"></script>
	<script src="javascript_files/ajaxForLog.js"></script>
	<script src="javascript_files/ajaxForPass.js"></script>
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
	<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
	<script src="javascript_files/cookiesBanner.js"></script>
	<noscript><div style="font-size: 30px;">JavaScript jest wyłączony!</div></noscript>
</head>

<body>
		<div id="header">Witaj w świecie NaturHouse!</div>

		<div id="log_form">

			<form action="zaloguj.php" method="post">
				<input type="text" name="login" id="log" placeholder="login"/>
				<div class="komunikat" id="komunikat1"></div>

				<input type="password" name="haslo" id="pass" placeholder="hasło"/>
				<div class="komunikat" id="komunikat2"></div>
				<?php
					if(isset($_SESSION['blad']))
					{
						echo '<div id="glowny_komunikat">'.$_SESSION['blad'].'</div>';
						unset($_SESSION['blad']);
					}
				?>

				<input type="submit" value="Zaloguj się"/>
			</form>

			<div id="tekst_lub">-------- lub --------</div>
			<div id="link_rejestracji"><a href="rejestracja.php">Zarejestruj się i dołącz do nas!</a></div>

		</div>
</body>
</html>