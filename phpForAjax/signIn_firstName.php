<?php
if(!isset($_POST['firstName']))
	echo 'Nie przesłano zmiennej "imie"';
else if(strlen($_POST['firstName']) < 1)
	echo 'Nie podałeś/aś imienia!';