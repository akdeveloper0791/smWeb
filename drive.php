<?php

require ("ScreensHelper.php");
require 'database.php';
$link=mysqli_connect($server,$username,$password);
mysqli_select_db($link,$database);

$val=true;
$dup_array=array();
$dup_array_name=array();
//$apiErrors = new ApiErrors();



//$channelId = $_REQUEST['channel_id'];

$channelId = json_decode($_REQUEST['channel_id'],true);
// print_r($channelId);
 // $channelId = "screen1";

error_reporting(0);
$list = implode(',', $channelId);
 //$result=mysqli_query($link,"select ip,name from screens where ch_id='$channelId'");
$result=mysqli_query($link,"select ip,ch_id from screens where ch_id IN ($list) ORDER BY ch_id ASC");

			if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$ip= $row["ip"];
				$dirnames = $row["ch_id"];
				// echo "dirname".$dirnames."<br/>";
				// echo "dirname".$ip."<br/>";

				// if(!is_readable($dirpaths))
				//if(!file_exists($dirpaths))
				if(!pingScreen($ip))
				{
					//echo $dirpaths."<br/>";
					$val=false;
					array_push($dup_array,$dirpaths);
					array_push($dup_array_name,$dirnames);
					//break;
				}

}

echo json_encode(array('statusCode'=>0,'value'=>$val,'data'=>$dup_array,'name'=>$dup_array_name));

//echo $val;

///return $val;
//echo $val;
//print_r($val);
/*if($val==1)
{
    $statusCode=0;
            //alert("success1");//true
    //echo json_encode(array('statusCode'=>0,'status'=>'Screen Successfully Conected..'));
    echo json_encode($statusCode);
}else 
{
    $statusCode=1;
    echo json_encode($statusCode);
        //alert("success2");//false
    //echo json_encode(array('statusCode'=>1,'status'=>'Check The Screen Connection..'));
}*/

}else
{
	echo json_encode(array('statusCode'=>1,'value'=>$val,'status'=>"All Screens are in active state"));
}
?>
