<?php
    session_start();

    //if the id of the user is not specified in the query string,
    //goto homepage and stop the execution of this script.
    if(!isset($_GET['id'])){
      header("Location: ../home.php");
      die();
    }

    //if user id is the same as the user currently
    //logged in, go to profile and stop this script execution.
    if(isset($_SESSION['pid'])){
      if($_GET['id'] == $_SESSION['pid']){
        header("Location: ../profile/profile.php");
        die();
      }
    }

    //get the information of the user from the database.
    include('../includes/db_connect.php');
    $userInfo = $conn->query("select * from people where pid=" . $_GET['id']);
    $userInfo = $userInfo->fetch();

    //retrieving user ratings...
    //retrieve ratings as task giver...
    $tgRating = $conn->query("select * from tasks where tg_id=".$_GET['id']." and tt_rates_tg IS NOT NULL");
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
    $ttRating = $conn->query("select * from tasks where tt_id =".$_GET['id']." and tg_rates_tt IS NOT NULL");
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

    //calculate total reiviews...
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

    $conn=null;
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title><?=$userInfo['username']?></title>

   <!--main menu css and js-->
   <link rel="stylesheet" href="../css/main_menu_style.css"/>
   <script src="../js/menuScrollJS.js"></script>

   <!--css for user_profile-->
   <link rel="stylesheet" href="css/user_profile.css"/>

   <!--css for icons-->
   <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
   <!--css for stars-->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <!--css for tags, use for skills-->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

   <!--jQuery-->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script>
      $(document).ready(function(){
          $("#tasktakenButton").click(function(){
            $(".wrap").fadeOut('fast');
              var uname = "<?=$userInfo['username']?>";
              $.ajax({
                type: 'POST',
                data: "id="+<?=$_GET['id']?>+"&uname="+uname,
                url: 'user_taskTaken.php',
                success: function(response){
                  $(".wrap").html(response);
                  $(".wrap").fadeIn('slow');
                  $("#tasktakenButton").css("background-color", "gray");
                  $("#tasktakenButton").attr("disabled", "disabled");
                  $("#taskgivenButton").css("background-color", "#005ab4");
                  $("#taskgivenButton").removeAttr("disabled");

                  //go to task page when a user clicks on a task card.
                  $('.card').click(function(){
                    window.location.href = "/taskforce/task/view_task.php?id=" + $(this).attr('id');
                  });

                  //retrieve reviews for tasks taken.
                  $.ajax({
                    type: 'POST',
                    data: 'id='+<?=$_GET['id']?>+'&avgTtRating='+<?=$avgTtRating?>,
                    url: 'user_ttReview.php',
                    success: function(response2){
                      $("#reviews").html(response2);
                    },
                    error: function(){
                      alert('an error occured while retrieving task taker reviews');
                    }
                  })

                },
                error: function(){
                  alert("an error occured while retrieving task taken");
                }
              });//end ajax.
          });


          $("#taskgivenButton").click(function(){
              $(".wrap").fadeOut('fast');
              var uname = "<?=$userInfo['username']?>";
              $.ajax({
                type: 'POST',
                data: "id="+<?=$_GET['id']?>+"&uname="+uname,
                url: 'user_taskgiven.php',
                success: function(response){
                  $(".wrap").html(response);
                  $(".wrap").fadeIn('slow');
                  $("#taskgivenButton").css("background-color", "gray");
                  $("#taskgivenButton").attr("disabled", "disabled");
                  $("#tasktakenButton").css("background-color", "#005ab4");
                  $("#tasktakenButton").removeAttr("disabled");

                  //go to task page when a user clicks on a task card.
                  $('.card').click(function(){
                    window.location.href = "/taskforce/task/view_task.php?id=" + $(this).attr('id');
                  });

                  //retrieve reviews for tasks given.
                  $.ajax({
                    type: 'POST',
                    data: 'id='+<?=$_GET['id']?>+'&avgTgRating='+<?=$avgTgRating?>,
                    url: 'user_tgReview.php',
                    success: function(response2){
                      $("#reviews").html(response2);
                    },
                    error: function(){
                      alert('an error occured while retrieving task taker reviews');
                    }
                  })


                },
                error: function(){
                  alert("an error occured while retrieving task taken");
                }
              });//end ajax.
          });


          //go to task page when a user clicks on a task card.
          $('.card').click(function(){
            window.location.href = "/taskforce/task/view_task.php?id=" + $(this).attr('id');
          });


      });
   </script>

   <style>
      /*fixes the search in the main menu*/
      #navbar input[type=text] {
        width: 65%;
      }
      body{
        background-color: #005ab4;
        font-family: 'Roboto', sans-serif;
        background-image: none;
      }
      .badge{
        margin-left: 8px;
        margin-bottom: 8px;
        padding: 8px;
        background-color:#005ab4;
      }

   </style>

 </head>
 <body>
   <?php
      $active = "";
      include('../includes/mainmenu.php');
      include('../includes/functions.php');
    ?>

    <!--display user information-->
    <div class="userBox">
      <div class="userInfoBox">
        <img src="/taskforce/profile_pictures/<?=$userInfo['picture']?>"/>
        <h3><?=$userInfo['username']?></h3>
        <?php
            for($i = 0; $i < 5; $i++){
              echo "<span " . $stars[$i] . "></span>";
            }
         ?>
        <span class="header"><?=$overallRating?></span>
        <span class="lightText">(<?=$totalReviews?> reviews)</span>
        <hr class="customHr">
        <?php
            //calcualte age from dob in database.
            $date = date("Y");
            $dob = date("Y", strtotime($userInfo['dob']));
            $age = $date - $dob;
            $age =  $age . " yrs";
         ?>
         <p><i class='fa fa-birthday-cake'></i> <?=$age?></p>
         <?php
            if($userInfo['nationality'] != ""){
          ?>
            <p><i class="fa fa-map-marker"></i> <?=$userInfo['nationality']?></p>
          <?php
            }
          ?>
      </div>
      <!--display some more user information-->
      <div class="userDescBox">
        <?php
            if($userInfo['about_me'] != ""){
        ?>
            <h4>Description</h4>
            <p class="lightText"><?=$userInfo['about_me']?></p>
            <hr class="customHr">
        <?php
            }
        ?>
        <?php
            //get user skills from database.
            include('../includes/db_connect.php');
            $sql = "select * from skills s, person_skillset ps where s.skill_id=ps.skill_id and ps.pid=".$_GET['id'];
            $userSkills = $conn->query($sql);
            $numSkills = $userSkills->rowCount();

            if($numSkills != 0){
        ?>
            <h4><span class='fas fa-award'></span> Skills</h4>
        <?php
            while($row = $userSkills->fetch()){
              echo "<span class='badge'>".$row['skill_name']."</span> ";
            }
            $conn=null;
         ?>
        <?php
            }
         ?>
      </div>
    </div>


      <!--display task given by this user-->
      <div class="userPanel">
        <div><button class="switch" id='taskgivenButton' style="background-color: gray" disabled><?=$userInfo['username']?> as task giver</button><button class="switch" id='tasktakenButton'><?=$userInfo['username']?> as task taker</button></div>
      <?php
          include('../includes/db_connect.php');
          $taskgiven = $conn->query("select * from tasks where tg_id=".$_GET['id']);
          $numTaskgiven = $taskgiven->rowCount();
          echo "<div class='wrap'>";
          if($numTaskgiven == 0){
            echo "<h4 style='margin-left: 20px;'>".$userInfo['username']." has posted no tasks yet.</h4>";
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
          echo "</div>";
       ?>
     </div>


     <!--display reviews-->
     <div class="userPanel" style="padding: 15px; margin-bottom: 20%;" id="reviews">
        <h4><b>Reviews as task giver</b> <span class='fa fa-star' style="color:orange"></span><span style="color:orange"> <?=$avgTgRating?></span><span class="lightText" style="font-size:15px"> (<?=$numTgRating?> reviews)</span></h4>
        <hr class="customHr">
        <?php
            include('../includes/db_connect.php');
            for($i = 0; $i < $numTgRating; $i++){
              $reviewer_name = $conn->query("select username,picture from people where pid=".$tgRating[$i]['tt_id']);
              $reviewer_name = $reviewer_name->fetch();
              echo "<img src='/taskforce/profile_pictures/".$reviewer_name['picture']."' class='reviewImg'/>";
              echo "<b><a href='/taskforce/user_profile/user_profile.php?id=".$tgRating[$i]['tt_id']."' class='profileLink'>".$reviewer_name['username']."</a>  </b>";
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
     </div>

      <!--<div class="userPanel">
        <h2 style="margin-left: 20px; margin-bottom: -35px;">Task Given</h2>
        <div class="wrap">
          <div class="card">
            <img src="taskimg.jpeg" alt="task00image">
            <h4><b>Task Name</b></h4>
            <p class="lightText">description</p>
          </div>
      </div>-->


 </body>
 </html>
