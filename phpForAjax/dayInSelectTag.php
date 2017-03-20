<?php
session_start();

function isLeapYear($year)
{
	return ((($year % 4) == 0) && ((($year % 100) != 0) || (($year % 400) == 0)));
}

$allDays = array();

if(!isset($_POST['year']) || !isset($_POST['month']))
{
	echo json_encode("Nie przesłano roku lub miesiąca!");
	exit();
}
else if($_POST['month'] != "---miesiąc---" && $_POST['month'] != "Luty")
{
	$month = $_POST['month'];

	if($month == "Styczeń" || $month == "Marzec" || $month == "Maj" || $month == "Lipiec" || $month == "Sierpień" || $month == "Październik" || $month == "Grudzień")
		$numberOfDays = 31;
	else
		$numberOfDays = 30;

	for ($i = 1; $i <= $numberOfDays; $i++)
		$allDays[] = $i;
}
else if($_POST['year'] != "---rok---" && $_POST['month'] == "Luty")
{
	$year = $_POST['year'];

	if(isLeapYear($year))
		$numberOfDays = 29;
	else
		$numberOfDays = 28;

	for ($i = 1; $i <= $numberOfDays; $i++)
		$allDays[] = $i;
}
else
{
	echo json_encode("Nie wybrano daty");
	exit();
}
echo json_encode($allDays);