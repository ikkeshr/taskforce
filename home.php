<?php 
  session_start(); 
?>
<html>
<head>
  <title>Home</title>

  <!-- css and script for mainmenu, on top-->
  <link rel="stylesheet" href="css/main_menu_style.css"/>
  <script src="js/menuScrollJS.js"></script>

  <!-- css for cards to hold tasks-->
  <link rel="stylesheet" href="/taskforce/css/card.css"/>

<style>
    /*body{
      background-image: none;
      background-color: #005ab4;
    }*/

    .banner{
      color: white;
      background: black;
      padding: 55px;
      padding-top: 8%;
      margin-left: -8%;
      width: 101%;
      height: 300px;

    }

    .banner h1{
      font-style: Trebuchet MS, sans-serif;
      font-size: 50px;
      text-align: center;
      margin-bottom: 5px;
    }
    h1.explore{
      font-style: Trebuchet MS, sans-serif;
      font-size: 50px;
      margin-left: 35%;
      margin-bottom: 5px;
    }
    .banner p{
      font-style: Trebuchet MS, sans-serif;
      text-align: center;
      font-weight: bold;
      margin-bottom: 30px;
    }
    .banner button{

      padding: 15px;
      color: white;
      font-size: 16px;
      font-weight: bold;
      background: #005ab4;
      width: 140px; /*important, for margin: auto */
      border: none;
      margin: 0 auto;
      border-radius: 5px;
    }
    .banner button:hover{
      cursor: pointer;
      background: #2389cd;
    }


</style>
</head>
<body>
  <?php
    //include the top menu with home tab active.
    $active='home';
    include('includes/mainmenu.php');

    require_once ('includes/dbcontroller.php');
    $db_controller = new DBController();

   ?>
    <div class="banner">
        <h1>Post a Task</h1>
        <p>and let other people bid their price.</p>
        <?php
            //if user is log in.
            $postTask_link = '';
            if(isset($_SESSION['pid'])){
              $postTask_link = "onclick=window.location.href=\"/taskforce/profile/postTask.php\"";
            }
            else{
              //plus sign represent spaces in query string!!
              $credentialErr = 'You+need+to+be+log+in,+to+post+a+task.';
              $postTask_link = "onclick=window.location.href=\"/taskforce/login/login.php?credentialErr=$credentialErr\"";
            }
         ?>
         <div style="text-align: center">
        <button <?php echo $postTask_link; ?> id='homePostTAsk'>Post a task</button>
        </div>
    </div><br/><br/>
    <h1 class="explore">Explore Tasks</h1>
    <br/><br/>


    <?php

      //if the user is logged in
      //this will display tasks
      //recommended for the user.
      if( isset($_SESSION['pid']) )
      {
        $sql = "select *
                from tasks t, task_required_skill tr, skills s
                where t.tid = tr.tid
                and t.banned = 0
                and t.assigned = 0
                and tr.skill_id = s.skill_id
                and tr.skill_id IN (select skill_id
                                    from person_skillset
                                    where pid = :pid ) LIMIT 6";
                                    
        $results = $db_controller->query( $sql, array( ':pid'=>$_SESSION['pid'] ) );

        if( $results->rowCount() != 0)
        {
            echo "<h1>Recommended for you</h1>";
            echo "<div class='row'>";
            /*base on the user skills*/

            while($row = $results->fetch())
            {
              echo "<div class='column'>";
              echo "<div class='card' onclick=window.location.href=\"/taskforce/task/view_task.php?id=" . $row['tid']."\">";
              echo "<h3>" . $row['t_name'] ."</h3>";
              echo "</div>";
              echo "</div>";
            }
            echo "</div>";
        }

      }
    ?>

    <h1>Task with the most bidders</h1>
    <div class="row">
    <?php
        $sql = "select t.*, COUNT(*) as biddings
                from biddings b, tasks t
                where b.tid = t.tid
                and t.banned = 0
                and t.assigned = 0
                GROUP BY t.tid
                ORDER BY biddings DESC LIMIT 6";

        $results = $db_controller->query_simple($sql);
        while($row = $results->fetch())
        {
          echo "<div class='column'>";
          echo "<div class='card' onclick=window.location.href=\"/taskforce/task/view_task.php?id=" . $row['tid']."\">";
          echo "<h3>" . $row['t_name'] ."</h3>";
          echo "</div>";
          echo "</div>";
        }
     ?>
   </div>

     <h1>Newest Tasks</h1>
     <div class='row'>
     <?php
         $sql = "select * from tasks
                  WHERE banned = 0
                  and assigned = 0
                  ORDER BY date_posted DESC LIMIT 6";

          $results = $db_controller->query_simple($sql);

         while($row = $results->fetch())
         {
           echo "<div class='column'>";
           echo "<div class='card' onclick=window.location.href=\"/taskforce/task/view_task.php?id=" . $row['tid']."\">";
           echo "<h3>" . $row['t_name'] ."</h3>";
           echo "</div>";
           echo "</div>";
         }
      ?>
    </div>



      <h1>Top TaskTakers</h1>
      <div class='row'>
      <?php
          $sql = "select p.*, avg(t.tg_rates_tt) as rating
                  from tasks t, people p
                  where t.tg_rates_tt IS NOT NULL
                  and t.tt_id = p.pid
                  GROUP BY p.pid
                  ORDER BY rating DESC";

          $results = $db_controller->query_simple($sql);
          while($row = $results->fetch())
          {
            echo "<div class='column'>";
            echo "<div class='card'>";
            echo "<h3>" . $row['username'] ."</h3>";
            echo "</div>";
            echo "</div>";
          }
       ?>
     </div>

       <h1>Top TaskGivers</h1>
       <div class='row'>
       <?php
           $sql = "select p.*, avg(t.tt_rates_tg) as rating
                   from tasks t, people p
                   where t.tt_rates_tg IS NOT NULL
                   and t.tg_id = p.pid
                   GROUP BY p.pid
                   ORDER BY rating DESC";

            $results = $db_controller->query_simple($sql);
           while($row = $results->fetch())
           {
             echo "<div class='column'>";
             echo "<div class='card'>";
             echo "<h3>" . $row['username'] ."</h3>";
             echo "</div>";
             echo "</div>";
           }
        ?>
      </div>




<br/><br/><br/><br/><br/><br/>
</body>
</html>
