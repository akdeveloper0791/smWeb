<?php

require '..\database.php';

$link=mysqli_connect($server,$username,$password);
mysqli_select_db($link,$database);

$name=$_POST['name'];
$path=$_POST['path'];
$drive=$_POST['drive'];


// $default_Channel = json_decode($_REQUEST['default_Channel'],true);
// echo $name." ".$path." ".$drive;

$stmt = $conn->prepare('SELECT * FROM screens WHERE path=?');
$stmt->bindParam(1, $path, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if($row>0)
{
 echo json_encode(array('statusCode'=>3,'status'=>'screen already exists'));
}else{
try
{

//   $result="SELECT count(ch_id) FROM screens
// WHERE ch_id=".$name;
// $data=mysql_fetch_assoc($link->query($result));
// echo $data['total'];

$howmanyuser_query=$link->query('SELECT COUNT(ch_id)  FROM screens WHERE ch_id='.$name);
$howmanyuser=$howmanyuser_query->fetch_array(MYSQLI_NUM); 
$howmanyuser=$howmanyuser[0]+1;



     $sql = "INSERT INTO screens (ch_id,name,path,ip)
           VALUES ('".$name."','".$howmanyuser."','".$path."','".$drive."')";

   if ($link->query($sql) === TRUE)
   {
     

      
                echo json_encode(array('statusCode'=>0,'status'=>'Successfully created'));
              }else
              {
       
                echo json_encode(array('statusCode'=>1,'status'=>'Sorry there must have been an issue creating'));
              }
}catch(Exception $e)
 {
                 // roll back the transaction if something failed
                mysqli_rollback($link);
                $status =  "Sorry there must have been an issue creating your account " . $e->getMessage();
                echo json_encode(array('statusCode'=>2,'status'=>$status));
 }
}


?>



  