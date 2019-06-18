<?php
  session_start ();
  require('../includes/db_connect.php');

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = trimInner($data); //my function
    return $data;
  }

  function removeIllegalCharacters($data){
    $data = preg_replace('/[^a-zA-Z0-9]/','',$data);
    return $data;
  }

  function trimInner($data){
    $data = preg_replace('/\s+/',' ',$data);
    return $data;
  }


  //validate Username
  $uname=test_input($_POST['reg_uname']);
  $unameErr="";
  if(!empty($uname))
  {
      $query = "SELECT * FROM people WHERE username=" . $conn->quote($uname);
      $result = $conn->query($query);
      $numrows = $result->rowCount();
      if($numrows != 0)
      {
        $unameErr = "We're sorry, that username is taken.";
      }
      else if(!preg_match("/^[a-zA-Z0-9 ]*$/",$uname))
      {
        $unameErr = "We're sorry, only letters, numbers and white space are allowed in your username.";
      }
  }
  else
  {
    $unameErr = "Please enter a username.";
  }

  //validate PASSWORD
  $passwordErr = "";
  if((empty($_POST['reg_password1'])) || (empty($_POST['reg_password2'])))
  {
    $passwordErr = "Please enter a password.";
  }
  if(!($_POST['reg_password1'] == $_POST['reg_password2']))
  {
    $passwordErr = "Passwords don't match";
  }


  //validate Email
  $email = test_input($_POST["reg_email"]);
  $emailErr = "";
  if (empty($_POST["reg_email"])) {
    $emailErr = "Please enter your email";
  }
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
  {
    // check if e-mail address is well-formed
      $emailErr = "The email you supplied is invalid.";
  }


  //validate date of Birth
  $dob = $_POST['reg_dob'];
  $dobErr = "";
  $date = date("Y-m-d");
  if(empty($_POST['reg_dob']))
  {
    $dobErr = "Please enter a your date of birth.";
  }
  else if ($_POST['reg_dob'] > $date)
  {
    $dobErr = "Please enter a valid date.";
  }

  //validate gender
  $gender = $_POST['reg_gender'];
  $genderErr = "";
  if(empty($_POST['reg_gender']))
  {
    $genderErr = "Please indicate your gender.";
  }



  //validate address
  $address = test_input($_POST['reg_address']);
  if(empty($address))
  {
    $address='';
  }


  //validate nationality
  if(empty($_POST['reg_nationality'])){
    $nationality='';
  }
  else{
    $nationality = $_POST['reg_nationality'];
  }

  //validate about
  $about = test_input($_POST['reg_about']);
  if(empty($_POST['reg_about'])){
    $about='';
  }


  //if all data are valid input
  if(($unameErr != "") || ($passwordErr != "") || ($emailErr != "") || ($dobErr != "") || ($genderErr != ""))
  {

    $credentialErr="Please fill in the required fields properly.";
    header("Location: register.php?unameErr=$unameErr&passwordErr=$passwordErr&emailErr=$emailErr&dobErr=$dobErr&genderErr=$genderErr&unameErr=$unameErr&nationality=$nationality&address=$address&about=$about&uname=$uname&dob=$dob&email=$email&gender=$gender&address=$address&nationality=$nationality&about=$about&credentialErr=$credentialErr");
  }
  else
  {

    $_SESSION['uname'] = $uname;
    $_SESSION['email'] = $email;
    $_SESSION['dob'] = $dob;
    $_SESSION['gender'] = $gender;
    $_SESSION['address'] = $address;
    $_SESSION['nationality'] = $nationality;
    $_SESSION['about_me'] = $about;
    $_SESSION['picture'] = 'default-profile-picture-hd.jpg';
    $_SESSION['account_type'] = 'normal';


    $uname=$conn->quote($uname);
    $password = password_hash($_POST['reg_password1'],PASSWORD_DEFAULT);
    $password =$conn->quote($password);
    $email=$conn->quote($email);
    $dob=$conn->quote($dob);
    $gender=$conn->quote($gender);
    if($nationality == ''){$nationality='null';}else{$nationality=$conn->quote($nationality);}
    if($address == ''){$address='null';}else{$address=$conn->quote($address);}
    if($about == ''){$about='null';}else{$about = $conn->quote($about);}


    $query="INSERT INTO `people`(`username`, `password`, `dob`, `gender`,
       `email`, `address`, `about_me`, `picture`, `nationality`, `account_type`)
       VALUES($uname, $password, $dob, $gender, $email, $address, $about,
       'default-profile-picture-hd.jpg',$nationality,'normal')";

    //echo $query;
    $exe=$conn->exec($query);
    $_SESSION['pid'] = $conn->lastInsertId();
    header("Location: register_skill.php");

  }
  $conn=null;

 ?>
