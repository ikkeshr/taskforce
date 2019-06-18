function trimOuter(x){
  return x.replace(/^\s+|\s+$/gm,'');
}

function trimInner(x){
  return x.replace(/\s+/gm,' ');
}


function validateEmail(){
  var email = document.getElementById("email");
  if(!email.checkValidity()){
    email.style.border="solid 1px red";
    document.getElementById("emailErr").innerHTML="&#9888 The email you supplied is invalid.";
    return false;
  }
  else if (!(email.value || '').length){
    email.style.border="solid 1px red";
    document.getElementById("emailErr").innerHTML="&#9888 Please enter your email.";
    return false;
  }
  else {
    email.style.border="solid 0.5px #D3D3D3";
    document.getElementById("emailErr").innerHTML="";
    return true;
  }
  return true;
}

function validatePasswords(){
  var password1 = document.getElementById("password1");
  var password2 = document.getElementById("password2");

  if (!(password1.value || '').length){
    password1.style.border="solid 1px red";
    document.getElementById("password1Err").innerHTML="&#9888 Please enter a password.";
    return false;
  }
  else if(!(password1.value==password2.value )){
    if ((password2.value || '').length){
      password2.style.border="solid 1px red";
      document.getElementById("passwordErr").innerHTML="&#9888 Passwords doesn't match.";
      return false;
    }
    else{
      password1.style.border="solid 0.5px #D3D3D3";
      document.getElementById("password1Err").innerHTML="";
      return true;
    }
  }
  else{
    password2.style.border="solid 0.5px #D3D3D3";
    password1.style.border="solid 0.5px #D3D3D3";
    document.getElementById("passwordErr").innerHTML="";
    return true;
  }
return true;

}

function validateUsername(){
  var uname = document.getElementById("uname");
  //trim outer and inner whitespaces(one or multiple inner white spaces replace by only one)
  var unameValue = trimOuter(uname.value);
  unameValue = trimInner(unameValue);

  if (!(unameValue || '').length){
    uname.style.border="solid 1px red";
    document.getElementById("unameErr").innerHTML="&#9888 Please enter a username.";
    return false;
  }
  else if(!(/^[a-zA-Z0-9 ]*$/g.test(uname.value)))
  {
    uname.style.border="solid 1px red";
    document.getElementById("unameErr").innerHTML="&#9888 Your username must contain letters and numbers only.";
    return false;
  }
  else {
    document.getElementById("uname").value=unameValue;
    uname.style.border="solid 0.5px #D3D3D3";
    document.getElementById("unameErr").innerHTML="";
    return true;
  }
  return true;
}

function validateDOB(){
  if (!(dob.value || '').length){
    dob.style.border="solid 1px red";
    document.getElementById("dobErr").innerHTML="&#9888 Please enter your date of birth.";
    return false;
  }
  else {
    dob.style.border="solid 0.5px #D3D3D3";
    document.getElementById("dobErr").innerHTML="";
    return true;
  }
  return true;
}

////////////////////if required fields are empty or invalid, don't submit form////////////////////////////////
function validateForm(){

  var password2 = document.getElementById("password2");
  var gender = document.forms["register"]["reg_gender"];
  var unvalid = 0; //0 is valid, non-zero is invalid

  //validate username
  if(!(validateUsername())){
    unvalid++;
  }

  //validate password
  if(!(validatePasswords())){
    unvalid++;
  }
  else if(!(password2.value || '').length){
    password2.style.border="solid 1px red";
    document.getElementById("passwordErr").innerHTML="&#9888 Please confirm your password.";
    unvalid++;
  }

  //validate email
  if(!(validateEmail())){
    unvalid++;
  }


  //validate date of birth
  if (!(validateDOB())){
    unvalid++;
  }


  //validate gender
  function validateRadio (radios){
    for (i = 0; i < radios.length; ++ i){
      if (radios [i].checked){
        return true;
      }
    }
    return false;
  }


  if(!(validateRadio (document.forms["register"]["reg_gender"])))
  {
    unvalid++;
    document.getElementById("genderErr").innerHTML="&#9888 Please indicate your gender.";
  }


  //submit form if no invalid data present else don't submit
  if(unvalid == 0){
    return true;
  }
  else{
    document.getElementById("ifempty").innerHTML="&#9888 Please fill in the required fields properly.";
    $('html, body').animate({ scrollTop: 0 }, 'fast');//scroll to top of page.
    return false;
  }

}//end function validateForm()
