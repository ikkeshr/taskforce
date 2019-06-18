<?php
  session_start();

  if(!isset($_SESSION['pid'])){
    header("Location: ../../login/login.php");
    die();
  }

  require('../../includes/db_connect.php');
  $query="select * from tasks where tg_id=".$_SESSION['pid']." and banned=0 ";
  $tasks=$conn->query($query);
  $tasks = $tasks->fetchAll();
  $conn=null;

 ?>
 <html>
 <head>
   <title>Task Given</title>
   <link rel="stylesheet" href="../../css/main_menu_style.css">
   <script src="../../js/menuScrollJS.js"></script>

   <link rel="stylesheet" href="css/menu2_style.css">
   <link rel="stylesheet" href="css/common_ttaken_tgiven.css">

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

   <script>
      $(document).ready(function(){

        var tasksArr = <?php echo json_encode($tasks); ?> ;


        function datetostr(date){
          var dateArr = date.split("-");
          var monthstr = "JanFebMarAprMayJunJulAugSepOctNovDec";
          var start = ((dateArr[1] - 1) * 3);
          var str = monthstr.substring(start, (start + 3));

          return dateArr[2] + " " + str + " " + dateArr[0];
        }

        function displayTableContent(i){

          var html = "";
          html += "<tr>";
          html += "<td><a href='/taskforce/task/view_task.php?id=" + tasksArr[i]['tid'] + "'>" + tasksArr[i]['t_name'] + "</a></td>";
          html += "<td>" + tasksArr[i]['max_budget'] + "</td>";
          html += "<td>" + datetostr(tasksArr[i]['date_posted']) + "</td>";

          //calculate status of task...
          if(tasksArr[i]['assigned'] == 1 && tasksArr[i]['completed'] == 0){
            html += "<td>Assigned</td>";
          }
          else if(tasksArr[i]['assigned'] == 1 && tasksArr[i]['completed'] == 1){
            html += "<td>Completed</td>";
          }
          else if(tasksArr[i]['assigned'] == 0){
            html += "<td>Open</td>";
          }


          //convert rating toString
          if(tasksArr[i]['completed'] == 0){
            html += "<td>Task not yet completed.</td>";
          }
          else if(tasksArr[i]['completed'] == 1 && tasksArr[i]['tt_rates_tg']){
            html += "<td>" + tasksArr[i]['tt_rates_tg'] + "</td>";
          }
          else if(tasksArr[i]['completed'] == 1 && !tasksArr[i]['tt_rates_tg']){
            html += "<td>rating not yet posted by tasktaker.</td>";
          }

          html += "</tr>";

          return html;
        }

        function displayTable(show){

            var assigned;
            var completed;

            if(show == 'completed')
            {
              assigned = 1;
              completed = 1;
            }
            else if(show == 'assigned')
            {
              assigned = 1;
              completed = 0;
            }
            else if(show == 'open')
            {
              assigned = 0;
              completed = 0;
            }

            var numOfTasks = tasksArr.length;
            var html = "<tr><th>Task Name</th><th>Budget</th><th>Date Posted</th><th>Status</th><th>Your rating as TaskGiver(out of 5)</th></tr>";
            if(show == 'all')
            {
              for(var i = 0; i < numOfTasks; i++)
              {
                html += displayTableContent(i);
              }
            }
            else
            {
              for(var i = 0; i < numOfTasks; i++)
              {
                if(tasksArr[i]['assigned'] == assigned && tasksArr[i]['completed'] == completed)
                {
                  html += displayTableContent(i);
                }
              }
            }

            $("#task_table").html(html);


        }//end function displayTableContent


        //run the function for first page load.
        displayTable('all');

        $('#dropdown').change(function(){
            $("#task_table").fadeOut('fast');
            var show = $("#dropdown").val();
            displayTable(show);
            $("#task_table").fadeIn('slow');
        });


      });

   </script>

 </head>
 <body>
   <?php
     $active="login";
     include('../../includes/mainmenu.php');
     $activeMenu2 = 'tgiven';
     include('includes/manage_tasks_menu.php');

   ?>

   <div class="panel">
      <div>
          <h1>TaskGiven</h1>
            Show:
            <select style="border: solid 1px #D3D3D3;" id='dropdown'>
              <option value="all" selected>All</option>
              <option value="completed">Completed</option>
              <option value="assigned">Assigned</option>
              <option value="open">Open</option>
            </select>
            <br/><br/>
      </div>
      <hr>


      <div>
          <table id="task_table">
          <table>
      </div>

   </div>


</body>
</html>
