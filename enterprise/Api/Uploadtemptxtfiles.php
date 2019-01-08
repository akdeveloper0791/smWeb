<?php

	$datas = json_decode($_REQUEST['data'],true);

	//$media_name = $_REQUEST['fileName'];

  	$duration = $_REQUEST['duration'];
  	$media_names = $_REQUEST['media_name'];
 	$offer_text= $_REQUEST['offer_text'];
  	$path = $_REQUEST['path'];

  	$type = $_REQUEST['type'];


  	if($type=="multiregion")
  	{
  		$datas['offer_text'] = $offer_text;
  	    $datas['duration'] = $duration;

  	}elseif($type=="Url")
  	{

  		$datas = $datas;

  	}elseif($type=="Image")
  	{
  		//$is_skip = $_REQUEST['is_skip'];
  		$datas = $datas;

  	}elseif($type=="Video")
  	{
  		$is_skip = $_REQUEST['is_skip'];
  		$datas = $datas;

  	}elseif($type=="File")
  	{
  		$insData = json_decode($_REQUEST['data1'],true);
  		$is_skip = $_REQUEST['is_skip'];

  		$datas = array('type'=>'multi_region','regions'=>$datas,'offer_text'=>$offer_text,'display_scroll_txt'=>false,'duration'=>(int)$duration,'is_skip'=>$is_skip);

  	}

  	
	//$path = $_REQUEST['path'];

	//$inputResult = json_decode($_REQUEST['data'],true);
	//$inputResult['media_name'] = $media_name;

	// print_r($datas);

	if($media_names!=null)
	{
		 //$file_name = $media_name.'.txt';
		$file_name = $media_names;

		$directory = "../../json/tmp/";

		 //$directory = "Z:/";

		//$directory = get_data();

		$cur_dir = dirname(getcwd());
		$cur_dir = str_replace('enterprise','',$cur_dir);
		$cur_dir = str_replace('\\','/',$cur_dir);

		if(file_put_contents($directory.$file_name,json_encode($datas)))
		{
			echo json_encode(array('statusCode'=>0,'status'=>'Media Updated Successfully','path'=>$cur_dir."json/tmp/".$file_name));

		}else
		{
			echo json_encode(array('statusCode'=>2,'status'=>'Media Not Updated'));

		}

	}else{

		echo json_encode(array('statusCode'=>1,'status'=>'Invalid file'));
	}

	
?>