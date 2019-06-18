<?php

    $username = $_POST['username'];

    include('../includes/db_connect.php');
    $result = $conn->query("select * from people where username=" . $conn->quote($username));
    $numrows = $result->rowCount();
    if($numrows != 0){
      echo true;
    }
    else{
      echo false;
    }
    $conn=null;

 ?>
