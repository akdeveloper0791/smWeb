<?php
// require ('../ScreensHelper.php');
require ('..\Constants.php');
	$datas = json_decode($_REQUEST['data'],true);

	$text = $_REQUEST['text'];
	$file_name = $_REQUEST['file_name'];
	 $path = json_decode($_REQUEST['path'],true);
	$offer_text = $_REQUEST['offer_text'];
	$duration = $_REQUEST['duration'];

	$inputtable['text'] = $text;
	$inputtable['name'] = $file_name;
	$inputtable['path'] = $path;


	$inputResult = json_encode(array('type'=>'multi_region','regions'=>$datas,'offer_text'=>$offer_text,'display_scroll_txt'=>false,'duration'=>(int)$duration));

	//echo "asdfasda".$file_name;
	get_data($file_name,$inputResult);
	
	
	
	function get_data($media_name,$inputResult)
	{
		
		 $directory = copy_campaign_temp_loc.$media_name."/";

        
    if(!file_exists ($directory))
                 {
                
                   $isCreatedNewDir = mkdir($directory,0777, true);

                 }

			
          try{

    

				$file_name1 = $GLOBALS['file_name'].'.txt';

					file_put_contents($directory.$file_name1, $inputResult);
		


          }catch(Exception $e){
            echo 'Inside exception in pushing';
             //echo $e->getMessage();
          }

   

       echo "New record created successfully";

	
		
	}
	
	
?>