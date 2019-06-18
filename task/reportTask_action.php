<?php
  $tid = $_POST['tid'];

  require('../includes/db_connect.php');
  $query = "update tasks
            set flag=1
            where tid=$tid";

  $conn->exec($query);

  echo "Task Reported";



 ?>
