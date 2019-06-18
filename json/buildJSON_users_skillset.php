<?php

    require_once "../includes/db_connect.php";

    $sQuery = "SELECT DISTINCT people.pid, people.username, people.email
              FROM person_skillset
              INNER JOIN people ON person_skillset.pid = people.pid";

    if(isset($_GET['pid']) && is_numeric($_GET['owner_id'])){
      $sQuery .= "WHERE person_skillset.pid = " . $_GET['pid'];
    }

    $result = $conn->query($sQuery);

    //create first array of users.
    $users = $result->fetchAll(PDO::FETCH_ASSOC);

    //build inner query to fetch skills of users.
    //loop through the users.
    for($i = 0; $i < count($users); $i++){

        $innerquery = "SELECT skills.skill_id, skills.skill_name, skills.skill_desc
                        FROM person_skillset
                        INNER JOIN skills
                        ON person_skillset.skill_id = skills.skill_id
                        WHERE person_skillset.pid = " . $users[$i]['pid'];

      $result2 = $conn->query($innerquery);
      $skills = $result2->fetchAll(PDO::FETCH_ASSOC);

      //push the skills array into this user array.
      $users[$i]['skills'] = $skills;

    }

    //inform browser about incoming JSON.
    header('Content-Type: application/json');
    //convert the php array to JSON and display it.
    echo json_encode($users, JSON_PRETTY_PRINT);

    $conn=null;
 ?>
