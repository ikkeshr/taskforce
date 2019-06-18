<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Search</title>
  <!--main menu (top horizontal)-->
  <link rel="stylesheet" href="../css/main_menu_style.css"/>
  <script src="../js/menuScrollJS.js"></script>
</head>
<style>
  .search-container{
    display: none;
  }
  body{
    background-color: #005ab4;
    font-family: 'Roboto', sans-serif;
    background-image: none;
  }
  .panel{
    margin-top: 8%;
    margin-left: 4%;
    margin-right: 4%;
    padding: 33px;
    background-color: #e5e5e5;
    border: solid 0.5px #7e7e7e;
    border-radius: 2px;
    margin-bottom: 155px;
  }

  .searchInput{
    width: 50%;
    height: 30px;
    margin-left: 22%;
    padding-top: 12px;
    padding-left: 10px;
    padding-left: 10px;
    padding-bottom: 2px;
    font-size: 18px;
    border: solid 0.5px gray;
    border-radius: 2px;
  }

  #results{
    padding: 25px;
  }
  .result-container{
    border: solid 0.5px;
    padding: 10px;
    margin-bottom: 20px;
  }

  /*page number*/
.pageNumbers{
  text-align: center;
}

  .pagination {
  display: inline-block;
}

.pagination a {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
}

.pagination a.active {
  background-color: #005ab4;
  color: white;
  border-radius: 5px;
}

.pagination a:hover:not(.active) {
  background-color: #ddd;
  border-radius: 5px;
}
</style>
<body>
  <?php
      $active = "";
      include('../includes/mainmenu.php');

      $searchValue = "";
      if(isset($_GET['search_value'])){
        $searchValue = $_GET['search_value'];
      }

   ?>
   <div class="panel">
     <input type='text' placeholder="Search..." class='searchInput' value='<?=$searchValue?>' autofocus='on'/>
     <br/><br/>
     <hr>
     <div id='results'>
       <div class='result-container'>
         <h4>task name</h4>
         <p>description</p>
         <span>skills</span>
       </div>
       <div class='result-container'>
         <h4>task name</h4>
         <p>description</p>
         <span>skills</span>
       </div>
     </div>
     <div class='pageNumbers'>
       <div class="pagination">
         <a href="#">&laquo;</a>
         <a href="#">1</a>
         <a href="#" class="active">2</a>
         <a href="#">3</a>
         <a href="#">4</a>
         <a href="#">5</a>
         <a href="#">6</a>
         <a href="#">&raquo;</a>
      </div>
     </div>
   </div>

</body>
</html>
