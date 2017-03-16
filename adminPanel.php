<?php
if(!isset($_COOKIE['adminLogged']))
{
	header("Location: index.php");
	exit();
}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>Panel admina NaturHouse</title>
	<link rel="stylesheet" href="css_files/basic.css" type="text/css"/>
	<link href="css_files/card.css" rel="stylesheet" type="text/css"/>
	<link href="https://fonts.googleapis.com/css?family=Great+Vibes|Playfair+Display:400,700&amp;subset=latin-ext"
		  rel="stylesheet">
	<script src="javascript_files/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="javascript_files/stickyMenu.js"></script>
	<link rel="stylesheet" type="text/css"
		  href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css"/>
	<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
	<script src="javascript_files/cookiesBanner.js"></script>
	<noscript><div id="infoAboutNoScript">Twoja przeglądarka nie obsługuje skryptów JavaScript!</div></noscript>
	<style>
		.menu > li:first-child
		{
			width: 25%;
		}

		.menu > li:first-child + li
		{
			width: 25%;
		}

		.menu > li:first-child + li + li
		{
			width: 25%;
		}

		.menu > li:first-child + li + li + li
		{
			width: 25%;
		}

		.menu > li:first-child + li + li + li + li
		{
			width: 25%;
		}
	</style>
</head>

