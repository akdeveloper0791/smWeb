
	<?php 

		$ipAddress = $_REQUEST['ip_address'];
		$audio_name = $_REQUEST['audio_name'];
		
 	    //$files = json_decode($_REQUEST['files'],true);

		if(isset($_FILES["AudiofileName"]['name']))
		{
			$audio_info = pathinfo($_FILES["AudiofileName"]['name']);
			$audio_ext = $audio_info['extension']; 
			//$newname = $_FILES["AudiofileName"]['name'].".".$audio_ext;

			$directory = "../json/audio/";

			$target_file = $directory.$_FILES["AudiofileName"]['name'];

		    //$src = $_FILES['AudiofileName']['tmp_name'];

		    $cur_dir = dirname(getcwd());
			$cur_dir = str_replace('enterprise','',$cur_dir);
			$cur_dir = str_replace('\\','/',$cur_dir);

		    if(rename($_FILES['AudiofileName']['tmp_name'],$target_file))
		    {
		    	echo json_encode(array('statusCode'=>0,'status'=>'Media Updated Successfully','path'=>$cur_dir.'/json/audio/'.$_FILES["AudiofileName"]['name'],'fileName'=>$_FILES["AudiofileName"]['name']));

		    }else 
		    {
		    	echo json_encode(array('statusCode'=>2,'status'=>'Media Not Updated'));

		    }
    	
			/*if(!file_exists (copy_resource_temp_loc))
            {  
                $isCreatedNewDir = mkdir(copy_resource_temp_loc,0777, true);
            }


            $tempFile = copy_resource_temp_loc.$newname;

            $isCopied = copy($src, $tempFile ); 
          
            rename($tempFile,$directory.$newname);*/
		
		}


	?>