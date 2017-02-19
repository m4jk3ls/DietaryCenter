<?php
if(!isset($_POST['lastName']))
	echo 'Nie przesłano zmiennej "nazwisko"';
else if(strlen($_POST['lastName']) < 1)
	echo 'Nie podałeś/aś nazwiska!';