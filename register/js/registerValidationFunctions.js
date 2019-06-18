function trimOuter(x){
  return x.replace(/^\s+|\s+$/gm,'');
}

function trimInner(x){
  return x.replace(/\s+/gm,' ');
}

function validateUsername(username){
  username = trimOuter(username);
  username = trimInner(username);

  //if username empty.
  if(username == ""){
    return false;
  }
  //else if username contains illegal characters.
  else if(!(/^[a-zA-Z0-9 ]*$/g.test(uname.value))){
    return false;
  }
  else{
    return true;
  }
}

function validatePasswords(password, passwordConfirmation){
  //if password is empty.
  if(password == ""){
    return false;
  }
  else if(!(password == passwordConfirmation)){
    return false;
  }
  else{
    return true;
  }
}

function validateEmail(email){
  if(email == ""){
    return false;
  }
  else if(!email.checkValidity()){
    return false;
  }
  else{
    return true;
  }
}

function validateDOB(dob){

  if(dob == ""){
    return false;
  }
  else{
    //checks if date is in the future.
    dob = new Date(dob);
    var now = new Date();
    if(dob > now){
      return false;
    }
    else{
      return true;
    }
  }
}

//takes in a group of radio button as argument.
function validateGender(gender){
  for (var i = 0; i < gender.length; ++i){
    if(gender[i].checked){
      return true;
    }
  }
  return false;
}
