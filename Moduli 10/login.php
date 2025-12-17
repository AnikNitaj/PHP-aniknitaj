

<?php include_once("header.php");?>


<!-- Pills navs -->
<ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
  <li class="nav-item" role="presentation">
    <a class="nav-link active" id="tab-login"  href="login.php">Login</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="tab-register" href="signup.php">Register</a>
  </li>
</ul>
<!-- Pills navs -->


<form action="loginlogic.php" method="POST">
      <!-- Email input -->
      <div data-mdb-input-init class="form-outline mb-4">
        <input type="username" id="username" class="form-control" name="username"/>
        <label class="form-label" for="username">Username</label>
      </div>


      <!-- Password input -->
      <div data-mdb-input-init class="form-outline mb-4">
        <input type="password" id="loginPassword" class="form-control" name="password" />
        <label class="form-label" for="loginPassword">Password</label>
      </div>



      <!-- Submit button -->
      <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">Sign in</button>


      <!-- Register buttons -->
</form>


<?php include_once("footer.php");?>