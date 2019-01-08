<?php

	// $datas = json_decode($_REQUEST['data'],true);

	// $inputResult = json_decode($_REQUEST['data'],true);
	
	$data = json_decode($_REQUEST['deletedata'],true);

    $path = $_REQUEST['channel_path'];
    
	//$arrayResult = array();

    // $dir = "../json/image/";
    //$dir = "Z:/";

    $dir = get_data();

    if($data!=null)
    {
        $boolean_data=true;

        foreach ($data as $value)
        {

            $myfile = fopen($dir.$value, "r") or die("Unable to open file!");

            $reader = fread($myfile,filesize($dir.$value));

            // Read JSON file
            $jsonfile = file_get_contents($dir.$value);

            //Decode JSON
            $json_data = json_decode($jsonfile,true);

            if($reader!=null)
            {
               // echo $json_data['resource'];

                if($json_data['type']=="Image")
                {
                    //echo "image==".$json_data['bg_audio'];

                    if(!empty($json_data['resource']))
                    {
                        if((is_file($dir.$json_data['resource']))&&(file_exists($dir.$json_data['resource'])))
                        {
                             unlink($dir.$json_data['resource']);
                        }


                    }


                    if(!empty($json_data['bg_audio']))
                    {
                    	if((is_file($dir.$json_data['bg_audio']))&&(file_exists($dir.$json_data['bg_audio'])))
                    	{
                         	unlink($dir.$json_data['bg_audio']);
                    	}

                    }

                   

                    /*if($dir.$json_data['resource']!=null)
                    {
                        unlink($dir.$json_data['resource']); 

                    }

                    if($dir.$json_data['bg_audio']!=null)
                    {
                       unlink($dir.$json_data['bg_audio']); 

                    }*/

                }elseif($json_data['type']=="Video")
                {
                    //echo "video==".$json_data['resource'];
                    if(!empty($json_data['resource']))
                    {
                        if((is_file($dir.$json_data['resource']))&&(file_exists($dir.$json_data['resource'])))
                        {
                            unlink($dir.$json_data['resource']);
                        }
                    }
                    

                }
                elseif($json_data['type']=="Url")
                {

                   //unlink($dir.$value);
                   $boolean_data=false; 
                   

                }
                /*elseif($json_data['regions'][0]['type']=="text" && $json_data['regions'][0]['properties']['textBgColor']!=null && $json_data['regions'][0]['properties']['textSize']!=null)
                {
                    // && $json_data['regions'][0]['properties']['textBgColor']!=null && $json_data['regions'][0]['properties']['textSize']!=null

                    $boolean_data=false;
                }*/
                elseif($json_data['regions'][0]['type']=="File")
                {
                       // lists.regions[0]['media_name']
                    if(!empty($json_data['regions'][0]['media_name']))
                    {
                        if((is_file($dir.$json_data['regions'][0]['media_name']))&&(file_exists($dir.$json_data['regions'][0]['media_name'])))
                        {
                            unlink($dir.$json_data['regions'][0]['media_name']);
                        }
                    }
                }

                elseif($json_data['type']=="multi_region")
                {
                    foreach ($json_data['regions'] as $key => $value1) {
                        
                            //echo  $value1['type'];

                        if($value1['type']=="Url")
                        {

                            $boolean_data=false;


                        }elseif($value1['type']=="text")
                        {

                            $boolean_data=false;

                        }elseif($value1['type']=="Image")
                        {

                            if(!empty($value1['media_name']) && $value1['media_name']!="default")
                            {
                                $dirs = $dir."Media/CImages/";

                                if((is_file($dirs.$value1['media_name']))&&(file_exists($dirs.$value1['media_name'])))
                                {
                                    unlink($dirs.$value1['media_name']);
                                }
                            }


                        }elseif($value1['type']=="Video")
                        {

                            if(!empty($value1['media_name']) && $value1['media_name']!="default")
                            {
                                if((is_file($dir.$value1['media_name']))&&(file_exists($dir.$value1['media_name'])))
                                {
                                    unlink($dir.$value1['media_name']);
                                }
                            }


                        }

                    }
                    

                }

                

            }

            fclose($myfile);

            if(unlink($dir.$value))
            {
                $boolean_data=true;

            }else 
            {
                $boolean_data=false;

            } 

               

        }


        if($boolean_data==true)
        {
            //echo "File Deleted Successfully";
            echo json_encode(array('statusCode'=>0,'status'=>"File Deleted Successfully"));

        }else 
        {
            echo json_encode(array('statusCode'=>1,'status'=>"File Not Deleted"));
        } 

    }



    function get_data()
    {
                    require '..\database.php';
$conn = mysqli_connect($server,$username,$password);
mysqli_select_db($conn,$database);
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

// Open a directory, and read its contents
/*if(is_dir($dir)){	
  if ($dh = opendir($dir)){


    while(($file = readdir($dh)) !== false)
    {

    	if($file!="." && $file!="..")
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
}*/

?>