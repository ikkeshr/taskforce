<?php
include('../includes/db_connect.php');
include('../includes/functions.php');
$ttRating = $conn->query("select * from tasks t, people p where t.tg_id=p.pid and tg_rates_tt IS NOT NULL and tt_id=".$_POST['id']);
$numTtRating = $ttRating->rowCount();
$ttRating = $ttRating->fetchAll();
echo "<h4><b>Reviews as task taker</b> <span class='fa fa-star' style='color:orange'></span><span style='color:orange'> ".$_POST['avgTtRating']."</span><span class='lightText' style='font-size:15px'> ($numTtRating reviews)</span></h4>";
echo "<hr class='customHr'>";


    for($i = 0; $i < $numTtRating; $i++){
      echo "<img src='/taskforce/profile_pictures/".$ttRating[$i]['picture']."' class='reviewImg'/>";
      echo "<b><a href='/taskforce/user_profile/user_profile.php?id=".$ttRating[$i]['tg_id']."' class='profileLink'>".$ttRating[$i]['username']."</a>  </b>";
      echo "<span class='fa fa-star' style='color:orange'> </span>";
      echo "<span style='color:orange'> ".$ttRating[$i]['tg_rates_tt']."</span>";
      echo "<span class='lightText'> • " .$ttRating[$i]['t_name']. "</span><br/>";
      if(!empty($ttRating[$i]['comment_from_tg'])) echo "<span style='margin-left: 35px'>".$ttRating[$i]['comment_from_tg']."</span><br/>";

      $dateReviewPosted = '';
      if($ttRating[$i]['date_tg_rates_tt'] != ''){
        $dateReviewPosted = howlong($ttRating[$i]['date_tg_rates_tt']);
      }

      echo "<span class='lightText' style='margin-left: 35px'>".$dateReviewPosted."</span>";
      if($i != ($numTtRating - 1)) echo "<hr class='customHr'>";
    }
    $conn=null;


 ?>
