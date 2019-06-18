<?php
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }


  $pid = $_POST['pid'];
  $tid = $_POST['tid'];

  include('../includes/db_connect.php');
  $query = "select * from biddings where pid=$pid and tid=$tid";
  $exist = $conn->query($query);
  $exist = $exist->rowCount();//checks to see if already bidded(in the user was modifying his bid and entered the same data).

  /*echo $pid."</br>";
  echo $tid."</br>";
  echo "</br>".$query."</br>";*/



  //validate amount
  $amount = $_POST['bidOnTask_Amount'];
  $amountErr = "";
  if(empty($amount)){
    $amountErr = "Sorry but seem to be an error in your last bid amount.";
  }
  else if($amount <= 0){
    $amountErr = "Sorry but there seem to be an error in your last bid amount.";
  }

  //validate description
  $desc = test_input($_POST['bidOnTask_desc']);
  if(empty($desc)){
    $desc = 'NULL';
  }
  else{
    $desc = $conn->quote($desc);
  }

  //date and time $bidder
  $date = date("Y-m-d h:i:s");


  if($amountErr != ""){
    header("Location: view_task.php?id=$tid&amountErr=$amountErr");
  }
  else{

    if($exist > 0){

      $query = "update biddings set bid_amount=$amount, bid_desc=$desc
                where pid=$pid and tid=$tid";
    }
    else{
      $query = "insert into biddings(pid, tid, bid_amount, bid_desc, date)
      values($pid, $tid, $amount, $desc, '$date')";
    }
    $conn->exec($query);
    //echo $query;
    header("Location: view_task.php?id=$tid");
  }


  $conn=null;






 ?>
