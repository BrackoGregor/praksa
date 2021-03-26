<?php
function open_database_connection(){
	$link=new mysqli("localhost","root","", "praksa");
	$link->query("SET NAMES 'utf8'");

	if (!$link) 
	{
		die('Could not connect: ' . mysql_error());
	}

	return $link;
}

function close_database_connection($link)
{
	mysqli_close($link);
}
?>
