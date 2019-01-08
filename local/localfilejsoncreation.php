<?php
// require ('../ScreensHelper.php');
require ('..\Constants.php');
  $datas = json_decode($_REQUEST['data'],true);
  $duration = $_REQUEST['duration'];
  $media_name = $_REQUEST['media_name'];
  $offer_text= $_REQUEST['offer_text'];
 $path = json_decode($_REQUEST['path'],true);


 
  $inputResult = array('type'=>'multi_region','regions'=>$datas,'offer_text'=>$offer_text,'display_scroll_txt'=>false,'duration'=>(int)$duration);


  //assigning values to array
  
  $insData = json_decode($_REQUEST['data1'],true);


  
  
  

  
  get_data($media_name,$inputResult);


  
  
  function get_data($media_name,$inputResult)
  {
    
    $directory = copy_campaign_temp_loc.$media_name."/";

        
    if(!file_exists ($directory))
                 {
                
                   $isCreatedNewDir = mkdir($directory,0777, true);

                 }

          
          try{

      
      if(isset($_FILES["fileName"]['name']))
      {
    $info = pathinfo($_FILES['fileName']['name']);
    $ext = $info['extension']; 
    $newname = "DNDM-".$GLOBALS['media_name'].".".$ext; 

    // $newname = $GLOBALS['data'][$arrayPosition]['media_name']; 

    $target_file = $directory.$newname;

    $src = $_FILES['fileName']['tmp_name'];


        // if(!file_exists (copy_resource_temp_loc))
        //          {
                
        //            $isCreatedNewDir = mkdir(copy_resource_temp_loc,0777, true);
        //          }


                 $tempFile = $directory.$newname;

                  $isCopied = copy($src, $tempFile ); 
          
                 rename($tempFile, $target_file);
 
    
    
  }

  //txt file creation
    $file_name = $GLOBALS['media_name'].'.txt';

    file_put_contents($directory.$file_name, json_encode($inputResult));
   
            



        }catch(Exception $e){
            echo 'Inside exception in pushing';
           
          }

     
       echo "New record created successfully";


  }
  
  
  
?>