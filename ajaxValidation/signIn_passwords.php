<?php
if(!isset($_POST['passwd1']) || !isset($_POST['passwd2']))
	echo 'Nie przesłano zmiennej "passwd1" lub "passwd2"';
else
{
	$passwd1 = $_POST['passwd1'];
	$passwd2 = $_POST['passwd2'];
	if($passwd1 != $passwd2)
		echo 'Hasła nie są identyczne!';
	else if(strlen($passwd1) < 8)
		echo 'Hasła są zbyt krótkie (min. 8 znaków)!';
	else if(strlen($passwd1) > 20)
		echo 'Hasła są zbyt długie (max. 20 znaków)!';
}