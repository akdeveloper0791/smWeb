<?php

Class FTPClient
{
    // *** Class variables
  private $connectionId;
  private $loginOk = false;
  private $messageArray = array();
  private $ftpUser = "android";
  private $ftpPassword = "android";
  private $port = 2020;

   public function __construct() { 

   }

   public function __deconstruct()
   {
    
      if ($this->connectionId) {
         ftp_close($this->connectionId);
      }
   }

   private function logMessage($message) 
  {
    $this->messageArray[] = $message;
  }

  public function getMessages()
  {
    return $this->messageArray;
  }

  public function connect ($server, $isPassive = true)
  {
 
    // *** Set up basic connection
   
     $this->connectionId = ftp_connect($server,$this->port);
  
    if ((!$this->connectionId))
    {
      $this->logMessage('FTP connection has failed!');

		   return false;

    }else{
	    // *** Login with username and password
	    $loginResult = ftp_login($this->connectionId, $this->ftpUser, $this->ftpPassword);
	 
	    // *** Sets passive mode on/off (default on)
	    ftp_pasv($this->connectionId, $isPassive);
	 
	    // *** Check connection
	    if ((!$this->connectionId) || (!$loginResult)) {
	        $this->logMessage('FTP connection has failed!');
	        return false;
	    } else {
	        $this->logMessage('Connected to ' . $server . ', for user ' . $this->ftpUser);
	        return true;
	    }
	 }
  }

  public function uploadFile($fileFrom,$fileTo,$mode=FTP_BINARY)
  {
     $upload = ftp_put($this->connectionId, $fileTo, $fileFrom, $mode);
 
    // *** Check upload status
    if (!$upload) {
 
            $this->logMessage('FTP upload has failed! unable to upload');
            return false;
 
        } else {
            $this->logMessage('Uploaded "' . $fileFrom . '" as "' . $fileTo);
            return true;
        }
  }

  public function downloadFile($fileFrom,$fileTo,$mode)
  {
     return ftp_get($this->connectionId, $fileTo, $fileFrom, $mode, 0);
  }

  public function getFiles()
  {
    return  ftp_nlist($this->connectionId, ".");
  }
}


?>