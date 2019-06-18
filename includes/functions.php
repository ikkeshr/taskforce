<?php
function datetostr($date){
  $arr = explode("-",$date);

  $year = $arr[0];
  $month = $arr[1];
  $day = $arr[2];

  $monthstr = "JanFebMarAprMayJunJulAugSepOctNovDec";
  $month = substr($monthstr,(($month - 1) * 3),3);

  return "$day $month $year";
}

function monthToStr($month){
  $monthstr = "JanFebMarAprMayJunJulAugSepOctNovDec";
  $month = substr($monthstr,(($month - 1) * 3),3);
  return $month;
}

function curToSymbol($cur){
  if($cur == 'ruppee')
  {
    return 'Rs';
  }
  else if($cur == 'usd'){
    return '$';
  }
  else if($cur == 'euro'){
    return '€';
  }
}


function daysInFeb($year){
  if(($year % 4) == 0){
    return 29;
  }
  else{
    return 28;
  }
}


function daysInMonth($month, $year){
  if($month < 8){
    $odd = $month % 2;
    if($odd == 0){
      if($month == 2){
        return daysInFeb($year);
      }
      else{
        return 30;
      }
    }
    else{
      return 31;
    }
  }
  else{
    $odd = $month % 2;
    if($odd == 0){
      return 31;
    }
    else{
      return 30;
    }
  }
}




  function dateDiff($date){
    $temp = explode(" ", $date);
    $date = $temp[0];
    $today = date("Y-m-d");
    $dateArr = explode("-", $date);
    $todayArr = explode("-", $today);

    if($todayArr[2] < $dateArr[2]){
      $dayDiff = (daysInMonth(($todayArr[1]), $todayArr[0]) + $todayArr[2]) - $dateArr[2];
      $todayArr[1]--;
    }
    else{
      $dayDiff = $todayArr[2] - $dateArr[2];
    }


    if($todayArr[1] < $dateArr[1]){
      $todayArr[0]--;
      $todayArr[1] = $todayArr[1] + 12;
      $monthDiff = $todayArr[1] -$dateArr[1];
    }
    else{
      $monthDiff = $todayArr[1] -$dateArr[1];
    }

    $yearDiff = $todayArr[0] - $dateArr[0];

    $diff[0] = $yearDiff;
    $diff[1] = $monthDiff;
    $diff[2] = $dayDiff;
    return $diff;
  }



  function howlong($date){
    $diff = array();
    $diff = dateDiff($date);

    if(($diff[0] == 0) && ($diff[1] == 0) && ($diff[2] > 0)){
      $s="";
      if($diff[2]>1){$s="s";}
      return $diff[2] . " day$s ago";
    }
    else if(($diff[0] == 0) && ($diff[1] > 0)){
      $s="";
      if($diff[1]>1){$s="s";}
      return $diff[1] . " month$s ago";
    }
    else if($diff[0] > 0){
      $s="";
      if($diff[0]>1){$s="s";}
      return $diff[0] . " year$s ago";
    }
    else{
      return "Today";
    }

  }



 ?>
