<div class="menu-box">
  <!--<img src="/taskforce/profile_pictures/<?=$_SESSION['picture']?>"/>-->

  <div class="container">
    <input type='file' id='profileImgUpload' style="display:none"/>
    <img src="/taskforce/profile_pictures/<?=$_SESSION['picture']?>" alt="Avatar" class="image" style="width:100%; height: 150px" id='profileImg'>
    <div class="middle">
      <div class="text" id='changeProfileImg'>Change</div>
    </div>
  </div>

  <!--script to open file upload when the profile image is click (jQuery)-->
  <script>
      $(document).ready(function(){
        //open file upload on button click.
        $('#changeProfileImg').click(function(){
          $('#profileImgUpload').trigger('click');
        });

        //function to validate image.
        function validateImage(element, formData) {
          var file = document.getElementById(element).files[0];

          formData.append("file", file);
          var t = file.type.split('/').pop().toLowerCase();
          if (t != "jpeg" && t != "jpg" && t != "png") {
            alert('Please select a valid image file');
            document.getElementById(element).value = '';
            return false;
          }
          if (file.size > 1024000) {
            alert('Max Upload size is 1MB only');
            document.getElementById(element).value = '';
            return false;
          }
          //console.log(file);
          return true;
        }
        //when image is selected run the validate image function.
        $('#profileImgUpload').change(function(){
          var formData = new FormData();
          if(validateImage("profileImgUpload", formData)){
            //if true, submit form.
            $.ajax({
              type: 'POST',
              url: 'edit/editProfileImg.php',
              data: formData,
              success: function(response){
                //on success change profile picture.
                console.log(response);
                response = response.replace(/^\s+|\s+$/gm,'');//trims both sides.
                response = "/taskforce/profile_pictures/" + response;
                console.log(response);
                //$("#profileImg").attr("src", "/taskforce/profile_pictures/default-profile-picture-hd.jpg");
                $("#profileImg").attr("src", response);
              },
              error: function(){
                console.log("an error occured [image upload]");
              },
              processData: false,
              contentType: false
            });
          }
        });

      });
  </script>


  <?php if($_SESSION['account_type'] == 'admin'){ ?>
   <button onclick="window.location.href='profileAdmin/profileAdmin.php'">Moderate ►</button>
 <?php } ?>

   <button  <?php if($activeProfileMenu=='postTask'){echo "class='active'";}  ?>  onclick="window.location.href='postTask.php'">Post a Task</button>
   <button  onclick="window.location.href='manage_tasks/manage_tasks_tgiven.php'">Manage Tasks ►</button>
   <button onclick="window.location.href='inbox.php'">Inbox</button>
   <button  <?php if($activeProfileMenu=='review'){echo "class='active'";}  ?>  onclick="window.location.href='profileReviews.php'">My Reviews</button>
   <button  <?php if($activeProfileMenu=='about'){echo "class='active'";}  ?>  onclick="window.location.href='profile.php'">About</button>
   <button onclick="window.location.href='logout.php'" id="logout_button">Log out</button>
 </div>
