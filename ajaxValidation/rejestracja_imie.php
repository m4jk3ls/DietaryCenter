<?php
if(!isset($_POST['imie']))
	echo 'Nie przesłano zmiennej "imie"';
else if(strlen($_POST['imie']) < 1)
	echo 'Nie podałeś/aś imienia!';