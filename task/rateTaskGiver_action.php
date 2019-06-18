<?php

include('../includes/db_connect.php');

function test_input($data) {
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
return $data;
}

$tid = $_POST['tid'];
$rating = $_POST['tt_rates_tg'];
$review = test_input($_POST['comment_from_tt']);

//validate rating
$ratingErr = "";
if(empty($rating)){
  $ratingErr = "Please select a rating.";
}
else if(($rating < 0) || ($rating > 5)){
  $ratingErr = "Invalid rating.";
}


//validate review
if(empty($review)){
  $review = 'null';
}
else{
  $review = $conn->quote($review);
}


if($ratingErr != ""){
  header("Location: view_task.php?id=$tid&rateTaskGiverErr=$ratingErr");
}
else{
  $dateToday = date("Y-m-d");
  $dateToday = $conn->quote($dateToday);
  $sql = "update tasks set tt_rates_tg=$rating, comment_from_tt=$review, date_tt_rates_tg=$dateToday
                        where tid=$tid";
  //echo $sql;
  $conn->exec($sql);
  header("Location: view_task.php?id=$tid");
}

$conn=null;

 ?>
