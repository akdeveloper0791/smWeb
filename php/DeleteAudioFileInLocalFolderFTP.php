<?php 

	$fileName = $_REQUEST['fileName'];
	$path = $_REQUEST['path'];

	if($fileName!=null)
	{
		if(unlink($path))
		{
			echo "File Deleted Successfully in Local.";
		}else 
		{
			echo "File Not Deleted.";
		}

	}


?>