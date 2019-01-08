<?php

/* error codes 
 99->Unabel to connect with the device, please check the connections
 100 -> Unable to prepare request file, please try again later
 101 -> Unable to send request, please try again later
 */
 
  require("../../ftp/FTPClient.php");
  require ('..\..\..\Constants.php');
  require("../../ftp/FTPModel.php");

  $ftpClient = new FTPClient();
  
  $ipAddress = $_REQUEST['ip_address'];
 // $requestJSON = $_REQUEST['request_JSON'];
 
  $index = $_REQUEST['index'];
  $saveResponseTo = getSaveFtpCommandResponseName(modify_key);

  //login to check 
  if($ftpClient->connect($ipAddress,true))
  {
      //prepare request json
  	   $requestJSON = getRequestJSON();
      
       $requestJSONFile = createFTPRequestFileFromString($requestJSON);
       
       if(!is_null($requestJSONFile))
       {
         //send modify request
         $isUploaded = $ftpClient->uploadFile($requestJSONFile,basename($requestJSONFile),FTP_ASCII);
         //delete request file to free up memory
         unlink($requestJSONFile);

         if($isUploaded)
         {
          //wait for 1.5 seconds before processing response
             sleep(1.5);
            echo json_encode(array('statusCode'=>0,
          'status'=>'Request has been sent successfully',
          'index'=>$index,'response_file'=>$saveResponseTo));;
         }else{

          echo json_encode(array('statusCode'=>101,
         'status'=>'Unable to send request, please try again later'));

          
         } 
       }else
       {
         echo json_encode(array('statusCode'=>100,
         'status'=>'Unable to prepare request file, please try again later'));

       }

       //close FTP connection
        $GLOBALS['ftpClient']->__deconstruct();
  }else
  {
  	 //unable to connect with the selected devices
  	 echo json_encode(array('statusCode'=>99,
  	 	'status'=>'Unable to connect with the device, please check the connections'));
  }

  function getRequestJSON()
  {
  	$filesList = array();
  	$filesList[app_default_request]=app_default_media_request;
  	$filesList[app_default_action]=modify_request;
  	$filesList[app_default_offset]=$GLOBALS['index'];
  	$filesList[save_ftp_command_response_to_json_key]=$GLOBALS['saveResponseTo'];
     
     return json_encode($filesList);
  }

?>