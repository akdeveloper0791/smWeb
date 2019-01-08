<?php

	$datas = json_decode($_REQUEST['data'],true);

	//$media_name = $_REQUEST['fileName'];

  	$duration = $_REQUEST['duration'];
  	$media_names = $_REQUEST['media_name'];
 	$offer_text= $_REQUEST['offer_text'];
  	$path = $_REQUEST['path'];


  	$datas['offer_text'] = $offer_text;
  	$datas['duration'] = $duration;
	
	//$path = $_REQUEST['path'];

	//$inputResult = json_decode($_REQUEST['data'],true);
	//$inputResult['media_name'] = $media_name;


	if($media_names!=null)
	{
		 //$file_name = $media_name.'.txt';
		$file_name = $media_names;

		//$directory = "../json/video/";

		 //$directory = "Z:/";

		 $directory = get_data();

		if(file_put_contents($directory.$file_name,json_encode($datas)))
		{
			echo json_encode(array('statusCode'=>0,'status'=>'Media Updated Successfully'));

		}else
		{
			echo json_encode(array('statusCode'=>2,'status'=>'Media Not Updated'));

		}

	}else{

		echo json_encode(array('statusCode'=>1,'status'=>'Invalid file'));
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