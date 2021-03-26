<?php ob_start()?>
<script>document.title="Home";</script>

<?php
    require_once "model.php";

    if (isset($_GET['page_no']) && $_GET['page_no']!="") 
    {
        $page_no = $_GET['page_no'];
    } 
    else 
    {
        $page_no = 1;
    }
    	
    $total_records_per_page = 8;

    $offset = ($page_no-1) * $total_records_per_page;
    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;
    $adjacents = "2";

    $link=open_database_connection(); 
    $result_count = mysqli_query($link,"SELECT COUNT(*) As total_records FROM `memes`");     
    $total_records = mysqli_fetch_array($result_count);    

    $total_records = $total_records['total_records'];
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
    $second_last = $total_no_of_pages - 1; // total pages minus 1

    $result = mysqli_query($link, "SELECT * FROM `memes` ORDER BY idMeme DESC LIMIT $offset, $total_records_per_page");
    close_database_connection($link);
?>

<div class="container" id="content">
    <div class="row">
        <?php
            while($row = mysqli_fetch_array($result))
            {
                echo '<div class="col-xs-3">'.
                        '<div class="card" style="width: 17rem;">'.            
                            '<div class="card-body">'.  
                                '<h5 class="card-title">'.$row["title"].'</h5>'.
                            '</div>'.
                            '<img class="card-img-top" src="photos/'.$row["photo"].'" alt='.$row["title"].'>'.
                            '<ul class="list-group list-group-flush">'.
                                '<li class="list-group-item">'.$row["description"].'</li>'.
                                '<li class="list-group-item">'.$row["upload_date"].'</li>'.
                            '</ul>';
                            if (isset($_COOKIE['Praksa']))
                            {
                                echo "<p>"."<a class='btn btn-primary' href='index.php?site=editMeme&id=".$row["idMeme"]."' role='button'>"."Edit"."</a>".
                                    "<a class='btn btn-danger' href='index.php?site=deleteMeme&id=".$row["idMeme"]."' role='button'>"."Delete"."</a>"."</p>";
                            }
                    echo '</div>';
                echo '</div>';
            }
        ?>

        <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
            <strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
        </div>

        <ul class="pagination">
	<?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } ?>
    
	<li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
	<a <?php if($page_no > 1){ echo "href='?page_no=$previous_page'"; } ?>>Previous</a>
	</li>
       
    <?php 
	if ($total_no_of_pages <= 10){  	 
		for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
			if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}
        }
	}
	elseif($total_no_of_pages > 10){
		
	if($page_no <= 4) {			
	 for ($counter = 1; $counter < 8; $counter++){		 
			if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}
        }
		echo "<li><a>...</a></li>";
		echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
		echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
		}

	 elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
		echo "<li><a href='?page_no=1'>1</a></li>";
		echo "<li><a href='?page_no=2'>2</a></li>";
        echo "<li><a>...</a></li>";
        for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
           if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}                  
       }
       echo "<li><a>...</a></li>";
	   echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
	   echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";      
            }
		
		else {
        echo "<li><a href='?page_no=1'>1</a></li>";
		echo "<li><a href='?page_no=2'>2</a></li>";
        echo "<li><a>...</a></li>";

        for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
          if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}                   
                }
            }
	}
?>
    
	<li <?php if($page_no >= $total_no_of_pages){ echo "class='disabled'"; } ?>>
	<a <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page'"; } ?>>Next</a>
	</li>
    <?php if($page_no < $total_no_of_pages){
		echo "<li><a href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
		} ?>
</ul>

    </div>
</div>

<?php
    $content=ob_get_clean();
    require "templates/layout.html.php";
?>
