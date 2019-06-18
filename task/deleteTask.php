<?php
  $tid = $_POST['tid'];

  $sql = "delete from tasks where tid=$tid";

  include("../includes/db_connect.php");
  $conn->exec($sql);

  //echo $sql;
  $conn=null;

  //heads to explore task? or another page. temporarily redirecting to profile post a task.
  header("Location: ../profile/postTask.php");
 ?>
