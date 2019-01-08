<?php
$screenid = $_REQUEST['sc_id'];
// $conn = mysqli_connect("localhost","root","root123","auth");
              require '..\database.php';
$conn = mysqli_connect($server,$username,$password);
mysqli_select_db($conn,$database);
          
             //then delete from the table
             // $deleteQuery = "DELETE FROM channel_table, screens WHERE id = ".$screenid;

$deleteQuery = "DELETE t1, t2 FROM screens as t1 INNER JOIN  channel_table as t2 on t1.ch_id = t2.ch_id WHERE  t1.ch_id =".$screenid;  
             if (mysqli_query($conn, $deleteQuery)) {
                 
                 //delete server file
                 //deleteFile(defects_image_folder.$defectPath);
                 
                 //refresh reports
                 //refreshReports($channelId,$defectDate);

                 echo json_encode(array('statusCode'=>0,
                  'status'=>'channel has been deleted successfully'));
               } else {
                  
                   $status = "Error - ".mysqli_error($conn);
                   echo json_encode(array('statusCode'=>1,
                  'status'=>$status));
                }
           
      
  mysqli_close($conn);

 

?>