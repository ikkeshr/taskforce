<?php if($active==''){echo "class='active'";} ?>
<div id="navbar">
  <a  <?php if($active=='home'){echo "class='active'";} ?>  href="../home.php">Home</a>
  <a  <?php if($active=='explore'){echo "class='active'";} ?>  href="../explore/explore.php">Explore Tasks</a>
  <a  <?php if($active=='howItWorks'){echo "class='active'";} ?>  href="../howItWorks.php">How it works?</a>
  <a  <?php if($active=='login'){echo "class='active-lastchild'";} ?>   class="lastchild"
    href="<?php
      if(isset($_SESSION['uname']))
      {
        echo "../profile/profile.php";
      }
      else{
        echo "../login/login.php";
      }
    ?>">
    <?php if(isset($_SESSION['uname'])){echo $_SESSION['uname'];}else{echo "Login";}  ?> </a>
</div>
