<?php ob_start()?>

<script>document.title="Eror 404";</script>

<div class="row" id="error">
        <div class="col-md-12">
            <div class="error-template">
                <h1>
                    Oooppsss!</h1>
                <h2>
                    404 Not Found</h2>
										<img src="photos/memed.jpg" alt="You have been memed">
                <div class="error-details">
                    This site does not exist!
                </div>
                <div class="error-actions">
									<br>
                    <a onClick=goHome() class="btn btn-success btn-lg"><span class="glyphicon glyphicon-home"></span>
                        Home <a onClick=goBack() class="btn btn-warning btn-lg"><span class="glyphicon glyphicon-envelope"></span>Back</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function goBack()
    {
        window.history.back();
    }

    function goHome()
    {
        document.location.href="http://localhost/praksa/index.php?site=home";
    }
</script>


<?php
$content=ob_get_clean();
require "templates/layout.html.php";
?>
