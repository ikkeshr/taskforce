
function bidOnTaskPopUp(){
  // Get the modal
  var bidOnTaskPopUp = document.getElementById('bidOnTask-modal');


  bidOnTaskPopUp.style.display = "block";

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
      if (event.target == bidOnTaskPopUp) {
        bidOnTaskPopUp.style.display = "none";
      }
    }
}


function deleteTaskPopUp(){
  // Get the modal
  var deleteTaskPopUp = document.getElementById('deleteTask-modalId');
  deleteTaskPopUp.style.display = "block";

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
      if (event.target == deleteTaskPopUp) {
        deleteTaskPopUp.style.display = "none";
      }
    }

    //when the user presses no in the modal, the modal closes.
    var btn = document.getElementById("confirm-no");
    btn.onclick = function() {
        deleteTaskPopUp.style.display = "none";
    }

}


function rateTaskTakerPopUp(){
  var rateTaskTakerPopUp = document.getElementById('rateTaskTaker-modalId');
  rateTaskTakerPopUp.style.display = "block";

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
      if (event.target == rateTaskTakerPopUp) {
        rateTaskTakerPopUp.style.display = "none";
      }
    }
}

function rateTaskGiverPopUp(){
  var rateTaskGiverPopUp = document.getElementById('rateTaskGiver-modalId');
  rateTaskGiverPopUp.style.display = "block";

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
      if (event.target == rateTaskGiverPopUp) {
        rateTaskGiverPopUp.style.display = "none";
      }
    }
}



function reportTask(tid){ //uses AJAX
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("reportTaskMsgID").innerHTML =
        this.responseText;
        document.getElementById("reportTask-modalId").style.display = "block";
      }
    };

  xhttp.open("POST", "reportTask_action.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("tid="+tid);

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
      if (event.target == document.getElementById("reportTask-modalId")) {
        document.getElementById("reportTask-modalId").style.display = "none";
      }
    }
}
