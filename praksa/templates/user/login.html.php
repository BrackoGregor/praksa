<?php ob_start()?>
<script>document.title="Login";</script>

<form class="form-signin" method="post">
  <img class="mb-4" src="photos/logo.png" alt="" width="72" height="72">
  <h1 class="h3 mb-3 font-weight-normal">Login</h1>
  <div class="form-group">
    <label for="inputUsername">Enter username:</label>
    <input name="username" type="text" id="inputUsername" class="form-control" placeholder="username" required autofocus>
  </div>
  <div class="form-group"> 
    <label for="inputPassword"">Enter password:</label>
    <input name="password" type="password" id="inputPassword" class="form-control" placeholder="password" required>
  </div>  
  <div class="checkbox mb-3">
    <label>
      <input name="remember" type="checkbox"> Remember me
    </label>
  </div>
  <button class="btn btn-lg btn-primary btn-block" name="button" type="submit">Login</button>
</form>

<?php
Login();
$content=ob_get_clean();
require "templates/layout.html.php";
?>
