<?php
require_once('../../includes/db_connect.php');

foreach($_POST as $key => $value){
  $tid = substr($key, 8);
  //echo $tid;
  if($value == 'banned'){
    $banned = 1;
  }
  else if($value == 'accept'){
    $banned = 0;
  }

  $sql = "update tasks set flag=0, banned=$banned where tid=$tid";
  $conn->exec($sql);

}//end loop


//header("Location: profileAdmin.php");

$conn=null;
?>
