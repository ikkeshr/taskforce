<?php
  session_start();

  if(!isset($_SESSION['pid'])){
    header("Location: ../login/login.php");
    die();
  }
 ?>
<html>
<head>
  <title><?php echo $_SESSION['uname'] ?></title>
  <link rel="stylesheet" href="../css/main_menu_style.css"/>
  <script src="../js/menuScrollJS.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <link rel="stylesheet" href="profileMenu/profileMenuStyle.css"/>

  <link rel="stylesheet" href="/taskforce/profile/css/postTask.css"/>

  <script>

    $(document).ready(function(){

      //declare an array to store skills already selected.
      var presentSkills = [];

      $('#addButton').click(function(){
          var skill = $('#skill_choice').val().split("|");
          //skill[0] is skill_id.
          //skill[1] is skill_name.

          //checks if skill was already selected or no skill selected.
          if(presentSkills.includes(skill[0]) || skill[0] == '')
          {
            $('#skill_choice').css('border', 'solid 0.5px red');
          }
          else{
            $('#skill_choice').css('border', 'solid 0.5px black');
            presentSkills.push(skill[0]);
            var row = "<tr><td><input type='hidden' name = 'skill_" + skill[1] + "' value='" + skill[0] + "'>" + skill[1] + "</td><td><button type='button' class='delete' id='" + skill[0] +"'>Delete</button></td></tr>";
            $(row).appendTo('#skill_table');
          }
      });


      $(document).on('click', '.delete', function(){
        //remove row in table
        $(this).parent().parent().remove();

        //remove from array 'presentSkills'.
        //get index of skill_id
        var index = presentSkills.indexOf($(this).attr('id'));
        //remove retrieved index.
        presentSkills.splice(index, 1);

      });
      
    });


  </script>

  <script src="js/functions.js"></script>
  <script src="js/postTaskValidation.js"></script>

</head>
<body>
  <?php
    $active='login';
    include('../includes/mainmenu.php');
    $activeProfileMenu='postTask';
    include('profileMenu/profileMenu.php');

    function toErrorString($str){
      if(!empty($str)){
        return "&#9888 " . $str;
      }
      else {
        return $str;
      }
    }

    $name = "";
    $deadline = "";
    $desc = "";
    $budget = "";
    $currency = "";

    $nameErr = "";
    $descErr = "";
    $deadlineErr = "";
    $budgetErr = "";

    if(isset($_GET['nameErr'])){
      $name = $_GET['name'];
      $deadline = $_GET['deadline'];
      $budget = $_GET['budget'];
      $desc = $_GET['desc'];
      $currency = $_GET['currency'];

      $nameErr = toErrorString($_GET['nameErr']);
      $descErr = toErrorString($_GET['descErr']);
      $deadlineErr = toErrorString($_GET['deadlineErr']);
      $budgetErr = toErrorString($_GET['budgetErr']);
    }

   ?>
   <div class='panel'>
      <h1>Post a Task</h1>
      <p>Fill in all these fields to post a task.</p>
      <hr>
      <div class="postTask-form">

        <form action="postTask_action.php" method="POST" onsubmit="validate(event);">
          <span id="nameErr"><?php echo $nameErr; ?></span>
          <input id="name" maxlength="100" type="text" name="task_name" placeholder="Task Name"
          onfocusout="removeNameError()" value='<?php echo $name; ?>'
          <?php if($nameErr != ''){echo "class='error'";} ?>/>


          <span id="descErr"><?php echo $descErr; ?></span>
          <textarea id="desc" name="task_desc" placeholder="Task Description (252 characters max)" maxlength="252"
          onfocusout="removeDescError()"  <?php if($descErr != ''){echo "class='error'";} ?>
          ><?php echo $desc; ?></textarea>


          <label for='deadline'>Deadline of biddings</label><br/><span id='deadlineErr'><?php echo $deadlineErr; ?> </span>
          <input type="date" name="task_deadline" id='deadline'
          onfocusout="removeDateError()" value='<?php echo $deadline; ?>'
          <?php if($deadlineErr != ''){echo "class='error'";} ?>/>

          <span id='budgetErr'><?php echo $budgetErr; ?></span><br/>
          <select name="currency">
            <option value='ruppee' <?php if($currency=='' || $currency=='ruppee'){echo "selected";} ?> >Rs</option>
            <option value='usd' <?php if($currency=='usd'){echo "selected";} ?> >USD</option>
            <option value='euro' <?php if($currency=='euro'){echo "selected";} ?> >Euro</option>
          </select>

          <input type='number' name="task_budget" id='budget' placeholder="Budget"
           onfocusout="removeBudgetError()" value='<?php echo $budget; ?>'
          <?php if($budgetErr != ''){echo "class='error'";} ?>/>

          <!--skills for task-->
          <div class="skills">
            <h3>Select skills required for your task. (Optional)
            <select id="skill_choice">
               <option value="" selected>Select Skill</option>
               <?php
                  include($_SERVER['DOCUMENT_ROOT'].'/taskforce/includes/db_connect.php');
                  $skills = $conn->query("select * from skills");
                  while($row = $skills->fetch())
                  {
                    echo "<option value='" . $row['skill_id'] ."|" . $row['skill_name'] . "'>" . $row['skill_name'] . "</option>";
                  }
                  $conn=null;
                ?>
             </select>
             <button type="button" id='addButton'>Add</button>
             <br/><br/>
             <table id='skill_table'></table>
          </div>

          <button type="submit">Post</button>

        </form>
      </div>
   </div>
 </br></br></br></br></br></br></br></br>
</body>
</html>
