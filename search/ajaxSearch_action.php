<?php

  $search_value = $_POST['search'];

  include('../includes/db_connect.php');

  //to cope with search values with quotes in them.
  $search_value = $conn->quote($search_value); //eg, 'o\'brian'
  $search_value =  substr($search_value, 1); //remove quote at start, eg, o\'brian'
  $search_value = substr($search_value, 0,-1); //remove quote at end, eg, o\'brian

  $users = "select * from people where username LIKE '%" . $search_value . "%' LIMIT 5";
  $tasks = "select tid, t_name from tasks where t_name LIKE '%" . $search_value . "%' LIMIT 5";
  $taskBy = "select t.tid, t.t_name, p.username from tasks t, people p
                where t.tg_id=p.pid
                AND p.username LIKE '%" . $search_value . "%' LIMIT 5";

  $tasksBySkill = "SELECT tasks.tid, tasks.t_name, skills.skill_name
                    FROM (tasks INNER JOIN task_required_skill ON tasks.tid=task_required_skill.tid)
                    INNER JOIN skills ON task_required_skill.skill_id=skills.skill_id
                    WHERE skills.skill_name LIKE '%$search_value%' LIMIT 4";

  $user_results = $conn->query($users);
  $task_results = $conn->query($tasks);
  $taskBy_results = $conn->query($taskBy);
  $tasksBySkill_results = $conn->query($tasksBySkill);

  $count = 0;

  //retrieve tasks.
  while(($row = $task_results->fetch()) && $count < 8){
    $tid = $row['tid'];
    echo "<li><a href='/taskforce/task/view_task.php?id=$tid'>".$row['t_name']."<br /><span>Task</span></a></li>";
    $count++;
  }

  //retrieve tasks by refered skill.
  while(($row = $tasksBySkill_results->fetch()) && $count < 8){
    $tid = $row['tid'];
    echo "<li><a href='/taskforce/task/view_task.php?id=$tid'>".$row['t_name']."<br /><span>".$row['skill_name']."</span></a></li>";
    $count++;
  }

  //retrieve users
  while(($row = $user_results->fetch()) && $count < 8){
    $pid = $row['pid'];
    echo "<li><a href='/taskforce/user_profile/user_profile.php?id=$pid'>".$row['username']."<br /><span>User</span></a></li>";
    $count++;
  }

  //retrieve tasks by user
  while(($row = $taskBy_results->fetch()) && $count < 8){
    $tid = $row['tid'];
    echo "<li><a href='/taskforce/task/view_task.php?id=$tid'>".$row['t_name']."<br /><span>Task by
                  ".$row['username']."</span></a></li>";
    $count++;
  }


  //fuzzy search if no results.
  if($count == 0){
    //fuzzy search people
    $sql = "select pid, username from people";
    $users = $conn->query($sql);
    while(($row = $users->fetch()) && $count < 8){
      $distance = levenshtein ( strtolower($row['username']) , strtolower($search_value));
      if($distance < 3){
        $pid = $row['pid'];
        echo "<li><a href='/taskforce/user_profile/user_profile.php?id=$pid'>".$row['username']."<br /><span>User</span></a></li>";
        $count++;
      }
    }

    //fuzzy search tasks.
    $sql = "select tid, t_name from tasks";
    $tasks = $conn->query($sql);
    while(($row = $tasks->fetch()) && $count < 8){
      $distance = levenshtein ( strtolower($row['t_name']) , strtolower($search_value));
      if($distance < 4){
        $tid = $row['tid'];
        echo "<li><a href='/taskforce/task/view_task.php?id=$tid'>".$row['t_name']."<br /><span>Task</span></a></li>";
        $count++;
      }
    }
  }


  $conn=null;
 ?>
