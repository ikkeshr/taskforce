<div class='menu-box'>

    <?php
      $tgiven_link="onclick=window.location.href=\"manage_tasks_tgiven.php\"";
    ?>
    <button  <?php echo $tgiven_link ?>  <?php if($activeMenu2=='tgiven'){echo "class='active'";} ?>>Task Given</button>


    <?php
      $ttaken_link="onclick=window.location.href=\"manage_tasks_ttaken.php\"";
    ?>
    <button <?php echo $ttaken_link ?>   <?php if($activeMenu2=='ttaken'){echo "class='active'";} ?>>Task Taken</button>


    <?php
      $tbidded_link="onclick=window.location.href=\"manage_tasks_tbidded.php\"";
    ?>
    <button  <?php echo $tbidded_link ?>  <?php if($activeMenu2=='tbidded'){echo "class='active'";} ?>>Task Bidded on</button>

    <?php
      $profile_link="onclick=window.location.href=\"../profile.php\"";
    ?>
    <button  <?php echo $profile_link ?>>◄ Profile</button>
</div>
