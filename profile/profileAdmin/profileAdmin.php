<?php
  session_start();
  if(isset($_SESSION['account_type'])){
    if($_SESSION['account_type'] != 'admin'){
      header("Location: ../profile.php");
      die();
    }
  }
  else{
    header("Location: ../../login/login.php");
    die();
  }
 ?>
<html>
<head>
  <title><?php echo $_SESSION['uname']; ?>-Moderate</title>

  <link rel="stylesheet" href="../../css/main_menu_style.css"/>
  <script src="../../js/menuScrollJS.js"></script>

  <link rel="stylesheet" href="../profileMenu/profileMenuStyle.css"/>

  <link rel="stylesheet" href="css/adminProfileStyle.css"/>

  <!-jQuery-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>
      $(document).ready(function(){
        //FOR THE MODERATE TASKS FORM WHEN THE ADMIN PAGE///////////////////
        ///////////////////////////////////////////////////////////////
        function moderateTasksSubmit(){
          var selected = $("input:checked").length;
          if(selected == 0){
            $("#formErr").html("No task selected.");
          }
          else{
            var data = $(this).serialize();
            //submit form with ajax.
            $.ajax({
              type: 'POST',
              data: data,
              url: 'moderateTasks_action.php',
              success: function(){
                //moderateTasks();
                //get all checked radios and remove the row in which they are are.
                $("input:checked").each(function(){
                  //console.log($(this).val() + $(this).attr("name"));
                  $(this).parent().parent().remove();

                });


              },
              error: function(){
                alert("form submission problem.[moderate task]");
              }
            });//end ajax.
          }//end else.
          return false;
        }

        $("#moderateTasks-form").submit(moderateTasksSubmit);
        /////////////////////////////////////////////////////////////////////

        //FOR THE MODERATE TASKS FORM WHEN THE USER HAS BEEN NAVIGATING THROUGHT THE ADMIN PAGE///
        function moderateTasks(){
          //set the button as active.
          $("#moderateTasks-menuButton").css("background-color", "#2389cd");
          $("#moderateTasks-menuButton").css("color", "white");

          //set other buttons as unactive.
          $("#moderateComments-menuButton").css("background-color", "white");
          $("#moderateComments-menuButton").css("color", "black");
          $("#makeAdmin-menuButton").css("background-color", "white");
          $("#makeAdmin-menuButton").css("color", "black");

          //use ajax to retrieve data from a php script.
          $.ajax({
            type: 'POST',
            url: 'adminTasks.php',
            success: function(response){
              //on success place data retrive into div panel
              $("#panel").html(response);
              //FORM ACTION LISTENER
              $("#moderateTasks-form").submit(moderateTasksSubmit);
            },
            error: function(){
              alert('error when retrieving flag tasks');
            }
          });//end ajax
        }

        function moderateComments(){
          //set the button as active.
          $("#moderateComments-menuButton").css("background-color", "#2389cd");
          $("#moderateComments-menuButton").css("color", "white");

          //set other buttons as unactive.
          $("#makeAdmin-menuButton").css("background-color", "white");
          $("#makeAdmin-menuButton").css("color", "black");
          $("#moderateTasks-menuButton").css("background-color", "white");
          $("#moderateTasks-menuButton").css("color", "black");

          //use ajax to retrieve data from a php script.
          $.ajax({
            type: 'POST',
            url: 'adminComments.php',
            success: function(response){
              //on success place data retrive into div panel
              $("#panel").html(response);
              //FORM SUBMISSION action
              $("#moderateComments-form").submit(function(){
                var selected = $("input:checked").length;
                if(selected == 0){
                  $("#formErr").html("No commment selected.");
                }
                else{
                  var data = $(this).serialize();
                  //submit form with ajax.
                  $.ajax({
                    type: 'POST',
                    data: data,
                    url: 'moderateComment_action.php',
                    success: function(){
                      //moderateComments();
                      $("input:checked").each(function(){
                        $(this).parent().parent().remove();
                      });
                    },
                    error: function(){
                      alert("form submission problem.[moderate comment]");
                    }
                  });//end ajax.
                }//end else.
                return false;
              });
            },
            error: function(){
              alert('error when retrieving flag comments');
            }
          });//end ajax
        }


        function makeAdmin(){
          //set the button as active.
          $("#makeAdmin-menuButton").css("background-color", "#2389cd");
          $("#makeAdmin-menuButton").css("color", "white");

          //set other buttons as unactive.
          $("#moderateComments-menuButton").css("background-color", "white");
          $("#moderateComments-menuButton").css("color", "black");
          $("#moderateTasks-menuButton").css("background-color", "white");
          $("#moderateTasks-menuButton").css("color", "black");

          //use ajax to retrieve data from a php script.
          $.ajax({
            type: 'POST',
            url: 'adminMakeAdmin.php',
            success: function(response){
              //on success place data retrive into div panel
              $("#panel").html(response);
              //Form submittion action.
              $("#makeAdmin-form").submit(function(){
                var checked = $("input:checkbox:checked").length;
                if(checked == 0){
                  $("#formErr").html("No user selected");
                }
                else{
                  var data = $(this).serialize();
                  $.ajax({
                    type: 'POST',
                    url: 'make_admin_action.php',
                    data : data,
                    success: function(){
                        //makeAdmin();
                        $("input:checkbox:checked").each(function(){
                          $(this).parent().parent().remove();
                        });
                    },
                    error: function(){
                      alert("make admin error. [form submission]");
                    }
                  });
                }//end else.
                return false;
              });
            },
            error: function(){
              alert('error when retrieving users in make admin');
            }
          });//end ajax
        }



        //vertical menu button listeners.
        //when the user click the make moderate tasks button on the vertical menu.
        $("#moderateTasks-menuButton").click(moderateTasks);

        //when user click the moderate comments button on the vertical menu.
        $("#moderateComments-menuButton").click(moderateComments);


        //when the user click the make admin button on the vertical menu.
        $("#makeAdmin-menuButton").click(makeAdmin);






      });
  </script>

</head>
<body>
  <?php
    $active = 'login';
    include('../../includes/mainmenu.php');
    $activeProfileMenu = 'moderate-tasks';
    include('includes/adminMenu.php');

   ?>

   <div class="panel" id="panel">
     <h1>Maintain Tasks</h1>
   <p>The table below contains tasks reported by users.</p>
   <hr>
   <form action='moderateTasks_action.php' method='POST' id='moderateTasks-form'>
   <table class="moderate">
     <tr><th>Task Name</th><th>Ban Task</th><th>Accept Task</th></tr>
     <?php
         require_once('../../includes/db_connect.php');
         $sql = "select tid, t_name from tasks where flag = 1";
         $banTasks = $conn->query($sql);

         while ($row = $banTasks->fetch()) {
           $task_id = $row['tid'];
           echo "<tr id='".$row['tid']."'>";
           echo "<td><a href='../../task/view_task.php?id=$task_id'>" .$row['t_name']. "</a></td>";
           echo "<td><input type='radio' name='task_id_$task_id' value='banned'></td>";
           echo "<td><input type='radio' name='task_id_$task_id' value='accept'></td>";
           echo "</tr>";
         }
         $conn=null;
      ?>
   </table>
   <div class="moderate-buttons">
     <input type='submit'/>
     <input type='reset'/>
   </div>
 </form>

   </div>
</body>
</html>
