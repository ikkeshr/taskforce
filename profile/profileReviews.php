<?php
  session_start();

  if(!isset($_SESSION['pid'])){
    header("Location: ../login/login.php");
    die();
  }


  include('../includes/db_connect.php');
  include('../includes/functions.php');
  //retrieve ratings as task giver..
  $tgRating = $conn->query("select * from tasks t, people p where tg_id=".$_SESSION['pid']." and tt_rates_tg IS NOT NULL and t.tt_id=p.pid");
  $numTgRating = $tgRating->rowCount();
  $avgTgRating = 0;
  if($numTgRating != 0){
    $tgRating = $tgRating->fetchAll();
    for($i = 0; $i < $numTgRating; $i++){
      $avgTgRating += $tgRating[$i]['tt_rates_tg'];
    }
    $avgTgRating = $avgTgRating / $numTgRating;
  }



  //retrieve ratings as task taker...
  $ttRating = $conn->query("select * from tasks t, people p where tt_id =".$_SESSION['pid']." and tg_rates_tt IS NOT NULL and t.tg_id=p.pid");
  $numTtRating = $ttRating->rowCount();
  $avgTtRating = 0;
  if($numTtRating != 0){
    $ttRating = $ttRating->fetchAll();
    for($i = 0; $i < $numTtRating; $i++){
      $avgTtRating += $ttRating[$i]['tg_rates_tt'];
    }
    $avgTtRating = $avgTtRating / $numTtRating;
  }



  //calculate the overall rating...
  $overallRating = 0;
  if($avgTgRating == 0){
      $overallRating = $avgTtRating;
  }
  else if($avgTtRating == 0){
    $overallRating = $avgTgRating;
  }
  else{
    $overallRating = ($avgTgRating + $avgTtRating) / 2;
  }
  $avgTgRating = round($avgTgRating,2);
  $avgTtRating = round($avgTtRating, 2);
  $overallRating = round($overallRating, 2);


  //calculate total reviews...
  $totalReviews = $numTgRating + $numTtRating;

  //calculate stars...
  $stars = array();
  for($i = 0; $i < 5; $i++){
    if($overallRating > $i && $overallRating < ($i + 1)){
      $stars[$i] = "class='fa fa-star-half-full' style='color:orange; font-size: 18px;'";
    }
    else if($overallRating > $i){
      $stars[$i] = "class='fa fa-star' style='color:orange; font-size: 18px;'";
    }
    else{
      $stars[$i] = "class='fa fa-star-o' style='color:gray; font-size: 18px;'";
    }
  }



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?=$_SESSION['uname']?></title>
  <link rel="stylesheet" href="../css/main_menu_style.css"/>
  <script src="../js/menuScrollJS.js"></script>
  <link rel="stylesheet" href="profileMenu/profileMenuStyle.css"/>

  <!--css for stars-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!--jQuery-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>
      $(document).ready(function(){

          var ttRating = <?php echo json_encode($ttRating); ?>;
          var tgRating = <?php echo json_encode($tgRating); ?>;
          var avgTtRating = <?=$avgTtRating?>;
          var avgTgRating = <?=$avgTgRating?>;
          var numTtRating = <?=$numTtRating?>;
          var numTgRating = <?=$numTgRating?>;

          function howlong(date){
            if(date == ''){
              return;
            }
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            dd = parseInt(dd,10);
            mm = parseInt(mm,10);
            yyyy = parseInt(yyyy,10);

            var datePosted = date.split("-");
            var dd_p = parseInt(datePosted[2]);
            var mm_p = parseInt(datePosted[1]);
            var yyyy_p = parseInt(datePosted[0]);

            var t = ((yyyy-1) * 365) + ((mm-1) * 30) + dd;
            var p = ((yyyy_p-1) * 365) + ((mm_p-1) * 30) + dd_p;
            var diff = t - p;
            var out = '';
            if(diff >= 0){
              if(diff / 365 >= 1){
                out = Math.floor(diff/365) + ' years ago';
              }
              else if(diff/30 >= 1){
                out = Math.floor(diff / 30) + ' months ago';
              }
              else if(diff == 0){
                out = "today";
              }
              else{
                out = diff + " days ago";
              }
            }
            return out;
          }

          function tgReviews(element){
            var html = "";
            html +=  "<h3><b>Reviews as task giver</b> <span class='fa fa-star' style='color:orange'></span><span style='color:orange'> "+avgTgRating+"</span><span class='lightText' style='font-size:15px'> ("+numTgRating+" reviews)</span></h3><br/>";
            for(var i = 0; i < numTgRating; i++){
              html+= "<img src='/taskforce/profile_pictures/" + tgRating[i]['picture'] + "' class='reviewImg'/>";
              html+= "<div style='margin-left: 55px; line-height: 1.6'>";
              html+= "<b><a href='/taskforce/user_profile/user_profile.php?id="+tgRating[i]['tt_id']+"' class='profileLink'>"+tgRating[i]['username']+"</a>  </b>";
              html+= "<span class='fa fa-star' style='color:orange'> </span>";
              html+= "<span style='color:orange'> "+tgRating[i]['tg_rates_tt']+"</span>";
              html+= "<span class='lightText'> • " +tgRating[i]['t_name']+ "</span><br/>";
              if(!(tgRating[i]['comment_from_tg'] == "")) html+= "<span>"+tgRating[i]['comment_from_tg']+"</span><br/>";
              html+= "<span class='lightText'>"+howlong(tgRating[i]['date_tg_rates_tt'])+"</span>";
              html+= "</div><br/>";
              if(i != (numTgRating - 1)) html+= "<hr class='customHr'>";
            }
            element.html(html);
          }

          function ttReviews(element){
            var html = "";
            html +=  "<h3><b>Reviews as task taker</b> <span class='fa fa-star' style='color:orange'></span><span style='color:orange'> "+avgTtRating+"</span><span class='lightText' style='font-size:15px'> ("+numTtRating+" reviews)</span></h3><br/>";
            for(var i = 0; i < numTtRating; i++){
              html+= "<img src='/taskforce/profile_pictures/" + ttRating[i]['picture'] + "' class='reviewImg'/>";
              html+= "<div style='margin-left: 55px; line-height: 1.6'>";
              html+= "<b><a href='/taskforce/user_profile/user_profile.php?id="+ttRating[i]['tg_id']+"' class='profileLink'>"+ttRating[i]['username']+"</a>  </b>";
              html+= "<span class='fa fa-star' style='color:orange'> </span>";
              html+= "<span style='color:orange'> "+ttRating[i]['tg_rates_tt']+"</span>";
              html+= "<span class='lightText'> • " +ttRating[i]['t_name']+ "</span><br/>";
              if(!(ttRating[i]['comment_from_tg'] == "")) html+= "<span>"+ttRating[i]['comment_from_tg']+"</span><br/>";
              html+= "<span class='lightText'>"+howlong(ttRating[i]['date_tt_rates_tg'])+"</span>";
              html+= "</div><br/>";
              if(i != (numTtRating - 1)) html+= "<hr class='customHr'>";
            }
            element.html(html);
          }


        $("#tasktakenButton").click(function(){
          $("#reviews").fadeOut('fast');
          ttReviews($("#reviews"));
          $("#tasktakenButton").css("background-color", "gray");
          $("#tasktakenButton").attr("disabled", "disabled");
          $("#taskgivenButton").css("background-color", "#005ab4");
          $("#taskgivenButton").removeAttr("disabled");
          $("#reviews").fadeIn('slow');
        });

        $("#taskgivenButton").click(function(){
          $("#reviews").fadeOut();
          tgReviews($("#reviews"));
          $("#taskgivenButton").css("background-color", "gray");
          $("#taskgivenButton").attr("disabled", "disabled");
          $("#tasktakenButton").css("background-color", "#005ab4");
          $("#tasktakenButton").removeAttr("disabled");
          $("#reviews").fadeIn();
        });

        tgReviews($("#reviews"));

      });
  </script>

  <style>
      #navbar input[type=text] {
        margin-left: 20px;
        width: 65%;
      }
      button.switch{
        color: white;
        background-color: #005ab4;
        border: none;
        margin-right: 20px;
        padding: 15px;
        border-radius: 15px;
      }
      button.switch:hover{
        background-color: gray;
        cursor: pointer;
      }
      .panel{
        background-color: #e5e5e5;
      }
      .lightText{
        color: gray;
        font-size: 14px;
      }
      .reviewImg{
        float: left;
        width: 40px;
        height: 40px;
        border-radius: 20px;
      }
      .customHr{
        border: 0;
        height: 1px;
        background: #333;
        background-image: linear-gradient(to right, #ccc, #333, #ccc);
      }
  </style>
</head>
<body>
  <?php
    $active="login";
    include('../includes/mainmenu.php');
    $activeProfileMenu = 'review';
    include('profileMenu/profileMenu.php');

   ?>

   <div class="panel">
     <div style="text-align: center; margin-bottom: 3%;">
       <?php
           for($i = 0; $i < 5; $i++){
             echo "<span " . $stars[$i] . "></span>";
           }
        ?>
        <span class="header"><?=$overallRating?></span>
        <span class="lightText">(<?=$totalReviews?> reviews)</span>
     </div>
     <div style="text-align: center; margin-bottom: 3%;">
       <button class="switch" id='taskgivenButton' style="background-color: gray" disabled>Reviews as task giver (<?=$numTgRating?>)</button><button class="switch" id='tasktakenButton'>Reviews as task taker (<?=$numTtRating?>)</button>
     </div>
     <hr class="customHr">
     <div id='reviews' style="font-size: 14px;"></div>
   </div>

</body>
</html>
