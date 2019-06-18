<?php
  session_start();

  include('../includes/functions.php'); //my functions.

  $pid = 0; //pid of 0 will be refered to as user not logged in.
  if(isset($_SESSION['pid'])){
    $pid = $_SESSION['pid'];
  }


  $sql = "select t.*, p.username
          from tasks t, people p
          where t.tid = ".$_GET['id']." and t.tg_id=p.pid";

  include('../includes/db_connect.php');

  $task = $conn->query($sql);

  //if task don't exist in db.
  $numrows = $task->rowCount();
  if($numrows == 0){
    header("Location: ../profile/profile.php");
    die();
  }

  $task = $task->fetch();
  $banned = $task['banned'];//if task is banned.
  if($banned == 1){
    header('Location: task_banned.php');
    die();
  }

  $tg_name = $task['username'];
  $tid = $task['tid'];
  $tg_id = $task['tg_id'];
  $t_name = $task['t_name'];
  $t_desc = $task['t_desc'];
  $deadline = $task['deadline'];
  $max_budget = $task['max_budget'];
  $currency = $task['currency'];
  $date_posted = $task['date_posted'];
  $assigned = $task['assigned'];
  $tt_id = $task['tt_id'];
  $completed = $task['completed'];
  $tg_rates_tt = $task['tg_rates_tt'];
  $comment_from_tg = $task['comment_from_tg'];
  $tt_rates_tg = $task['tt_rates_tg'];
  $comment_from_tt = $task['comment_from_tt'];
  $flag = $task['flag'];


  //retrieve tasktaker name if task is assigned.
  if(!empty($tt_id)){
    $sql = "select username from people where pid=$tt_id";
    $tt_nameTable = $conn->query($sql);
    $tt_nameTable = $tt_nameTable->fetch();
    $tt_name = $tt_nameTable['username']; // to be used for status in task details and rate tasktaker popup
  }

  $conn = null;

?>
<html>
<head>
  <title><?php echo $t_name; ?></title>
  <link rel="stylesheet" href="../css/main_menu_style.css"/>
  <link rel="stylesheet" href="taskMenu/taskMenuStyle.css"/>
  <script src="../js/menuScrollJS.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <link rel="stylesheet" href="taskMenu/buttonsAction/buttonsFormStyle.css"/>
  <script src="taskMenu/buttonsAction/buttonFormsJS.js"></script>
  <script src="taskMenu/buttonsAction/buttonsFormValidation.js"></script>

  <link rel="stylesheet" href="css/viewTaskCommentStyle.css"/>
  <script src="includes/commentJS.js"></script>

  <link rel="stylesheet" href="css/view_task_style.css"/>


  <script>
      function currency_converter(input)
      {
        var amount1 = $('#amount1').val();
        var amount2 = $('#amount2').val();
        var currency1 = $('#currency1').val();
        var currency2 = $('#currency2').val();

        //euro to usd to mur
        var currencies = [1, 1.14, 39.03];

        if(input == 1){
          amount2 = amount1 * (currencies[currency2] / currencies[currency1]);
          $('#amount2').val(amount2.toFixed(2)); //.toFixed(2) - rounds to 2dp.
        }
        else{
          amount1 = amount2 * (currencies[currency1] / currencies[currency2]);
          $('#amount1').val(amount1.toFixed(2));
        }

      }


      $(document).ready(function(){
        currency_converter(1);
        $('#amount1').keyup(function(){currency_converter(1);});
        $('#currency1').change(function(){currency_converter(1);});
        $('#amount2').keyup(function(){currency_converter(2);});
        $('#currency2').change(function(){currency_converter(1);});
      });


  </script>

</head>
<body>
  <?php
      $active='explore';
      include('../includes/mainmenu.php'); //horizontal menu on top

      include('taskMenu/taskMenu.php'); //vertical menu

      include('taskMenu/buttonsAction/buttonsForms.php'); //pop up forms when menu button is clicked
   ?>

   <div class='panel'>
     <h1><?php echo $t_name; ?></h1>
     <i><?php echo "posted by <a href='' class='profileLink'>". $tg_name . "<a> on " . datetostr($date_posted); ?></i>
     <hr>
     <p><?php echo $t_desc; ?></p>
    </br>
      <div class='about'>
        <b><?php echo datetostr($deadline); ?></b></br>
        <i>Deadline</i>
      </div>

     <div class='about'>
        <b><?php echo curToSymbol($currency) . $max_budget; ?></b></br>
        <i>Budget</i>
     </div>

     <?php include('includes/taskStatus.php'); ?>

     <?php
        require($_SERVER['DOCUMENT_ROOT'].'/taskforce/includes/db_connect.php');
        $sql = "select * from task_required_skill tr, skills s
                    where tr.tid=$tid and tr.skill_id=s.skill_id";
        $skills = $conn->query($sql);
        $skillCount = $skills->rowCount();

        if($skillCount != 0){
      ?>
        <div class='about'>
          <?php
            $skills_name = "";
            $comma = ", ";
            $count = 1;
            while($row = $skills->fetch())
            {
              if($count == $skillCount){$comma = ".";}
              $skills_name = $skills_name . $row['skill_name'] . $comma;
              $count++;
            }
            $conn=null;
            echo "<b>" . $skills_name . "</b><br/>";
           ?>
           <i>Skills required</i>
        </div>
    <?php } ?>

   </div>

   <div class="panel">
     <h1>Biddings</h1>
     <hr>
     <?php include('includes/taskBiddings.php'); ?>
   </div>

   <div class="panel">
     <h1>Comments</h1>
     <hr>
     <?php include('includes/taskComments.php'); ?>
   </div>


</br></br></br></br></br></br></br></br></br></br></br></br>
</body>
</html>
