<?php

echo "<h1>Maintain Comments</h1>";
echo "<p>The table below contains comments reported by users.</p>";
echo "<hr>";
echo "<form action='moderateComment_action.php' method='POST' id='moderateComments-form'>";
echo "<table class='moderate'>";
echo   "<tr><th>Comment</th><th>Ban Comment</th><th>Accept Comment</th></tr>";

      require_once('../../includes/db_connect.php');
      $sql = "select comment_id, comment from comments where flag = 1";
      $banComments = $conn->query($sql);

      while ($row = $banComments->fetch()) {
        $comment_id = $row['comment_id'];
        $comment = substr($row['comment'], 0, 62); // cut the comment if too long, to fit in table cell.
        echo "<tr>";
        echo "<td>" .$comment. "</td>";
        echo "<td><input type='radio' name='comment_id_$comment_id' value='banned'></td>";
        echo "<td><input type='radio' name='comment_id_$comment_id' value='accept'></td>";
        echo "</tr>";
      }
      $conn=null;

echo "</table>";
echo "<div class='moderate-buttons'>";
echo "<span id='formErr' style='color: red;'></span><br/><br/>";
echo  "<input type='submit'/>";
echo   "<input type='reset'/>";
echo "</div>";
echo "</form>";

 ?>
