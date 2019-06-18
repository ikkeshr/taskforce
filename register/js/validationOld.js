function validateRegisterForm(){

  if(!(validateUsername(document.getElementById("uname").value))){
    alert("Invalid username");
    return false;
  }

  if(!validatePasswords(document.getElementById("password1").value, document.getElementById("password2").value)){
    alert("Password Error");
    return false;
  }

  if(!validateEmail(document.getElementById("email").value)){
    alert("Invalid email");
    return false;
  }

  if(!validateDOB(document.getElementById("dob").value)){
    alert("Invalid date of birth");
    return false;
  }

  if(!(validateGender (document.forms["register"]["reg_gender"])))
  {
    alert("Gender Error");
    return false;
  }

  return true;
}
