<?php ob_start()?>
<script>document.title="New meme";</script>

<div class="container" id="content">
    <h1 class="h3 mb-3 font-weight-normal">New meme</h1>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="inputTitle">Title:</label>
            <input name="title" class="form-control" id="title" placeholder="Title">
        </div>
        <div class="form-group">
            <label for="inputdescription">Description:</label>
            <input name="description" class="form-control" id="description" placeholder="My new meme">
        </div>
        <div class="form-group">
            <label for="uploadPhoto">Photo:</label>
            <input name="uploadPhoto" type="file" class="form-control-file" id="uploadPhoto">
        </div>
        <button name="button" type="submit" class="btn btn-primary">Submit</button>
    </form>
    <br>
</div>

<?php
    newMeme();
    $content=ob_get_clean();
    require "templates/layout.html.php";
?>