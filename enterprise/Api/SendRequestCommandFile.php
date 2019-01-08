<?php

/* error codes 
 99->Unabel to connect with the device, please check the connections
 100 -> Unable to prepare request file, please try again later
 101 -> Unable to send request, please try again later
 
 */
 
  require("../ftp/FTPClient.php");
  require('..\..\Constants.php');
  require("../ftp/FTPModel.php");

  $ftpClient = new FTPClient();
  
  $ipAddress = $_REQUEST['ip_address'];
  $requestJSON = $_REQUEST['request_json'];
  
  /*$requestJSON = getSkipJSON();
  echo $requestJSON;*/

  //create request file from request json
  $requestJSONFile = createFTPRequestFileFromString($requestJSON);
  
  if(!is_null($requestJSONFile))
  {
      //login to check 
     if($ftpClient->connect($ipAddress,true))
     {
        //send modify request
         $isUploaded = $ftpClient->uploadFile($requestJSONFile,basename($requestJSONFile),FTP_ASCII);
         //delete request file to free up memory
         unlink($requestJSONFile);

         if($isUploaded)
         {
            echo json_encode(array('statusCode'=>0,
           'status'=>'Request has been sent successfully'));
         }else{

           echo json_encode(array('statusCode'=>101,
           'status'=>'Unable to send request, please try again later'));  
         } 

         //close FTP connection
      $ftpClient->__deconstruct();
      
     }else
     {
  	     //unable to connect with the selected devices
  	     echo json_encode(array('statusCode'=>99,
  	 	 'status'=>'Unable to connect with the device, please check the connections'));
     }
  }else
  {
     echo json_encode(array('statusCode'=>100,
         'status'=>'Unable to prepare request file, please try again later'));

  }


   function getSkipJSON()
   {
     $filesList = array();
     $filesList[app_default_request]='media_and_player_request';
     $filesList['payload_string']='media_settings_request:skip_setting:balloon.txt:true';
     
     return json_encode($filesList);
   }

    // function deleteFile()
    // {
    //    $filesList = array();
    //    $filesList[app_default_request]='media_request';
    //    $filesList[app_default_action]='delete_action_request:';
    //    $filesList['files']= array('facebook.txt');
       
    //    return json_encode($filesList);
    // }

?>