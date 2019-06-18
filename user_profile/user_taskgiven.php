<?php

include('../includes/db_connect.php');
$taskgiven = $conn->query("select * from tasks where tg_id=".$_POST['id']);
$numTaskgiven = $taskgiven->rowCount();

if($numTaskgiven == 0){
  echo "<h4 style='margin-left: 20px;'>".$_POST['uname']." has posted no tasks yet.</h4>";
}
else{
  /*echo "<h2 style='margin-left: 20px; margin-bottom: -35px;'>Task given</h2>";*/
  while($row = $taskgiven->fetch()){
    echo "<div class='card' id='".$row['tid']."'>";
    echo   "<img src='taskimg.jpeg' alt='task00image'>";
    $rating = "";
    $rating = ($row['tt_rates_tg'] != "") ? " <span class='fa fa-star' style='color:orange; font-size: 12px'></span><span style='color:orange ; font-size: 12px'> ".$row['tt_rates_tg']."</span>" : "";
    echo   "<h4>".$row['t_name']. $rating . "</h4>";
    echo   "<p class='lightText'>Budget of ".$row['max_budget']."</p>";
    echo "</div>";
  }
}

 ?>
