<?php

    $url = "http://localhost/taskforce/json/buildJSON_users_skillset.php";
    $json = file_get_contents($url);

 ?>
 <html>
 <head>
   <title>Users skills</title>
   <link rel='stylesheet' href='../xml/css/show_users_skillset_style.css'/>
   <!--jQuery-->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script>
        $(document).ready(function(){
          var obj_json = <?php echo $json ?>;

          var getObjectByValue = function (array, key, value) {
              return array.filter(function (object) {
                  return object[key] === value;
                });
            };


            //populate users table.
            var users_table = "";
            users_table += "<table id='users_table' class='table'>";
            users_table += "<tr><th>Username</th><th>Email</th><th>Skills</th></tr>";
            for(var i=0; i < obj_json.length; i++){
              users_table += "<tr id='" + obj_json[i]['pid'] + "'>";
              users_table += "<td>" + obj_json[i]['username'] + "</td>";
              users_table += "<td>" + obj_json[i]['email'] + "</td>";
              users_table += "<td>";
              for(var j=0; j < obj_json[i].skills.length; j++){
                  users_table += obj_json[i].skills[j].skill_name;
                  if(j != obj_json[i].skills.length-1){
                      users_table += ", ";
                  }
              }
              users_table += "<td>";
              users_table += "</tr>";
            }
            users_table += "</table>";
            $('#users_table_holder').html(users_table);


            //when a row is click run this function.
            $('#users_table tr').click(function(){
                var pid = $(this).attr('id');
                //console.log(pid);
                var user = getObjectByValue(obj_json, 'pid', pid);
                //console.log(user);

                $("#modalName").html(user[0].username);
                $("#modalEmail").html("Email: " + user[0].email);

                //populate skills table.
                var skill_table = "<tr><th>Skill name</th><th>Skill description</th></tr>";
                var skills = user[0].skills;
                for(var i=0; i < skills.length; i++){
                    skill_table += "<tr>";
                    skill_table += "<td>" + skills[i].skill_name + "</td>";
                    skill_table += "<td>" + skills[i].skill_desc + "</td>";
                    skill_table += "</tr>";
                }
                skill_table += "</table>";
                $('#skills_table').html(skill_table);

                //make modal appear.
                $("#myModal").css("display", "block");
            })

        });

   </script>
 </head>
 <body>
    <h1 style='text-align:center'>Users Skills JSON</h1>
    <div id='users_table_holder'></div>


    <!--the modal that appears when a row is clicked-->
    <!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2 id='modalName'></h2>
    </div>
    <div class="modal-body">
      <p id='modalEmail'></p>
      <table id='skills_table' class="table">

      </table>
    </div>
  </div>
</div>

<!--script to close modal on click-->
<script>
// Get the modal
var modal = document.getElementById('myModal');
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

</body>
</html>
