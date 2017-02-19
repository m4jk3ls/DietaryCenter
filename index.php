<?php
session_start();
if (isset($_COOKIE["patientLogged"]))
{
	header('Location: yourCard.php');
	exit();
}
if (isset($_COOKIE["dieticianLogged"]))
{
	header('Location: dieticianCard.php');
	exit();
}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta name="description" content="Oficjalna aplikacja centrum dietetycznego NaturHouse"/>
	<meta name="keywords"
		  content="naturhouse, dietetyk, najlepszy dietetyk, dieta cud, jak schudnąć do wakacji, jak być zdrowym, zdrowe odżywianie, plan dietetyczny, organizacja posiłków, metamorfoza"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>NaturHouse - dietetyk na wyciągnięcie ręki</title>
	<link rel="stylesheet" href="css_files/index.css" type="text/css"/>
	<link href="https://fonts.googleapis.com/css?family=Great+Vibes|Playfair+Display:400,700&amp;subset=latin-ext"
		  rel="stylesheet">
	<script src="javascript_files/jquery-3.1.1.min.js"></script>
	<script src="javascript_files/getDivsSizes.js"></script>
	<script src="javascript_files/ajax/logIn_login.js"></script>
	<script src="javascript_files/ajax/logIn_password.js"></script>
	<script src="javascript_files/cookiesBanner.js"></script>
	<link rel="stylesheet" type="text/css"
		  href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css"/>
	<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
	<noscript><div id="infoAboutNoScript">Twoja przeglądarka nie obsługuje skryptów JavaScript!</div></noscript>
</head>

<body>
<div id="headline">Witaj w świecie NaturHouse!</div>
<div id="logInForm">
	<form action="logInProcess.php" method="post">
		<input type="text" name="login" id="loginID" placeholder="login"/>
		<div class="errorFromAjax" id="loginError"></div>
		<input type="password" name="passwd" id="passwdID" placeholder="hasło"/>
		<div class="errorFromAjax" id="passwdError"></div>
		<?php
		if (isset($_SESSION['error']))
		{
		echo '<div id="errorAfterSubmit">' . $_SESSION['error'] . '</div>';
		unset($_SESSION['error']);
		}
		?>
		<input type="submit" id="logInButton" value="Zaloguj się" onclick="this.disabled=true; this.value='Wczytuję...'; this.form.submit();"/>
	</form>
	<div id="alternative">-------- lub --------</div>
	<div id="linkToSignIn"><a href="signIn.php">Zarejestruj się i dołącz do nas!</a></div>
</div>
</body>
</html>