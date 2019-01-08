<?php
ini_set('max_execution_time', 600); 

require ('..\..\ApiErrors.php');
require ('..\..\database.php');
require ('..\..\ScreensHelper.php');

/* error codes 
 1-> unable to connect with data base
 2-> error updating records

*/

 
$apiErrors = new ApiErrors();
//global variables
$ipAvailabelDevices = array();
$noIpDevices = array();
$checkedIpAddress = array();
$connectedDevices = array();
$newIPMacs = array();
$myIpSubnet; $myIp=0;$incrementIP=1;$decrementIP=255;

 //get reports query only top 10
$conn = mysqli_connect("localhost",$username,$password,$database);
	
	if ($conn-> connect_error) {
	
         echo json_encode(array('statusCode'=>1,'status'=>$apiErrors->db_connect_error_msg));
	}else
	{
		  
       $sql = "SELECT mac,ip FROM enterprise_device_list WHERE is_hide = 0";
       $result = $conn->query($sql);
       if ($result->num_rows > 0) {
	      
	        prepareAvailableDevices($result);

	         checkAndUpdateDeviceStatus();
        }else
        {
        	echo json_encode(array('statusCode'=>2,
        		'status'=>"No devices found"));
        }
       
   }

   function prepareAvailableDevices($result)
   {
   	  global $ipAvailabelDevices,$noIpDevices;

   	  while($row = $result->fetch_assoc()) 
      {
      	$ipAddress = $row['ip'];
      	if(isValidIp($ipAddress))
      	{
      		$ipAvailabelDevices[$row['mac']] = $ipAddress;
      	}else
      	{
          array_push($noIpDevices, $row['mac']);
      	
      	}
      	
      }
       
   }

   function checkAndUpdateDeviceStatus()
   {
      if(count($GLOBALS['ipAvailabelDevices'])>=1)
      {
           //check available devices status
         pingAvailableDeviceStatus();
      }else 
      {
        //process no ip devices
      
            processNoIpDevices();
        
      } 

   }

   function isValidIp($ipAddress)
   {
   	 $ipNumeric = (str_replace(".", "", $ipAddress));
   	 return (!is_null($ipAddress) && (is_numeric($ipNumeric) &&  $ipNumeric>=1));
   }

   function pingAvailableDeviceStatus()
   {
     global $ipAvailabelDevices,$checkedIpAddress,$connectedDevices,$noIpDevices,
       $newIPMacs;

     $ipAddress = current($ipAvailabelDevices);
     $mac = key($ipAvailabelDevices);
     
      //ping ip address
      if(pingIp($ipAddress))
      {
        //ping is successs,, check whether ip is belongs 
        // to same mac
        

        $isSameMac = $newMac = isIpConnectedToSameMac($ipAddress,$mac);
        
        if($isSameMac === true)
        {
          
           //ip belongs to same mac and connected to same network
           array_push($connectedDevices, array(
            'mac'=>$mac,'ip'=>$ipAddress,'status'=>1));
        }else
        {
          
          //ip does not belongs to the mac
          array_push($noIpDevices, $mac);

          if(is_string($newMac))
          {
             //connected to different mac
            $newIPMacs[$ipAddress] = $newMac;
          }
        }
        
      }else
      {
         //ip is unreachable 
         array_push($noIpDevices, $mac);
      }

      //once the process is successful, remove the device
      //from list
      unset($ipAvailabelDevices[$mac]); 

      //add to checked ip address
      array_push($checkedIpAddress, $ipAddress);
      
      //check and do for next available devices
      if(count($ipAvailabelDevices)>=1)
      {
        pingAvailableDeviceStatus();
      }else
      {
         //process no Ip available devices
         processNoIpDevices();
      }
   }

  function isIpConnectedToSameMac($ipAddress,$checkMac)
  {
    $isConnected = false;

    $arpa = shell_exec('arp -a');
    $arpa = stristr($arpa, 'Type');
    $arpa = preg_replace("/\s+/", " ", $arpa);
    $arpat = explode(" ",$arpa);

    list($k,$v) = each($arpat);
    while (list($k, $v) = each($arpat)) {
    $ippp = $v;
    list($k, $v) = each($arpat);
    $iddd = $v;
    list($k, $v) = each($arpat);
    $typer = $v;
    if ($v && $iddd && ($typer != "invalid")) {
    $arpa_new_status[$iddd]['ip'] = $ippp;
    }
    }
    ksort($arpa_new_status);
    reset($arpa_new_status);

    foreach ($arpa_new_status as $mac => $values) {
      $mac = str_replace("-", ":", $mac);
      if($values['ip'] == $ipAddress && $mac == $checkMac)
      {
        $isConnected = true;
        break;
      }else if($values['ip'] == $ipAddress)
      {
        //ip is assigned with different mac
         $isConnected = $mac;
         break;
      }
   
    }
    
    return $isConnected;
  
  }

  function processNoIpDevices()
  {
    if(count($GLOBALS['noIpDevices'])>=1)
    {
      global $noIpDevices,$myIpSubnet;
      $myIpSubnet = getMyIPSubnetMask();
      if(!is_null($myIpSubnet))
      {
         $myIpSubnet = $myIpSubnet.".";
         connectIpWithMac($GLOBALS['incrementIP'],"incrementIP");//start with increment ip
      }
      
    }else
    {
      updateResult();
    }
  
  }

  function getMyIPSubnetMask()
  {
    global $myIp;
    $localIP = gethostbyname(trim(exec("hostname")));
    $myIpSubnet = null;
    if(!is_null($localIP))
    {
       $subnetMaskArray = explode(".", $localIP);
      
       if(count($subnetMaskArray)>=4)
       {
         $ipLength = count($subnetMaskArray);
         $prefix = "";

         for ($i=0; $i < ($ipLength-1) ; $i++)//ignore the last number
          { 
             $myIpSubnet =  $myIpSubnet.$prefix.$subnetMaskArray[$i];
             $prefix = ".";
          }

          $myIp = $subnetMaskArray[($ipLength-1)];
          initIncrementDecrementIps($myIp);

          //add local ip to checked list to skip check
          if(!in_array($localIP, $GLOBALS['checkedIpAddress']))
          {
            array_push($GLOBALS['checkedIpAddress'], $localIP);
          }   
        }
    }

    return $myIpSubnet;
  }

  function initIncrementDecrementIps($myIp)
  {

    if($myIp==0)
    {
      //if my ip is the starting point
      $GLOBALS['incrementIP'] = 1;
      $GLOBALS['decrementIP'] = 255;
    }else if($myIp==255)
    {
       $GLOBALS['incrementIP'] = 0;
       $GLOBALS['decrementIP'] = 254;
    }else
    {
       $GLOBALS['incrementIP'] = ++$myIp;
       $GLOBALS['decrementIP'] = --$myIp;
    }
  }
   
   function connectIpWithMac($ipPosition,$ipWhat)
   {
     global $checkedIpAddress,$newIPMacs,
     $incrementIP,$decrementIP;
    
     if(count($GLOBALS['noIpDevices'])>=1 && count($checkedIpAddress)<=255 )
     {
       $ipAddress = $GLOBALS['myIpSubnet'].$ipPosition;
       //before ping check whether device is already ping or not
       if(!in_array($ipAddress, $checkedIpAddress))
       {
         
         //echo " check ip address - ".$ipAddress."</br>";
        if(pingIp($ipAddress)==true)
        {
         //echo(" ip ping success - ".$ipAddress."</br>");
         checkAndMapIpWithMac($ipAddress);
        }
         /*else
         {
          echo(" ip ping fail - ".$ipAddress."</br>");
         }*/
        array_push($checkedIpAddress, $ipAddress);
       }else
       {
         //check for mac
         if(array_key_exists($ipAddress, $newIPMacs))
         {
           $newIpMac = $newIPMacs[$ipAddress];
           checkAndMapIPMac($ipAddress,$newIpMac);
         }
       }
        
        
        if($ipWhat == "decrementIP")
        {
          $nextIpWhat = "incrementIP";
          $nextIp = $incrementIP;
          //decrement current position
           if($decrementIP==0)
           {
            $decrementIP = 255;
           }else
           {
            $decrementIP -= 1;
           }
        }else
        {
          $nextIpWhat = "decrementIP";
          $nextIp = $decrementIP;
          //increment current position
          if($incrementIP==255)
           {
            $incrementIP = 0;
           }else
           {
            $incrementIP += 1;
           }
           
        }
       
       //refreshARP();
       connectIpWithMac($nextIp,$nextIpWhat);
     }else
     {
      //refreshARP();
      //echo 'connected devices - '.json_encode($GLOBALS['connectedDevices']) ."</br>";
       updateResult();
     }

     
   }

   function checkAndMapIpWithMac($ipAddress)
   {
    $ipAssignedMac = null;

    $arpa = shell_exec('arp -a');
    $arpa = stristr($arpa, 'Type');
    $arpa = preg_replace("/\s+/", " ", $arpa);
    $arpat = explode(" ",$arpa);

    list($k,$v) = each($arpat);
    while (list($k, $v) = each($arpat)) {
    $ippp = $v;
    list($k, $v) = each($arpat);
    $iddd = $v;
    list($k, $v) = each($arpat);
    $typer = $v;
    if ($v && $iddd && ($typer != "invalid")) {
    $arpa_new_status[$iddd]['ip'] = $ippp;
    }
    }
    ksort($arpa_new_status);
    reset($arpa_new_status);

     foreach ($arpa_new_status as $mac => $values) {
      if($values['ip'] == $ipAddress)
      {
        $ipAssignedMac = str_replace("-", ":", $mac);
       // echo 'ipAssignedMac - '.$ipAssignedMac."</br>";
        break;
      }
    }
      if(!is_null($ipAssignedMac))
      {
        global $noIpDevices;
       
        foreach ($noIpDevices as $key => $value) {
            
        //for($index=0;$index<count($noIpDevices);$index++)
        //{
         // if($ipAssignedMac == $noIpDevices[$index])
             if($ipAssignedMac == $value)
          {
            //found device, update status to connected
            array_push($GLOBALS['connectedDevices'], array(
            'mac'=>$ipAssignedMac,'ip'=>$ipAddress,'status'=>1,'key'=>$key));
          
            //remove the device from no ip list
            //unset($noIpDevices[$index]);
            unset($noIpDevices[$key]);
            break;
          }
        }
      
      }
   }

   function checkAndMapIPMac($ipAddress,$ipAssignedMac)
   {
     if(!is_null($ipAssignedMac))
      {
        global $noIpDevices;
      
        foreach ($noIpDevices as $key => $value) {
            
        //for($index=0;$index<count($noIpDevices);$index++)
        //{
         // if($ipAssignedMac == $noIpDevices[$index])
             if($ipAssignedMac == $value)
          {
            //found device, update status to connected
            array_push($GLOBALS['connectedDevices'], array(
            'mac'=>$ipAssignedMac,'ip'=>$ipAddress,'status'=>1,'key'=>$key));
          
            //remove the device from no ip list
            //unset($noIpDevices[$index]);
            unset($noIpDevices[$key]);
            break;
          }
        }
      
       }
   }

   //update result
   function updateResult()
   {
     //check and update connected devices status
    $status = updateConnectedDeviceStatus();

     if($status == true)
     {
         $status = updateFailedDeviceStatus();
         if($status == true)
         {
          echo json_encode(array('statusCode'=>0,
            'status'=>"Devices has been refreshed successfully"));
         }
         else
         {
           //unable to update records
           echo json_encode(array('statusCode'=>2,
            'status'=>$status));
          }
     }else
     {
       //unable to update records
       echo json_encode(array('statusCode'=>2,
        'status'=>$status));
     }
   }

   //check and update connected devices status
   function updateConnectedDeviceStatus()
   {
     global $connectedDevices;
     //echo "connectedDevices - ".json_encode($connectedDevices);

     $coloumnsToUpdate = array('ip','status');
     $totalConnectedDevices = count($connectedDevices);
     $coloumnsConditions = array();
     $macsArray = array();
     if($totalConnectedDevices>=1)
     {
       foreach ($coloumnsToUpdate as $key => $coloumn) {
         # code...
         $indvColoumnQuery = $coloumn." = CASE";

         foreach ($connectedDevices as $key => $deviceArray) {
           # code...
          $indvColoumnQuery .= " WHEN mac = '".$deviceArray['mac']."' THEN '".$deviceArray[$coloumn]."'";
         }

         //postfix
         $indvColoumnQuery .= " ELSE ".$coloumn." END";
         array_push($coloumnsConditions, $indvColoumnQuery);
         $indvColoumnQuery = "";
       }
     }
       $connectedDevicesMac = array();
       foreach ($connectedDevices as $key => $value) {
         # code...
        array_push($connectedDevicesMac, $value['mac']);
       }

       //prepare final update query
       $finalQuery = "UPDATE enterprise_device_list SET ".
       implode(",", $coloumnsConditions)." WHERE mac IN ('".implode("','", $connectedDevicesMac)."')";
      
       if ($GLOBALS['conn']->query($finalQuery) === TRUE) {
           return true;
        } else {
            return "Error updating record: " . $GLOBALS['conn']->error;
        }
       
 
   }

   function updateFailedDeviceStatus()
   {
      //echo 'no Ip devices - '.json_encode($GLOBALS['noIpDevices'])." </ br>";

     $updateQuery = "UPDATE enterprise_device_list SET ip = '', status=0 WHERE 
     mac IN ('".implode("','", $GLOBALS['noIpDevices'])."')";
     
      if ($GLOBALS['conn']->query($updateQuery) === TRUE) {
           return true;
        } else {
            return "Error updating record: " . $GLOBALS['conn']->error;
        }
   }

  function pingIp($ip)
  {
    //echo "</br> pinging ip -".$ip;

    //$output=shell_exec('ping -n 1 '.$ip);
   $output=shell_exec('ping -w 1700 -n 1 '.$ip); //ping -w 1000

    //echo $output.$ip;

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
      //echo "false====";
       return false;
    }
     
        // $pingresult = exec("ping -n 1 $ip", $outcome, $status);
        // if (0 == $status) {
        //    return true;
        // } else {
        //    return false;
        // }
       
  }
?>