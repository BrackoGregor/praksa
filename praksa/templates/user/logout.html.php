<?php ob_start()?>
<?php
    Logout();
    $content=ob_get_clean();
    require "templates/layout.html.php";
?>
