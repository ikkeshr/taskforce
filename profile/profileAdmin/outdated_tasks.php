<?php
  session_start();
  if(isset($_SESSION['account_type'])){
    if($_SESSION['account_type'] != 'admin'){
      header("Location: ../profile.php");
      die();
    }
  }
  else{
    header("Location: ../../login/login.php");
    die();
  }

  include('../../includes/db_connect.php');
  $date = date("Y-m-d");
  $sql = "select * from tasks where deadline < " . $date;
  $outdated = $conn->query($sql);
  $conn=null;

 ?>
<html>
<head>
  <title><?php echo $_SESSION['uname']; ?>-Moderate</title>

  <link rel="stylesheet" href="../../css/main_menu_style.css"/>
  <script src="../../js/menuScrollJS.js"></script>

  <link rel="stylesheet" href="../profileMenu/profileMenuStyle.css"/>

  <link rel="stylesheet" href="css/adminProfileStyle.css"/>

</head>
<body>
  <?php
    $active = 'login';
    include('../../includes/mainmenu.php');
    $activeProfileMenu = 'outdated-tasks';
    include('includes/adminMenu.php');

   ?>

   <div class="panel">
    <h1>Outdated Tasks</h1>
    <p>The table below contains tasks which deadline is over.</p>
    <hr>
    <form>
    <table class="moderate">
      <tr><th>Task Name</th><th>Delete Task <input type='checkbox' id='select-all'></th></tr>
      <?php

          while ($row = $outdated->fetch()) {
            $tid = $row['tid'];
            $t_name = $row['t_name'];
            echo "<tr>";
            echo "<td>" .$t_name. "</td>";
            echo "<td><input type='checkbox' name='$t_name' value='$tid'></td>";
            echo "</tr>";
          }
       ?>
    </table>
    <div class="moderate-buttons">
      <input type='submit'/>
      <input type='reset'/>
    </div>
  </form>
   </div>
</body>
</html>
