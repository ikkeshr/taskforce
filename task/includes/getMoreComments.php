<?php

    require_once '../../includes/db_connect.php';

    include '../../includes/functions.php';

    $currentMaxComment = $_POST['currentMaxComment'];
    $tid = $_POST['tid'];
    $pid = $_POST['pid'];

    $sql = "select c.*, p.username, p.picture from comments c, people p
                where c.tid=$tid and c.banned=0 and c.pid=p.pid
                order by date DESC LIMIT $currentMaxComment, 3";

    $result = $conn->query($sql);

    while ($row = $result->fetch()){

      echo "<div id='comment_container_" . $row['comment_id'] . "'>";
      echo "<div class='comment-box' id='comment_" . $row['comment_id'] . "'>";
      echo "<img src='/taskforce/profile_pictures/".$row['picture']."'/>";
      echo "<b><a href='' class='profileLink'>".$row['username']."</a> </b> • ";
      echo "<span>".howlong($row['date'])."</span></br></br>";
      echo "<p>".wordwrap(nl2br($row['comment']), 80, "<br/>\n")."</p>";
      echo "</div>";
      echo "<div class='comment-box-footer' id='comment_" . $row['comment_id'] . "_footer'>";
      echo "<p>";
      $comment_id = $row['comment_id'];
      if($pid == $row['pid']){
        echo "<button onclick='deleteComment($comment_id,$tid,$pid)'>Delete</button>";
      }else{
        echo "<button onclick='reportComment($comment_id)'>Report</button>";
      }
      echo "</p>";
      echo "</div>";
      echo "</div>";
    }

 ?>
