<?php
/* error codes
 1->Unable to connect with the device, please check the connections
 2-> No files found
 */

  require("../ftp/FTPClient.php");
  require ('..\..\Constants.php');
  require("../ftp/FTPModel.php");

  $ipAddress = $_REQUEST['ip_address'];

  $ftpClient = new FTPClient();
  if($ftpClient->connect($ipAddress,true)) 
  {
     $retrievedFiles = $ftpClient->getFiles();
     if(!is_null($retrievedFiles) && count($retrievedFiles)>=1)
     {
        $campaignFiles = getCampaignFiles($retrievedFiles);
       if(!is_null($campaignFiles) && count($campaignFiles)>=1)
       {
          echo json_encode(array('statusCode'=>0,
        	'files'=>$campaignFiles));
       }else
       {
         echo json_encode(array('statusCode'=>2,
        	'status'=>'No files found'));
        }
     }else
     {
        echo json_encode(array('statusCode'=>2,
        	'status'=>'No files found'));
     }
     
     //close FTP connection
      $GLOBALS['ftpClient']->__deconstruct();
     
  }else
  {
  	 echo json_encode(array('statusCode'=>1,
  	 	'status'=>'Unable to connect with the device, please check the connections'));

  }

  function getCampaignFiles($retrievedFiles)
  {
  	$campaignFiles = array();

  	 foreach ($retrievedFiles as $key => $value) {
  	 	# code...
  	 	if(isCampaign($value))
  	 	{
           array_push($campaignFiles, $value);
  	 	}
  	 	
  	 }

  	 return $campaignFiles;
  }

   
  
?>