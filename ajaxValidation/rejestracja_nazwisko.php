<?php
if(!isset($_POST['nazwisko']))
	echo 'Nie przesłano zmiennej "nazwisko"';
else if(strlen($_POST['nazwisko']) < 1)
	echo 'Nie podałeś/aś nazwiska!';