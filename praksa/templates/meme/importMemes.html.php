<?php ob_start()?>
<script>document.title="Import memes";</script>

<div class="container" id="content">
    <h1 class="h3 mb-3 font-weight-normal">Import memes</h1>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="uploadFile">File (.csv):</label>
            <input name="uploadFile" type="file" class="form-control-file" id="uploadFile" accept=".csv">
        </div>
        <button name="button" type="submit" class="btn btn-primary">Submit</button>
    </form>
    <br>
</div>

<?php
    importMemes();
    $content=ob_get_clean();
    require "templates/layout.html.php";
?>