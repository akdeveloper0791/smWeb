<?php

/* error codes 
 99->Unable to connect with the device, please check the connections
 100 -> Unable to prepare request file, please try again later
 101 -> Unable to send request, please try again later
 */

  require("../ftp/FTPClient.php");
  require ('..\..\Constants.php');
  require("../ftp/FTPModel.php");

  $ftpClient = new FTPClient();
  
  $ipAddress = $_REQUEST['ip_address'];
  $requestJSONArray = json_decode($_REQUEST['request_JSON'],true);
  $action = $_REQUEST['action'];
  
  $responseFileName = getSaveFtpCommandResponseName($action);
  $requestJSONArray[save_ftp_command_response_to_json_key] = $responseFileName;
  $requestJSON = json_encode($requestJSONArray);

  //$requestJSON = getAudioReqJson();
  //echo $requestJSON;

  //login to check 
  if($ftpClient->connect($ipAddress,true))
  {
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
             sleep(2);
            echo json_encode(array('statusCode'=>0,
          'status'=>'Request has been sent successfully',
          'response_file'=>$responseFileName));;
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
      $ftpClient->__deconstruct();
  }else
  {
  	 //unable to connect with the selected devices
  	 echo json_encode(array('statusCode'=>99,
  	 	'status'=>'Unable to connect with the device, please check the connections'));
  }
  
 
?>