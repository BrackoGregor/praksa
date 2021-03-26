<?php ob_start()?>
<script>document.title="Sign Up";</script>

<form class="form-register" method="post">
  <img class="mb-4" src="photos/logo.png" alt="" width="100" height="100">
  <h1 class="h3 mb-3 font-weight-normal">Sign Up</h1>
  <div class="form-group"> 
    <label for="inputUsername">Enter username:</label>
    <input name="username" type="text" id="inputUsername" class="form-control" placeholder="username" required autofocus>
  </div>
  <div class="form-group"> 
    <label for="inputPassword1">Enter password:</label>
    <input name="password" type="password" id="inputPassword" class="form-control" placeholder="password" required>
  </div>
  <div class="form-group"> 
    <label for="inputPassword2">Re-enter password:</label>
    <input name="repassword" type="password" id="inputPassword" class="form-control" placeholder="password" required>
  </div>
  <div class="form-group"> 
    <label for="inputemail">Enter email:</label>
    <input name="email" type="email" id="inputPassword" class="form-control" placeholder="email" required>
  </div>
  <button class="btn btn-lg btn-primary btn-block" name="button" type="submit">Sign Up</button>
</form>

<?php
SignUp();
$content=ob_get_clean();
require "templates/layout.html.php";
?>
