<?php
require ('..\..\ApiErrors.php');
require ('..\..\database.php');

/* error codes 
 1-> unable to connect with data base
 2-> No devices
*/

$apiErrors = new ApiErrors();

 //get reports query only top 10
$conn = mysqli_connect("localhost",$username,$password,$database);
	
	if ($conn-> connect_error) {
	
         echo json_encode(array('statusCode'=>1,'status'=>$apiErrors->db_connect_error_msg));
	}else
	{
		
       
       $sql = "SELECT * FROM enterprise_device_list";

       $result = $conn->query($sql);
       $resultData = array();

       if ($result->num_rows > 0) {
	      
	      $resultData = prepareResult($result);

        }

        if(!is_null($resultData) && count($resultData)>=1)
        {
           echo json_encode(array('statusCode'=>0,
           	'list'=>$resultData));
        }else
        {
        	echo json_encode(array('statusCode'=>2,
        		'status'=>"No Displays Found"));
        }
	}

	function prepareResult($result)
	{
      $rows = array();
     while($row = $result->fetch_assoc())
      {
         array_push($rows,$row);
      }
       return $rows;

	}