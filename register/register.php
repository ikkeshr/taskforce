<?php
    session_start();
    if(isset($_SESSION['pid'])){
      header("Location: ../profile/profile.php");
      die();
    }
 ?>
<html>
<head>
  <title>Register</title>

  <!--footer bootstrap by Jacob Alfahad-->
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="../footer/footer_style.css">

  <!--main menu style and script-->
  <link rel="stylesheet" href="../css/main_menu_style.css"/>
  <script src="../js/menuScrollJS.js"></script>

  <link rel="stylesheet" href="css/registerStyle.css"/>
  <script src="js/registerJSValidation.js"></script>

  <!--jQuery-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>
      $(document).ready(function(){
        $("#uname").blur(function(){
          var uname = $("#uname").val();
          uname = uname.replace(/^\s+|\s+$/gm,'');
          $.ajax({
            type: 'POST',
            url: 'validateUsername.php',
            data: {'username': uname},
            success: function(response){
              //if username exists...
              if(response == true){
                $("#unameErr").html("&#9888 Sorry, this username is already taken.");
                $("#uname").css("border", "0.5px solid red");
              }
            },
            error: function(xhr, status, error) {
              alert(xhr + " " + status + " " + error);
            }
          });
        });
      });
  </script>


</head>
<body>

  <?php
      $active='login';
      include('../includes/mainmenu.php'); //include main menu

      $credentialErr="";
      $unameErr="";
      $passwordErr="";
      $dobErr="";
      $gender="";
      $genderErr="";
      $emailErr="";
      $address="";
      $nationality="";
      $about="";

      if(isset($_GET['credentialErr']))
      {
        $credentialErr= "&#9888" . $_GET['credentialErr'];
        if($_GET['unameErr']!=""){$unameErr= "&#9888" . $_GET['unameErr'];}
        if($_GET['passwordErr']!=""){$passwordErr= "&#9888" . $_GET['passwordErr'];}
        if($_GET['dobErr']){$dobErr= "&#9888" . $_GET['dobErr'];}
        $gender= $_GET['gender'];
        if($_GET['genderErr']!=""){$genderErr= "&#9888" . $_GET['genderErr'];}
        if($_GET['emailErr']!=""){$emailErr= "&#9888" . $_GET['emailErr'];}
        $address=$_GET['address'];
        $nationality=$_GET['nationality'];
        $about=$_GET['about'];
      }
   ?>
   <br/>
  <div class="form">
    <h1>Sign Up</h1>
    <p>Please fill in the form to create an account.</p>
    <span id="ifempty"><?php echo $credentialErr ?></span>
    <hr>
    <form id="register-form" name="register" method="POST" action="register_action.php" onsubmit="return validateForm();">
        <span id="unameErr"><?php echo $unameErr; ?></span>
        <input type="text" id="uname" name="reg_uname" placeholder="Username"
                autocomplete="off" onfocusout="validateUsername()"
                value="<?php if(isset($_GET['uname'])){echo $_GET['uname'];} ?>"/>

        <span id="password1Err"></span>
        <input type="password" id="password1" id name="reg_password1" placeholder="Password"
                onfocusout="validatePasswords()"/>

        <span id="passwordErr"><?php echo $passwordErr; ?></span>
        <input type="password" id="password2" name="reg_password2"
                placeholder="Confirm Password" onfocusout="validatePasswords()"/>

        <span id="emailErr"><?php echo $emailErr?></span>
        <input type="email" id="email" name="reg_email" placeholder="Email"
                onfocusout="validateEmail()" autocomplete="off"
                value="<?php if(isset($_GET['email'])){echo $_GET['email'];} ?>"/>

        Date of Birth
        <input type="date" id="dob" name="reg_dob" onfocusout="validateDOB()"
                value="<?php if(isset($_GET['dob'])){echo $_GET['dob'];} ?>"/>
        <span id="dobErr"><?php echo "    ".$dobErr; ?></span></br>

        <input type="radio" name="reg_gender" value="M"
        <?php if($gender=='M'){echo "checked";} ?>/>
        Male
        <input type="radio" name="reg_gender" value="F"
        <?php if($gender=='F'){echo "checked";} ?>/>
        Female
        <input type="radio" name="reg_gender" value="O"
        <?php if($gender=='O'){echo "checked";} ?>/>
        Other
        <span id="genderErr"><?php echo "    ".$genderErr; ?></span></br>

        <?php include('includes/nationalities.php'); ?>

        <input type="text" name="reg_address" placeholder="Address(Optional)"
        value="<?php if(isset($_GET['address'])){echo $_GET['address'];} ?>"/>

        <textarea name="reg_about" placeholder="Tell us something about yourself(Optional)"
        ><?php if(isset($_GET['about'])){echo $_GET['about'];} ?></textarea>

        <button type="submit">Sign Up</button>
    </form>
    <div class="login-link">Already have an account? <a href="../login/login.php">Log In</a></div>
  </div>
</body>
<!--footer bootstrap-->
<?php include('../footer/footer.html'); ?>
</html>
