<?php
// Funkcja generujaca token, ktory jest uzywany w formularzu
function getToken()
{
	$token = sha1(mt_rand());
	if(!isset($_SESSION['tokens']))
		$_SESSION['tokens'] = array($token => 1);
	else
		$_SESSION['tokens'][$token] = 1;
	return $token;
}

// Sprawdzanie poprawnosci tokenu oraz usuwanie go z listy poprawnych token'ow
function isTokenValid($token)
{
	if(!empty($_SESSION['tokens'][$token]))
	{
		unset($_SESSION['tokens'][$token]);
		return true;
	}
	return false;
}