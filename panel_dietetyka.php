<?php
	session_start();

	if(!isset($_COOKIE["zalogowany_dietetyk"]))
	{
		header('Location: index.php');
		exit();
	}