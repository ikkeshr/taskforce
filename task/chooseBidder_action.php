<?php
  $tid = $_POST['tid'];
  $tt_id = $_POST['tt_id'];

  include('../includes/db_connect.php');
  $sql = "update tasks set assigned=1, tt_id=$tt_id where tid=$tid";
  $conn->exec($sql);
  $conn=null;
  //echo $sql;
  header("Location: view_task.php?id=$tid");


 ?>
