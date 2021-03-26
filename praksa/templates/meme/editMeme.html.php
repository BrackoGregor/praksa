<?php ob_start()?>
<script>document.title="Edit meme";</script>

<?php
  $link=open_database_connection();
  $idMeme = $_GET['id'];

  $sql = "SELECT * FROM memes WHERE idMeme='$idMeme'";
  $result = mysqli_query($link, $sql);
  close_database_connection($link);

  if (mysqli_num_rows($result) > 0)
      {
        while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
        {
          echo '<div class="container" id="content">'.
                  '<h1 class="h3 mb-3 font-weight-normal">'."Edit meme".'</h1>'.
                      '<form method="post" enctype="multipart/form-data">'.
                        '<div class="form-group">'.
                        '  <label for="inputTitle">Edit title:</label>'.
                          "<input name='title' type='text' class='form-control' id='title' value='".$row['title']."'>".
                        '</div>'.
                        '<div class="form-group">'.
                        '  <label for="inputDescription">Edit description:</label>'.
                          "<input name='description' type='text' class='form-control' id='description' value='".$row['description']."'>".
                        '</div>'.
                        '<div class="form-group">'.
                          '<label for="uploadPhoto">'."Edit photo (if there is no picture selected, the old one will remain):".'</label>'.
                          "<input name='uploadPhoto' type='file' class='form-control-file' id='uploadPhoto'>".
                        '</div>'.
                        '<button name="button" type="submit" class="btn btn-primary">'."Edit".'</button>'.
                      '</form>'.
                      '<br>'.
              '</div>';
        }
    }
?>

<?php
    editMeme($idMeme);
    $content=ob_get_clean();
    require "templates/layout.html.php";
?>