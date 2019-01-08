<?php
	// require ('../ScreensHelper.php');
	require ('..\Constants.php');

	$datas = json_decode($_REQUEST['data'],true);

	$inputResult = json_decode($_REQUEST['data'],true);
	
	$media_name = $_REQUEST['media_name'];
	$path = $_REQUEST['path'];
	//$duration_name = $_REQUEST['duration_name'];
	//$audio_name = $_REQUEST['audio_name'];


 //assigning values to array
	$inputResult['media_name'] = $media_name;
	$inputResult['path'] = $path;

	$response = json_encode($datas);

	//echo "krishjasd".$media_name ;
	//$directory=copy_campaign_temp_loc.$media_name;
	//echo "krishjasd".$directory ;
	get_data($media_name,$datas);
	
	
	
	function get_data($media_name,$inputResult)
	{


	// $screen=$GLOBALS['path']; 
	// $directory=copy_campaign_temp_loc;
	// $directory1=copy_campaign_temp_loc.$media_name;
	$directory = copy_campaign_temp_loc.$media_name."/";

        
 		if(!file_exists ($directory))
                 {
                
                   $isCreatedNewDir = mkdir($directory,0777, true);

                 }

          
          try{


			if(isset($_FILES["fileName"]['name']))
            {
               $info = pathinfo($_FILES["fileName"]['name']);

               $ext = $info['extension'];            
             
               $newname = "DNDM-".$GLOBALS['media_name'].".".$ext; 

                $target_file = $directory.$newname;

		    	$src = $_FILES['fileName']['tmp_name'];

                 // $tempFile = copy_campaign_temp_loc.$newname;
		    	$tempFile = $directory.$newname;

                  $isCopied = copy($src, $tempFile ); 
          
                 rename($tempFile, $target_file);
		
				}				

          //audio

				if(isset($_FILES["AudiofileName"]['name']))
				{
				$audio_info = pathinfo($_FILES["AudiofileName"]['name']);
				$audio_ext = $audio_info['extension']; 
				$newname = "DNDM-".$GLOBALS['media_name'].".".$audio_ext;

				$target_file = $directory.$newname;

		    	$src = $_FILES['AudiofileName']['tmp_name'];
    	
			  // if(!file_exists (copy_resource_temp_loc))
     //             {
                
     //               $isCreatedNewDir = mkdir(copy_resource_temp_loc,0777, true);
     //             }


                 $tempFile =$directory.$newname;

                  $isCopied = copy($src, $tempFile ); 
          
                 rename($tempFile,$directory.$newname);
		
				}			

			  //json 
				$file_name1 = $GLOBALS['media_name'].'.txt';
				//echo "json".copy_campaign_temp_loc.$media_name;
				file_put_contents($directory.$file_name1, json_encode($inputResult));
			
          }catch(Exception $e){
            echo 'Inside exception in pushing';
             
          }

       echo "New record created successfully";	
		
	}
	
	
	
?>