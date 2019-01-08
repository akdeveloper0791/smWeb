<?php
	
	$filename = $_REQUEST['filename'];
	$path = $_REQUEST['channel_path'];

	if($filename!=null)
	{

		//$dir = "./json/image/";
		//$dir = "Z:/";

		$dir = get_data();

		$myfile = fopen($dir.$filename, "r") or die("Unable to open file!");

		$reader = fread($myfile,filesize($dir.$filename));

		//echo json_encode(array('statusCode'=>0,'value'=>$reader));
		//($reader, JSON_UNESCAPED_SLASHES);

		if($reader!=null)
		{
			echo json_encode(array('statusCode'=>0,'value'=>$reader));

			//echo $reader;

		}

		fclose($myfile);


	}else 
	{

		echo json_encode(array('statusCode'=>1,'status'=>'File is not valid'));


	}


	function get_data()
    {
                     require '..\database.php';
$conn = mysqli_connect($server,$username,$password);
mysqli_select_db($conn,$database);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 


            $screen=$GLOBALS['path'];       
            $channelsQuery = "SELECT * from screens where ch_id = '" .$screen."'";          
            // $channelsQuery = "SELECT path from screens where ch_id = ".$GLOBALS['path'];
      
             $id = $conn->insert_id;

            $result = $conn->query($channelsQuery);

        if ($result->num_rows > 0) 
        {
            while($row = $result->fetch_assoc()) 
            {
              $directory = $row['path'];
              // $ip = $row['ip'];
              
              return $directory;

            }
           
        }    

        
        
    }

?>