<body>
<div id="container">
	<div id="logo"><img id="logo-img" src="img/logo.jpg"/></div>
	<ol class="menu">
		<li><a href="adminPanel.php">Strona główna</a></li>
		<li><a href="dieticiansManager.php">Dietetycy</a></li>
		<li><a href="patientsManager.php">Pacjenci</a></li>
		<li><a href="logOut.php">Wyloguj</a></li>
	</ol>
	<div id="topbarPackage">
		<div id="topbar">
			<div id="topbarL"><img id="topbarL-img" src="img/admin.png"/></div>
			<div id="topbarR">
				<div id="quotation">„Jesteśmy tym, co wciąż powtarzamy. Doskonałość nie jest zatem aktem, ale nawykiem".</div>
				<div id="signature">Arystoteles</div>
			</div>
		</div>
	</div>
	<div id="content">
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce vehicula dolor dapibus diam consequat, vel bibendum tortor pulvinar. Aenean eleifend odio quis ligula congue, sit amet suscipit orci placerat. Phasellus non nisl sit amet mauris tincidunt finibus. Curabitur convallis rutrum tempor. Vivamus venenatis, est id imperdiet pharetra, ligula mauris maximus lorem, at finibus neque dui malesuada lorem. Quisque aliquam massa id nulla consectetur laoreet. Aenean egestas, quam vitae fermentum placerat, neque urna consequat tellus, a finibus sem lacus non odio. Donec venenatis facilisis suscipit. Aenean quis gravida erat. In non ipsum sed nisl efficitur tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Pellentesque at magna a ligula mollis condimentum id sit amet sem. Ut dictum orci augue. Sed a condimentum orci. Integer suscipit bibendum magna, eu sodales dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent varius id sem a accumsan. Duis sit amet lectus in tortor faucibus ornare. Nullam in odio luctus, luctus tellus a, viverra magna. Interdum et malesuada fames ac ante ipsum primis in faucibus. Praesent et viverra diam, a feugiat ex. Aenean ac ante nunc. Fusce tempus, felis a feugiat dictum, mauris nisl sollicitudin turpis, non sodales orci elit id lorem. Donec vulputate felis ac blandit mollis. Donec maximus, erat quis ullamcorper bibendum, lorem est luctus risus, ac euismod justo enim vel augue. Praesent vehicula, ligula in posuere pellentesque, ipsum turpis mollis arcu, ac commodo mi tortor sit amet libero. Nullam vehicula lacus at auctor ullamcorper. Morbi nec turpis scelerisque, dapibus lorem ut, egestas dolor. Nam vitae elit felis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pulvinar accumsan efficitur. Quisque egestas lorem nec mi condimentum vulputate. Aliquam tempor, elit sit amet placerat imperdiet, nunc eros pharetra lorem, in sodales urna dolor at libero. Suspendisse scelerisque, nibh eu lacinia mattis, ligula massa volutpat nunc, sit amet luctus massa lectus sit amet nibh. Maecenas pulvinar facilisis nisi. Ut laoreet faucibus urna eu facilisis. In cursus vitae leo tempor dictum. Integer nec sagittis nibh. Pellentesque iaculis, ex quis condimentum blandit, ex nisi aliquam enim, a fermentum felis mi eget tortor. Nullam magna lacus, luctus ut lectus eget, efficitur consequat augue. Etiam nisl ipsum, dignissim vitae lorem sed, ultrices viverra ipsum. Sed id laoreet enim.
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce vehicula dolor dapibus diam consequat, vel bibendum tortor pulvinar. Aenean eleifend odio quis ligula congue, sit amet suscipit orci placerat. Phasellus non nisl sit amet mauris tincidunt finibus. Curabitur convallis rutrum tempor. Vivamus venenatis, est id imperdiet pharetra, ligula mauris maximus lorem, at finibus neque dui malesuada lorem. Quisque aliquam massa id nulla consectetur laoreet. Aenean egestas, quam vitae fermentum placerat, neque urna consequat tellus, a finibus sem lacus non odio. Donec venenatis facilisis suscipit. Aenean quis gravida erat. In non ipsum sed nisl efficitur tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Pellentesque at magna a ligula mollis condimentum id sit amet sem. Ut dictum orci augue. Sed a condimentum orci. Integer suscipit bibendum magna, eu sodales dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent varius id sem a accumsan. Duis sit amet lectus in tortor faucibus ornare. Nullam in odio luctus, luctus tellus a, viverra magna. Interdum et malesuada fames ac ante ipsum primis in faucibus. Praesent et viverra diam, a feugiat ex. Aenean ac ante nunc. Fusce tempus, felis a feugiat dictum, mauris nisl sollicitudin turpis, non sodales orci elit id lorem. Donec vulputate felis ac blandit mollis. Donec maximus, erat quis ullamcorper bibendum, lorem est luctus risus, ac euismod justo enim vel augue. Praesent vehicula, ligula in posuere pellentesque, ipsum turpis mollis arcu, ac commodo mi tortor sit amet libero. Nullam vehicula lacus at auctor ullamcorper. Morbi nec turpis scelerisque, dapibus lorem ut, egestas dolor. Nam vitae elit felis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pulvinar accumsan efficitur. Quisque egestas lorem nec mi condimentum vulputate. Aliquam tempor, elit sit amet placerat imperdiet, nunc eros pharetra lorem, in sodales urna dolor at libero. Suspendisse scelerisque, nibh eu lacinia mattis, ligula massa volutpat nunc, sit amet luctus massa lectus sit amet nibh. Maecenas pulvinar facilisis nisi. Ut laoreet faucibus urna eu facilisis. In cursus vitae leo tempor dictum. Integer nec sagittis nibh. Pellentesque iaculis, ex quis condimentum blandit, ex nisi aliquam enim, a fermentum felis mi eget tortor. Nullam magna lacus, luctus ut lectus eget, efficitur consequat augue. Etiam nisl ipsum, dignissim vitae lorem sed, ultrices viverra ipsum. Sed id laoreet enim.
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce vehicula dolor dapibus diam consequat, vel bibendum tortor pulvinar. Aenean eleifend odio quis ligula congue, sit amet suscipit orci placerat. Phasellus non nisl sit amet mauris tincidunt finibus. Curabitur convallis rutrum tempor. Vivamus venenatis, est id imperdiet pharetra, ligula mauris maximus lorem, at finibus neque dui malesuada lorem. Quisque aliquam massa id nulla consectetur laoreet. Aenean egestas, quam vitae fermentum placerat, neque urna consequat tellus, a finibus sem lacus non odio. Donec venenatis facilisis suscipit. Aenean quis gravida erat. In non ipsum sed nisl efficitur tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Pellentesque at magna a ligula mollis condimentum id sit amet sem. Ut dictum orci augue. Sed a condimentum orci. Integer suscipit bibendum magna, eu sodales dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent varius id sem a accumsan. Duis sit amet lectus in tortor faucibus ornare. Nullam in odio luctus, luctus tellus a, viverra magna. Interdum et malesuada fames ac ante ipsum primis in faucibus. Praesent et viverra diam, a feugiat ex. Aenean ac ante nunc. Fusce tempus, felis a feugiat dictum, mauris nisl sollicitudin turpis, non sodales orci elit id lorem. Donec vulputate felis ac blandit mollis. Donec maximus, erat quis ullamcorper bibendum, lorem est luctus risus, ac euismod justo enim vel augue. Praesent vehicula, ligula in posuere pellentesque, ipsum turpis mollis arcu, ac commodo mi tortor sit amet libero. Nullam vehicula lacus at auctor ullamcorper. Morbi nec turpis scelerisque, dapibus lorem ut, egestas dolor. Nam vitae elit felis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pulvinar accumsan efficitur. Quisque egestas lorem nec mi condimentum vulputate. Aliquam tempor, elit sit amet placerat imperdiet, nunc eros pharetra lorem, in sodales urna dolor at libero. Suspendisse scelerisque, nibh eu lacinia mattis, ligula massa volutpat nunc, sit amet luctus massa lectus sit amet nibh. Maecenas pulvinar facilisis nisi. Ut laoreet faucibus urna eu facilisis. In cursus vitae leo tempor dictum. Integer nec sagittis nibh. Pellentesque iaculis, ex quis condimentum blandit, ex nisi aliquam enim, a fermentum felis mi eget tortor. Nullam magna lacus, luctus ut lectus eget, efficitur consequat augue. Etiam nisl ipsum, dignissim vitae lorem sed, ultrices viverra ipsum. Sed id laoreet enim.
	</div>
	<div id="footer">NaturHouse - Twój osobisty dietetyk. Strona w sieci od 2017 r. &copy;
					 Wszelkie prawa zastrzeżone</div>
</div>
</body>
</html>