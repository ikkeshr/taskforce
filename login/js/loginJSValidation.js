function trimOuter(x){
  return x.replace(/^\s+|\s+$/gm,'');
}

function trimInner(x){
  return x.replace(/\s+/gm,' ');
}


function autoValidateUsername(){
  var uname = document.getElementById("uname");
  //trim outer and inner whitespaces(one or multiple inner white spaces replace by only one)
  var unameValue = trimOuter(uname.value);
  unameValue = trimInner(unameValue);

  if ((unameValue || '').length){
    uname.style.border="solid 0.5px #D3D3D3";
    document.getElementById("unameErr").innerHTML="";
    document.getElementById("uname").value=unameValue;
  }
}

function autoValidatePassword(){
  var password = document.getElementById("password");
  if ((password.value || '').length){
    password.style.border="solid 0.5px #D3D3D3";
    document.getElementById("passwordErr").innerHTML="";
  }
}


function validateUsername(){
  var uname = document.getElementById("uname");
  //trim outer and inner whitespaces(one or multiple inner white spaces replace by only one)
  var unameValue = trimOuter(uname.value);
  unameValue = trimInner(unameValue);

  if (!(unameValue || '').length){
    uname.style.border="solid 1px red";
    document.getElementById("unameErr").innerHTML="&#9888 Please enter your username.";
    return false;
  }
  else {
    document.getElementById("uname").value=unameValue;
    uname.style.border="solid 0.5px #D3D3D3";
    document.getElementById("unameErr").innerHTML="";
    return true;
  }
  return true;
}//end validateUsername

function validatePassword(){
  var password = document.getElementById("password");
  if (!(password.value || '').length){
    password.style.border="solid 1px red";
    document.getElementById("passwordErr").innerHTML="&#9888 Please enter your password.";
    return false;
  }
  else {
    password.style.border="solid 0.5px #D3D3D3";
    document.getElementById("passwordErr").innerHTML="";
    return true;
  }
  return true;
}//end validatePassword


///////////////////////validatte on submt///////////////////////
function validateForm(){
  var unvalid = 0; // 0 means valid

  if(!(validateUsername())){
    unvalid++;
  }

  if(!(validatePassword())){
    unvalid++;
  }

  if(unvalid == 0){
    return true;
  }
  else{
    return false;
  }

}//end validateForm
