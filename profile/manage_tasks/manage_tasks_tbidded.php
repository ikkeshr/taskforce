<?php
  session_start();

  if(!isset($_SESSION['pid'])){
    header("Location: ../../login.php");
    die();
  }

 ?>
 <html>
 <head>
   <title>Task Bidded on</title>
   <link rel="stylesheet" href="../../css/main_menu_style.css">
   <script src="../../js/menuScrollJS.js"></script>

   <link rel="stylesheet" href="css/menu2_style.css">
   <link rel="stylesheet" href="css/common_ttaken_tgiven.css">

 </head>
 <body>
   <?php
     $active="login";
     include('../../includes/mainmenu.php');
     $activeMenu2 = 'tbidded';
     include('includes/manage_tasks_menu.php');

     require('../../includes/db_connect.php');
     $query="select * from tasks t, biddings b
              where t.tid=b.tid
              and b.pid=".$_SESSION['pid']."
              and t.assigned=0 and t.completed=0 and t.banned=0";
     $tasks=$conn->query($query);
   ?>

   <div class="panel">
      <div class="panel-header">
          <h1>Task Bidded on</h1>
      </div>
      <hr>
      <div>
        <table id="task_table">
          <tr><th>Task Name</th><th>Budget</th><th>Date Posted</th><th>Your bid</th></tr>
          <?php
              include('../../includes/functions.php'); //contains function datetostr.

              while($row=$tasks->fetch()){
                  $tid=$row['tid'];
                  $link='../../task/view_task.php?id='.$tid;
                  echo "<tr>";
                  echo "<td><a href=$link>".$row['t_name']."</a></td>";
                  echo "<td>".$row['max_budget']."</td>";
                  echo "<td>".datetostr($row['date_posted'])."</td>";
                  echo "<td>".curToSymbol($row['currency']) . $row['bid_amount']."</td>";
                  echo "</tr>";
                }
              $conn=null;
           ?>
         </table>
      </div>
   </div>
</body>
</html>
