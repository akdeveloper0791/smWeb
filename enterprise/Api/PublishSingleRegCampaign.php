<?php
 ini_set('max_execution_time', 300);
 
  require("../ftp/FTPClient.php");
  require ('..\..\Constants.php');

  /* error codes 
   1->No screens selected
   2->Unable to send the data to the screens, 
     please check the connections
   */

  $ftpClient = new FTPClient();
  
  $failedScreens = array();
  $successScreens = array();

  $datas = json_decode($_REQUEST['data'],true);
  //$inputResult = json_decode($_REQUEST['data'],true);
  $media_name = $_REQUEST['media_name'];
  $path = json_decode($_REQUEST['path'],true);
  //$path = array('192.168.0.101');
  //$duration_name = $_REQUEST['duration_name'];
  //$audio_name = $_REQUEST['audio_name'];
  //echo 'audio_name - '.$audio_name;

   //assigning values to array
	//$inputResult['media_name'] = $media_name;
	//$inputResult['path'] = $path;

	$response = json_encode($datas);
	
	//echo $response."< br/>";
	//echo "inputresult".json_encode($inputResult);
	//echo "checkk".json_encode($datas);

	//get_data($inputResult,$datas);
    getData();

    function getData()
    {
      global $path;
      if (count($path)>=1) {     
      
      for($index=0;$index<count($path);$index++) 
        {
          
          $ip = $path[$index];
          
          publishCampaignTo($ip);

        }//end while

         //check and return result
         returnResult();

       }else
       {
       	 echo json_encode(array('statusCode'=>1,
       	 	'status'=>'No screens selected'));
       }   
    }

    function publishCampaignTo($ip)
    {
	  	global $ftpClient,$failedScreens,$successScreens,$datas;
	    
	    try{

	         if($ftpClient->connect($ip,true)) 
	         {
	         	$isCampaignSent = true;
	      
	   
	          // check and send files
	          if(isset($_FILES["fileName"]['name']))
			  {
				$info = pathinfo($_FILES['fileName']['name']);
				
				$ext = $info['extension']; 
				$target = $datas['resource'];
				$src1 = $_FILES['fileName']['tmp_name']; 
				
				//publish campaing gile
                 $isCopied = $ftpClient->uploadFile($src1,$target,getMode($ext));
                 if(!$isCopied)
                 {
                 	$isCampaignSent = false;
                 	//array_push($failedScreens, $ip);
                    
                 }

				}
				
			if(isset($_FILES["AudiofileName"]['name']) && $isCampaignSent)
			{
				$audio_info = pathinfo($_FILES["AudiofileName"]['name']);
				
				$audio_ext = $audio_info['extension']; 
				$target = $datas['bg_audio'];
                $src = $_FILES['AudiofileName']['tmp_name'];
                
				  //publish campaing gile
                 $isCopied = $ftpClient->uploadFile($src,$target,getMode($audio_ext));
                 
                 if(!$isCopied)
                 {
                 	$isCampaignSent = false;
                 	//array_push($failedScreens, $ip);
                    
                 }
				
				
				}
	           
	          if($isCampaignSent)
	          {
	          	$file_name = $GLOBALS['media_name'].'.txt';
	            $isCampaignSent = uploadCampaignTxt($file_name,$ip);
	          }
	          
	          if(!$isCampaignSent)
	          {
	            //false unable to send to screen
	        	array_push($failedScreens, $ip);
	          }else
	          {
	          	array_push($successScreens, $ip);
	          }
	      

	        }else{
	        	//false unable to send to screen
	        	array_push($failedScreens, $ip);
	        }  


	      }catch(Exception $e){

	      	  array_push($failedScreens, $ip);
	            
	             //echo $e->getMessage();
	       }
	}

	function uploadCampaignTxt($file_name,$ip)
    {
	  	global $response;
	  	 //create a new file
	  	if(!file_exists (copy_resource_temp_loc))
	    {
	                
	      $isCreatedNewDir = mkdir(copy_resource_temp_loc,0777, true);
	    }
	    
	    $src1 = copy_resource_temp_loc.$file_name;
	    file_put_contents($src1, $response);
	  	
	  	//copy to screen

	  	$isCopied = $GLOBALS['ftpClient']->uploadFile($src1,$file_name,FTP_ASCII);
	    
	    unlink($src1);

	    return $isCopied;

	}


	  //check whether uploading file is ascii 
	  function getMode($extension)
	  {
	  	 $asciiArray = array('txt', 'csv');
	  	 if(in_array($extension, $asciiArray))
	  	 {
	        return FTP_ASCII;
	  	 }else
	  	 {
	  	 	return FTP_BINARY;
	  	 }
	  }

   function returnResult()
   {
  	 global $path,$successScreens,$failedScreens;
  	 if(count($path) == count($successScreens))
  	 {
  	 	 //campaign has been published to all screens
  	 	echo json_encode(array('statusCode'=>0,
  	 		'status'=>'Campaign has been published successfully'));
  	 }else if(count($path) == count($failedScreens))
  	 {
  	 	echo json_encode(array('statusCode'=>2,
  	 		'status'=>'Unable to publish  to the screens, please check the connections'));
  	 }else
  	 {
  	 	 //publishing failed for some screens,,
  	 	 //get the screens
  	 	 $failedScreensNames = getFailedScreens();
  	 	 echo json_encode(array('statusCode'=>2,
  	 		'status'=>'Unable to publish  to the some of the screens,('.implode(",", $failedScreensNames).'), please check the connections'));
  	 }

  	 //close FTP connection
      $GLOBALS['ftpClient']->__deconstruct();
  }

   function getFailedScreens()
   {
   	 require ('..\..\database.php');
   	 global $failedScreens;
   	 //get reports query only top 10
       $conn = mysqli_connect("localhost",$username,$password,$database);
	
	   if ($conn-> connect_error) {
	     mysqli_close($conn);
	     return $failedScreens;

	   }else
	   {
		
       
       $sql = "SELECT name FROM enterprise_device_list WHERE ip IN ('".implode("','", $failedScreens)."')";
       
       $result = $conn->query($sql);
       $resultData = array();

       if ($result->num_rows > 0) {
	      
	      $resultData = array();
         while($row = $result->fetch_assoc())
         {
            array_push($resultData,$row['name']);
         }
         
         mysqli_close($conn);
         return $resultData;

        }else
        {
        	mysqli_close($conn);
        	return $failedScreens;
        }
       }
   }

	
?>