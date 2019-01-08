<?php
/* error codes 
 1-> unable to connect with data base
 2-> unable to add device 
*/
require ('..\..\ApiErrors.php');
require ('..\..\database.php');


$conn = mysqli_connect("localhost",$username,$password,$database);
  
  if ($conn-> connect_error) {
  
         echo json_encode(array('statusCode'=>1,'status'=>$apiErrors->db_connect_error_msg));
  }else
  {
  	$inputResult = json_decode($_REQUEST['data'],true);
    
    $encodedMac = $inputResult['mac'];
    $inputResult['mac'] = base64_decode($encodedMac);
     
     $columns = implode(",",array_keys($inputResult));
     $escaped_values = array_map('mysql_real_escape_string', array_values($inputResult));
     $values  = implode("', '",$escaped_values);
     $sql = "INSERT INTO enterprise_device_list ($columns) VALUES ('$values')";
      
   
     if ($conn->query($sql) === TRUE) 
      {   
            
                 echo json_encode(array('statusCode'=>0,
                  'status'=>'screen has been added successfully'));
       } else {
                  
                   $status = "Error - ".mysqli_error($conn);
                   echo json_encode(array('statusCode'=>2,
                  'status'=>$status));
                }
           
      
        mysqli_close($conn);

  }
?>