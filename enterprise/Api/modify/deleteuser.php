<?php
$screenid = $_REQUEST['sc_id'];
// $conn = mysqli_connect("localhost","root","root123","auth");
              require '..\..\..\database.php';
$conn = mysqli_connect($server,$username,$password);
mysqli_select_db($conn,$database);
          
             //then delete from the table
             $deleteQuery = "DELETE FROM users WHERE id = ".$screenid." AND status = 0";

//  $deleteQuery = drop trigger user_channels;
// DELIMITER |
// CREATE TRIGGER user_channels BEFORE UPDATE ON users
// FOR EACH ROW
// BEGIN
// IF NEW.id=2 THEN
// SET NEW.user = 'n';
// END IF;
// END
// |
// DELIMITER ;
// $deleteQuery = "DELETE t1,t2 FROM enterprise_channels as t1 INNER JOIN  users as t2 on t1.user_id = t2.id WHERE  t2.id =".$screenid;
            
                   if (mysqli_query($conn, $deleteQuery)) {
                 
                 if($conn->affected_rows>=1)
                 {
                  echo json_encode(array('statusCode'=>0,
                  'status'=>'Staff has been deleted successfully'));
                 }else
                 {
                  echo json_encode(array('statusCode'=>1,
                  'status'=>'Admin can not be deleted'));
                 }

                 
               } else {
                  
                   $status = "Error - ".mysqli_error($conn);
                   echo json_encode(array('statusCode'=>1,
                  'status'=>$status));
                }
           
      
  mysqli_close($conn);

 

?>