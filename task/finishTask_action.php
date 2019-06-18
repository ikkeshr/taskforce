<?php
  $tid = $_POST['tid'];

  $sql = "update tasks set completed = 1 where tid = $tid";

  include('../includes/db_connect.php');
  //echo $sql;
  $conn->exec($sql);
  $conn=null;
  header("location: view_task.php?id=$tid");

 ?>
