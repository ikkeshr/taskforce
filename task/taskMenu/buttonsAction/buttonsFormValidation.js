function validatebidOnTask(e){
  amount = document.getElementById("amountInput");
  amountErr = document.getElementById("amountInputErr");

  if(amount.value == ""){
    amount.style.border="solid 1px red";
    amountInputErr.innerHTML = "&#9888 Please enter the amount you would like to bid.";
    e.preventDefault();
    return false;
  }
  else if(amount.value <= 0 ){
    amount.style.border="solid 1px red";
    amountInputErr.innerHTML = "&#9888 Sorry, your bid amount must be above zero.";
    e.preventDefault();
    return false;
  }
  else{
    amount.style.border="solid 0.5px #D3D3D3";
    amountInputErr.innerHTML = "";
    return true;
  }
  return true;

}


function validateRating(element, elementErr){
  if (element.value == ''){
    element.style.border = "solid 0.5px red";
    elementErr.innerHTML="&#9888 Please enter a rating value.";
    elementErr.style.color = "#b20000";
    return false;
  }
  return true;
}

function validateRating_tg_rates_tt(e){
  var rating = document.getElementById('tg_rates_ttId');
  var ratingErr = document.getElementById('ratingError_tg_rates_tt');
  if(!validateRating(rating, ratingErr)){
    e.preventDefault();
    return false;
  }
  return true;
}

function validateRating_tt_rates_tg(e){
  var rating = document.getElementById('tt_rates_tgId');
  var ratingErr = document.getElementById('ratingError_tt_rates_tg');
  if(!validateRating(rating, ratingErr)){
    e.preventDefault();
    return false;
  }
  return true;
}
