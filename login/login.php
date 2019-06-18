<?php
  session_start();
  if(isset($_SESSION['pid'])){
    header("Location: ../profile/profile.php");
    die();
  }
?>

<html>
<head>
  <title>Log in</title>
  <link rel="stylesheet" href="../css/main_menu_style.css"/ type="text/css">
  <script src="../js/menuScrollJS.js"></script>

  <link rel="stylesheet" href="css/loginStyle.css"/ type="text/css">
  <script src="js/loginJSValidation.js"></script>

</head>
<body>
  <?php
    $active='login';
    include('../includes/mainmenu.php');

    $credentialErr="";
    $unameErr="";
    $passwordErr="";
    if(isset($_GET['unameErr'])){
      if(!empty($_GET['unameErr'])){$unameErr="&#9888 ".$_GET['unameErr'];}
      if(!empty($_GET['passwordErr'])){$passwordErr="&#9888 ".$_GET['passwordErr'];}
    }

    if(isset($_GET['credentialErr'])){$credentialErr="&#9888 ".$_GET['credentialErr'];}

  ?>

  <div class="login-box">
    <div class="login-box-header">
      <h1>Login</h1>
      <p>Log into your account</p>
      <span id="ErrInHeader"><?php echo $credentialErr ?></span>
    </div>
    <hr>
    <div class="login-form">
      <form action="login_action.php" method="POST" onsubmit="return validateForm();">
          <input id="uname" type="text" name="login_uname" autocomplete="off"
           placeholder="Username" onfocusout="autoValidateUsername()"
           <?php  if(isset($_GET['uname'])){echo "value='".$_GET['uname']."'";} ?>  />
          <span id=unameErr><?php echo $unameErr ?></span></br>

          <input id="password" type="password" name="login_password"
           placeholder="Password" onfocusout="autoValidatePassword()"/>
          <span id="passwordErr"><?php echo $passwordErr ?></span></br>

          <button type="submit">Login</button>
      </form>
    </div>
    <div class="login-box-footer">
        <p>Don't have an account? <a href="../register/register.php">Sign up</a></p>
    </div>
  </div>


</body>
</html>
