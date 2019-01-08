<?php
require ('../ScreensHelper.php');
require ('..\Constants.php');
	$datas = json_decode($_REQUEST['data'],true);

	$text = $_REQUEST['text'];
	$file_name = $_REQUEST['file_name'];
	 $path = json_decode($_REQUEST['path'],true);
	$offer_text = $_REQUEST['offer_text'];
	$duration = $_REQUEST['duration'];

	$inputtable['text'] = $text;
	$inputtable['name'] = $file_name;
	$inputtable['path'] = $path;


	$inputResult = json_encode(array('type'=>'multi_region','regions'=>$datas,'offer_text'=>$offer_text,'display_scroll_txt'=>false,'duration'=>(int)$duration));

	
	get_data($inputResult);
	
	
	
	function get_data($inputResult)
	{
		
		
			require '..\database.php';
			$conn = mysqli_connect($server,$username,$password);
			mysqli_select_db($conn,$database);
			
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


				$file_name1 = $GLOBALS['file_name'].'.txt';

					file_put_contents($directory.$file_name1, $inputResult);
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