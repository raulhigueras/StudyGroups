<?php
  $subject = $_POST["subject"];
  $classroom = $_POST["classroom"];
  $date = $_POST["date"];
  $time1 = $_POST["startTime"];
  $maxLearners = $_POST["maxLearners"];
  function convert_date($date, $time){
    $date = $date." ".$time;
    $date .= ":00";
    return $date;
  }
  function add($subject, $date, $time1, $maxLearners, $classroom){
    include './db_connect.php';
    //'CAL', 'fisica 2', '2018-10-22 11:00:00', '2018-10-22 12:00:00', 6, 'A3102'
    $sql = "INSERT INTO meetings (subject, startTime, maxLearners, classroom) VALUES ('" .$subject. "','" .convert_date($date, $time1). "','" .$maxLearners."','" . $classroom. "' )";
    if (mysqli_query($conn, $sql)) {
        header('Location: ./../noterror.html'); ;
    } else {
        header('Location: ./../error.html'); ;
    }
    mysqli_close($conn);
  }
  add($subject, $date, $time1, $maxLearners, $classroom);
 ?>
