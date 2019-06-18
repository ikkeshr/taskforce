<?php

echo "<h1>Maintain Tasks</h1>";
echo "<p>The table below contains tasks reported by users.</p>";
echo "<hr>";
echo "<form action='moderateTasks_action.php' method='POST' id='moderateTasks-form'>";
echo "<table class='moderate'>";
echo   "<tr><th>Task Name</th><th>Ban Task</th><th>Accept Task</th></tr>";

      require_once('../../includes/db_connect.php');
      $sql = "select tid, t_name from tasks where flag = 1";
      $banTasks = $conn->query($sql);

      while ($row = $banTasks->fetch()) {
        $task_id = $row['tid'];
        echo "<tr>";
        echo "<td><a href='../../task/view_task.php?id=$task_id'>" .$row['t_name']. "</a></td>";
        echo "<td><input type='radio' name='task_id_$task_id' value='banned'></td>";
        echo "<td><input type='radio' name='task_id_$task_id' value='accept'></td>";
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
