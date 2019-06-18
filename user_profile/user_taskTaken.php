<?php
include('../includes/db_connect.php');
$tasktaken = $conn->query("select * from tasks where tt_id=".$_POST['id']);
$numTasktaken = $tasktaken->rowCount();
if($numTasktaken == 0){
  echo "<h4 style='margin-left: 20px;'>".$_POST['uname']." has taken no tasks yet.</h4>";
}
else{
  /*echo "<h2 style='margin-left: 20px; margin-bottom: -35px;'>Task given</h2>";*/
  while($row = $tasktaken->fetch()){
    echo "<div class='card' id='".$row['tid']."'>";
    echo   "<img src='taskimg.jpeg' alt='task00image'>";
    $rating = "";
    $rating = ($row['tg_rates_tt'] != "") ? " <span class='fa fa-star' style='color:orange; font-size: 12px'></span><span style='color:orange ; font-size: 12px'> ".$row['tg_rates_tt']."</span>" : "";
    echo   "<h4>".$row['t_name']. $rating . "</h4>";
    echo   "<p class='lightText'>Budget of ".$row['max_budget']."</p>";
    echo "</div>";
  }
}
 ?>
