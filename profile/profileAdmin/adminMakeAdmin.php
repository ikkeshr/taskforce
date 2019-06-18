<?php

echo "<h1>Make a user an Admin</h1>";
echo "<p>The table below contains all users on the platform.</p>";
echo "<hr>";
echo "<form action='make_admin_action.php' method='POST' id='makeAdmin-form'>";
echo "<table class='moderate'>";
echo   "<tr><th>Username</th><th>Make Admin</th></tr>";

      require_once('../../includes/db_connect.php');
      $sql = "select pid, username from people where account_type='normal'";
      $people = $conn->query($sql);

      while ($row = $people->fetch()) {
        $pid = $row['pid'];
        $username = $row['username'];
        echo "<tr>";
        echo "<td>" .$username. "</td>";
        echo "<td><input type='checkbox' name='$username' value='$pid'></td>";
        echo "</tr>";
      }
      $conn=null;

echo "</table>";
echo "<div class='moderate-buttons'>";
echo "<span id='formErr' style='color: red;'></span><br/><br/>";
echo   "<input type='submit'/>";
echo   "<input type='reset'/>";
echo "</div>";
echo "</form>";

 ?>
