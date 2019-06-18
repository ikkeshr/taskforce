<?php
  session_start();

  if(!isset($_SESSION['pid'])){
    header("Location: ../../login.php");
    die();
  }

 ?>
 <html>
 <head>
   <title>Task Taken</title>
   <link rel="stylesheet" href="../../css/main_menu_style.css">
   <script src="../../js/menuScrollJS.js"></script>

   <link rel="stylesheet" href="css/menu2_style.css">

   <link rel="stylesheet" href="css/common_ttaken_tgiven.css">

 </head>
 <body>
   <?php
     $active="login";
     include('../../includes/mainmenu.php');
     $activeMenu2='ttaken';
     include('includes/manage_tasks_menu.php');

     $selected="all";
     $where="";
     if(isset($_GET['show'])){
       if($_GET['show'] == "completed"){
         $selected="completed";
         $where="and completed=1";
       }
       else if($_GET['show'] == "ongoing"){
         $selected="ongoing";
         $where="and completed=0";
       }
     }


     require('../../includes/db_connect.php');
     $query="select * from tasks where tt_id=".$_SESSION['pid']." and banned=0 and assigned=1 ".$where;
     $tasks=$conn->query($query);
   ?>

   <div class="panel">
      <div>
          <h1>TaskTaken</h1>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            Show:
            <select style="border: solid 1px #D3D3D3;" onchange="this.form.submit()" name="show">
              <option value="all" <?php if($selected=="all"){echo "selected";} ?>>All</option>
              <option value="completed" <?php if($selected=="completed"){echo "selected";} ?>>Completed</option>
              <option value="ongoing" <?php if($selected=="ongoing"){echo "selected";} ?>>Ongoing</option>
            </select>
          </form>
      </div>
      <hr>
      <div>
        <table id="task_table">
          <tr><th>Task Name</th><th>Budget</th><th>Date Posted</th><th>Status</th><th>Your rating as TaskTaker(out of 5)</th></tr>
          <?php
              include('../../includes/functions.php'); //contains function datetostr.


              while($row=$tasks->fetch()){
                  $tid=$row['tid'];
                  $link='../../task/view_task.php?id='.$tid;
                  echo "<tr>";
                  echo "<td><a href=$link>".$row['t_name']."</a></td>";
                  echo "<td>".$row['max_budget']."</td>";
                  echo "<td>".datetostr($row['date_posted'])."</td>";

                  $status = "";
                  if($row['completed'] == 0){
                    $status = "Assigned";
                  }
                  else if($row['completed'] == 1){
                    $status = "Completed";
                  }
                  echo "<td>".$status."</td>";

                  $rating = "";
                  if($row['completed'] == 0){
                    $rating = "Task not yet completed.";
                  }
                  else if($row['completed'] == 1 && $row['tg_rates_tt'] != ''){
                    $rating = $row['tg_rates_tt'];
                  }
                  else if($row['completed'] == 1 && $row['tg_rates_tt'] == ''){
                    $rating = "rating not yet posted by tasktaker.";
                  }

                  echo "<td>".$rating."</td>";


                  echo "</tr>";
                }
              $conn=null;
           ?>
         </table>
      </div>
    </div>

    </br></br></br></br></br></br></br></br></br></br>
</body>
</html>
