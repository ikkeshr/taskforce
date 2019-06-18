function removeNameError(){
  var name = document.getElementById("name");
  var nameErr = document.getElementById("nameErr");
  removeValidateNameErrorRefresh(name, nameErr);
}

function removeDescError(){
  var desc = document.getElementById("desc");
  var descErr = document.getElementById("descErr");
  removeValidateDescErrorRefresh(desc, descErr);
}

function removeDateError(){
  var deadline = document.getElementById("deadline");
  var deadlineErr = document.getElementById("deadlineErr");
  removeValidateDateErrorRefresh(deadline, deadlineErr);
}

function removeBudgetError(){
  var budget = document.getElementById("budget");
  var budgetErr = document.getElementById("budgetErr");
  removeValidateBudgetErrorRefresh(budget,budgetErr);
}



function validate(e){
  var unvalid = false;

  var name = document.getElementById("name");
  var nameErr = document.getElementById("nameErr");
  var msg1 = "Please enter name for your task";
  var msg2 = "Sorry, tasks name can only contain letters and numbers";
  if(!validateName(name, msg1, msg2, nameErr)){
    unvalid = true;
  }

  var desc = document.getElementById("desc");
  var descErr = document.getElementById("descErr");
  var msg = "Please enter a description for your task";
  if(!validateDesc(desc, msg, descErr)){
    unvalid = true;
  }

  var deadline = document.getElementById("deadline");
  var deadlineErr = document.getElementById("deadlineErr");
  msg = "Sorry, the deadline must be in the future";
  if(!validateDate(deadline,msg,deadlineErr)){
    unvalid = true;
  }

  var budget = document.getElementById("budget");
  var budgetErr = document.getElementById("budgetErr");
  msg = "Please enter an amount above zero";
  if(!validateBudget(budget, msg, budgetErr)){
    unvalid = true;
  }



  if(unvalid){
    e.preventDefault();
    return false;
  }
  else{
    return true;
  }


}
