<?php

/* error codes
 1->Unable to connect with the device, please check the connections
 2->Unable to publish  to the screens, 
       please check the connections
 */

  require("../ftp/FTPClient.php");
  require ('..\..\Constants.php');

 $ipAddress = $_REQUEST['ip_address'];
 $files = json_decode($_REQUEST['files'],true);
 
  //$files = array(array('file_name'=>'t3.txt','file_path'=>'C:/xampp/htdocs/smweb/json/tmp/t3.txt'));
 //$files = array($files);

 //echo json_encode($files);

 $ftpClient = new FTPClient();
 //first connect 
 if($ftpClient->connect($ipAddress,true)) 
 {
    //publish individual files
    $isCampaignSent = true;
    
    foreach ($files as $key => $indivFile) {
    	# code...
    	$src1 = $indivFile['file_path'];

    	 $info = pathinfo($src1);
        $ext = $info['extension']; 
               
        $newname = $indivFile['file_name']; 
        $isCopied = $ftpClient->uploadFile($src1,$newname,getMode($ext));
        if(!$isCopied)
        {
          $isCampaignSent = false;
          
           break;
        }

    }

    //return response
    if($isCampaignSent)
    {
       echo json_encode(array('statusCode'=>0,
  	 		'status'=>'Campaign modify has been published successfully')); 
    }else
    {
    	echo json_encode(array('statusCode'=>2,
    		'status'=>'Unable to publish  to the screens, 
       please check the connections'));
    }

   //close FTP connection
      $ftpClient->__deconstruct();
      
 }else
 {
 	 echo json_encode(array('statusCode'=>1,
  	 	'status'=>'Unable to connect with the device, please check the connections'));
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
?>