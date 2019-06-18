<div class='date'>
<label for='day'>Day</label>
<select  name="day" id='day' onchange="checkDay();">
  <?php
     for($i=1; $i <= 31; $i++)
     {
       echo "<option value='".$i."'>".$i."</option>";
     }
   ?>
</select>
<label for='month'>Month</label>
<select  name="month" id='month' onchange="checkDay();">
  <?php
     $monthstr = "JanFebMarAprMayJunJulAugSepOctNovDec";
     for($i=1; $i <= 12; $i++)
     {
       $month = substr($monthstr,(($i - 1) * 3),3);
       echo "<option value='".$i."'>".$month."</option>";
     }
   ?>
</select>
<label for='year'>Year</label>
<select  name="year" id='year' onchange="checkDay();">
  <?php
     for($i=2019; $i >= 1900; $i--)
     {
       echo "<option value='".$i."'>".$i."</option>";
     }
   ?>
</select><br/><br/>
<span id='date_error'></span>
</div>
