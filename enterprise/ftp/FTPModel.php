<?php

date_default_timezone_set("Asia/Kolkata");

 function createFTPRequestFileFromString($inputResult)
  {
  	 //create a new file
  	if(!file_exists (copy_request_temp_loc))
    {
                
      $isCreatedNewDir = mkdir(copy_request_temp_loc,0777, true);
    }
     
     $file_name = getFTPCommandFileName();
     $src1 = copy_request_temp_loc.$file_name;
     $isSuccess = file_put_contents($src1, $inputResult);
     
     if($isSuccess)
     {
         return $src1;
     }else
     {
        return null;
     }
     
  }

  function getFTPCommandFileName()
  {
  	$randomNumber = str_replace(".", "", (microtime(true)*1000));
  	 return "AK_FTP_COMMAND_"."WEB_".$randomNumber.".json";
  }

  function getSaveFtpCommandResponseName($action)
  {
    $randomNumber = str_replace(".", "", (microtime(true)*1000));
     return mobi_key."_"."WEB"."_".$action."_".$randomNumber.".json";

  }

  function getFTPResponseFileText($file)
  {
     $text="";

     $fh = fopen($file,'r');
     while ($line = fgets($fh)) {
        $text = $text.$line;
      }
     fclose($fh);

     return $text;
  }

  function isCampaign($value)
   {
     $s = strtolower($value);
     
     return ((!startsWith(do_not_display_media_small,$s)) && (
       endsWith('wmv',$s)||endsWith('avi',$s)||
       endsWith('mpg',$s)||endsWith('mpeg',$s)||
       endsWith('webm',$s)||endsWith('mp4',$s)||
       endsWith('3gp',$s)||endsWith('mkv',$s)|
       endsWith('jpg',$s)||endsWith('jpeg',$s)||
       endsWith('png',$s)||endsWith('bmp',$s)||
       endsWith('gif',$s)||endsWith('3gp',$s)||
       endsWith('txt',$s)));
   }

    function startsWith($needle,$haystack)
   {
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
   }

   function endsWith($needle,$haystack)
   {
      $length = strlen($needle);

      if ($length == 0) {

        return true;
       }

     return (substr($haystack, -$length) === $needle);
    
   }




?>