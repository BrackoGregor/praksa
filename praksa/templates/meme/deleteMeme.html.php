<?php ob_start()?>
<script>document.title="Delete meme";</script>
<?php
  $idMeme = $_GET['id'];
  deleteMeme($idMeme);
?>
<?php
$content=ob_get_clean();
require "templates/layout.html.php";
?>