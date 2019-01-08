<?php
error_reporting(E_ERROR | E_PARSE);


  function isScreenConnected($path)
  {
  	return (file_exists($path) && opendir($path));
  }

  function pingScreen($ip)
  {
    $output=shell_exec('ping -n 1 '.$ip);

if (strpos($output, 'out') !== false) {
    return false;
}
    elseif(strpos($output, 'expired') !== false)
{
    return false;
}
elseif(strpos($output, 'unreachable') !== false)
{
    return false;
}
    elseif(strpos($output, 'data') !== false)
{
    return true;
}
else
{
   return false;
}
 
    // $pingresult = exec("ping -n 1 $ip", $outcome, $status);
    // if (0 == $status) {
    //    return true;
    // } else {
    //    return false;
    // }
   
  }

  function deleteScreenDefects($path)
  {
     //echo $path;
  	 if(file_exists($path))
     {

        $deleted = unlink($path);

        if($deleted != true)
        {
           return moveDefectsToTrashFolder($path);
        }

        return $deleted;
     }else
     {
     	 return true;
     }
  }

  function moveDefectsToTrashFolder($oldFile)
  { 
    

    if(file_exists($oldFile))
    {
       $trashFolder = main_directory."trash\\";

      if(!file_exists ($trashFolder))
      {
         mkdir($trashFolder);
      }

      $trashFile=$trashFolder.'trash.jpg';
     return rename($oldFile, $trashFile);
    }else
    {
    	return true;
    }
 }
?>