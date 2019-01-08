<?php

require '..\database.php';

$link=mysqli_connect($server,$username,$password);
mysqli_select_db($link,$database);

$name=$_POST['channel'];

$stmt = $conn->prepare('SELECT * FROM channel_table WHERE names=?');
$stmt->bindParam(1, $name, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if($row>0)
{
 echo json_encode(array('statusCode'=>3,'status'=>'channel name exists'));
}else{
try
{

     // begin the transaction
   // Set autocommit to off
  
    $sql = "INSERT INTO channel_table (names)
           VALUES ('".$name."')";

   if ($link->query($sql) === TRUE)
   {
     

              
                echo json_encode(array('statusCode'=>0,'status'=>'Successfully created new user'));
              }else
              {
                 
                echo json_encode(array('statusCode'=>1,'status'=>'Sorry there must have been an issue creating '));
              }
}catch(Exception $e)
 {
                 // roll back the transaction if something failed
                
                $status =  "Sorry there must have been an issue creating your account " . $e->getMessage();
                echo json_encode(array('statusCode'=>2,'status'=>$status));
 }
}


?>



  