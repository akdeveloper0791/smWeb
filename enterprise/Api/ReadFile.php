<?php 
error_reporting(E_ERROR | E_PARSE);
/* error codes 
 99->Unabel to connect with the device, please check the connections
 100 -> no file found with that name 
 */

require("../ftp/FTPClient.php");
require ('..\..\Constants.php');
require("../ftp/FTPModel.php");

$ipAddress = $_REQUEST['ip_address'];
$fileName  = $_REQUEST['file_name'];

$ftpClient = new FTPClient();

//login to check 
  if($ftpClient->connect($ipAddress,true))
  {
     //download file to temp location
  	 downloadFile();

     //close FTP connection
      $ftpClient->__deconstruct();
  }else
  {
  	 //unable to connect with the selected devices
  	 echo json_encode(array('statusCode'=>99,
  	 	'status'=>'Unable to connect with the device, please check the connections'));
  }

 function downloadFile()
 {
 	global $fileName;
  	
    if(!file_exists (copy_request_temp_loc))
     {
                
       $isCreatedNewDir = mkdir(copy_request_temp_loc,0777, true);
     }
     
     $src1 = copy_request_temp_loc.$fileName;

  	 if($GLOBALS['ftpClient']->downloadFile($fileName,$src1,FTP_ASCII))
  	 {
        processFile($src1);
        //echo 'file downloaded successfully - '.$src1; 
  	 }else
  	 {
        echo json_encode(array('statusCode'=>100,
        	'status'=>'No file found with that name '));
  	 }
 }

  function processFile($responseFile)
  {
    try
    {
     $processText = getFTPResponseFileText($responseFile);
     
      echo $processText;

    }catch(Exception $e)
    {
      echo json_encode(array(
          'statusCode'=>100,'status'=>'Unable to process the response text, please try again later .'.$e->getMessage()));

    }finally
    {
         //delete the response file to free up space
       unlink($responseFile);
    }
     
  }

?>