<div style="margin-left: 4%;">

<?php if(isset($_SESSION['pid'])){ ?> <!--if user is logged in-->
<form method="POST" action="comment_action.php" onsubmit="postComment(event); return false;">
  <textarea class='comment' id="textbox-comment" oninput="commentEntered()"
  name="comment_txt" placeholder="Add a public comment..."
  cols="80"></textarea></br>

  <input id="tid_txt" type="hidden" name="tid_txt" value=<?php echo $tid; ?>>
  <input id="pid_txt" type="hidden" name="pid_txt" value=<?php echo $pid; ?>>
  <button class="comment" id="commentBtn" disabled>Comment</button><span id='ifposted'></span>
</form>


<?php }else{ ?> <!--if user is not logged in-->
  <h3>You need to Log in to be able to post a comment.</h3>
<?php } ?>
</div>

<hr>

<!--the backend pages(comment_action and deleteComment_action)
uses this div(id='displayComments') to display the updated list of comments.-->
<div id="displayComments" style="margin-left: 4%;">
<!--diplay comments on this task.-->
<?php

  $sql = "select c.*, p.username, p.picture from comments c, people p
              where c.tid=$tid and c.banned=0 and c.pid=p.pid
              order by date DESC";

  include('../includes/db_connect.php');
  $commentTable = $conn->query($sql);
  while ($row = $commentTable->fetch()){

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
</div>
<!--
<div style="text-align: center; margin-top: 30px;">
  <button id='showMoreCommentsBtn'>Show more</button>
</div>
-->
<script>
    var currentMaxComment = 3;
    $('#showMoreCommentsBtn').click(function(){
        $.ajax({
            type: 'POST',
             data: 'currentMaxComment='+ currentMaxComment+'&tid=<?=$tid?>&pid=<?=$pid?>',
            url: 'includes/getMoreComments.php',
            success: function(response){
                  $('#displayComments').append(response);
                   currentMaxComment += 3;
            },
            error: function(){
              alert('error while fetching new comments');
            }
        });
    });
</script>
