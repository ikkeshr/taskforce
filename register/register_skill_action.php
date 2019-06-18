<?php
    session_start();
    if(!isset($_SESSION['pid'])){
      header("Location: register.php");
      die();
    }
?>
<html>
  <title>Processing...</title>
<body>

<?php
    require_once('../includes/db_connect.php');
    $pid = $_SESSION['pid'];
    $emptyMsg = "No skills selected.";

    //value is skill_id
    foreach($_POST as $value){
      $insert = "insert into person_skillset(pid, skill_id)
                  values($pid, $value)";
      $conn->exec($insert);
      //echo $insert . "<br>";
      $emptyMsg = "";
    }

    if($emptyMsg != ""){
      header("Location: register_skill.php?msg=$emptyMsg");
    }
    else{
      header("Location: /taskforce/profile/profile.php");
    }

    $conn = null;
 ?>

</body>
</html>
