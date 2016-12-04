<?php
	session_start();
	session_unset();
	setcookie("zalogowany", false, time() - 1);
	header('Location: index.php');
?>