<?php
require_once('../../includes/db_connect.php');

foreach($_POST as $key => $value){
  $comment_id = substr($key, 11);
  //echo $tid;
  if($value == 'banned'){
    $banned = 1;
  }
  else if($value == 'accept'){
    $banned = 0;
  }

  $sql = "update comments set flag=0, banned=$banned where comment_id=$comment_id";
  $conn->exec($sql);
  //echo $sql . "</br>";

}//end loop


//header("Location: moderateComments.php");

$conn=null;
?>
