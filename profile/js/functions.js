function validateName(element, msg1, msg2, elementErr){

  //trim both sides
  element.value = element.value.replace(/^\s+|\s+$/gm,'');

  if (!(element.value || '').length){
    element.style.border="solid 1px red";
    elementErr.innerHTML="&#9888 " + msg1 + ".";
    return false;
  }
  else if(!(/^[a-zA-Z0-9. ]*$/g.test(element.value)))
  {
    element.style.border="solid 1px red";
    elementErr.innerHTML="&#9888 " + msg2 + ".";
    return false;
  }
  else {
    element.style.border="solid 0.5px #D3D3D3";
    elementErr.innerHTML="";
    return true;
  }
  return true;

}

function removeValidateNameErrorRefresh(element, elementErr){
  element.value = element.value.replace(/^\s+|\s+$/gm,'');
    if(((element.value || '').length) && ((/^[a-zA-Z0-9 ]*$/g.test(element.value)))){
      element.style.border="solid 0.5px #D3D3D3";
      elementErr.innerHTML="";
    }
}


function validateDesc(element, msg, elementErr){

  //trim both sides
  element.value = element.value.replace(/^\s+|\s+$/gm,'');

  if (!(element.value || '').length){
    element.style.border="solid 1px red";
    elementErr.innerHTML="&#9888 " + msg + ".";
    return false;
  }
  else {
    element.style.border="solid 0.5px #D3D3D3";
    elementErr.innerHTML="";
    return true;
  }
  return true;

}

function removeValidateDescErrorRefresh(element, elementErr){
  element.value = element.value.replace(/^\s+|\s+$/gm,'');
  if((element.value || '').length){
    element.style.border="solid 0.5px #D3D3D3";
    elementErr.innerHTML="";
  }
}

function validateDate(element, msg, elementErr){

  if(!(element.value || '').length){
    element.style.border="solid 1px red";
    elementErr.innerHTML="&#9888 Please specify the deadline of biddings on your task.";
    return false;
  }
  else{
    var date = new Date();
    var mydate = new Date(element.value);

    if(mydate < date)
    {
      element.style.border="solid 1px red";
      elementErr.innerHTML="&#9888 " + msg + ".";
      return false;
    }
    else
    {
      element.style.border="solid 0.5px #D3D3D3";
      elementErr.innerHTML="";
      return true;
    }
  }
  return true;
}

function removeValidateDateErrorRefresh(element, elementErr){
  var date = new Date();
  var mydate = new Date(element.value);

  if(((element.value || '').length) && (mydate > date)){
    element.style.border="solid 0.5px #D3D3D3";
    elementErr.innerHTML="";
  }
}


function validateBudget(element, msg, elementErr){
  if(!(element.value || '').length){
    element.style.border="solid 1px red";
    elementErr.innerHTML="&#9888 Please enter your budget.";
    return false;
  }
  else if(element.value < 0){
    element.style.border="solid 1px red";
    elementErr.innerHTML="&#9888 " + msg + ".";
    return false;
  }
  else{
    element.style.border="solid 0.5px #D3D3D3";
    elementErr.innerHTML="";
    return true;
  }
  return true;
}

function removeValidateBudgetErrorRefresh(element, elementErr){
  if(((element.value || '').length) && (element.value >= 0)){
    element.style.border="solid 0.5px #D3D3D3";
    elementErr.innerHTML="";
  }
}
