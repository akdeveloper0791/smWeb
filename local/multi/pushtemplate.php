<?php
// require ('..\..\ScreensHelper.php');
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

  //echo "asdasdasd".$media_name;
  get_data($media_name,$inputResult);
  
  
  
  function get_data($media_name,$inputResult)
  {
    
    $directory = copy_campaign_temp_loc.$media_name."/";

     
    if(!file_exists ($directory))
                 {
                
                   $isCreatedNewDir = mkdir($directory,0777, true);

                 }
   
          try{
      
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
         
                 // if(!file_exists (copy_resource_temp_loc))
                 // {
                
                 //   $isCreatedNewDir = mkdir(copy_resource_temp_loc,0777, true);
                 // }


                 $tempFile = $directory.$newname;

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

              // $directory1= $directory."Media/CImages/";
    
              // if (!file_exists($directory1)) {
              //    mkdir($directory1, 0777, true);
              //  }

                $src1 = $_FILES["imagefileName".$i]['tmp_name'];

                // if(!file_exists (copy_resource_temp_loc))
                //  {
                
                //    $isCreatedNewDir = mkdir(copy_resource_temp_loc,0777, true);
                //  }

                 

                 $tempFile = $directory.$newname;

                  $isCopied = copy($src1, $tempFile); 
          
                 rename($tempFile, $directory.$newname);

            }

          }
           



      //txt file creation
       $file_name = $GLOBALS['media_name'].'.txt';

       file_put_contents($directory.$file_name, json_encode($inputResult));
    //file_put_contents("../json/video/".$file_name, json_encode($insData));
           // }  


          }catch(Exception $e){
            echo 'Inside exception in pushing';
             //echo $e->getMessage();
          }

       echo "New record created successfully";

    
  }
  
  
  
?>