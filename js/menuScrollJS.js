/* When the user scrolls down, hide the navbar. When the user scrolls up, show the navbar */
var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
var currentScrollPos = window.pageYOffset;
if (prevScrollpos > currentScrollPos) {
document.getElementById("navbar").style.top = "0";
} else {
document.getElementById("navbar").style.top = "-60px";
var x = document.getElementById("searchResults");
x.style.display= "none";
document.getElementById("search-field").blur();
}
prevScrollpos = currentScrollPos;
}

function focusSearch(){

  var search_value = document.getElementById("search-field").value;
  search_value = search_value.replace(/^\s+|\s+$/gm,'');
  if(search_value !== ""){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var response = this.responseText;
          response = response.replace(/^\s+|\s+$/gm,'');//trims both sides.

          if(response != ""){
            document.getElementById("searchResults").style.display="block";
            document.getElementById("search-results").style.display="block";
              document.getElementById("search-results").innerHTML =
              this.responseText;
          }
          else{
            document.getElementById("search-results").style.display="block";
            document.getElementById("search-results").innerHTML = "No results";
          }

       }
    };
    xhttp.open("POST", "/taskforce/search/ajaxSearch_action.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("search="+search_value);

  }
  else{
      document.getElementById("search-results").innerHTML ="";
      document.getElementById("search-results").style.display="none";
  }
}

/*window.onload = function(){
  document.getElementById("searchResults").addEventListener("focusout", function(){
    //console.log("entered");
    document.getElementById("searchResults").style.display="none";
  });

  document.getElementById("searchResults").addEventListener("mouseover", function(){
    //console.log("entered2");
    document.getElementById("searchResults").focus();
  });
}*/

function removeResults(){
  document.getElementById("search-results").style.display = "none";
}
