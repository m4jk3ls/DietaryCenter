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
				$ID_help = $_SESSION['id_uzytkownik'];
				$token_help = $_COOKIE['token'];

				if (!($rezultat = $polaczenie->query("select count(Token) from aktywne_sesje where `Numer ID` like '$ID_help' and Token like '$token_help'")))
					throw new Exception($polaczenie->error);
				if(!$rezultat->fetch_assoc()['count(Token)'])	//Jesli w bazie nie ma pasujacego do ciastka token'a (zostal zwrocony wiersz z wartoscia count(Token)=0)
				{
					if(!$polaczenie->query("delete from aktywne_sesje where `Numer ID` like '$ID_help'"))
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

	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Twoja karta pacjenta</title>

	<link href="css_files/twoja_karta_style.css" rel="stylesheet" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Great+Vibes|Playfair+Display:400,700&amp;subset=latin-ext" rel="stylesheet">
	<script src="javascript_files/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="javascript_files/stickyMenu.js"></script>
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
	<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
	<script src="javascript_files/cookiesBanner.js"></script>

</head>

<body>
<div id="container">
	<div id="logo">
		<img id="logo-img" src="img/logo.jpg"/>
	</div>

	<ol class="menu">
		<li><a href="twoja_karta.php">Strona główna</a></li>
		<li><a href="#">Twoja wizyta</a></li>
		<li><a href="#">Twoje rezultaty</a></li>
		<li><a href="#">Kontakt</a></li>
		<li><a href="logout.php">Wyloguj</a></li>
	</ol>

	<div id="topbarPackage">
		<div id="topbar">
			<div id="topbarL">
				<img id="topbarL-img" src="img/czlowiek-warzywko.jpg"/>
			</div>

			<div id="topbarR">
				<div id="quotation">
					"Granice? Nigdy żadnej nie widziałem, ale słyszałem, że istnieją w umysłach niektórych ludzi".
				</div>

				<div id="signature">
					Thor Heyerdahl
				</div>
			</div>
		</div>
	</div>

	<div id="content">
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce vehicula dolor dapibus diam consequat, vel bibendum tortor pulvinar. Aenean eleifend odio quis ligula congue, sit amet suscipit orci placerat. Phasellus non nisl sit amet mauris tincidunt finibus. Curabitur convallis rutrum tempor. Vivamus venenatis, est id imperdiet pharetra, ligula mauris maximus lorem, at finibus neque dui malesuada lorem. Quisque aliquam massa id nulla consectetur laoreet. Aenean egestas, quam vitae fermentum placerat, neque urna consequat tellus, a finibus sem lacus non odio. Donec venenatis facilisis suscipit. Aenean quis gravida erat. In non ipsum sed nisl efficitur tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Pellentesque at magna a ligula mollis condimentum id sit amet sem. Ut dictum orci augue. Sed a condimentum orci. Integer suscipit bibendum magna, eu sodales dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent varius id sem a accumsan. Duis sit amet lectus in tortor faucibus ornare. Nullam in odio luctus, luctus tellus a, viverra magna. Interdum et malesuada fames ac ante ipsum primis in faucibus. Praesent et viverra diam, a feugiat ex. Aenean ac ante nunc. Fusce tempus, felis a feugiat dictum, mauris nisl sollicitudin turpis, non sodales orci elit id lorem. Donec vulputate felis ac blandit mollis. Donec maximus, erat quis ullamcorper bibendum, lorem est luctus risus, ac euismod justo enim vel augue. Praesent vehicula, ligula in posuere pellentesque, ipsum turpis mollis arcu, ac commodo mi tortor sit amet libero. Nullam vehicula lacus at auctor ullamcorper. Morbi nec turpis scelerisque, dapibus lorem ut, egestas dolor. Nam vitae elit felis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pulvinar accumsan efficitur. Quisque egestas lorem nec mi condimentum vulputate. Aliquam tempor, elit sit amet placerat imperdiet, nunc eros pharetra lorem, in sodales urna dolor at libero. Suspendisse scelerisque, nibh eu lacinia mattis, ligula massa volutpat nunc, sit amet luctus massa lectus sit amet nibh. Maecenas pulvinar facilisis nisi. Ut laoreet faucibus urna eu facilisis. In cursus vitae leo tempor dictum. Integer nec sagittis nibh. Pellentesque iaculis, ex quis condimentum blandit, ex nisi aliquam enim, a fermentum felis mi eget tortor. Nullam magna lacus, luctus ut lectus eget, efficitur consequat augue. Etiam nisl ipsum, dignissim vitae lorem sed, ultrices viverra ipsum. Sed id laoreet enim.
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce vehicula dolor dapibus diam consequat, vel bibendum tortor pulvinar. Aenean eleifend odio quis ligula congue, sit amet suscipit orci placerat. Phasellus non nisl sit amet mauris tincidunt finibus. Curabitur convallis rutrum tempor. Vivamus venenatis, est id imperdiet pharetra, ligula mauris maximus lorem, at finibus neque dui malesuada lorem. Quisque aliquam massa id nulla consectetur laoreet. Aenean egestas, quam vitae fermentum placerat, neque urna consequat tellus, a finibus sem lacus non odio. Donec venenatis facilisis suscipit. Aenean quis gravida erat. In non ipsum sed nisl efficitur tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Pellentesque at magna a ligula mollis condimentum id sit amet sem. Ut dictum orci augue. Sed a condimentum orci. Integer suscipit bibendum magna, eu sodales dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent varius id sem a accumsan. Duis sit amet lectus in tortor faucibus ornare. Nullam in odio luctus, luctus tellus a, viverra magna. Interdum et malesuada fames ac ante ipsum primis in faucibus. Praesent et viverra diam, a feugiat ex. Aenean ac ante nunc. Fusce tempus, felis a feugiat dictum, mauris nisl sollicitudin turpis, non sodales orci elit id lorem. Donec vulputate felis ac blandit mollis. Donec maximus, erat quis ullamcorper bibendum, lorem est luctus risus, ac euismod justo enim vel augue. Praesent vehicula, ligula in posuere pellentesque, ipsum turpis mollis arcu, ac commodo mi tortor sit amet libero. Nullam vehicula lacus at auctor ullamcorper. Morbi nec turpis scelerisque, dapibus lorem ut, egestas dolor. Nam vitae elit felis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pulvinar accumsan efficitur. Quisque egestas lorem nec mi condimentum vulputate. Aliquam tempor, elit sit amet placerat imperdiet, nunc eros pharetra lorem, in sodales urna dolor at libero. Suspendisse scelerisque, nibh eu lacinia mattis, ligula massa volutpat nunc, sit amet luctus massa lectus sit amet nibh. Maecenas pulvinar facilisis nisi. Ut laoreet faucibus urna eu facilisis. In cursus vitae leo tempor dictum. Integer nec sagittis nibh. Pellentesque iaculis, ex quis condimentum blandit, ex nisi aliquam enim, a fermentum felis mi eget tortor. Nullam magna lacus, luctus ut lectus eget, efficitur consequat augue. Etiam nisl ipsum, dignissim vitae lorem sed, ultrices viverra ipsum. Sed id laoreet enim.
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce vehicula dolor dapibus diam consequat, vel bibendum tortor pulvinar. Aenean eleifend odio quis ligula congue, sit amet suscipit orci placerat. Phasellus non nisl sit amet mauris tincidunt finibus. Curabitur convallis rutrum tempor. Vivamus venenatis, est id imperdiet pharetra, ligula mauris maximus lorem, at finibus neque dui malesuada lorem. Quisque aliquam massa id nulla consectetur laoreet. Aenean egestas, quam vitae fermentum placerat, neque urna consequat tellus, a finibus sem lacus non odio. Donec venenatis facilisis suscipit. Aenean quis gravida erat. In non ipsum sed nisl efficitur tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Pellentesque at magna a ligula mollis condimentum id sit amet sem. Ut dictum orci augue. Sed a condimentum orci. Integer suscipit bibendum magna, eu sodales dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent varius id sem a accumsan. Duis sit amet lectus in tortor faucibus ornare. Nullam in odio luctus, luctus tellus a, viverra magna. Interdum et malesuada fames ac ante ipsum primis in faucibus. Praesent et viverra diam, a feugiat ex. Aenean ac ante nunc. Fusce tempus, felis a feugiat dictum, mauris nisl sollicitudin turpis, non sodales orci elit id lorem. Donec vulputate felis ac blandit mollis. Donec maximus, erat quis ullamcorper bibendum, lorem est luctus risus, ac euismod justo enim vel augue. Praesent vehicula, ligula in posuere pellentesque, ipsum turpis mollis arcu, ac commodo mi tortor sit amet libero. Nullam vehicula lacus at auctor ullamcorper. Morbi nec turpis scelerisque, dapibus lorem ut, egestas dolor. Nam vitae elit felis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pulvinar accumsan efficitur. Quisque egestas lorem nec mi condimentum vulputate. Aliquam tempor, elit sit amet placerat imperdiet, nunc eros pharetra lorem, in sodales urna dolor at libero. Suspendisse scelerisque, nibh eu lacinia mattis, ligula massa volutpat nunc, sit amet luctus massa lectus sit amet nibh. Maecenas pulvinar facilisis nisi. Ut laoreet faucibus urna eu facilisis. In cursus vitae leo tempor dictum. Integer nec sagittis nibh. Pellentesque iaculis, ex quis condimentum blandit, ex nisi aliquam enim, a fermentum felis mi eget tortor. Nullam magna lacus, luctus ut lectus eget, efficitur consequat augue. Etiam nisl ipsum, dignissim vitae lorem sed, ultrices viverra ipsum. Sed id laoreet enim.
	</div>

	<div id="footer">
		NaturHouse - Twój osobisty dietetyk. Strona w sieci od 2017 r. &copy; Wszelkie prawa zastrzeżone
	</div>
</div>
</body>
</html>