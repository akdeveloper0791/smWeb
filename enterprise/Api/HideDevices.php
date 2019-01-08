<?php 
require ('..\..\ApiErrors.php');
require ('..\..\database.php');

/* error codes 
 11 -> invalid request
 12 -> No devices selected
 13 -> Error updating record:
 */

$apiErrors = new ApiErrors();

 //get reports query only top 10
$conn = mysqli_connect("localhost",$username,$password,$database);
	
	if ($conn-> connect_error) {
	
         echo json_encode(array('statusCode'=>1,'status'=>$apiErrors->db_connect_error_msg));
	}else
	{
		$devices = json_decode($_REQUEST['devices'],true);
		$isHide = $_REQUEST['is_hide']; //1->hide, 0->show
	    
	    if(!is_null($devices) && count($devices)>=1)
	     {
            if($isHide==0 || $isHide==1)
            {
               $updateQuery= "UPDATE enterprise_device_list SET is_hide= ".$isHide.
               " WHERE mac IN ('".implode("','", $GLOBALS['devices'])."')";

                if ($GLOBALS['conn']->query($updateQuery) === TRUE) {
                      echo json_encode(array(
                      	'statusCode'=>0,'status'=>
                      	"Updated successfully"));
                 } else {
                     echo json_encode(array(
                      	'statusCode'=>13,'status'=>
                      	"Error updating record: " . $GLOBALS['conn']->error));
                 }
            }else
	        {
	     	  echo json_encode(array('statusCode'=>11,'status'=>"Invalid request"));
	        }
	     }else
	     {
	     	echo json_encode(array('statusCode'=>12,'status'=>"No devices selected"));
	     }
		
	}
?>