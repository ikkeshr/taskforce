<div class='menu-panel'>
<div class='menu-box'>
    <?php
        include('../includes/db_connect.php');
        $query = "select * from biddings where pid=".$pid." and tid=".$tid;
        $biddings = $conn->query($query);
        $biddingsRows = $biddings->rowCount();

        $biddings = $biddings->fetch();
        $bidAmount = $biddings['bid_amount'];
        $bidDesc = $biddings['bid_desc']; // to be used for modify bid form.
        $conn = null;

        $date_today = date("Y-m-d"); //to test if deadline is pass, if true disable biddings.
     ?>


     <!----------------------NOT USER'S TASK--------------------------------------------->
     <?php if($tg_id != $pid){ ?>




     <?php if(($biddingsRows == 0) && ($assigned == 0) && ($completed == 0) && ($deadline >= $date_today)){ ?>
       <button  id="bidOnTaskId" onclick="bidOnTaskPopUp()">Bid on task</button>
    <?php } ?>


    <?php if(($biddingsRows > 0) && ($assigned == 0) && ($completed == 0) && ($deadline >= $date_today)){ ?>
      <?php echo "<p>Your Bid: " . curToSymbol($currency) . $bidAmount . "</p>";?>
      <button onclick="bidOnTaskPopUp()">Modify Bid</button>

      <form action="deleteBid_action.php" method="POST">
        <input type="hidden" name="pid" value="<?php echo $pid; ?>"/>
        <input type="hidden" name="tid" value="<?php echo $tid; ?>"/>
        <button type="submit">Delete Bid</button>
      </form>
   <?php } ?>


   <?php if(($tt_id == $pid) && ($assigned == 1) && ($completed == 1)){ ?>
     <button onclick="rateTaskGiverPopUp()">Rate TaskGiver</button>
  <?php } ?>


    <button onclick="reportTask(<?php echo $tid; ?>)">Report Task</button>

  <!----------------------USER'S TASK--------------------------------------------->

<?php }else if($tg_id == $pid){ ?>

    <?php if($completed == 0){ ?>
      <button onclick="deleteTaskPopUp()">Delete Task</button>
    <?php } ?>

    <?php if(($assigned == 1) && ($completed == 0)){ ?>
      <form action="finishTask_action.php" method="POST">
        <input type="hidden" name="tid" value="<?php echo $tid; ?>"/>
        <button type="submit">Finish Task</button>
      </form>
    <?php } ?>

    <?php if(($assigned == 1) && ($completed == 1)){ ?>
      <button onclick="rateTaskTakerPopUp()">Rate TaskTaker</button>
    <?php } ?>

<?php } ?>

</div>



<br/><br/>
<div class='converter-box'>
  <p>Currency Converter</p>
  <hr>

  <select id='currency1'>
    <option value='2' <?php if($currency=='ruppee'){echo "selected";} ?> >Rs</option>
    <option value='1' <?php if($currency=='usd'){echo "selected";} ?> >$</option>
    <option value='0' <?php if($currency=='euro'){echo "selected";} ?> >€</option>
  </select>
  <input type='number' min='0' id='amount1' value="<?php echo $max_budget; ?>"/><br/><br/>

  <select id='currency2'>
    <option value='2'>Rs</option>
    <option value='1'>$</option>
    <option value='0'>€</option>
  </select>
  <input type='number' min='0' id='amount2'/>

</div>


</div>
