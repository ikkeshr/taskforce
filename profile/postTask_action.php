<?php
  session_start();

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  //validate task name.
  $name = trim($_POST['task_name']);
  $nameErr = "";
  if(empty($name)){
    $nameErr = "Please enter a name for your task.";
  }
  else if(!preg_match("/^[a-zA-Z0-9. ]*$/",$name)){
    $nameErr = "Sorry, your task name can contain only letters and numbers.";
  }

  //validate task description.
  $desc = trim($_POST['task_desc']);
  $descErr = "";
  if(empty($desc)){
    $descErr = "Please enter a description for your task.";
  }


  //validate task deadline.
  $deadline = $_POST['task_deadline'];
  $deadlineErr = "";
  if(empty($deadline)){
    $deadlineErr = "Please specify the deadline of biddings on your task.";
  }
  else{
    $dateToday = date("Y-m-d");
    if($deadline < $dateToday){
      $deadlineErr = "Sorry, the deadline must be in the future";
    }
  }

  //validate task budget.
  $currency = $_POST['currency'];
  $budget = $_POST['task_budget'];
  $budgetErr = "";
  if(empty($budget)){
    $budgetErr = "Please enter a budget for your task.";
  }
  else if($budget < 0){
    $budgetErr = "Sorry, your task budget must be above zero.";
  }


  if(($nameErr != "") || ($descErr != "") || ($deadlineErr != "") || ($budgetErr != ""))
  {

    header("Location: postTask.php?nameErr=$nameErr&descErr=$descErr&deadlineErr=$deadlineErr&budgetErr=$budgetErr&name=$name&deadline=$deadline&currency=$currency&budget=$budget&desc=$desc");
  }
  else{
    $desc = test_input($desc);
    require('../includes/db_connect.php');
    $sql = "insert into tasks (tg_id, t_name, t_desc, deadline, max_budget, currency, date_posted, assigned, completed)
            values(".$_SESSION['pid'].", ".$conn->quote($name).", ".$conn->quote($desc).",
            ".$conn->quote($deadline).", ".$budget.", " . $conn->quote($currency) . ", ".$conn->quote($dateToday).", 0, 0)";
    //echo $sql . "<br/>";
    $conn->exec($sql);

    //get id of last inserted task.(this task)
    $tid = $conn->lastInsertId();

    //insert skills required for this task.
    /*issues
    -someone might change other inputs name to begin with skill_
    -bypass js and duplicate skill_id in $_POST array.($result = array_unique($array);)*/
    foreach($_POST as $key => $value)
    {
      if(substr($key, 0, 6) == 'skill_'){
        try{
          $sql = "insert into task_required_skill(tid, skill_id)
                    values($tid, $value)";
          $conn->exec($sql);
          //echo $sql . "<br/>";
        }
        catch(PDOException $e){
          echo $sql . "<br>" . $e->getMessage();
        }
      }
    }



    header("Location: ../task/view_task.php?id=$tid");
  }

  $conn = null;

?>
