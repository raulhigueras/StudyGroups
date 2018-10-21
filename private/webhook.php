<?php
include 'createResponse.php';
include 'database.php';

function processMessage($data){
  #Get intent
  $intent = $data["queryResult"]["intent"]["displayName"];
  $params = $data["queryResult"]["parameters"];
  $msg_text = $data["queryResult"]["queryText"];
  if ($intent == "JoinGroup") {
    $subject = $params["Subject"];
    $free = search_free_classrooms($subject);
    while($row = mysqli_fetch_assoc($free)){
      return increment_learner($row["id"]);
    }return "D'on no n'hi ha no en raja.";
  }
  if ($intent == "JoinConcrete"){
    $subject = $params["Subject"];
    $classroom = $params["Room"];
    $date = $params["Date"];
    $time1 = $params["timeStart"];
    $time2 = $params["timeEnd"];
    $row = get_group($subject, $classroom, $date, $time1, $time2);
    if ($row == "10"){
      return "There isn't such group, you can create it or look for the available ones.";
    }return increment_learner($row["id"]);
  }
  if ($intent == "SearchGroup"){
    $subject = $params["Subject"];
    $classroom = $params["Room"];
    $date = $params["Date"];
    $time1 = $params["timeStart"];
    $resultado = get_group2($subject, $classroom, $date, $time1);
    if ($resultado == "10"){
      return "There isn't such group, you can create it.";
    }else {
      $out = "";
      foreach ($resultado as $row){
        if(is_array($row)){
          foreach ($row as $key) {
            $out .= $key.", ";
          }
        }else{
          $out .= $row.", ";
        }
      }
      $out = substr($out, 0, -2);
      return $out;
    }
  }

    //$endTime = $params["time1"];


  else if($intent == "CreateGroup"){
    $subject = $params["Subject"];
    $classroom = $params["Room"];
    $date = $params["date"];
    $startTime = $params["time"];
    $endTime = $params["time1"];
    $maxLearners = $params["MaxPeople"];
    if(get_group($subject, $classroom, $date, $startTime, $endTime) == "10"){
      return add($subject, $date, $startTime, $endTime, $maxLearners, $classroom);
    }
    /*
      else{
      return "This hours or class are not available";
    }*/
  }

  //echo json_encode(createResponse("holi"));
}

$update_response = file_get_contents("php://input");
$update = json_decode($update_response, true);
if (isset($update["queryResult"]["intent"])) {
    echo json_encode(createResponse(processMessage($update)));
}else{
    echo "JSON error";
}


?>
