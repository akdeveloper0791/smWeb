<?php
require ('..\Constants.php');

	$datas = json_decode($_REQUEST['data'],true);

	$inputResult = json_decode($_REQUEST['data'],true);
	
	$media_name = $_REQUEST['media_name'];
	$path = json_decode($_REQUEST['path'],true);

	$inputResult['media_name'] = $media_name;
	$inputResult['path'] = $path;

	
	$response = json_encode($datas);
	
	get_data($media_name,$datas);
	
	
	function get_data($media_name,$insData)
	{
		 $directory = copy_campaign_temp_loc.$media_name."/";

        
    if(!file_exists ($directory))
                 {
                
                   $isCreatedNewDir = mkdir($directory,0777, true);

                 }
          try{

     
				$file_name1 = $GLOBALS['media_name'].'.txt';

				file_put_contents($directory.$file_name1, json_encode($insData));

            	


          }catch(Exception $e){
            echo 'Inside exception in pushing';
             //echo $e->getMessage();
          }

   
       echo "New record created successfully";

	}
	
	
?>