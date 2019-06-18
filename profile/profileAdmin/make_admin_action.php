<?php
  require_once('../../includes/db_connect.php');

  foreach($_POST as $key => $value){
    $sql = "update people set account_type='admin' where pid=$value";
    $conn->exec($sql);
    //echo $sql . "</br>";
  }
  //header("Location: make_admin.php");
  $conn=null;
 ?>
