<?php /*if($active==''){echo "class='active'";}*/ ?>
<div id="navbar">
  <a  <?php if($active=='home'){echo "class='active'";} ?>  href="/taskforce/home.php">Home</a>
  <a  <?php if($active=='explore'){echo "class='active'";} ?>  href="/taskforce/explore/explore.php">Explore Tasks</a>
  <a  <?php if($active=='howItWorks'){echo "class='active'";} ?>  href="/taskforce/howItWorks.php">How it works?</a>

  <div class='search-container'>
    <form action='/taskforce/search/search.php' method='GET'>
      <input type='text' placeholder="Search..." autocomplete="off" id="search-field" onkeyup="focusSearch()" onfocus="focusSearch()" name='search_value'/>
      <button type='submit' disabled>Search</button>
    </form>
      <div id='searchResults' tabindex="1"><ul class="results" id="search-results"></ul></div>
  </div>

  <a  <?php if($active=='login'){echo "class='active-lastchild'";} ?>   class="lastchild"
    href="<?php
      if(isset($_SESSION['uname']))
      {
        echo "/taskforce/profile/profile.php";
      }
      else{
        echo "/taskforce/login/login.php";
      }
    ?>">
    <?php if(isset($_SESSION['uname'])){echo $_SESSION['uname'];}else{echo "Login";}  ?> </a>
</div>
