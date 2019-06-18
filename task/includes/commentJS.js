
    //comment validation.
    function commentEntered(){
      commentBtn.disabled=false;
      commentBtn.style.opacity="1";

      //checks if user deletes its inserted text(backspace pressed)
      var commentBox = document.getElementById("textbox-comment");
      var comment = commentBox.value;
      //commentBox.value = comment.replace(/^\s+|\s+$/gm,'');
      commentBox.value = comment.replace(/^\s+/gm,'');
      if(commentBox.value==''){
        commentBtn.disabled=true;
        commentBtn.style.opacity="0.5";
        commentBox.value = comment.replace(/^\s+|\s+$/gm,'');
      }

    }


    //ajax funtions below

    function postComment(e){
      e.preventDefault();

      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            /*document.getElementById("displayComments").innerHTML =
            this.responseText;*/
            $('#displayComments').prepend(this.responseText);

            var commentBtn = document.getElementById("commentBtn");
            commentBtn.disabled = true;
            commentBtn.style.opacity = '0.5';
            document.getElementById("textbox-comment").value = '';

            //show 'comment posted' next to comment button when comment is submitted.
            document.getElementById("ifposted").innerHTML = "Comment Posted";
            //removes the msg when the user clicks anywhere.
            window.onclick = function(event) {
                document.getElementById("ifposted").innerHTML = "";
            }

          }
        };

      var comment = document.getElementById("textbox-comment").value;
      var pid = document.getElementById("pid_txt").value;
      var tid = document.getElementById("tid_txt").value;
      xhttp.open("POST", "comment_action.php", true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send("comment_txt="+comment+"&pid_txt="+pid+"&tid_txt="+tid);
    }


    function deleteComment(comment_id, tid, pid){
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {

            //display pop up, confirming comment has been deleted.
          /*  document.getElementById("reportComment-modalId").style.display = "block";
            document.getElementById("reportCommentMsgID").innerHTML ="Comment deleted";

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == document.getElementById("reportComment-modalId")) {
                  document.getElementById("reportComment-modalId").style.display = "none";
                }
            }*/

            //displays new comment list.
            /*document.getElementById("displayComments").innerHTML =
            this.responseText;*/
            //removes the div and footer of deleted comment.
            //$("#test").slideUp('slow');
            $('#comment_container_' + comment_id).slideUp('slow');
            $('#comment_' + comment_id).remove();
            $('#comment_' + comment_id + '_footer').remove();
          }
        };


      xhttp.open("POST", "deleteComment_action.php", true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send("comment_id="+comment_id+"&tid="+tid+"&pid="+pid);
    }

    function reportComment(comment_id){
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("reportComment-modalId").style.display = "block";
            document.getElementById("reportCommentMsgID").innerHTML =
            this.responseText;
          }
        };


      xhttp.open("POST", "reportComment_action.php", true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send("comment_id="+comment_id);

      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function(event) {
          if (event.target == document.getElementById("reportComment-modalId")) {
            document.getElementById("reportComment-modalId").style.display = "none";
          }
        }
    }
