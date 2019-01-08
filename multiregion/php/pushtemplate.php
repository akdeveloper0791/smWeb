<?php
require ('..\..\ScreensHelper.php');
require ('..\..\Constants.php');
  
  $data=array();


  $regionsCount = $_REQUEST['regions_count'];
 
  //preapare regions data array
  for ($i=1; $i <= ($regionsCount) ; $i++) { 
    # code...
    array_push($data,json_decode($_REQUEST['data'.$i],true)); 
  }


  $path = json_decode($_REQUEST['path'],true);

  // echo $path;
  // echo print_r($path);
   
   $isCreateTemp = (count($path)>=2 ? true:false);

  $media_name = $_REQUEST['media_name'];
  $offer_text = $_REQUEST['offer_text'];
  $duration = $_REQUEST['duration'];

  $videodurationfileName1 = $_REQUEST['videodurationfileName1'];
  $videodurationfileName2 = $_REQUEST['videodurationfileName2'];
  $imagedurationfileName1 = $_REQUEST['imagedurationfileName1'];
  $imagedurationfileName2 = $_REQUEST['imagedurationfileName2'];
  
  /*$data=array();
  array_push($data,$data1);    
  array_push($data,$data2);*/


  $inputResult = array('type'=>'multi_region','regions'=>$data,'offer_text'=>$offer_text,'display_scroll_txt'=>false,'duration'=>(int)$duration);

  
 get_data($inputResult);

  
  function get_data($inputResult)
  {
    
    
    require '..\..\database.php';
        $conn = mysqli_connect($server,$username,$password);
            mysqli_select_db($conn,$database);


   
    $screen=$GLOBALS['path'];  

    $list = implode(',', $screen); 
   
      //$channelsQuery = "SELECT path,ip from screens where ch_id = ".$screen; 

      $channelsQuery = "SELECT path,ip from screens where ch_id IN ($list) "; 

     // $result=mysqli_query($link,"select ip,name from screens where ch_id IN ($list)");

       $id = $conn->insert_id;

       $result = $conn->query($channelsQuery);

       if ($result->num_rows > 0) {

        
        while($row = $result->fetch_assoc()) 
        {
          $directory = $row['path'];
          $ip = $row['ip'];
          //echo $directory;
           // echo $ip;
          try{

        if(pingScreen($ip))
          {
      
   
         //video file creation
          for ($i=1; $i <= $GLOBALS['regionsCount']; $i++) { 
            # code...
            if(isset($_FILES["fileName".$i]['name']))
            { 

              

                  $info = pathinfo($_FILES["fileName".$i]['name']);
                  $ext = $info['extension']; 
                 $arrayPosition = $i-1;

                 $newname = $GLOBALS['data'][$arrayPosition]['media_name']; 
              
                 $target_file=$directory.$newname;

                 $src1 = $_FILES["fileName".$i]['tmp_name'];
         
                 if(!file_exists (copy_resource_temp_loc))
                 {
                
                   $isCreatedNewDir = mkdir(copy_resource_temp_loc,0777, true);
                 }


                 $tempFile = copy_resource_temp_loc.$newname;

                  $isCopied = copy($src1, $tempFile ); 
          
                 rename($tempFile, $target_file);

      
 
            }
             //image
            else if(isset($_FILES["imagefileName".$i]['name']))
            {
               $info = pathinfo($_FILES["imagefileName".$i]['name']);
               $ext = $info['extension']; 
               
                $arrayPosition = $i-1;

               $newname = $GLOBALS['data'][$arrayPosition]['media_name']; 

              $directory1= $directory."Media/CImages/";
    
              if (!file_exists($directory1)) {
                 mkdir($directory1, 0777, true);
               }

                $src1 = $_FILES["imagefileName".$i]['tmp_name'];

                if(!file_exists (copy_resource_temp_loc))
                 {
                
                   $isCreatedNewDir = mkdir(copy_resource_temp_loc,0777, true);
                 }

                 

                 $tempFile = copy_resource_temp_loc.$newname;

                  $isCopied = copy($src1, $tempFile); 
          
                 rename($tempFile, $directory1.$newname);

            }

          }
           



      //txt file creation
       $file_name = $GLOBALS['media_name'].'.txt';

       file_put_contents($directory.$file_name, json_encode($inputResult));
    //file_put_contents("../json/video/".$file_name, json_encode($insData));
           }  


          }catch(Exception $e){
            echo 'Inside exception in pushing';
             //echo $e->getMessage();
          }

        }//end while



       }

       echo "New record created successfully";
        
      // } else 
      // {
      //   echo "Error: " . $sql . "<br>" . $conn->error;
      // }

      // $conn->close();
    
  }
  
  
  
?>