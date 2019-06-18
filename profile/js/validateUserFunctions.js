function validateUsername(username){
  username = username.replace(/^\s+|\s+$/gm,'');
  username = username.replace(/\s+/gm,' ');
  if(username == ""){
    return false;
  }
  else if(!(/^[a-zA-Z0-9 ]*$/g.test(username))){
    return false;
  }
  else{
    return true;
  }
}

function validateGender(genderElement){
  var checked = 0;
  genderElement.each(function(){
    if($(this).is(":checked")){
      checked++;
    }
  });
  if(checked>0){
    return true;
  }
  else{
    return false;
  }
}

function validateDOB(dobElement){
  console.log(dobElement.val());
  if(dobElement.val() == ""){
    return false;
  }
  else{
    var date = new Date();
    var mydate = new Date(dobElement.val());
    if(mydate > date)
    {
      return false;
    }
  }
  return true;
}

function validateEmail(emailElement){
  var email = $("#emailInputField").val();
  email_regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i;
  if(!email_regex.test(email)){
    return false;
  }
  else if (email == ""){
    return false;
  }
  return true;
}

function validateAddress(addressElement){
  var address = addressElement.val();
  address = address.replace(/^\s+|\s+$/gm,''); //trim both sides.
  if(address == ""){
    return false;
  }
  return true;
}

function validateAbout(aboutElement){
  var about = aboutElement.val();
  about = about.replace(/^\s+|\s+$/gm,''); //trim both sides.
  if(about == ""){
    return false;
  }
  return true;
}
