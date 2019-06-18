<?php
  $date_today = date("Y-m-d");
  if($assigned == 1 || $deadline < $date_today){
    echo "<h3 style='color:red;'>Biddings are closed</h3>";
  }
  else{
?>


<?php
    $sql = "select b.*, p.username  from biddings b, people p
            where b.tid=$tid and b.pid = p.pid
            order by date ASC";
    include('../includes/db_connect.php');
    $biddingTable = $conn->query($sql);

    $rowCount = $biddingTable->rowCount();
    if($assigned == 0 && $rowCount == 0){
      echo "<h3 style='color:red;'>No biddings yet.</h3>";
    }
    else{

      echo "<table id='biddings'>";
      echo "<tr><th>Name</th><th>Amount (". curToSymbol($currency) .")</th><th>Details</th>";
      if($pid == $tg_id){
        echo "<th>Choose Bidder</th>";
      }
      echo "</tr>";

      while($row = $biddingTable->fetch()){
        echo "<tr>";
        echo "<td><a href='' class='profileLink'>" . $row['username'] . "<a></td>";
        echo "<td>" . $row['bid_amount'] . "</td>";
        echo "<td>" . $row['bid_desc'] . "</td>";

        if($pid == $tg_id){
          $bidderId = $row['pid'];

          echo "<form action='chooseBidder_action.php' method='POST' id='formId_$bidderId'>";
          echo "<input type='hidden' value='".$tid."' name='tid'/>";
          echo "<input type='hidden' value='".$bidderId."' name='tt_id'/>";
          echo "</form>";

          echo "<td>";
              echo "<a href='#' onclick=\"document.getElementById('formId_$bidderId').submit();\">Choose</a>";
          echo "</td>";
        }

        echo "</tr>";
      }//end while

      echo "</table>";

    }



}//end outer most if
 ?>


</table>
