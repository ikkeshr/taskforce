<?php
  session_start();

  $uname = $_POST['login_uname'];
  $password = $_POST['login_password'];


  //if username is empty
  $unameErr="";
  $unameTrimmed = trim($uname); //to catch a username entered consisting of spaces only
  if(empty($unameTrimmed)){
    $unameErr="Please enter your username.";
  }

  //if password is empty
  $passwordErr="";
  if(empty($password)){
    $passwordErr="Please enter your password.";
  }


  //if username or password is empty go to register.php
  //else check credentials
  $credentialErr="";
  if(($unameErr != "") || ($passwordErr != "")){
    header("Location: login.php?unameErr=$unameErr&passwordErr=$passwordErr&credentialErr=$credentialErr&uname=$unameTrimmed");
  }
  else {

    require('../includes/db_connect.php');
    $uname = $conn->quote($_POST['login_uname']);
    $query = "select * from people where username=".$uname;
    $result = $conn->query($query);
    $numrows = $result->rowCount();
    $exist = false;

    if($numrows != 0)
    {
        $result = $result->fetch();
        $hashed_password = $result['password'];
        if(password_verify($_POST['login_password'],$hashed_password))
        {
            //go to profile
            $_SESSION['pid'] = $result['pid'];
            $_SESSION['uname'] = $result['username'];
            $_SESSION['dob'] = $result['dob'];
            $_SESSION['gender'] = $result['gender'];
            $_SESSION['email'] = $result['email'];
            $_SESSION['address'] = $result['address'];
            $_SESSION['nationality'] = $result['nationality'];
            $_SESSION['about_me'] = $result['about_me'];
            $_SESSION['picture'] = $result['picture'];
            $_SESSION['account_type'] = $result['account_type'];

            echo $_SESSION['pid'];
            header("Location: ../profile/profile.php");

            $exist = true;
        }//end inner if
    }//end outer if

    if($exist==false){
      $credentialErr="Invalid username or password.";
      header("Location: login.php?unameErr=$unameErr&passwordErr=$passwordErr&credentialErr=$credentialErr&uname=$unameTrimmed");
    }


  }//end outer most if/else


  $conn=null;




 ?>
