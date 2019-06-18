<?php
  $date_today = date("Y-m-d");
  $status = "";

  if($assigned == 1){
    $status = "Assigned to ";
    if($completed == 1){
      $status = "Completed by ";
    }

    $status = $status . "<a href='' class='profileLink'>" . $tt_name . "</a>";

  }
  else if($deadline < $date_today){
    $status = "Deadline over";
  }
  else if($assigned==0){
    $status = "Open";
  }


 ?>

<div class='about'>
   <b><?php echo $status; ?></b></br>
   <i>Status</i>
</div>
