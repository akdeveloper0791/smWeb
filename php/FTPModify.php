<?php
require ('..\Constants.php');
session_start();

require '../database.php';
$link=mysqli_connect($server,$username,$password);
mysqli_select_db($link,$database);
if( isset($_SESSION['user_id']) ){

  $records = $conn->prepare('SELECT id,email,password FROM users WHERE id = :id');
  $records->bindParam(':id', $_SESSION['user_id']);
  $records->execute();
  $results = $records->fetch(PDO::FETCH_ASSOC);

  $user = NULL;

  if( count($results) > 0){
    $user = $results;
  }

}


?>


<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel='shortcut icon' type='image/x-icon' href='../images/signage.ico' />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="generator" content="">
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">

<link href="../css/style.css" rel="stylesheet">
<!-- <link href="../css/w3.css" rel="stylesheet"> -->
<script src="../js/sweetalert.js"></script>
<link rel="stylesheet" href="../js/sweetalert.css">
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/default_busy_loader.js"></script>
<link href="../_css/Icomoon/style.css" rel="stylesheet" type="text/css" />
<script src="../js/js/popper.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Roboto:200,300,400,500,600,700" rel="stylesheet">



<style type="text/css">

      
        .video-preview-input {
          position: relative;
          overflow: hidden;
          margin: 0px;    
          color: #333;
          background-color: #fff;
          border-color: #ccc;    
        }
        
        .video-preview-input input[type=file] {
          position: absolute;
          top: 0;
          right: 0;
          margin: 0;
          padding: 0;
          font-size: 20px;
          background-color: #fff;
          cursor: pointer;
          opacity: 0;
          filter: alpha(opacity=0);
        }
        
        .video-preview-input-title {
          margin-left:2px;
        }


        .image-preview-input {
          position: relative;
          overflow: hidden;
          margin: 0px;    
          color: #333;
          background-color: #fff;
          border-color: #ccc;    
        }
        
        .image-preview-input input[type=file] {
          position: absolute;
          top: 0;
          right: 0;
          margin: 0;
          padding: 0;
          font-size: 20px;
          background-color: #fff;
          cursor: pointer;
          opacity: 0;
          filter: alpha(opacity=0);
        }
        
        .image-preview-input-title {
          margin-left:2px;
        }
        img{
          text-align: center;
        }
      
      

      	//toggle buttons
      	.anil_nepal{width:60%;}
		.switch {
		    position: relative;
		    display: inline-block;
		    vertical-align: top;
		    width: 100px;
		    height: 30px;
		    padding: 3px;
		    margin: 0 10px 10px 0;
		    background: linear-gradient(to bottom, #eeeeee, #FFFFFF 25px);
		    background-image: -webkit-linear-gradient(top, #eeeeee, #FFFFFF 25px);
		    border-radius: 18px;
		    box-shadow: inset 0 -1px white, inset 0 1px 1px rgba(0, 0, 0, 0.05);
		    cursor: pointer;
		    box-sizing: content-box;
		}
		label {
		    font-weight: inherit;
		}
		input[type=checkbox], input[type=radio] {
		    margin: 4px 0 0;

		    line-height: normal;
		      -webkit-box-sizing: border-box;
		    -moz-box-sizing: border-box;
		    box-sizing: border-box;
		    padding: 0;
		}


		.switch-input {
		    position: absolute;
		    top: 0;
		    left: 0;
		    opacity: 0;
		    box-sizing: content-box;
		}
		.switch-left-right .switch-input:checked ~ .switch-label {
		    background: inherit;
		}
		.switch-input:checked ~ .switch-label {
		    background: #E1B42B;
		    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.15), inset 0 0 3px rgba(0, 0, 0, 0.2);
		}
		.switch-left-right .switch-label {
		    overflow: hidden;
		}
		.switch-label, .switch-handle {
		    transition: All 0.3s ease;
		    -webkit-transition: All 0.3s ease;
		    -moz-transition: All 0.3s ease;
		    -o-transition: All 0.3s ease;
		}
		.switch-label {
		    position: relative;
		    display: block;
		    height: inherit;
		    font-size: 10px;
		    text-transform: uppercase;
		    background: #eceeef;
		    border-radius: inherit;
		    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.12), inset 0 0 2px rgba(0, 0, 0, 0.15);
		    box-sizing: content-box;
		}
		.switch-left-right .switch-input:checked ~ .switch-label:before {
		    opacity: 1;
		    left: 100px;
		}
		.switch-input:checked ~ .switch-label:before {
		    opacity: 0;
		}
		.switch-left-right .switch-label:before {
		    background: #eceeef;
		    text-align: left;
		    padding-left: 80px!important;
		}
		.switch-left-right .switch-label:before, .switch-left-right .switch-label:after {
		    width: 20px;
		    height: 20px;
		    top: 4px;
		    left: 0;
		    right: 0;
		    bottom: 0;
		    padding: 11px 0 0 0;
		    text-indent: -12px;
		    border-radius: 20px;
		    box-shadow: inset 0 1px 4px rgba(0, 0, 0, 0.2), inset 0 0 3px rgba(0, 0, 0, 0.1);
		}
		.switch-label:before {
		    content: attr(data-off);
		    right: 11px;
		    color: #aaaaaa;
		    text-shadow: 0 1px rgba(255, 255, 255, 0.5);
		}

		span.switch-label:after {
		    content: attr(data-on);
		    left: 11px;
		    color: #FFFFFF;
		    text-shadow: 0 1px rgba(0, 0, 0, 0.2);
		    position: absolute;
		  
		}

		.switch-label:before, .switch-label:after {
		    position: absolute;
		    top: 50%;
		    margin-top: -5px;
		    line-height: 1;
		    -webkit-transition: inherit;
		    -moz-transition: inherit;
		    -o-transition: inherit;
		    transition: inherit;
		    box-sizing: content-box;
		}

		.switch-left-right .switch-input:checked ~ .switch-label:after {
		    left: 0!important;
		    opacity: 1;
		    padding-left: 20px;
		}


		.switch-input:checked ~ .switch-label:after {
		    opacity: 1;
		}


		.switch-left-right .switch-label:after {
		    text-align: left;
		    text-indent: 9px;
		    /*background: #FF7F50!important;*/
		    background: #42abec!important;
		    left: -100px!important;
		    opacity: 1;
		    width: 100%!important;
		 
		}
		.switch-left-right .switch-label:before, .switch-left-right .switch-label:after {
		    width: 20px;
		    height: 20px;
		    top: 4px;
		    left: 0;
		    right: 0;
		    bottom: 0;
		    padding: 11px 0 0 0;
		    text-indent: -12px;
		    border-radius: 20px;
		    box-shadow: inset 0 1px 4px rgba(0, 0, 0, 0.2), inset 0 0 3px rgba(0, 0, 0, 0.1);
		}
		.switch-input:checked ~ .switch-handle {
		    left: 74px;
		    box-shadow: -1px 1px 5px rgba(0, 0, 0, 0.2);
		}
		.switch-label, .switch-handle {
		    transition: All 0.3s ease;
		    -webkit-transition: All 0.3s ease;
		    -moz-transition: All 0.3s ease;
		    -o-transition: All 0.3s ease;
		}

		.switch-handle {
		    position: absolute;
		    top: 4px;
		    left: 4px;
		    width: 28px;
		    height: 28px;
		    background: linear-gradient(to bottom, #FFFFFF 40%, #f0f0f0);
		    background-image: -webkit-linear-gradient(top, #FFFFFF 40%, #f0f0f0);
		    border-radius: 100%;
		    box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.2);
		}

		.switch-handle:before {
		    content: "";
		    position: absolute;
		    top: 50%;
		    left: 50%;
		    margin: -6px 0 0 -6px;
		    width: 12px;
		    height: 12px;
		    background: linear-gradient(to bottom, #eeeeee, #FFFFFF);
		    background-image: -webkit-linear-gradient(top, #eeeeee, #FFFFFF);
		    border-radius: 6px;
		    box-shadow: inset 0 1px rgba(0, 0, 0, 0.02);
		}

    
</style>
</head>
<body>

<!-- HEADER =============================-->
<header class="item header margin-top-0">
<div class="wrapper">
  <nav role="navigation" class="navbar navbar-white navbar-embossed navbar-lg navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button data-target="#navbar-collapse-02" data-toggle="collapse" class="navbar-toggle" type="button">
      <i class="fa fa-bars"></i>
      <span class="sr-only">Toggle navigation</span>
      </button>
      <a href="../index.php" class="navbar-brand brand" style="
    display: inline-flex;
"> <img src="../images/signage.png" alt="" class="logo" style="
    width: 32px;
    height:  32px;margin: 0 10px;
">Signage Manager </a>
    </div>
    <div id="navbar-collapse-02" class="collapse navbar-collapse">
      <ul class="nav navbar-nav navbar-right">
          <li id="propClone" class="propClone"><a href="../index.php"><span class='icon-home'></span></a></li>
          <li class="propClone" id="logout"><a href="../logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
  </nav>

  <?php if( !empty($user) ): ?>
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center">
        <!-- <div class="text-pageheader">
          <div class="subtext-image" data-scrollreveal="enter bottom over 1.7s after 0.1s" >
            <h2><span style="color: orange;"><?= $user['email']; ?></span></h2>
          </div>
        </div> -->
      </div>
    </div>
  </div>
</div>
</header>

  <?php else: ?>
 <br/><br/><br/><br/><br/><br/><br/>
  <center>
  <div style="height: 20%;">

    <h1 style="color:white;text-align: center;">Please <a href="index.php">Login</a> 
    </h1>

</div>
</center>

 	<script type="text/javascript">
       $('#propClone').hide(); 
       $('#logout').hide(); 
    </script>
  <?php endif; ?>

 <br/><br/><br/><br/>


 <div class="container">
 	<div class ="row">
 		<div class="col-md-12" style="height:400px;overflow-y: auto">

 			<div id="ftp_modify_list_display"></div>

 		</div>
 	</div>
 </div>


 <!-- Modify URL -->
  <div class="modal" id="ModifyURL">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" style="text-align:center;">Modify URL
          <span type="button" class="close" data-dismiss="modal" onclick="$('#ModifyURL').hide();">&times;</span></h4>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" >
			<div class="form-group">
                <label for="modify_url">URL :</label>
                    <input type="text" class="form-control" placeholder="Enter url address like https://www.example.com " name="modify_url" id="modify_url" focus>
            </div>

           	<div class="form-group">
                <label for="modify_media_name">Media Name :</label>
                    <input type="text" class="form-control" placeholder="Enter Media Name" name="modify_media_name" id="modify_media_name" disabled>
                       
            </div>

            <div class="form-group">
                <label for="modify_duration">Duration in Second(s) :</label>
                    <input type="number" class="form-control" placeholder="Enter Duration(Sec)" name="modify_duration" id="modify_duration">
            </div>  

            <div class="form-group">
                <label for="modify_text_media">Text for Media :</label>
                    <input type="text" class="form-control" placeholder="Enter Text for Media" name="modify_text_media" id="modify_text_media">
            </div>

          	<input type="hidden" name="modify_url_channel" id="modify_url_channel">
          	<input type="hidden" name="modify_url_is_skip" id="modify_url_is_skip" value=false>

        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <center>
            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#ModifyURL').hide();">Close</button>
		        <button type="button" class="btn btn-success" onclick="ModifyDisplaySubmit('Url');">Submit</button>
          </center>
        </div>
        
      </div>
    </div>
  </div>


  <!-- Modify Image -->
  <div class="modal" id="ModifyImage">
    <div class="modal-dialog modal-lg" >
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" style="text-align:center;">Modify Image
          <span type="button" class="close" data-dismiss="modal" onclick="$('#ModifyImage').hide();">&times;</span></h4>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" >
         
			<div class="form-group">
                <label for="modify_image_media_name">Media Name:</label>
                <input type="text" class="form-control" placeholder="Enter Media Name" name="modify_image_media_name" id="modify_image_media_name" readonly>
                       
            </div>

            <div class="form-group">
                <label for="modify_image_text_media">Scrolling Text :</label>
                <input type="text" class="form-control"  placeholder="Enter Scrolling Text that will be displayed on the bottom of the Screen" name="modify_image_text_media" id="modify_image_text_media"  >

                <!-- onkeyup="ModifyonkeyValuepressImage()" -->
            </div>

            <div class="form-group" style="display: none;">
                <label id="modify_media_checkbox_label_image" ><input type="checkbox" id="modify_media_checkbox_image" ></label>
            </div>

            <div class="form-group">
                <label for="modify_image_duration">Play Duration :</label>
                <input type="number" class="form-control" placeholder="Enter Duration in Second(s)" name="modify_image_duration" id="modify_image_duration">
            </div>

			<!-- <div class="checkbox">
                <label id="modify_play_audio_checkbox_label_image" onclick="ModifyCheckUncheck()"><input type="checkbox" id="modify_play_audio_checkbox_image" >  Play Audio with Media</label>
            </div> -->


            <input type="hidden" id="modify_image_resource">

			     <input type="hidden" id="modify_bg_audio_name">
			     <input type="hidden" id="modify_bg_audio_boolean">
                  
            <!--<div class="form-group" id="modify_audio_record_block" style="display:none;">
                 
                    
                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 col-12 text-center modify_audio_image_preview" >
                      
                    <label class="btn btn-primary"><span class="icon-music"><input type="file" name="modify_input-file-audio-preview" accept="audio/*"style="display:none;"/>     Attach Audio File</span></label><br>
                    <p id="modify_assign_name_to_audio"></p>
					
                
                      
                </div>      
            </div> -->
            
            	<input type="hidden" name="modify_image_channel" id="modify_image_channel">

            	<input type="hidden" name="modify_image_is_skip" id="modify_image_is_skip" value=false>

            	<input type="hidden" name="modify_image_josnformat" id="modify_image_josnformat">

         
		 <br><br>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <center>
           <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#ModifyImage').hide();">Close</button>
		   <button type="button" class="btn btn-success" onclick="ModifyImageDisplaySubmit('Image');">Submit</button></center>
        </div>
        
      </div>
    </div>
  </div>


  <!-- Modify Video -->
  <div class="modal" id="ModifyVideo">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" style="text-align:center;">Modify Video
          <span type="button" class="close" data-dismiss="modal" onclick="$('#ModifyVideo').hide();">&times;</span></h4>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" >
			<div class="form-group">
                <label for="modify_video_media_name">Media Name:</label>
                <input type="text" class="form-control" placeholder="Enter Media Name" name="modify_video_media_name" id="modify_video_media_name" readonly>          
            </div>

            <div class="form-group">
                <label for="modify_video_text_media">Scrolling Text :</label>
                <input type="text" class="form-control" placeholder="Enter Scrolling Text that will be displayed on the bottom of the Screen" name="modify_video_text_media" id="modify_video_text_media" >

               <!--  onkeyup="onkeyValuepress()" -->
            </div>

            <div class="checkbox" style="display:none;">
               <label id="modify_video_media_checkbox_label">
               <input type="checkbox" id="modify_video_media_checkbox"  ></label>
            </div>

            	<input type="hidden" id="modify_video_resource">

            	<input type="hidden" name="modify_video_channel" id="modify_video_channel">

            	<input type="hidden" name="modify_video_is_skip" id="modify_video_is_skip" value=false>

            	<input type="hidden" class="form-control" name="modify_video_duration" id="modify_video_duration">
		 
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <center>
           <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#ModifyVideo').hide();">Close</button>
		   <button type="button" class="btn btn-success" onclick="ModifyVideoDisplaySubmit('Video');">Submit</button></center>
        </div>
        
      </div>
    </div>
  </div>


   <!-- Modify pdf/excel Files -->
  <div class="modal" id="Modify_Files">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" style="text-align:center;">Modify Files
          <span type="button" class="close" data-dismiss="modal" onclick="$('#Modify_Files').hide();">&times;</span></h4>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style="height:300px;overflow-y: auto">
            <div class="form-group">
                <label for="modify_files_media_name">Media Name:</label>
                <input type="text" class="form-control" placeholder="Enter Media Name" name="modify_files_media_name" id="modify_files_media_name" readonly>          
            </div>

            <div class="form-group">
                <label for="modify_files_text_media">Scrolling Text :</label>
                <input type="text" class="form-control" placeholder="Enter Scrolling Text that will be displayed on the bottom of the Screen" name="modify_files_text_media" id="modify_files_text_media" >

               <!--  onkeyup="onkeyValuepress()" -->
            </div>

            <div class="form-group">
                <label for="exampleInputPassword2">Duration in Second(s) : </label>
                <input type="number" class="form-control" placeholder="Enter Duration(Sec)" name="modify_files_duration" id="modify_files_duration">
                <!-- <p>Default Duration:10s</p> -->
            </div> 

            <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1" id='exampleInputEmail1'>Zoom Level : </label>
                    <input type="number" class="form-control" placeholder="Enter in digits" name="modify_files_zoomLevel" id="modify_files_zoomLevel">
                  </div>
                  
                  <label><input type="checkbox" name="modify_files_fitscreen" id="modify_files_fitscreen" onclick="fitscreen();">  Fit to Screen</label>

                </div>


                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputPassword2">Scrolling Speed :</label>
                    <input type="number" class="form-control" placeholder="Enter Scrolling Speed Duration in Second(s)" name="modify_files_scrollingSpeed" id="modify_files_scrollingSpeed">
                    <!--     <input type="tel" class="form-control" value="10" placeholder="Enter Scrolling Speed Duration in Second(s)" name="scrollingSpeed" id="scrollingSpeed" maxlength="2"> -->
                  </div>
                </div>

            </div>

             <!-- <input type="hidden" id="modify_files_file_name">  -->

             <input type="hidden" name="modify_files_channel" id="modify_files_channel">

             <input type="hidden" name="modify_file_is_skip" id="modify_file_is_skip" value=false>

             <input type="hidden" name="modify_file_resource_media" id="modify_file_resource_media" value=false>
     
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <center>
           <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#Modify_Files').hide();">Close</button>
           <button type="button" class="btn btn-success" onclick="Modify_FilesDisplaySubmit('File');">Submit</button></center>
        </div>
        
      </div>
    </div>
  </div>


<!--Start FTP Multi Region Modify Popup -->
  <div class="modal" id="ModifyMultiRegion">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" style="text-align:center;">Multi Region
          <span type="button" class="close" data-dismiss="modal" onclick="$('#ModifyMultiRegion').hide();">&times;</span></h4>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" >
           <!-- <div class="form-group">
                <label for="modify_url">URL :</label>
                    <input type="text" class="form-control" placeholder="Enter url address like https://www.example.com " name="modify_url" id="modify_url" focus>
            </div> -->

            <div class="form-group">
                <label for="modify_multiregion_media_name">Media Name :</label>
                    <input type="text" class="form-control" placeholder="Enter Media Name" name="modify_multiregion_media_name" id="modify_multiregion_media_name" disabled>
                       
            </div>

            <div class="form-group">
                <label for="modify_multiregion_duration">Duration in Second(s) :</label>
                    <input type="number" class="form-control" placeholder="Enter Duration(Sec)" name="modify_multiregion_duration" id="modify_multiregion_duration">
            </div>  

            <div class="form-group">
                <label for="modify_multiregion_text_media">Text for Media :</label>
                    <input type="text" class="form-control" placeholder="Enter Text for Media" name="modify_multiregion_text_media" id="modify_multiregion_text_media">
            </div>

            <input type="hidden" name="modify_multiregion_channel" id="modify_multiregion_channel">

            <input type="hidden" class="form-control" name="modify_multiregion_josnformat" id="modify_multiregion_josnformat">

        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <center>
            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#ModifyMultiRegion').hide();">Close</button>
            <button type="button" class="btn btn-success" onclick="ModifyMultiRegionDisplaySubmit('multiregion');">Submit</button>
          </center>
        </div>
        
      </div>
    </div>
  </div>
<!--End FTP Multi Region Modify Popup -->



<!-- FOOTER =============================-->
<div class="footer" style='position:fixed;left: 0;
   bottom: 0;
   width: 100%;
   text-align: center;'>
<div class="container">
  <div class="row">
    <p>
      Copyright (c) 2018 SignageServ, All Rights Reserved. Powered by AdsKite India Pvt. Ltd.
    </p>
  </div>
</div>
</div>




<script>
	 	var screen_name = <?php echo $_REQUEST['screen']; ?>;
   		var screen_mode = <?php echo $_REQUEST['mode']; ?>;
   		//var indexpos = 0;

   		var GlobalRecordsList=[];

   		console.log("screen_name==" + screen_name +"==="+ screen_mode );

   		function FTPModifyRequestFile(indexpos)
   		{
   			console.log("indexpos=="+indexpos);

   		    ajaxindicatorstart("<img src='../images/ajax-loader.gif'><br/> Please wait...!");
          
          	var form_data = new FormData();                 
              form_data.append('ip_address',screen_name);
              form_data.append('index',indexpos);

                $.ajax({
                	type: "POST",
                	dataType: 'text',
                  	url: "/smweb/enterprise/Api/modify/SendModifyRequestFile.php",
                  	cache: false,
                  	contentType: false,
                  	processData: false,
                  	data: form_data,                         
                  	type: 'post',
                 
                 	success: function(data){
                  		console.log(data);
                    	ajaxindicatorstop();

                   try
                   {

                    var jsonResponse = JSON.parse(data);
                    
                    if(jsonResponse.statusCode==0)
                    {
                      
                      var gotindexvalue = jsonResponse.index;
                      var gotResponseFile = jsonResponse.response_file;

                      console.log(gotindexvalue+"==="+gotResponseFile);

                      getFTPModifyRequestFileList(gotindexvalue,gotResponseFile);

                    }else if(jsonResponse.statusCode==99)
                    {
                       swal(jsonResponse.status);
                    }
                    else if(jsonResponse.statusCode==100)
                    {
                       swal(jsonResponse.status);
                    }else if(jsonResponse.statusCode==101)
                    {
                       swal(jsonResponse.status);
                    }

                   }catch(Exception)
                   {
                    alert('Dear user, Unable to push content please try again');
                   } 

                  }
                });
   		}


   		function getFTPModifyRequestFileList(gotindexvalue,gotResponseFile)
   		{
   			console.log("gotindexvalue=="+gotindexvalue);

   		    ajaxindicatorstart("<img src='../images/ajax-loader.gif'><br/> Please wait...!");
          
          	var form_data = new FormData();                 
              form_data.append('ip_address',screen_name);
              form_data.append('index',gotindexvalue);
              form_data.append('response_file',gotResponseFile);

                $.ajax({
                	type: "POST",
                	dataType: 'text',
                  	url: "/smweb/enterprise/Api/modify/ProcessResponseFile.php",
                  	cache: false,
                  	contentType: false,
                  	processData: false,
                  	data: form_data,                         
                  	type: 'post',
                 
                 	success: function(data){
                  		console.log(data);
                    	ajaxindicatorstop();

                   try
                   {

                    var jsonResponse = JSON.parse(data);
                    
                    if(jsonResponse.statusCode==1)
                    {

                    	if(jsonResponse.query_again==true)
                    	{
                    		//GlobalRecordsList.push(jsonResponse.filesArray);

                    		//console.log(GlobalRecordsList.length+"==="+JSON.stringify(GlobalRecordsList));
                    		//next_index

                    		//FTPModifyRequestFile(jsonResponse.next_index);

                    		displayFTPFilesList(jsonResponse.next_index,jsonResponse.query_again,jsonResponse.filesArray);

                    	}else if(jsonResponse.query_again==false)
                    	{
                    		//GlobalRecordsList.push(jsonResponse.filesArray);
                    		//displaylist filesArray
                    		displayFTPFilesList(undefined,jsonResponse.query_again,jsonResponse.filesArray);

                    		//console.log(GlobalRecordsList.length+"==="+JSON.stringify(GlobalRecordsList));

                    	}                    

                    }else if(jsonResponse.statusCode==99)
                    {
                       swal(jsonResponse.status);
                    }
                    else if(jsonResponse.statusCode==100)
                    {
                       swal(jsonResponse.status);
                    }
                    else if(jsonResponse.statusCode==101)
                    {
                       swal(jsonResponse.status);
                    }else if(jsonResponse.statusCode==4)
                    {
                      //displayFTPFilesList(GlobalRecordsList);
                      swal(jsonResponse.status);
                    }else
                    {
                      swal(jsonResponse.status);
                    }

                   }catch(Exception)
                   {
                    alert('Dear user, Unable to push content please try again');
                   } 

                  }
                });

   		}

   		function displayFTPFilesList(indexpos,query_again,filesArray)
   		{
   			var totalen = filesArray.length;

   			console.log("totalen---"+totalen);

   			if(query_again==true)
   			{

   				for(var i=0;i<totalen;i++)
   	 			{
	   	 			var record = filesArray[i];

	   	 			console.log(record.media_name);
	   	 			//onclick='ReadFileContent(\""+record.media_name+"\",\""+Channel_Channel+"\");'

	   	 			var newRows = "<div id='modifylist_"+i+"' style='border:1px solid orange;border-radius:5px;margin-bottom:5px;padding: 10px;'>";

					   if(record.is_skip==true)
	   	 				{
	   	 					newRows +="<p id='modify_name_"+i+"' style='margin:0px;'>"+getFileName(record.media_name)+"<span id='modify_edit_"+i+"' class='fa fa-pencil-square-o' onclick='ModifyMultiRegionFile(\""+record.media_name+"\",\""+record.media_path+"\",\""+i+"\");' style='float:right;margin-right:10px;padding-top:5px;font-size:20px;'>"+"</span>"+"<span class='anil_nepal' id='modify_is_skip_"+i+"'style='float:right;padding-right:30px;'><label class='switch switch-left-right'><input class='switch-input' type='checkbox' id='is_skip_value_"+i+"' onchange='is_skipMode(this,\""+record.media_path+"\",\""+i+"\");' value='"+i+"' checked>"+"<span class='switch-label' data-on='skip' data-off='skip'></span><span class='switch-handle'></span></label></span>"+"</p>"

	   	 				}else 
	   	 				{
	   	 					newRows +="<p id='modify_name_"+i+"' style='margin:0px;'>"+getFileName(record.media_name)+"<span id='modify_edit_"+i+"' class='fa fa-pencil-square-o' onclick='ModifyMultiRegionFile(\""+record.media_name+"\",\""+record.media_path+"\",\""+i+"\");' style='float:right;margin-right:10px;padding-top:5px;font-size:20px;'>"+"</span>"+"<span class='anil_nepal' id='modify_is_skip_"+i+"'style='float:right;padding-right:30px;'><label class='switch switch-left-right'><input class='switch-input' type='checkbox' id='is_skip_value_"+i+"' onchange='is_skipMode(this,\""+record.media_path+"\",\""+i+"\");' value='"+i+"'>"+"<span class='switch-label' data-on='skip' data-off='skip'></span><span class='switch-handle'></span></label></span>"+"</p>"

	   	 				}

					    newRows +="</div>"

					 $("#ftp_modify_list_display").append(newRows);

   	 			}

   	 			FTPModifyRequestFile(indexpos);

   			}else if(query_again==false)
   			{

   				for(var i=0;i<totalen;i++)
   	 			{
	   	 			var record = filesArray[i];

	   	 			console.log(record.media_name);
	   	 			//onclick='ReadFileContent(\""+record.media_name+"\",\""+Channel_Channel+"\");'

	   	 			var newRows = "<div id='modifylist_"+i+"' style='border:1px solid orange;border-radius:5px;margin-bottom:5px;padding: 10px;'>";

	   	 				if(record.is_skip==true)
	   	 				{
	   	 					newRows +="<p id='modify_name_"+i+"' style='margin:0px;'>"+getFileName(record.media_name)+"<span id='modify_edit_"+i+"' class='fa fa-pencil-square-o' onclick='ModifyMultiRegionFile(\""+record.media_name+"\",\""+record.media_path+"\",\""+i+"\");' style='float:right;margin-right:10px;padding-top:5px;font-size:20px;'>"+"</span>"+"<span class='anil_nepal' id='modify_is_skip_"+i+"'style='float:right;padding-right:30px;'><label class='switch switch-left-right'><input class='switch-input' type='checkbox' id='is_skip_value_"+i+"' onchange='is_skipMode(this,\""+record.media_path+"\",\""+i+"\");' value='"+i+"' checked>"+"<span class='switch-label' data-on='skip' data-off='skip'></span><span class='switch-handle'></span></label></span>"+"</p>"

	   	 				}else 
	   	 				{
	   	 					newRows +="<p id='modify_name_"+i+"' style='margin:0px;'>"+getFileName(record.media_name)+"<span id='modify_edit_"+i+"' class='fa fa-pencil-square-o' onclick='ModifyMultiRegionFile(\""+record.media_name+"\",\""+record.media_path+"\",\""+i+"\");' style='float:right;margin-right:10px;padding-top:5px;font-size:20px;'>"+"</span>"+"<span class='anil_nepal' id='modify_is_skip_"+i+"'style='float:right;padding-right:30px;'><label class='switch switch-left-right'><input class='switch-input' type='checkbox' id='is_skip_value_"+i+"' onchange='is_skipMode(this,\""+record.media_path+"\",\""+i+"\");' value='"+i+"'>"+"<span class='switch-label' data-on='skip' data-off='skip'></span><span class='switch-handle'></span></label></span>"+"</p>"

	   	 				}

					   newRows +="</div>"

					 $("#ftp_modify_list_display").append(newRows);


   	 			}


   			}

   		}

   		function getFileName(val)
		{
			//var res = val.substr(0, val.lastIndexOf('.'));
			//return res;
			if(val!=null)
			{
				return val;
			}
		}


		function is_skipMode(mode,media_pth,indexval)
		{
			if(mode.checked==true)
			{
				console.log("checked buddy");
				isSkipResponse(true,media_pth,indexval);

			}else 
			{
				console.log("un checked buddy");
				isSkipResponse(false,media_pth,indexval);
			}

		}

		function isSkipResponse(booleanvalue,media_pth,indexval)
		{

			console.log("---"+booleanvalue);

   		    ajaxindicatorstart("<img src='../images/ajax-loader.gif'><br/> Please wait...!");

   		    var ResponseVal = {"request":"media_and_player_request","payload_string":"media_settings_request:skip_setting:"+media_pth+":"+booleanvalue+""};

   		    console.log("==="+JSON.stringify(ResponseVal));
          
          	var form_data = new FormData();                 
              form_data.append('ip_address',screen_name);
              form_data.append('request_json',JSON.stringify(ResponseVal));

                $.ajax({
                	type: "POST",
                	dataType: 'text',
                  	url: "/smweb/enterprise/Api/SendRequestCommandFile.php",
                  	cache: false,
                  	contentType: false,
                  	processData: false,
                  	data: form_data,                         
                  	type: 'post',
                 
                 	success: function(data){
                  		console.log(data);
                    	ajaxindicatorstop();

                   try
                   {

                    var jsonResponse = JSON.parse(data);
                    
                    if(jsonResponse.statusCode==0)
                    {
                      
                      document.getElementById('is_skip_value_'+indexval).checked=booleanvalue;
                      // var gotindexvalue = jsonResponse.index;
                      // var gotResponseFile = jsonResponse.response_file;


                    }else if(jsonResponse.statusCode==99)
                    {
                       swal(jsonResponse.status);
                    }
                    else if(jsonResponse.statusCode==100)
                    {
                       swal(jsonResponse.status);
                    }else if(jsonResponse.statusCode==101)
                    {
                       swal(jsonResponse.status);
                    }

                   }catch(Exception)
                   {
                    alert('Dear user, Unable to push content please try again');
                   } 

                  }
                });

		}


		function ModifyMultiRegionFile(media_name,media_path,indexval)
		{
			ajaxindicatorstart("<img src='../images/ajax-loader.gif'><br/> Please wait...!");

			console.log(media_name);
          
          	var form_data = new FormData();                 
              form_data.append('ip_address',screen_name);
              form_data.append('file_name',media_name+".txt");

                $.ajax({
                	type: "POST",
                	dataType: 'text',
                  	url: "/smweb/enterprise/Api/ReadFile.php",
                  	cache: false,
                  	contentType: false,
                  	processData: false,
                  	data: form_data,                         
                  	type: 'post',
                 
                 	success: function(data){
                  		console.log(data);
                    	ajaxindicatorstop();

                   try
                   {

                    var jsonResponse = JSON.parse(data);

                    //console.log(jsonResponse.type +"==="+ jsonResponse.offer_text);

                    ChecktheMediaFile(jsonResponse,media_name);
                    
                    if(jsonResponse.statusCode==0)
                    {
                    	swal(jsonResponse.status);

                    }else if(jsonResponse.statusCode==99)
                    {
                       swal(jsonResponse.status);
                    }
                    else if(jsonResponse.statusCode==100)
                    {
                       swal(jsonResponse.status);
                    }else if(jsonResponse.statusCode==101)
                    {
                       swal(jsonResponse.status);
                    }

                   }catch(Exception)
                   {
                    alert('Dear user, Unable to push content please try again');
                   } 

                  }
                });


		}

		function ChecktheMediaFile(lists,media_name)
		{

			if(lists.type=='Url')
			{

				$('#ModifyURL').show();
				document.getElementById('modify_url').value = lists.url;
				document.getElementById('modify_media_name').value = media_name+".txt";

				if(lists.duration==-1)
				{
				   document.getElementById('modify_duration').value = '';

				}else 
				{
					document.getElementById('modify_duration').value = lists.duration;
				}
			
		        if(lists.offer_text=="null" || lists.offer_text==null || lists.offer_text==" " || lists.offer_text==undefined || lists.offer_text=="undefined")
		        {
		           document.getElementById('modify_text_media').value = "";
		        }else 
		        {
		          document.getElementById('modify_text_media').value = lists.offer_text;
		        }

     			document.getElementById('modify_url_channel').value =screen_name;
          
          if(lists.hasOwnProperty('is_skip'))
          {
            document.getElementById('modify_url_is_skip').value =lists.is_skip;

          }else
          {
            document.getElementById('modify_url_is_skip').value = false;

          }
     			
			}

			else if(lists.type=='Image')
			{
			    $('#ModifyImage').show();

			     document.getElementById('modify_image_media_name').value = media_name+".txt";

		        if(lists.offer_text=="null" || lists.offer_text==null || lists.offer_text==" " || lists.offer_text==undefined || lists.offer_text=="undefined")
		        {
		          document.getElementById('modify_image_text_media').value = "";
		        }else 
		        {
		          document.getElementById('modify_image_text_media').value = lists.offer_text;
		        }

				if(lists.duration==-1)
				{
				   document.getElementById('modify_image_duration').value = '';

				}else 
				{
					document.getElementById('modify_image_duration').value = lists.duration;
				}

				if(lists.display_scroll_txt==true)
			   	{
			        document.getElementById('modify_media_checkbox_image').checked=true;
			    }else if(lists.display_scroll_txt==false)
			    {
			        document.getElementById('modify_media_checkbox_image').checked=false;
			    }

			    document.getElementById('modify_image_resource').value = lists.resource;

			    document.getElementById('modify_bg_audio_name').value = lists.bg_audio;

			        /*if(lists.play_bg_audio==true || lists.play_bg_audio=="true")
			        {

			          document.getElementById('modify_play_audio_checkbox_image').checked=true;

			          document.getElementById('modify_assign_name_to_audio').innerHTML=lists.bg_audio;

			          

			        $('#modify_audio_record_block').show();

			        }else if(lists.play_bg_audio==false || lists.play_bg_audio=="false")
			        {
			        	document.getElementById('modify_play_audio_checkbox_image').checked=false;

			        	$('#modify_audio_record_block').hide();
			        }*/
			    
			      document.getElementById('modify_image_josnformat').value=JSON.stringify(lists);

		        document.getElementById('modify_image_channel').value =screen_name;

          if(lists.hasOwnProperty('is_skip'))
          {
            document.getElementById('modify_image_is_skip').value =lists.is_skip;

          }else
          {
            document.getElementById('modify_image_is_skip').value = false;

          }

          if(lists.hasOwnProperty('play_bg_audio'))
          {
            document.getElementById('modify_bg_audio_boolean').value =lists.play_bg_audio;

          }else
          {
            document.getElementById('modify_bg_audio_boolean').value = false;

          }
		       
			}

			else if(lists.type=='Video')
			{
			   $('#ModifyVideo').show();

			   document.getElementById('modify_video_media_name').value = lists.media_name+".txt";

			    if(lists.offer_text=="null" || lists.offer_text==null || lists.offer_text==" " || lists.offer_text==undefined || lists.offer_text=="undefined")
			    {
			        document.getElementById('modify_video_text_media').value = "";
			    }else 
			    {
			        document.getElementById('modify_video_text_media').value = lists.offer_text;
			    }
					
				    document.getElementById('modify_video_resource').value = lists.resource;

				    if(lists.display_scroll_txt==true)
			      {
			        document.getElementById('modify_video_media_checkbox').checked=true;
			      }
			      else if(lists.display_scroll_txt==false)
			      {
			        document.getElementById('modify_video_media_checkbox').checked=false;
			      }

            if(lists.duration==undefined || lists.duration==null || lists.duration=="undefined" || lists.duration=="" ||lists.duration==" ")
            {
              document.getElementById('modify_video_duration').value = 10;

            }else 
            {
              document.getElementById('modify_video_duration').value = lists.duration;
            }

			      
		        document.getElementById('modify_video_channel').value =screen_name;

           //document.getElementById('modify_video_is_skip').value =lists.is_skip;

          if(lists.hasOwnProperty('is_skip'))
          {
            document.getElementById('modify_video_is_skip').value =lists.is_skip;

          }else
          {
            document.getElementById('modify_video_is_skip').value = false;

          }

		        		          

			}
		   
		    else if(lists.type=='multi_region')
		    {
		        console.log("Multi Region==="+lists.regions[0]['type']);

		        if(lists.regions[0]['type']=="File")
		        {
		        	$('#Modify_Files').show();

			        //document.getElementById('modify_files_file_name').value=media_name;
			        document.getElementById('modify_files_media_name').value=media_name+".txt";
			        document.getElementById('modify_files_duration').value=lists.duration;

			        document.getElementById('modify_files_zoomLevel').value=lists.regions[0].properties['zoomLevel'];
			        document.getElementById('modify_files_scrollingSpeed').value=lists.regions[0].properties['scrollingSpeed'];
              document.getElementById('modify_file_resource_media').value=lists.regions[0].media_name;

				        if(lists.regions[0].properties['isFitToScreen']==true)
				        {
				          console.log(lists.regions[0].properties['isFitToScreen']);
				          document.getElementById('modify_files_fitscreen').checked=true;

				          $('#modify_files_zoomLevel').hide();
				          $('#exampleInputEmail1').hide();


				        }
				        else
				        {
				          console.log(lists.regions[0].properties['isFitToScreen']);
				          document.getElementById('modify_files_fitscreen').checked=false;
				           $('#modify_files_zoomLevel').show();
				           $('#exampleInputEmail1').show();

				        }

				      if(lists.offer_text==undefined || lists.offer_text=="undefined" || lists.offer_text=="" || lists.offer_text==" ")
				      {
				        document.getElementById('modify_files_text_media').value= "";
				      }else 
				      {
				        document.getElementById('modify_files_text_media').value= lists.offer_text;
				      } 


				      document.getElementById('modify_files_channel').value=screen_name;

              if(lists.hasOwnProperty('is_skip'))
             {
                document.getElementById('modify_file_is_skip').value =lists.is_skip;

             }else
             {
               document.getElementById('modify_file_is_skip').value = false;

              }

				  

		        }else 
		        {

		        	$('#ModifyMultiRegion').show();

		        	document.getElementById('modify_multiregion_media_name').value=media_name+".txt";

			        if(lists.offer_text!=null && lists.offer_text!=undefined)
			        {
			          document.getElementById('modify_multiregion_text_media').value=lists.offer_text;
			        }else 
			        {
			          document.getElementById('modify_multiregion_text_media').value="";
			        }


			        if(lists.duration!=null && lists.duration!=undefined)
			        {
			          document.getElementById('modify_multiregion_duration').value=lists.duration;
			        }else 
			        {
			          document.getElementById('modify_multiregion_duration').value="";
			        }

			        document.getElementById('modify_multiregion_channel').value=screen_name;

		        	document.getElementById('modify_multiregion_josnformat').value=JSON.stringify(lists);

		        }

		    }



		}
		

		function fitscreen()
	    {
	      if(document.getElementById('modify_files_fitscreen').checked==true)
	      {
	        $('#modify_files_zoomLevel').hide();
	        $('#exampleInputEmail1').hide();
	      }else 
	      {
	        $('#modify_files_zoomLevel').show();
	        $('#exampleInputEmail1').show();
	      }
	        
	    }

	    function ModifyDisplaySubmit(type)
		{

			var url_url = document.getElementById('modify_url').value;
	 		var media_name = document.getElementById('modify_media_name').value;
	 		var duration = document.getElementById('modify_duration').value;
	 		var text_media = document.getElementById('modify_text_media').value;
	 		var Channel_Channel = document.getElementById('modify_url_channel').value;
	 		var is_skip = document.getElementById('modify_url_is_skip').value;

			if(duration==null || duration=="" || duration==" " || duration=="Enter Duration(Sec)")
			{
			  duration = 10;
			}

      if( is_skip==undefined || is_skip==null || is_skip =="undefined")
      {
        is_skip=false;
      }

			if(url_url=='Enter url address like https://www.example.com ' || url_url=='' || url_url==null){
			  swal({
			  title: 'Please enter URL!',
			  timer: 2000
			});
			  return false;
			}else if(media_name=='Enter Media Name' || media_name=='' || media_name==null){
			  swal({
			  title: 'Please enter media name!',
			  timer: 2000
			});
			  return false;
			} 

  			var datastring = {}
          
	            datastring['type'] = "Url";
	            datastring['offer_text'] = text_media;
	            datastring['url'] = url_url;
	            datastring['display_scroll_txt'] = "true";
	            datastring['duration'] = duration;
	            datastring['is_skip'] = is_skip;
        

            var data = JSON.stringify(datastring);
        		ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>Please wait...!");
          
            var form_data = new FormData();     
              form_data.append('media_name',media_name);
              form_data.append('path',Channel_Channel);             
              form_data.append('data',data);

              form_data.append('type',type);
              form_data.append('offer_text',text_media);
              form_data.append('duration',duration);
              form_data.append('is_skip',is_skip);
    
               $.ajax({
                type: "POST",
                dataType: 'text',
                  url: "/smweb/enterprise/Api/Uploadtemptxtfiles.php",
                  cache: false,
                  contentType: false,
                  processData: false,
                  data: form_data,                         
                  type: 'post',
                 
                 success: function(data){
                 	console.log(data);
                  ajaxindicatorstop();
                   try
                   {
                    var jsonResponse = JSON.parse(data);
                    if(jsonResponse.statusCode==0)
                    { 
                      //swal(jsonResponse.status);
                      UploadModifyFileFtp(media_name,jsonResponse.path,Channel_Channel,type);

                      //$('#ModifyURL').hide();

                    }else
                    {
                       swal(jsonResponse.status);
                    }
                   }catch(Exception)
                   {
                     alert('Error,Please Contact Technical Support..!');
                   } 

                  }
                });
		}


		function ModifyImageDisplaySubmit(type)
		{

			 var media_name = document.getElementById('modify_image_media_name').value;
			 var text_media = document.getElementById('modify_image_text_media').value;
			 var duration = document.getElementById('modify_image_duration').value;

			 var modify_resource = document.getElementById('modify_image_resource').value;
			var  modify_bg_audio_name = document.getElementById('modify_bg_audio_name').value;
			var  modify_bg_audio_boolean = document.getElementById('modify_bg_audio_boolean').value;

    	var Channel_Channel = document.getElementById('modify_image_channel').value;

    	var is_skip = document.getElementById('modify_image_is_skip').value;

			if(duration==null || duration=="" || duration==" " || duration=="Enter Duration(Sec)")
			{
			  duration = 10;
			}

      if( is_skip==undefined || is_skip==null || is_skip =="undefined")
      {
        is_skip=false;
      }

      if( modify_bg_audio_boolean==undefined || modify_bg_audio_boolean==null || modify_bg_audio_boolean =="undefined")
      {
        modify_bg_audio_boolean=false;
      }

      

			if(media_name=='Enter Media Name' || media_name=='' || media_name==null)
			{
			  swal({
			  title: 'Please Enter media name!',
			  timer: 2000
				});
			  return false;
			} 


		    /*if(document.getElementById('modify_play_audio_checkbox_image').checked==true)
		    {

		      if(modify_bg_audio_name!=null)
		    {
		      var aud_name = modify_bg_audio_name;    
		            var aud_booblean = modify_bg_audio_boolean;

		            if(modify_audio_file_name!=null && modify_audio_file_name!=undefined)
		          {
		           
		              aud_name = 'DNDM-'+ media_name + '.'+file_get_ext(modify_audio_file_name.name);
		                
		              aud_booblean = true;
		              
		               
		          }

		        

		    }else 
		    {
		      if(modify_audio_file_name!=null && modify_audio_file_name!=undefined)
		          {
		              
		                
		              aud_name = 'DNDM-'+ media_name + '.'+file_get_ext(modify_audio_file_name.name);
		                
		              aud_booblean = true;
		              
		              
		              
		          }

		         
		    }


		    }else 
		    {


		        modify_audio_file_name="";
		                
		        var aud_name ="";
		                
		        var aud_booblean = false;

		    }*/

        //console.log("----"+Removetxtintext(media_name));

        var datastring = {}
          
              datastring['type'] = "Image";
              datastring['media_name'] = Removetxtintext(media_name);
              datastring['offer_text'] = text_media;
              datastring['resource'] = modify_resource;
              datastring['duration'] = duration;
              datastring['display_scroll_txt'] = false;
            
              datastring['bg_audio'] = modify_bg_audio_name;
              datastring['play_bg_audio'] = modify_bg_audio_boolean;
              datastring['is_skip']=is_skip;
          
            var data = JSON.stringify(datastring);

            console.log("==="+data);
            
       ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>Please wait...!");
        var form_data = new FormData(); 
           form_data.append('offer_text',text_media);
           form_data.append('duration',duration);
           form_data.append('path',Channel_Channel); 
           form_data.append('type',"Image"); 
           form_data.append('media_name',media_name);
           form_data.append('data',data);
    
            $.ajax({
                type: "POST",
                dataType: 'text',
                  url: "/smweb/enterprise/Api/Uploadtemptxtfiles.php",
                  cache: false,
                  contentType: false,
                  processData: false,
                  data: form_data,                         
                  type: 'post',
                 
                 success: function(data){
                    console.log(data);

                   ajaxindicatorstop();
                   try
                   {
                    var jsonResponse = JSON.parse(data);
                    if(jsonResponse.statusCode==0)
                    {
                      
                      //swal(jsonResponse.status);

                      //$('#ModifyImage').hide();

                      UploadModifyFileFtp(media_name,jsonResponse.path,Channel_Channel,type);

                    }else
                    {
                      swal(jsonResponse.status);
                    }
                   }catch(Exception)
                    {
                      alert('Error,Please Contact Technical Support..!');
                    } 

                  }
                });

		}


    function Removetxtintext(text)
    {

      //return text.replace( /#/g, "" );
      return text.replace( /.txt/g, "" );

    }

		function ModifyVideoDisplaySubmit(type)
		{
	 		var modify_resource = document.getElementById('modify_video_resource').value;
	 		var media_name = document.getElementById('modify_video_media_name').value;
	 		var text_media = document.getElementById('modify_video_text_media').value;
	 		var Channel_Channel = document.getElementById('modify_video_channel').value;
	 		var is_skip = document.getElementById('modify_video_is_skip').value;

	 		var duration = document.getElementById('modify_video_duration').value;

       console.log("is_skip before ==="+is_skip);

      if( is_skip==undefined || is_skip==null || is_skip =="undefined")
      {
        is_skip=false;
      }

      console.log("is_skip after ==="+is_skip);

			if(media_name=='Enter Media Name' || media_name=='' || media_name==null)
			{
			  swal({
			  	title: 'Please enter media name!',
			  	timer: 2000
				});
			  	return false;
			} 

      console.log("media_name===="+media_name);

  			var datastring = {}
          
            	datastring['type'] = "Video";
            	datastring['offer_text'] = text_media;
            	datastring['resource'] = modify_resource;
            	datastring['display_scroll_txt'] = false;
            	datastring['media_name'] = Removetxtintext(media_name);
            	datastring['duration'] = duration;
            	datastring['is_skip'] = is_skip;
            

            	var data = JSON.stringify(datastring);

              console.log("===="+data);
           
         		ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>Please wait...!");

          		var form_data = new FormData();     
              		form_data.append('media_name',media_name);
              		form_data.append('path',Channel_Channel);             
            		  form_data.append('data',data);
            		  form_data.append('type',type);
            		  form_data.append('offer_text',text_media);
            		  form_data.append('duration',duration);
            		  form_data.append('is_skip',is_skip);
    
               	$.ajax({
                	type: "POST",
                	dataType: 'text',
                  	url: "/smweb/enterprise/Api/Uploadtemptxtfiles.php",
                  	cache: false,
                  	contentType: false,
                  	processData: false,
                  	data: form_data,                         
                  	type: 'post',
                 
                 	success: function(data){
                    console.log(data);
                  	ajaxindicatorstop();
	                   try
	                   {
	                    var jsonResponse = JSON.parse(data);
	                    if(jsonResponse.statusCode==0)
	                    {
	                      
	                      //swal(jsonResponse.status);
	                      //$('#ModifyVideo').hide();
	                      UploadModifyFileFtp(media_name,jsonResponse.path,Channel_Channel,type);

	                    }else
	                    {
	                       swal(jsonResponse.status);
	                    }
	                   }catch(Exception)
	                   {
	                     alert('Error,Please Contact Technical Support..!');
	                   } 

	                  }
                });

		}




	    function Modify_FilesDisplaySubmit(type)
	    {

	    	var media_name = document.getElementById('modify_files_media_name').value;
      		var duration = document.getElementById('modify_files_duration').value;
      		var text_media = document.getElementById('modify_files_text_media').value;
      		var zoomLevel = document.getElementById('modify_files_zoomLevel').value;
      		var scrollingSpeed = document.getElementById('modify_files_scrollingSpeed').value;

      		//var file_name = document.getElementById('modify_files_file_name').value;


      		var Channel_Channel = document.getElementById('modify_files_channel').value;

      		var is_skip = document.getElementById('modify_file_is_skip').value;


	          if(document.getElementById('modify_files_fitscreen').checked==true)
	          {
	           var isFitToScreen = true;
	          }else 
	          {
	            var isFitToScreen = false;
	          }


	          if(duration==null || duration=="" || duration==" " || duration=="Enter Duration(Sec)")
	          {
	            duration = 10;
	          }
	          if(zoomLevel==null || zoomLevel=="" || zoomLevel==" " || zoomLevel=="Enter in digits")
	          {
	            zoomLevel = 1.0;
	          }
	          if(scrollingSpeed==null || scrollingSpeed=="" || scrollingSpeed==" " || scrollingSpeed=="Enter Scrolling Speed Duration in Second(s)")
	          {
	            scrollingSpeed = 10;
	          }

            if( is_skip==undefined || is_skip==null || is_skip =="undefined")
           {
             is_skip=false;
           }


	         if(media_name=='Enter Media Name' || media_name=='' || media_name==null){
	          swal({
	          title: 'Please Enter media name!',
	          timer: 2000
	        	});
	          return false;
	        } 

        	console.log(media_name+"...."+duration);

        	var data2 = ({"zoomLevel":Number(zoomLevel),"scrollingSpeed":Number(scrollingSpeed),"isFitToScreen":isFitToScreen});

        	var datastring = ([{"type":"File","width":100,"height":100,"top_margin":0,"bottom_margin":0,"left_margin":0,"right_margin":0,"media_name":document.getElementById('modify_file_resource_media').value,"is_self_path":false,'properties':data2}]);

        	var datastring1 = {}
                      datastring1['type'] = "File";
                      datastring1['media_name'] = media_name;
                      datastring1['offer_text'] = text_media;
                      datastring1['resource'] = media_name;
                      datastring1['duration'] = duration;
                      datastring1['path'] = Channel_Channel;
                    
                      var data1 = JSON.stringify(datastring1);
                      console.log(data1);

           var data = JSON.stringify(datastring);
                console.log(data);

          ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>File transfer in progress<br/> Please wait...!");
          
          var form_data = new FormData();     
           // form_data.append('fileName',file_name);
            form_data.append('data1',data1);
            form_data.append('path',Channel_Channel);             
            form_data.append('data',data);
            form_data.append('type',type);
            form_data.append('offer_text',text_media);
            form_data.append('duration',duration);
            form_data.append('media_name',media_name);
            form_data.append('is_skip',is_skip);
           

               $.ajax({
                type: "POST",
                dataType: 'text',
                  url: "/smweb/enterprise/Api/Uploadtemptxtfiles.php",
                  cache: false,
                  contentType: false,
                  processData: false,
                  data: form_data,                         
                  type: 'post',
                 
                 success: function(data){
                  console.log(data);
                    ajaxindicatorstop();
                   try
                   {


                    var jsonResponse = JSON.parse(data);
                    if(jsonResponse.statusCode==0)
                    {

                      UploadModifyFileFtp(media_name,jsonResponse.path,Channel_Channel,type);
                      //swal(jsonResponse.status);

                      //$('#Modify_Files').hide();

                    }else
                    {
                       swal(jsonResponse.status);
                    }
                   }catch(Exception)
                   {
                    alert('Dear user, Unable to push content please try again');
                   } 

                  }
                });

	    }

	    function ModifyMultiRegionDisplaySubmit(type)
	    {
	    	var media_name = document.getElementById('modify_multiregion_media_name').value;
      		var duration = document.getElementById('modify_multiregion_duration').value;
      		var text_media = document.getElementById('modify_multiregion_text_media').value;
      		var array_Jsonformat = document.getElementById('modify_multiregion_josnformat').value;
      		var Channel_Channel = document.getElementById('modify_multiregion_channel').value;

          	ajaxindicatorstart("<img src='../images/ajax-loader.gif'><br/>File transfer in progress<br/> Please wait...!");
          
           var form_data = new FormData();     
              //form_data.append('fileName',file_name);
              form_data.append('path',Channel_Channel);             
              form_data.append('data',array_Jsonformat);
              form_data.append('type',type);
              form_data.append('offer_text',text_media);
              form_data.append('duration',duration);
              form_data.append('media_name',media_name);
           

               $.ajax({
                type: "POST",
                dataType: 'text',
                  url: "/smweb/enterprise/Api/Uploadtemptxtfiles.php",
                  cache: false,
                  contentType: false,
                  processData: false,
                  data: form_data,                         
                  type: 'post',
                 
                 success: function(data){
                  console.log(data);
                    ajaxindicatorstop();
                   try
                   {


                    var jsonResponse = JSON.parse(data);
                    if(jsonResponse.statusCode==0)
                    {
                      
                      //swal(jsonResponse.status);

                      	UploadModifyFileFtp(media_name,jsonResponse.path,Channel_Channel,type);
                      //$('#ModifyMultiRegion').hide();

                    }else if(jsonResponse.statusCode==2)
                    {
                    	swal(jsonResponse.status);
                    }else
                    {
                       swal(jsonResponse.status);
                    }
                   }catch(Exception)
                   {
                    alert('Dear user, Unable to push content please try again');
                   } 

                  }
                });

	    }


	    function UploadModifyFileFtp(media_name,path,Channel_Channel,type)
	    {
	    	console.log(media_name+"==="+path);

	    	var datastring = ([{"file_name":media_name,"file_path":path}]);

	    	// var datastring = {}
	    	// 	datastring['file_name'] = media_name;
	    	// 	datastring['file_path'] = path;

	    	var data = JSON.stringify(datastring);

	    	console.log(data);

	    	ajaxindicatorstart("<img src='../images/ajax-loader.gif'><br/>File transfer in progress<br/> Please wait...!");
          
            var form_data = new FormData();     
              //form_data.append('fileName',file_name);
              form_data.append('ip_address',Channel_Channel);             
              form_data.append('files',data);
              
                $.ajax({
                  type: "POST",
                  dataType: 'text',
                  url: "/smweb/enterprise/Api/SendFileService.php",
                  cache: false,
                  contentType: false,
                  processData: false,
                  data: form_data,                         
                  type: 'post',
                 
                success: function(data){
                  console.log("UploadModifyFileFtp=="+data);
                    ajaxindicatorstop();
                   try
                   {

                    var jsonResponse = JSON.parse(data);
                    if(jsonResponse.statusCode==0)
                    {
                      
                       swal(jsonResponse.status);

                        if(type=="multiregion")
          					  	{
          					  		$('#ModifyMultiRegion').hide();
                          //DeleteAudioFileInLocal(media_name,path);
          					  	}else if(type=="Url")
          					  	{
          					  		$('#ModifyURL').hide();
                          //DeleteAudioFileInLocal(media_name,path);
          					  	}else if(type=="Image")
          					  	{
          					  		$('#ModifyImage').hide();
                          //DeleteAudioFileInLocal(media_name,path);

          					  	}else if(type=="Video")
          					  	{
          					  		$('#ModifyVideo').hide();
                          //DeleteAudioFileInLocal(media_name,path);

          					  	}else if(type=="File")
          					  	{
          					  		$('#Modify_Files').hide();
                          //DeleteAudioFileInLocal(media_name,path);
          					  	}


                    }else if(jsonResponse.statusCode==2)
                    {
                    	swal(jsonResponse.status);
                    }else
                    {
                       swal(jsonResponse.status);
                    }
                   }catch(Exception)
                   {
                    alert('Dear user, Unable to push content please try again');
                   } 

                  }
                });

	    }


      // function DeleteAudioFileInLocal(fileName,path)
      // {
      //     ajaxindicatorstart("<img src='../images/ajax-loader.gif'><br/> Please wait...!");
          
      //       var form_data = new FormData();                 
      //           form_data.append('fileName',fileName);
      //           form_data.append('path',path);

      //           $.ajax({
      //             type: "POST",
      //             dataType: 'text',
      //               url: "/smweb/php/DeleteAudioFileInLocalFolderFTP.php",
      //               cache: false,
      //               contentType: false,
      //               processData: false,
      //               data: form_data,                         
      //               type: 'post',
                 
      //             success: function(data)
      //             {  
      //                 ajaxindicatorstop();

      //              try
      //              {

      //                 console.log(data);
                  
      //              }catch(Exception)
      //              {
      //               alert('Dear user, Unable to push content please try again');
      //              } 

      //             }
      //         });

      // }


   		window.onload = FTPModifyRequestFile(0);
</script>



<!-- Load JS here for greater good =============================-->
 <script src="../js/jquery-.js"></script>
 <script src="../js/bootstrap.min.js"></script>
 <script src="../js/anim.js"></script>
 <script src="../js/jscolor.js"></script>
 <script src="../js/js/Videopage.js"></script>
 <script src="../js/js/Imagepage.js"></script>

</body>
</html>