<?php
session_start();

if(!isset($_POST['date']))
	echo 'Nie wybrano daty!';
else
{
	$date = $_POST['date'];
	if(isset($_SESSION['freeHoursByDay'][$date]) && $_SESSION['freeHoursByDay'][$date] != null)
		echo json_encode($_SESSION['freeHoursByDay'][$date]);
	else if($date == "---brak---")
		echo json_encode("---brak---");
}