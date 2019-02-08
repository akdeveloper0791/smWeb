<?php
ini_set('max_execution_time', 3600);

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

  

  $data=array();


  $regionsCount = $_REQUEST['regions_count'];
 
  //preapare regions data array
  for ($i=1; $i <= ($regionsCount) ; $i++) { 
    # code...
    $indivData = json_decode($_REQUEST['data'.$i],true);
    $indivData['is_self_path'] = true;
    array_push($data,$indivData); 
  }

  //Array containing screen ip's
  $path = json_decode($_REQUEST['path'],true);
    //$path = array('192.168.0.114');
  // echo $path;
  // echo print_r($path);
   
   $isCreateTemp = (count($path)>=2 ? true:false);

  $media_name = $_REQUEST['media_name'];
  $offer_text = $_REQUEST['offer_text'];
  $duration = $_REQUEST['duration'];


  $inputResult = array('type'=>'multi_region','regions'=>$data,'offer_text'=>$offer_text,'display_scroll_txt'=>false,'duration'=>(int)$duration);

  
  get_data($inputResult);

  
  function get_data($inputResult)
  {
    global $path;//screens
    
   
      //$channelsQuery = "SELECT path,ip from screens where ch_id = ".$screen; 

    if (count($path)>=1) {

        
        for($index=0;$index<count($path);$index++) 
        {
          
          $ip = $path[$index];
          
          publishCampaignTo($ip);
          //echo $directory;
           // echo $ip;
          

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
  	global $ftpClient,$failedScreens,$successScreens;
  	 try{

         if($ftpClient->connect($ip,true)) 
         {

         	$isCampaignSent = true;
      
   
         //video file creation
          for ($i=1; $i <= $GLOBALS['regionsCount']; $i++) { 
            # code...
            if(isset($_FILES["fileName".$i]['name']))
            { 

              

                  $info = pathinfo($_FILES["fileName".$i]['name']);
                  $ext = $info['extension']; 
                  $arrayPosition = $i-1;

                 $newname = $GLOBALS['data'][$arrayPosition]['media_name']; 
                 $src1 = $_FILES["fileName".$i]['tmp_name'];
                
                //publish campaing gile
                 $isCopied = $ftpClient->uploadFile($src1,$newname,getMode($ext));
                 if(!$isCopied)
                 {
                 	$isCampaignSent = false;
                 	array_push($failedScreens, $ip);
                      break;
                 }
                 //echo json_encode($ftpClient->getMessages());
            }
             //image
            else if(isset($_FILES["imagefileName".$i]['name']))
            {
               $info = pathinfo($_FILES["imagefileName".$i]['name']);
               $ext = $info['extension']; 
               
                $arrayPosition = $i-1;

               $newname = $GLOBALS['data'][$arrayPosition]['media_name']; 
               
               $GLOBALS['data'][$arrayPosition]['is_self'] = true;

               $src1 = $_FILES["imagefileName".$i]['tmp_name'];
                
                //publish campaing gile
                $isCopied = $ftpClient->uploadFile($src1,$newname,getMode($ext));
                
                if(!$isCopied)
                 {
                 	$isCampaignSent = false;
                 	array_push($failedScreens, $ip);
                      break;
                 }

              
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
      
          //close FTP connection
         $ftpClient->__deconstruct();
         
        }else{
        	//false unable to send to screen
        	array_push($failedScreens, $ip);
        }  


      }catch(Exception $e){

      	  array_push($failedScreens, $ip);
            
             //echo $e->getMessage();
       }
  }


  //check whether uploading file is ascii 
  function getMode($extension)
  {
  	 $asciiArray = array('txt', 'csv','pdf');
  	 if(in_array($extension, $asciiArray))
  	 {
        return FTP_ASCII;
  	 }else
  	 {
  	 	return FTP_BINARY;
  	 }
  }

  function uploadCampaignTxt($file_name,$ip)
  {
  	global $inputResult;
  	 //create a new file
  	if(!file_exists (copy_resource_temp_loc))
    {
                
      $isCreatedNewDir = mkdir(copy_resource_temp_loc,0777, true);
    }
    
    $src1 = copy_resource_temp_loc.$file_name;
    file_put_contents($src1, json_encode($inputResult));
  	
  	//copy to screen

  	$isCopied = $GLOBALS['ftpClient']->uploadFile($src1,$file_name,FTP_ASCII);
    
    unlink($src1);

    return $isCopied;

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
     //   $failedScreensNames = getFailedScreens();
  	 	// echo json_encode(array('statusCode'=>1,
  	 	// 	'status'=>'Unable to publish  to the screens, 
     //   please check the connections'));
      $failedScreensNames = getFailedScreens();
      echo json_encode(array('statusCode'=>1,
        'status'=>'Unable to publish  to the screens,('.implode(",", $failedScreensNames).') please check the connections and resend'));
  	 }else
  	 {
  	 	 //publishing failed for some screens,,
  	 	 //get the screens
  	 	 // $failedScreensNames = getFailedScreens();
  	 	 // echo json_encode(array('statusCode'=>2,
  	 		// 'status'=>'Unable to publish  to the some of the screens,('.implode(",", $failedScreensNames).'), please check the connections'));
      $failedScreensNames = getFailedScreens();
       echo json_encode(array('statusCode'=>2,
        'status'=>'Unable to publish  to the some of the screens,('.implode(",", $failedScreensNames).') please check the connections and resend',
        'ip'=>$failedScreens));
  	 }
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