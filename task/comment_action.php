<?php
  session_start();

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $comment = test_input($_POST['comment_txt']);

  $tid = $_POST['tid_txt'];
  $pid = $_POST['pid_txt'];

  date_default_timezone_set("Indian/Mauritius");
  $date = date("Y-m-d h:i:s");

  if($comment == ""){
    echo "No comment entered";
  }
  else{
    include('../includes/db_connect.php');
    include('../includes/functions.php');
    $sql = "insert into comments (tid, pid, date, comment, flag, banned)
                values($tid, $pid, ".$conn->quote($date).", ".$conn->quote($comment).", 0, 0)";
    //echo $sql;
    $conn->exec($sql);
    //$conn=null;
    //header("Location: view_task.php?id=$tid");

////////////////////////DISPLAYS NEW COMMENT(using AJAX, prepend it to comment list.)///////////////////////////////////////////

    $now = date("Y-m-d");
    $comment_id = $conn->lastInsertId();
    $conn=null;

    echo "<div id='comment_container_" . $comment_id . "'>";
    echo "<div class='comment-box' id='comment_" . $comment_id . "'>";
    echo "<img src='/taskforce/profile_pictures/".$_SESSION['picture']."'/>";
    echo "<b>".$_SESSION['uname']." </b> • ";
    echo "<span>".howlong($now)."</span></br></br>";
    echo "<p>".wordwrap(nl2br($comment), 80, "<br/>\n")."</p>";
    echo "</div>";
    echo "<div class='comment-box-footer' id='comment_" . $comment_id . "_footer'>";
    echo "<p>";

    echo "<button onclick='deleteComment($comment_id,$tid,$pid)'>Delete</button>";
    echo "</p>";
    echo "</div>";
    echo "</div>";



  }



 ?>
