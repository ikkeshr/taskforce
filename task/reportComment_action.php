<?php

  $comment_id = $_POST['comment_id'];

  include('../includes/db_connect.php');
  $sql = "update comments set flag=1 where comment_id=$comment_id";

  $conn->exec($sql);
  //header("Location: view_task.php?id=$tid");
  $conn=null;

  //will display this msg in the pop up when a comment is reported.(using Ajax).
  echo "Comment Reported";

 ?>
