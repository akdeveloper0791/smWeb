<?php

/* error codes 

 99->Unable to connect with the device, please check the connections
 2-> No files found
 3->Error in processing request
 4->successfully all files have been retrieved
 100->Unable to process the response text, please try again later
*/
  require("../../ftp/FTPClient.php");
  require ('..\..\..\Constants.php');
  require("../../ftp/FTPModel.php");

 $previousIndex = $_REQUEST['index'];
 $responseFileName = $_REQUEST['response_file'];
 $ipAddress = $_REQUEST['ip_address'];

  $ftpClient = new FTPClient();
   //login to check 
  if($ftpClient->connect($ipAddress,true))
  {
     //download file to
  	//create a new file
  	downloadResponse();
  	
  }
   else
   {
  	 //unable to connect with the selected devices
  	 echo json_encode(array('statusCode'=>99,
  	 	'status'=>'Unable to connect with the device, please check the connections'));
   }

  function downloadResponse()
  {
  	global $responseFileName;
  	
    if(!file_exists (copy_request_temp_loc))
     {
                
       $isCreatedNewDir = mkdir(copy_request_temp_loc,0777, true);
     }
     
     $src1 = copy_request_temp_loc.$responseFileName;

  	 if($GLOBALS['ftpClient']->downloadFile($responseFileName,$src1,FTP_ASCII))
  	 {
        processFile($src1);
        //echo 'file downloaded successfully - '.$src1; 
  	 }else
  	 {
         //wait for another second
  	 	 sleep(1);
  	 	 downloadResponse();

  	 }
  }

  function processFile($responseFile)
  {
    try
    {
     $processText = getFTPResponseFileText($responseFile);
     

     if(!is_null($processText))
     {
         $processedJSON = json_decode($processText,true);
         $statusCode = $processedJSON['statusCode'];
         if($statusCode == 2)
         {
           echo json_encode(array(
            'statusCode'=>2,'status'=>'No files found'));
         }
         else if($statusCode == 4)
         {
           //files have been retrieved successfully
           echo json_encode(array(
            'statusCode'=>4,'status'=>'files have been retrieved successfully'));
         }else if($statusCode == 1)
         {
           $returnJSON = $processedJSON;

           //files have been found
            $filesArray = $processedJSON['filesArray'];
            if(count($filesArray) >= modify_files_query_limit)
            {
              $returnJSON['query_again'] = true;
              $returnJSON['next_index'] = ($GLOBALS['previousIndex']+modify_files_query_limit);
            }else
            {
               $returnJSON['query_again'] = false;
            }

            echo json_encode($returnJSON);
         }else
         {
            echo $processText;
         }
     }else
     {
        echo json_encode(array(
          'statusCode'=>100,'status'=>'Unable to process the response text, please try again later'));
     }
    }catch(Exception $e)
    {
      echo json_encode(array(
          'statusCode'=>100,'status'=>'Unable to process the response text, please try again later .'.$e->getMessage()));

    }finally
    {
         //delete the response file to free up space
         unlink($responseFile);

         //close FTP connection
         $GLOBALS['ftpClient']->__deconstruct();
    }
     
  }

?>