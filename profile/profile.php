<?php
  session_start();

  if(!isset($_SESSION['pid'])){
    header("Location: ../login/login.php");
    die();
  }

?>
<html>
<head>
  <title><?php echo $_SESSION['uname'] ?></title>
  <link rel="stylesheet" href="../css/main_menu_style.css"/>
  <script src="../js/menuScrollJS.js"></script>
  <link rel="stylesheet" href="profileMenu/profileMenuStyle.css"/>

  <!--jQuery-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!--google library of icons, using it for search icon-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

  <style>
      div.about{
        padding: 20px;
        font-size: 18px;
        bottom: 20px;
      }

      .about i{
        font-size: 14px;
      }

  </style>

</head>
<body>
  <?php
    $active="login";
    include('../includes/mainmenu.php');

    $gender;
    if ($_SESSION['gender'] == 'M'){
      $gender = "Male";
    }
    else {
      $gender = "Female";
    }

    $date = date("Y");
    $dob = date("Y", strtotime($_SESSION['dob']));
    $age = $date - $dob;
    $age = $age . " yrs";

   ?>

  <?php
    $activeProfileMenu = 'about';
    include('profileMenu/profileMenu.php');
  ?>


   <div class="panel">
     <h1>About</h1>
     <hr>
     <div class='about'>
       <i class="material-icons"  style="font-size:40px; float:left; color: #005ab4">person</i>
       <b><?php echo $_SESSION['uname'] ?></b></br>
       <i>Username</i>
     </div>

     <div class='about'>
       <i class="material-icons"  style="font-size:40px; float:left; color: #005ab4">wc</i>
       <b><?php echo $gender ?></b></br>
       <i>Gender</i>
     </div>

     <div class='about'>
       <i class="material-icons"  style="font-size:40px; float:left; color: #005ab4">cake</i>
       <b><?php echo $age ?></b></br>
       <i>Age</i>
     </div>

     <div class='about'>
       <i class="material-icons"  style="font-size:40px; float:left; color: #005ab4">email</i>
       <b><?php echo $_SESSION['email'] ?></b></br>
       <i>Email</i>
     </div>

     <?php if($_SESSION['address'] != ''){ ?>
       <div class='about'>
         <i class="material-icons"  style="font-size:40px; float:left; color: #005ab4">home</i>
         <b><?php echo $_SESSION['address'] ?></b></br>
         <i>Address</i>
       </div>
     <?php } ?>

     <?php if($_SESSION['nationality'] != ''){ ?>
       <div class='about'>
         <i class="material-icons"  style="font-size:40px; float:left; color: #005ab4">public</i>
         <b><?php echo $_SESSION['nationality'] ?></b></br>
         <i>Nationality</i>
       </div>
     <?php } ?>

     <?php
        require_once('../includes/db_connect.php');
        $sql = "select * from person_skillset ps, skills s
                        where ps.pid=" . $_SESSION['pid'] . " and ps.skill_id = s.skill_id";
        $skills = $conn->query($sql);
        $skillCount = $skills->rowCount();

        if($skillCount != 0){
      ?>
        <div class='about'>
          <i class="material-icons"  style="font-size:40px; float:left; color: #005ab4">school</i>
          <?php
            $skills_name = "";
            $comma = ", ";
            $count = 1;
            while($row = $skills->fetch())
            {
              if($count == $skillCount){$comma = ".";}
              $skills_name = $skills_name . $row['skill_name'] . $comma;
              $count++;
            }
            $conn=null;
            echo "<b>" . $skills_name . "</b><br/>";
           ?>
           <i>Skills</i>
        </div>
    <?php } ?>

     <?php if($_SESSION['about_me'] != ''){ ?>
       <div class='about'>
         <i>About</i></br>
         <b><?php echo $_SESSION['about_me'] ?></b>
       </div>
     <?php } ?>


   </div>

</br></br></br></br></br></br></br></br></br>
</body>
</html>
