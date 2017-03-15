<?php
if(!isset($_COOKIE['adminLogged']))
{
	header("Location: index.php");
	exit();
}
echo 'Panel admina :)';
?>