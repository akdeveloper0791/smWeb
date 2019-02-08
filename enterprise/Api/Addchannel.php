<?php

require ('..\..\database.php');

$link=mysqli_connect($server,$username,$password);
mysqli_select_db($link,$database);

$name=$_POST['channel'];

$stmt = $conn->prepare('SELECT * FROM enterprise_channel_table WHERE names=?');
$stmt->bindParam(1, $name, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if($row>0)
{
 echo json_encode(array('statusCode'=>3,'status'=>'Group name exists'));
}else{
try
{

     // begin the transaction
   // Set autocommit to off
  
    $sql = "INSERT INTO enterprise_channel_table (names)
           VALUES ('".$name."')";

   if ($link->query($sql) === TRUE)
   {
     

              
                echo json_encode(array('statusCode'=>0,'status'=>'Successfully created group'));
              }else
              {
                 
                echo json_encode(array('statusCode'=>1,'status'=>'Sorry there must have been an issue creating group'));
              }
}catch(Exception $e)
 {
                 // roll back the transaction if something failed
                
                $status =  "Sorry there must have been an issue creating your group " . $e->getMessage();
                echo json_encode(array('statusCode'=>2,'status'=>$status));
 }
}


?>



  