<?php

  function convert_date($date, $time){
    if (is_array($time)){
      $time = $time[0];
    }
    $date = substr($date, 0,-6);
    $time = substr($time, 0,-6);
    $date = strtotime($date);
    $time = strtotime($time);
    $date = date("Y-m-d", $date);
    $date .= " ";
    $date .= date("H:i", $time);
    $date .= ":00";
    return $date;
  }

  function add($subj, $date, $startTime, $endTime, $maxLearners, $classroom){
    include './db_connect.php';
    //'CAL', 'fisica 2', '2018-10-22 11:00:00', '2018-10-22 12:00:00', 6, 'A3102'
    $sql = "INSERT INTO meetings (subject, startTime, endTime, maxLearners, classroom) VALUES ('" .$subj. "', '" .convert_date($date, $startTime). "', '" .convert_date($date, $endTime). "', '" .$maxLearners."', '" . $classroom. "')";
    if (mysqli_query($conn, $sql)) {
        return "New group registered";
    } else {
        return "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    mysqli_close($conn);
  }

  // Precondicion: el meeting de id $id no está lleno
  function increment_learner($id){
    include './db_connect.php';

    $sql = "SELECT id, learners, maxLearners FROM meetings WHERE id=".$id;

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $learners = $row['learners'];
    $maxLearners = $row['maxLearners'];
    if( $learners < $maxLearners ){
      $learners += 1;
      $sql = "UPDATE meetings SET learners=". $learners ." WHERE id=".$id;
      mysqli_query($conn, $sql);
      if($learners == $maxLearners){
        $sql = "UPDATE meetings SET full=1 WHERE id=".$id;
        mysqli_query($conn, $sql);
      }
      return "You were successfully added to the group";
    }else{
      return "The meeting is full";
    }
    mysqli_close($conn);
  }

  function search_free_classrooms($subject){
    include './db_connect.php';
    $sql = "SELECT id, startTime, endTime, learners, maxLearners, classroom FROM meetings WHERE subject='".$subject."' and full = 0";
    $result = mysqli_query($conn, $sql);
    /*$response = "";
    if (mysqli_num_rows($result) > 0) {
        $response .= "The classrooms availables are: ";
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $spaces = $row["maxLearners"] - $row["learners"];
            $response .= $row["classroom"]." from ".$row["startTime"]." to ".$row["endTime"]. " there are ".$spaces." free space(s)";
        }
    } else {
        $response = "0 results";
    }*/
    mysqli_close($conn);
    return $result;
  }

  function get_group($subject, $classroom, $date, $startTime, $endTime){
    include './db_connect.php';
    $sql = "SELECT id, full FROM meetings WHERE subject='".$subject."' and classroom='".$classroom."' and startTime='".convert_date($date, $startTime)."' and endTime='".convert_date($date, $endTime)."'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1){
      $row = mysqli_fetch_assoc($result);
      mysqli_close($conn);
      return $row;
    }else{
      return "10";
    }
  }
  //Selecciona de la base de datos en función de que parametros se quiera
  //Precondicion: $subject no esta vacio, y ignoramos la hora final
  function get_group2($subject, $classroom, $date, $startTime){
    include './db_connect.php';
    if ($classroom != "" and $date != "" and $startTime != ""){
      $sql = "SELECT classroom, startTime, learners, maxLearners FROM meetings WHERE subject='".$subject."' and classroom='".$classroom."' and startTime='".convert_date($date, $startTime)."' and full = 0";
      $result = mysqli_query($conn, $sql);
      if (mysqli_num_rows($result) == 1){
        return $result;
      }else{
        return "10";
      }
    }else if($classroom == "" and $date == "" and $startTime == ""){
      $sql = "SELECT classroom, startTime, learners, maxLearners FROM meetings WHERE subject='".$subject."' and full = 0";
      $result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($result) < 1){
        return "10";
      }return $result;
    }else if($classroom != "" and ($date == "" or $startTime == "")){
      $sql = "SELECT classroom, startTime, learners, maxLearners FROM meetings WHERE subject='".$subject."' and classroom='".$classroom."' and full = 0";
      $result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($result) < 1){
        return "10";
      }return $result;
    }else if($classroom == "" and $date != "" and $startTime != ""){
      $sql = "SELECT classroom, startTime, learners, maxLearners FROM meetings WHERE subject='".$subject."' and startTime='".convert_date($date, $startTime)."' and full = 0";
      $result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($result) < 1){
        return "10";
      }return $result;
    }else if($classroom == "" and ($date == "" or $startTime == "")){
      $sql = "SELECT classroom, startTime, learners, maxLearners FROM meetings WHERE subject='".$subject."' and full = 0";
      $result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($result) < 1){
        return "10";
      }return $result;
    }
    else {
      echo "fail";
      return "10";
    }
  }

function check_available($classroom, $startTime){
  include './db_connect.php';
  $sql = "SELECT id from meetings WHERE classroom='".$classroom."' and startTime='".$startTime."'";
  $result = mysqli_query($conn, $sql);
  return mysqli_num_rows($result) < 1;
}

 ?>
