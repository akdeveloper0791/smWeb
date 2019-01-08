<?php

	// $datas = json_decode($_REQUEST['data'],true);

	// $inputResult = json_decode($_REQUEST['data'],true);
	
	$path = $_REQUEST['channel_path'];

	$arrayResult = array();

    
//$dir = "./json/image/";
//$dir = "Z:/";

$dir = get_data();

//echo "bdjhsd====".$dir;

// Open a directory, and read its contents
if(is_dir($dir)){	
  if ($dh = opendir($dir)){


    while(($file = readdir($dh)) !== false)
    {

    	if($file!="." && $file!=".." && $file!="Media")
        {
            if (strpos($file, 'DNDM') !== false) {
    			//echo 'true'.$file."<br>";

			}else 
			{
				array_push($arrayResult, $file);
	
			}

        }
        //echo "filename:" . $file . "<br>";
    }

    if($arrayResult!=null)
    {
    	echo json_encode(array('statusCode'=>0,'value'=>$arrayResult));
    }else 
    {
    	echo json_encode(array('statusCode'=>1,'status'=>'Directory is Empty'));
    }


     closedir($dh);
  }
}





    function get_data()
    {
            // $servername = "localhost";
            // $username = "root";
            // $password = "root123";
            // $dbname = "auth";
            
            require '..\database.php';
$conn = mysqli_connect($server,$username,$password);
mysqli_select_db($conn,$database);
            // Create connection
            // $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 


            $screen=$GLOBALS['path'];       
            $channelsQuery = "SELECT * from screens where ch_id = '" .$screen."'";          
            // $channelsQuery = "SELECT path from screens where ch_id = ".$GLOBALS['path'];
      
             $id = $conn->insert_id;

            $result = $conn->query($channelsQuery);

        if ($result->num_rows > 0) 
        {
            while($row = $result->fetch_assoc()) 
            {
              $directory = $row['path'];
              // $ip = $row['ip'];
              
              return $directory;

            }
           
        }    

        
        
    }







?>