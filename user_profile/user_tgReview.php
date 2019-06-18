<?php
include('../includes/db_connect.php');
include('../includes/functions.php');
$tgRating = $conn->query("select * from tasks t, people p where t.tt_id=p.pid and tt_rates_tg IS NOT NULL and tg_id=".$_POST['id']);
$numTgRating = $tgRating->rowCount();
$tgRating = $tgRating->fetchAll();
echo "<h4><b>Reviews as task giver</b> <span class='fa fa-star' style='color:orange'></span><span style='color:orange'> ".$_POST['avgTgRating']."</span><span class='lightText' style='font-size:15px'> ($numTgRating reviews)</span></h4>";
echo "<hr class='customHr'>";


    for($i = 0; $i < $numTgRating; $i++){
      echo "<img src='/taskforce/profile_pictures/".$tgRating[$i]['picture']."' class='reviewImg'/>";
      echo "<b><a href='/taskforce/user_profile/user_profile.php?id=".$tgRating[$i]['tt_id']."' class='profileLink'>".$tgRating[$i]['username']."</a>  </b>";
      echo "<span class='fa fa-star' style='color:orange'> </span>";
      echo "<span style='color:orange'> ".$tgRating[$i]['tt_rates_tg']."</span>";
      echo "<span class='lightText'> • " .$tgRating[$i]['t_name']. "</span><br/>";
      if(!empty($tgRating[$i]['comment_from_tt'])) echo "<span style='margin-left: 35px'>".$tgRating[$i]['comment_from_tt']."</span><br/>";
      $dateRatingPosted = '';
      if($tgRating[$i]['date_tt_rates_tg'] != ''){
        $dateRatingPosted = howlong($tgRating[$i]['date_tt_rates_tg']);
      }

      echo "<span class='lightText' style='margin-left: 35px'>".$dateRatingPosted."</span>";
      if($i != ($numTgRating - 1)) echo "<hr class='customHr'>";
    }
    $conn=null;


 ?>
