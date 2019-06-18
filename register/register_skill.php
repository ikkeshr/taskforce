<?php
  session_start();
  if(!isset($_SESSION['pid'])){
    header("Location: register.php");
    die();
  }

  require_once('../includes/db_connect.php');
  //first check if user have already register for some skills.
  //in case the user type in the link in the address bar.
  //this will avoid Integrity constraint violation as duplicate primary key may be entered
  //if the user enters a skill that he/she already registered for.
  $check = $conn->query("select * from person_skillset where pid=".$_SESSION['pid']);
  $check = $check->rowCount();
  if($check != 0){
    header("Location: ../profile/profile.php");
    die();
  }

  $skillArr = $conn->query("select * from skills");
  $skillArr = $skillArr->fetchAll();
  $conn=null;
  $skillArrLength = sizeof($skillArr);
 ?>
<!DOCTYPE html>
<html>
<head>
  <title>What are your skills</title>
  <meta charset="UTF-8">
  <meta name="description" content="what are your skills">
  <meta name="keywords" content="what are your skills, skills register">
  <meta name="author" content="Ikkesh Ramanna">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!--main menu style and script-->
  <link rel="stylesheet" href="../css/main_menu_style.css"/>
  <script src="../js/menuScrollJS.js"></script>

  <!--register style-->
  <link rel="stylesheet" href="css/registerStyle.css"/>

  <style>
    .search-container{
      display: none;
    }
    span.skillTag{
      padding: 8px;
      border-radius: 6px;
      background-color: #005ab4;
      color: white;
      margin-left: 5px;
      margin-top: 15px;
    }
    div.tags{
      margin: auto;
      width: 50%;
      padding: 15px;
    }
  </style>

  <!--jquery-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>
    $(document).ready(function(){
      //validation
      $('#register-skills-form').submit(function(){
        var checked = $(".skills :checkbox:checked").length;
        if(checked == 0){
          $('#register-skills-error').html('&#9888 No skills selected.');
          return false;
        }
      });

      //search skill.
      var skillsArr = <?php echo json_encode($skillArr); ?> ;
      var skillArrLength = skillsArr.length;
      $('#search').keyup(function(){
        var searchValue = $('#search').val();
        var temp = "^" + searchValue;
        var regexp = new RegExp(temp, "i");

        for(var i=0; i < skillArrLength; i++){
          if(!(regexp.test(skillsArr[i]['skill_name']))){
            $('#'+skillsArr[i]['skill_id']).hide();
          }
          else{
              $('#'+skillsArr[i]['skill_id']).show();
          }
        }
      });

      //add/remove skill tag.
      $('.skills :checkbox').change(function(){
          if($(this).is(':checked'))
          {
              $("#showSelected").append(
                "<span class='skillTag' id='"+$(this).val()+"'>" + $(this).attr("name") + "</span>"
              )
          }
          else
          {
              $("#"+$(this).val()).remove();
          }
      });

      $('#resetBtn').click(function(){
          $('.skills :checkbox:checked').each(function(){
              $("#"+$(this).val()).remove();
          })
      });

    });
  </script>

</head>
<body>
  <?php
      $active='login';
      include('../includes/mainmenu.php'); //include main menu

      $msg = "";
      if(isset($_POST['msg'])){$msg = $_POST['msg'];}

  ?>
  <div class='form'>
    <h1>Select your skills</h1>
    <p>click on the box next to the skills which you master</p>
    <hr>
    <form action='register_skill_action.php' method='POST' id='register-skills-form'>
      <div id='showSelected' class='tags'></div>
      <div class='skills'>
        <input type='text' style="width: 94%;" placeholder=' &#128269 Search skill...' id='search' autocomplete="off"/>
        <div style="overflow-y:auto; height: 250px;">
        <table>
          <?php
            for($i=0; $i<$skillArrLength; $i++)
            {
              echo "<tr id='". $skillArr[$i]['skill_id'] ."'><td><p>" . $skillArr[$i]['skill_name'] . "</p></td>";
              echo "<td><input type='checkbox' name='" .$skillArr[$i]['skill_name'] . "' value='" . $skillArr[$i]['skill_id'] . "'/></td></tr>";
            }
           ?>
        </table>
      </div>
        <input type="reset" id='resetBtn'/>
      </div>
      <div class='bottom'>
        <span id='register-skills-error'><?php echo $msg; ?></span><br/><br/>
        <button type='submit'>Next</button>
      </div>
    </form><br/>
    <div class="login-link" style='float:right;'><a href="/taskforce/profile/profile.php">Skip</a></div><br/>
  </div>
<br/><br/><br/><br/><br/><br/>
</body>
</html>
