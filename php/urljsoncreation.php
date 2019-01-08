<?php
require ('../ScreensHelper.php');
require ('..\Constants.php');

	$datas = json_decode($_REQUEST['data'],true);

	$inputResult = json_decode($_REQUEST['data'],true);
	
	$media_name = $_REQUEST['media_name'];
	$path = json_decode($_REQUEST['path'],true);

	$inputResult['media_name'] = $media_name;
	$inputResult['path'] = $path;

	
	$response = json_encode($datas);
	
	get_data($datas);
	
	
	function get_data($insData)
	{
		            require '..\database.php';
					$conn = mysqli_connect($server,$username,$password);
					mysqli_select_db($conn,$database);
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			} 
			
	

       $screen=$GLOBALS['path']; 

  $list = implode(',', $screen);  
   $channelsQuery = "SELECT path,ip from screens where ch_id IN ($list) "; 

        $result = $conn->query($channelsQuery);

       if ($result->num_rows > 0) {

        
        while($row = $result->fetch_assoc()) 
        {
          $directory = $row['path'];
          $ip = $row['ip'];
          
          try{

        if(pingScreen($ip))
          {
				$file_name1 = $GLOBALS['media_name'].'.txt';

				file_put_contents($directory.$file_name1, json_encode($insData));

            	

			}
          }catch(Exception $e){
            echo 'Inside exception in pushing';
             //echo $e->getMessage();
          }

        }
       }

       echo "New record created successfully";

			$conn->close();
		
	}






	
	
	
?>