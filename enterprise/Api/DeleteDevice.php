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
  	$device = ($_REQUEST['device']);
    
     $sql = "DELETE FROM enterprise_device_list WHERE mac = '".$device."'";
      
   
     if ($conn->query($sql) === TRUE) 
      {   
            
        echo json_encode(array('statusCode'=>0,
                  'status'=>'screen has been deleted successfully'));
       } else {
                  
                   $status = "Error - ".mysqli_error($conn);
                   echo json_encode(array('statusCode'=>2,
                  'status'=>$status));
                }
           
      
        mysqli_close($conn);

  }
?>