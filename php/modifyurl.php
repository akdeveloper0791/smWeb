<?php

	$datas = json_decode($_REQUEST['data'],true);

	$media_name = $_REQUEST['media_name'];
	$path = $_REQUEST['path'];

	//$inputResult = json_decode($_REQUEST['data'],true);
	//$inputResult['media_name'] = $media_name;


	if($media_name!=null)
	{
		// $file_name = $media_name.'.txt';
		$file_name = $media_name;

		//$directory = "../json/url/";

		//$directory = "Z:/";
		$directory = get_data();
		

		if(file_put_contents($directory.$file_name, json_encode($datas)))
		{
			echo json_encode(array('statusCode'=>0,'status'=>'Media Updated Successfully'));

		}else
		{
			echo json_encode(array('statusCode'=>2,'status'=>'Media Not Updated'));

		}

	}else{

		echo json_encode(array('statusCode'=>1,'status'=>'Invalid file'));
	}

	



	//$inputResult['path'] = $path;

	//echo print_r($inputResult);

	//echo print_r($datas);
	
	//$response = json_encode($datas);
	
	//get_data($inputResult,$datas);
	
	//echo $response;
	
	
	  /*$file = 'file2.json';
			file_put_contents($file, json_encode($datas));
			header("Content-type: application/json");
			header('Content-Disposition: attachment; filename="'.basename($file).'"'); 
			header('Content-Length: ' . filesize($file));
			readfile($file);*/
	
	/*date_default_timezone_set('Asia/Calcutta');		
	$file_name_date = date('d-m-y');
	$file_name_time = date('h:i:s');

	$file_name = $file_name_date."_".$file_name_time;
	
	//str_replace(":","-",$file_name_time);
	$file_name = str_replace(":","-",$file_name).'.json';

	if(file_put_contents("./json/".$file_name, json_encode($datas)))
	{
		echo $file_name.'file_created';
	}else 
	{
		echo "There is error with saving";
	}*/
		
	
	
	
	//echo "welcome to url page";
	
	
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