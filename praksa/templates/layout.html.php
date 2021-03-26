<!DOCTYPE HTML>
<html>
  <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
  </head>

  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="index.php?site=home">Solve-X meme library</a>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Menu
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">Random</a>
              <div class='dropdown-divider'></div>
              <a class="dropdown-item" href="index.php?site=importmeme">Import memes</a>
              <?php
                if (isset($_SESSION["praksa"]))
                {
                  echo "<div class='dropdown-divider'>"."</div>";
                  echo "<a class='dropdown-item' href='index.php?site=newmeme'>"."New meme"."</a>";
                }
              ?>
            </div>
          </li>          
        </ul>
        <h5 class="navbar-text navbar-right">
              <?php
              if (isset($_SESSION["praksa"]))
                {
                  $link=open_database_connection();
                  $sql="SELECT username FROM users WHERE idUser='".$_SESSION['praksa']."'";
                  $result = mysqli_query($link,$sql);
                  $username = mysqli_fetch_array($result);
                  echo $username['username'];
                  close_database_connection($link);
                }
              ?>
        </h5>
        <div class="nav navbar-nav navbar-right">
            <?php
              if (isset($_SESSION["praksa"]))
              {
                echo "<ul class='navbar-nav mr-auto'>".
                      "<li class='nav-item dropdown'>".
                        "<a class='nav-link dropdown-toggle' href='' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"."</a>".
                        "<div class='dropdown-menu' aria-labelledby='navbarDropdown'>".
                          "<a class='dropdown-item' href='index.php?site=logout'>"."Logout"."</a>".
                        "</div>".
                      "</li>".
                      "</ul>";
              }
              else
              {
                echo "<ul class='navbar-nav mr-auto'>".
                      "<li class='nav-item'>".
                        "<a class='nav-link' href='index.php?site=login'>"."Login"."</a>".
                      "</li>".
                      "</ul>";
                echo "<ul class='navbar-nav mr-auto'>".
                      "<li class='nav-item'>".
                        "<a class='nav-link' href='index.php?site=signup'>"."SignUp"."</a>".
                      "</li>".
                      "</ul>";
              }
            ?>
        </div>
      </div>
    </nav>

    <div class="container">
      <?php
        echo $content;
       ?>
    </div>

    <footer class="bg-light text-center text-lg-start"> 
      <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © 2020 Copyright: Gregor Bračko
      </div>
    </footer>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
  
  </body>
</html>