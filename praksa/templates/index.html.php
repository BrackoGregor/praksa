<?php ob_start()?>
<script>document.title="Home";</script>
<style>   
    table {  
        border-collapse: collapse;  
    }  
        .inline{   
            display: inline-block;   
            float: right;   
            margin: 20px 0px;   
        }   
         
        input, button{   
            height: 34px;   
        }   
  
    .pagination {   
        display: inline-block;   
    }   
    .pagination a {   
        font-weight:bold;   
        font-size:18px;   
        color: black;   
        float: left;   
        padding: 8px 16px;   
        text-decoration: none;   
        border:1px solid black;   
    }   
    .pagination a.active {   
            background-color: pink;   
    }   
    .pagination a:hover:not(.active) {   
        background-color: skyblue;   
    }   
</style>  

<?php        
    // Import the file where we defined the connection to Database.     
    require_once "model.php";   

    $per_page_record = 8;  // Number of entries to show in a page.   
    // Look for a GET variable page if not found default is 1.        
    if (isset($_GET["page"])) {    
        $page  = $_GET["page"];    
    }    
    else {    
    $page=1;    
    }    

    $start_from = ($page-1) * $per_page_record;     

    $query = "SELECT * FROM memes ORDER BY idMeme DESC LIMIT $start_from, $per_page_record"; 
    $link=open_database_connection();    
    $rs_result = mysqli_query ($link, $query);  
    close_database_connection($link);  
?> 
<div class="container" id="content">
    <div class="row">
        <?php     
            while ($row = mysqli_fetch_array($rs_result)) 
            {
                echo '<div class="col-xs-3">'.
                        '<div class="card" style="width: 17rem;">'.            
                            '<div class="card-body">'.  
                                '<h5 class="card-title">'.$row["title"]. /*$row["idMeme"].*/'</h5>'.
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
            };    
        ?> 

        <div class="pagination">    
            <?php  
                $query = "SELECT COUNT(*) FROM memes";  
                $link=open_database_connection();   
                $rs_result = mysqli_query($link, $query);     
                close_database_connection($link);
                $row = mysqli_fetch_row($rs_result);     
                $total_records = $row[0];     
                
                echo "</br>";        
                $total_pages = ceil($total_records / $per_page_record);     
                $pagLink = "";       
            
                if($page>=2)
                {   
                    echo "<a href='index.php?page=".($page-1)."'>  Prev </a>";   
                }       
                        
                for ($i=1; $i<=$total_pages; $i++) 
                {   
                    if ($i == $page) 
                    {   
                        $pagLink .= "<a class = 'active' href='index.php?page=".$i."'>".$i."</a>";   
                    }               
                    else  
                    {   
                        $pagLink .= "<a href='index.php?page=".$i."'>".$i."</a>";     
                    }   
                };     
                echo $pagLink;   
        
                if($page<$total_pages)
                {   
                    echo "<a href='index.php?page=".($page+1)."'>  Next </a>";   
                }       
            ?>    
      </div>  

      <div class="inline">   
        <input id="page" type="number" min="1" max="<?php echo $total_pages?>"   
        placeholder="<?php echo $page."/".$total_pages; ?>" required>   
        <button onClick="go2Page();">Go</button> 
      </div>  
    </div>
</div>

<script>   
    function go2Page()   
    {   
        var page = document.getElementById("page").value;   
        page = ((page><?php echo $total_pages; ?>)?<?php echo $total_pages; ?>:((page<1)?1:page));   
        window.location.href = 'index.php?page='+page;   
    }   
  </script>  

<?php
    $content=ob_get_clean();
    require "templates/layout.html.php";
?>
