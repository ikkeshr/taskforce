<?php
  $pid=$_POST['pid'];
  $tid =$_POST['tid'];

  require('../includes/db_connect.php');
  $query_delete = "DELETE FROM biddings
                    WHERE pid=$pid AND tid=$tid";

  echo $query_delete;
  $conn->exec($query_delete);
  $conn = null;

  header("Location: view_task.php?id=$tid");
 ?>
