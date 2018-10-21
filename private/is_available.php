<?php
include './database.php';

$time = $_POST["time"];
$classroom = $_POST["classroom"];
$date = $_POST["date"];

$startTime = $date." ".$time.":00";

echo check_available($classroom, $startTime);
?>
