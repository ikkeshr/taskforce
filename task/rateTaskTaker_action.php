<?php
  include('../includes/db_connect.php');

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


  $tid = $_POST['tid'];
  $tg_rates_tt = $_POST['tg_rates_tt'];
  $comment_from_tg = test_input($_POST['comment_from_tg']);

  //validate rating
  $ratingErr = "";
  if(empty($tg_rates_tt)){
    $ratingErr = "Please select a rating.";
  }
  else if(($tg_rates_tt < 0) || ($tg_rates_tt > 5)){
    $ratingErr = "Invalid rating.";
  }

  //validate review
  if(empty($comment_from_tg)){
    $comment_from_tg = 'null';
  }
  else{
    $comment_from_tg = $conn->quote($comment_from_tg);
  }


  if($ratingErr != ""){
    header("Location: view_task.php?id=$tid&rateTaskTakerErr=$ratingErr");
  }
  else{
    $dateToday = date("Y-m-d");
    $dateToday = $conn->quote($dateToday);
    $sql = "update tasks set tg_rates_tt=$tg_rates_tt, comment_from_tg=$comment_from_tg, date_tg_rates_tt=$dateToday
                        where tid=$tid";
    //echo $sql;
    $conn->exec($sql);
    header("Location: view_task.php?id=$tid");
  }

  $conn = null;

 ?>
