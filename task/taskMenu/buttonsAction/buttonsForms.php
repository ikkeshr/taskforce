<!--Form for bid on task and modify bid-->
<?php
  $amountErr = "";
  if(isset($_GET['amountErr'])){
    $amountErr = "&#9888 " . $_GET['amountErr'];
  }

  if($pid != 0){
 ?>

<div class="bidOnTask" id="bidOnTask-modal">
  <div class="modal-content">
    <h1>Bid on task</h1>
    <p>Task Budget: <?php echo curToSymbol($currency) . $max_budget; ?></p>
    <span><?php echo $amountErr; ?></span>
    <hr>
    </br>
      <form method="POST" action="bidOnTask_action.php" onsubmit="validatebidOnTask(event)">
        <span id="amountInputErr"></span>
        <input type="number" name="bidOnTask_Amount" placeholder="Amount (<?php echo curToSymbol($currency); ?>)" id="amountInput"
        value='<?php echo $bidAmount; ?>'/>
        <textarea name="bidOnTask_desc" placeholder="Bid details (Optional, 50 characters max)" maxlength="50"
        ><?php echo $bidDesc; ?></textarea>

        <input type="hidden" name="pid" value=<?php echo $pid; ?> />
        <input type="hidden" name="tid" value=<?php echo $tid; ?> />

        <button type="submit">Bid</button>
      </form>
  </div>
</div>

<?php }else{ ?>
<div class="bidOnTask" id="bidOnTask-modal">
  <div class="modal-content">
    <h3>You need to log in first, then you can bid.</h3>
    <button onclick="window.location.href='../login/login.php'">Log in</button>
  </div>
</div>

<?php } ?>

<!--popup for report task button-->
<div class="reportTask-modal" id="reportTask-modalId">
  <div class="modal-content">
    <img src="img/circle-check-512.png" width="200" height="200">
    <h1 id="reportTaskMsgID"></h1>
  </div>
</div>

<!--popup for report comment button in comment section-->
<div class="reportComment-modal" id="reportComment-modalId">
  <div class="modal-content">
    <img src="img/circle-check-512.png" width="200" height="200">
    <h2 id="reportCommentMsgID"></h2>
  </div>
</div>


<!--popup for delete task-->
<div class="deleteTask-modal" id="deleteTask-modalId">
  <div class="modal-content">
    <form action="deleteTask.php" method="POST">
    <h3>Are you sure you want to delete this task?</h3>
    <input type="hidden" name="tid" value="<?php echo $tid; ?>"/>
    <p><button class="confirm" id="confirm-yes" type="submit">Yes</button>          <button class="confirm" id="confirm-no" type="button">No</button></p>
  </form>
  </div>
</div>

<!--popup for rate TaskTaker-->
<?php
$rateTaskTakerMsg="";
$rateTaskTakerMsg2="";
$rateTaskTakerMsg3="";
  if($tg_rates_tt != ''){
    $rateTaskTakerMsg="You have already rated <a href=''>".$tt_name."</a> for this task.";
    $rateTaskTakerMsg2="You can modify your rating.";
    $rateTaskTakerMsg3="your previous rating was " . $tg_rates_tt." .";
  }

  $rateTaskTakerErr = "";
  if(isset($_GET['rateTaskTakerErr'])){
    $rateTaskTakerErr = $_GET['rateTaskTakerErr'];
  }

 ?>

<div class="rateTaskTaker-modal" id="rateTaskTaker-modalId">
  <div class="modal-content">
    <h2>Rate TaskTaker</h2>
    <hr>
    <p><?php echo $rateTaskTakerMsg; ?></p>
    <p><?php echo $rateTaskTakerMsg2; ?></p>
    <p><?php echo $rateTaskTakerMsg3; ?></p>
    <form method="POST" action="rateTaskTaker_action.php" onsubmit="validateRating_tg_rates_tt(event)">
      <div class='rating-select'>
        Rating
        <select name='tg_rates_tt' id="tg_rates_ttId">
          <option value='' disabled <?php if($tg_rates_tt == ''){echo "selected";}  ?>>Select a rating</option>
          <option value='0' <?php if($tg_rates_tt == '0'){echo "selected";}  ?>>0</option>
          <option value='1' <?php if($tg_rates_tt == '1'){echo "selected";}  ?>>1</option>
          <option value='2' <?php if($tg_rates_tt == '2'){echo "selected";}  ?>>2</option>
          <option value='3' <?php if($tg_rates_tt == '3'){echo "selected";}  ?>>3</option>
          <option value='4' <?php if($tg_rates_tt == '4'){echo "selected";}  ?>>4</option>
          <option value='5' <?php if($tg_rates_tt == '5'){echo "selected";}  ?>>5</option>
        </select></br></br></br>
        Write a review
        <textarea name='comment_from_tg' placeholder="Write a review.. "><?php echo $comment_from_tg ?></textarea>
        <input type='hidden' value='<?php echo $tid; ?>' name='tid'/>
        <p id='ratingError_tg_rates_tt'><? echo $rateTaskTakerErr; ?></p>
        <button type='submit'>OK</button>
      </div>
    </form>
  </div>
</div>



<!--rate task giver popup-->

<?php
$rateTaskGiverMsg="";
$rateTaskGiverMsg2="";
$rateTaskGiverMsg3="";
  if($tt_rates_tg != ''){
    $rateTaskGiverMsg="You have already rated <a href=''>".$tg_name."</a> for this task.";
    $rateTaskGiverMsg2="You can modify your rating.";
    $rateTaskGiverMsg3="your previous rating was " . $tt_rates_tg." .";
  }

  $rateTaskGiverErr = "";
  if(isset($_GET['rateTaskGiverErr'])){
    $rateTaskGiverErr = $_GET['rateTaskGiverErr'];
  }

 ?>

<div class="rateTaskGiver-modal" id="rateTaskGiver-modalId">
  <div class="modal-content">
    <h2>Rate TaskGiver</h2>
    <hr>
    <p><?php echo $rateTaskGiverMsg; ?></p>
    <p><?php echo $rateTaskGiverMsg2; ?></p>
    <p><?php echo $rateTaskGiverMsg3; ?></p>
    <form method="POST" action="rateTaskGiver_action.php" onsubmit="validateRating_tt_rates_tg(event)">
      <div class='rating-select'>
        Rating
        <select name='tt_rates_tg' id="tt_rates_tgId">
          <option value='' disabled <?php if($tt_rates_tg == ''){echo "selected";}  ?>>Select a rating</option>
          <option value='0' <?php if($tt_rates_tg == '0'){echo "selected";}  ?>>0</option>
          <option value='1' <?php if($tt_rates_tg == '1'){echo "selected";}  ?>>1</option>
          <option value='2' <?php if($tt_rates_tg == '2'){echo "selected";}  ?>>2</option>
          <option value='3' <?php if($tt_rates_tg == '3'){echo "selected";}  ?>>3</option>
          <option value='4' <?php if($tt_rates_tg == '4'){echo "selected";}  ?>>4</option>
          <option value='5' <?php if($tt_rates_tg == '5'){echo "selected";}  ?>>5</option>
        </select></br></br></br>
        Write a review
        <textarea name='comment_from_tt' placeholder="Write a review.. "><?php echo $comment_from_tt ?></textarea>
        <input type='hidden' value='<?php echo $tid ?>' name='tid'/>
        <p id='ratingError_tt_rates_tg'><?php echo $rateTaskGiverErr; ?></p>
        <button type='submit'>OK</button>
      </div>
    </form>
  </div>
</div>
