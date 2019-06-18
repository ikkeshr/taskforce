<?php

  $tid = $_POST['tid'];
  $comment_id = $_POST['comment_id'];
  $pid = $_POST['pid'];

  include('../includes/db_connect.php');
  include('../includes/functions.php'); //my functions.
  $sql = "delete from comments where comment_id=$comment_id";
  $conn->exec($sql);
  
  $conn=null;

 ?>
