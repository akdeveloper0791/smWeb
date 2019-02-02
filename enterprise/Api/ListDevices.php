<?php
require ('..\..\ApiErrors.php');
require ('..\..\database.php');

session_start();
$link=mysqli_connect($server,$username,$password);
mysqli_select_db($link,$database);
if( isset($_SESSION['user_id']) ){

  $records = $conn->prepare('SELECT id,email,password FROM users WHERE id = :id');
  $records->bindParam(':id', $_SESSION['user_id']);
  $records->execute();
  $results = $records->fetch(PDO::FETCH_ASSOC);

  $user = NULL;
}

/* error codes 
 1-> unable to connect with data base
 2-> No devices
*/

// $user_screen = $_REQUEST['user_screen'];
// $user_screen = $_SESSION['user_id'];
// print_r("qweqw".$user_screen);
$apiErrors = new ApiErrors();

 //get reports query only top 10
$conn = mysqli_connect("localhost",$username,$password,$database);
	
	if ($conn-> connect_error) {
	
         echo json_encode(array('statusCode'=>1,'status'=>$apiErrors->db_connect_error_msg));
	}else
	{
	
       // $sql = "SELECT * FROM enterprise_device_list ";
    //$sql = "SELECT * FROM enterprise_device_list ";
    // $sql = " SELECT * FROM `enterprise_device_list` WHERE sc_id IN ( SELECT name FROM enterprisechannel_table WHERE ch_id IN ( select ch_id FROM enterprise_channels WHERE user_id = ".$_SESSION['user_id'].") )";
    // $sql = " SELECT * FROM `enterprise_device_list` WHERE sc_id IN ( select ch_id FROM enterprise_channels WHERE user_id = ".$_SESSION['user_id']." )";
     $sql = " SELECT * FROM `enterprise_device_list` WHERE name IN ( SELECT ch_id FROM enterprise_channel_table WHERE ch_id IN ( select ch_id FROM enterprise_channels WHERE user_id = ".$_SESSION['user_id']." ) )";
    

       $result = $conn->query($sql);
       $resultData = array();

       if ($result->num_rows > 0) {
	      echo "Inside result data ".$result->num_rows;
	      $resultData = prepareResult($result);

        }

        if(!is_null($resultData) && count($resultData)>=1)
        {
          echo "\nInside result data after processing".json_encode($resultData);

          $result =  json_encode(array('statusCode'=>0));
           echo $result;
        }else
        {
          echo "Inside result data after processing No data";

          json_encode(array('statusCode'=>2,
            'status'=>"No Displays Found"));

        	echo $result;
        }

        
	}



	function prepareResult($result)
	{
      $rows = array();
     while($row = $result->fetch_assoc())
      {
        //echo json_encode($row);
         array_push($rows,$row);
      }
      echo json_encode($rows);
       return $rows;


	}