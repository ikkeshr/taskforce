<?php session_start(); ?>
<html>
<head>
  <title>How it works?</title>
  <link rel="stylesheet" href="css/main_menu_style.css"/>
  <script src="js/menuScrollJS.js"></script>
  <style>
    body{
      background-color: #005ab4;
      font-family: 'Roboto', sans-serif;
    }


    .box {
      background-color: white;
      padding: 50px;
      font-size: 14px;
      margin-left: 20%;
      margin-top: 8%;
      width: 680px;
      box-shadow: none;
      border-radius: 5px;
    }

    .box h1{
      text-align: center;
      color: #333;
      font-weight: bold;
    }

    .box hr{
      margin: 0 -50px 20px;
    }

    .box p {
      font-size: 16px;
    }


  </style>
</head>
<body>
  <?php
      $active='howItWorks';
      include('includes/mainmenu.php');
   ?>

   <div class='box'>
     <h1>How it works?</h1>
     <hr>
       <p>• A user posts a task and become a task giver.</p>
       <p>• Users bids on the task.</p>
       <p>• Taskgiver chooses a user's bid, and make him/her  the task taker.</p>
       <p>• Taskgiver and Tasktaker can now see each other contact information.</p>
       <p>• Once the task has been completed, the Tasktaker clicks the 'Finish task' button in the task page.</p>
       <p>• Once the 'Finish Task' button clicked, Taskgiver and Tasktaker can rate each other for this particular task.</p>
   </div>
</body>
</html>
