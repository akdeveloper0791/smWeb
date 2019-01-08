<?php

session_start();
require 'database.php';
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

  $cookie_name = "Mode_Selection";

  if(isset($_COOKIE[$cookie_name])) 
  {
      //echo "Cookie named '" . $cookie_name . "' is not set!";
      if($_COOKIE[$cookie_name]=="Enterprise")
      {
        header("Location: enterprise.php");
      }
  } 
  


?>


<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="generator" content="">
<link rel='shortcut icon' type='image/x-icon' href='images/signage.ico' />
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<script src="js/sweetalert.js"></script>
<link rel="stylesheet" href="js/sweetalert.css">
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/default_busy_loader.js"></script>
<script src="js/jscolor.js"></script>
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Roboto:200,300,400,500,600,700" rel="stylesheet">
<script src="js/bootstrap-select.min.js"></script>
<link rel="stylesheet" href="css/bootstrap-select.min.css">

<style type="text/css">
  .modal {
  text-align: center;
  padding: 0!important;
}
.modal:before {
  content: '';
  display: inline-block;
  height: 100%;
  vertical-align: middle;
  margin-right: -4px;
}
.modal-dialog {
  display: inline-block;
  text-align: left;
  vertical-align: middle;
}
</style>
<!-- <style type="text/css">
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   text-align: center;
}
</style> -->
</head>
<body>

<header class="item header margin-top-0">
<div class="wrapper">
	<nav role="navigation" class="navbar navbar-white navbar-embossed navbar-lg navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button data-target="#navbar-collapse-02" data-toggle="collapse" class="navbar-toggle" type="button">
			<i class="fa fa-bars"></i>
			<span class="sr-only">Toggle navigation</span>
			</button>
			<a href="index.php" class="navbar-brand brand" style="
    display: inline-flex;
"> <img src="images/signage.png" alt="" class="logo" style="
    width: 32px;
    height:  32px;margin: 0 10px;
">Signage Manager </a>
		</div>
		<div id="navbar-collapse-02" class="collapse navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
                <li class="propClone" ><a href="https://www.greencontent.in/campaign/" target="blank">Upload Campaign</a></li>
        <li class="propClone" ><a href="https://www.greencontent.in/my_campaigns/"  target="blank">Download Campaign</a></li>
			<!-- 	<li class="propClone" id="superuser"><a href="addscreen.php">Add Screen</a></li>
        <li class="propClone" id="superuser1"><a href="useraccount.php">User Account</a></li> -->
					<li class="propClone" id="logout"><a href="logout.php">Logout</a></li>
			</ul>
		</div>
	</div>
	</nav>

	<?php if( !empty($user) ): ?>
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<div class="text-pageheader">
					<div class="subtext-image" data-scrollreveal="enter bottom over 1.7s after 0.1s" >
						<br /><h1>Welcome to Signage Manager</h1><h2><span style="color: orange;"><?= $user['email']; ?></span></h2>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</header>

<section class="item content" style="background-color: darkgray;">
<div class="container toparea">
 <div class="underlined-title">
  <div class="editContent">
   <span id='message'></span>
   <div class="rows">
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
      <!--  <h4 class="latestitems" style="text-align: center;">Select Channel(s):</h4> --><hr/>
    </div>
  </div>
  </div>

      <div class="col-md-12">

      <!--     <div class="col-md-4" style="text-align: center;">

          <div class="form-check" style="display:inline-flex;margin-right:30px;">
            <label class="form-check-label">
            <input type="radio" class="form-check-input" name="optradio" id="add" checked> Add
            </label>
          </div>

          <div class="form-check" style="display:inline-flex;margin-right:30px;">
            <label class="form-check-label">
            <input type="radio" class="form-check-input" name="optradio" onclick="SelectScreen1('modify');"> Modify
            </label>
          </div>
    
          <div class="form-check" style="display:inline-flex">
            <label class="form-check-label">
            <input type="radio" class="form-check-input" name="optradio" onclick="SelectScreen1('delete');"> Delete
            </label>
          </div>


        </div> -->

<!--          <div class="col-md-4">
         </div>
        <div class="col-md-4">

            <select name="default_Channel[]" id="default_Channel" class="selectpicker form-control"  multiple required >
             <?php 

                $query = "SELECT Channel.names as ch_names,Channel.ch_id as ch_id FROM (SELECT ch_id FROM user_channels WHERE user_id = ".$_SESSION['user_id']." ) as UserChannel INNER JOIN channel_table as Channel ON UserChannel.ch_id = Channel.ch_id";


                $res=mysqli_query($link,$query);
               
                while($row=mysqli_fetch_array($res)){
                ?>
              <option value="<?php echo $row["ch_id"]; ?>"><?php echo $row["ch_names"]; ?></option>
              <?php
            }
            ?>
            </select>
        </div>
 -->

        <div class="rows">
        <div class="col-md-12">
          <div class="col-md-4" style="text-align: center;">

          <div class="form-check" style="display:inline-flex;margin-right:30px;">
            <label class="form-check-label">
            <input type="radio" class="singleclass" name="region" id="single" checked> Single Region
            </label>
          </div>

          <div class="form-check" style="display:inline-flex;margin-right:30px;">
            <label class="form-check-label">
            <input type="radio" class="multiregion" name="region" onclick="SelectScreen('multi');"> Multi Region
            </label>
          </div>
    

        </div>
        </div>
    </div>


      </div>



 </div>

 <div class="row"> <hr>
  <div class="col-md-12">
  <div class="col-md-2">
  </div>
  <div class="col-md-2">
   <div class="productbox" style="border: 2px solid orange;">
     <a onclick="SelectScreen('Image');">
      <div class="product-details">
          <img src="images/image.png" alt="">
          <b>Image</b>
      </div>
    </a>
   </div>
  </div>

  <div class="col-md-2">
   <div class="productbox" style="border: 2px solid orange;"> 
    <a  onclick="SelectScreen('Video');">
    <div class="product-details">
      <img src="images/video.png" alt="">
     <b>Video</b>
    </div>
    </a>
   </div>
  </div>


  <div class="col-md-2">
   <div class="productbox" style="border: 2px solid orange;">
    <a  onclick="SelectScreen('Text');">
    <div class="product-details" >
      <img src="images/text.png" alt="">
     <b>TEXT</b>
    </div>
    </a>
   </div>
  </div>

    <div class="col-md-2">
   <div class="productbox" style="border: 2px solid orange;">
    <a  onclick="SelectScreen('File');">
    <div class="product-details" >
      <img src="images/File.png" alt="">
     <b>FILE</b>
    </div>
    </a>
   </div>
  </div>


   <div class="col-md-2">
   <div class="productbox" style="border: 2px solid orange;">
     <a onclick="SelectScreen('Url');">
    <div class="product-details" >
      <img src="images/url.png" alt="">
     <b>URL</b>
    </div>
    </a>
   </div>
  </div>  

  </div>
 </div>
<br/>
</div>
</div>
</section>


	<?php else: ?>
  <br/><br/><br/><br/><br/><br/><br/>
  <center>
  <div style="height: 20%;">

		<h1 style="color:white;text-align: center;">Please <a href="index.php">Login</a>
    </h1>
		

</div>
</center>
 <br/><br/><br/><br/><br/>
    <br/><br/><br/><br/>
    <script type="text/javascript">
       $('#superuser').hide(); 
       $('#superuser1').hide(); 
       
       $('#logout').hide(); 
    </script>

	<?php endif; ?>
<!-- FOOTER =============================-->
<div class="footer text-center">
<div class="container">
	<div class="row">
	
		<p>
			Copyright (c) 2018 SignageServ, All Rights Reserved. Powered by AdsKite India Pvt. Ltd.

		</p>
	</div>
</div>
</div>

<!-- The Multi region Modal -->
 <div class="modal" id="multiregion">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header"> 
          <h4 class="modal-title" style="text-align:center;">Choose your layout from the available templates
          <span type="button" class="close" data-dismiss="modal" onclick="$('#multiregion').hide();document.getElementById('single').checked = true;">&times;</span></h4>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style="overflow-y:auto;height:330px;">

         <div class="rows" >
          <div class="col-md-12" style="margin-bottom:25px;">
            <div class="col-md-3">
              <img src="images/11.jpg" onclick="multiscreen('template1');">
            </div>
            <div class="col-md-3">
               <img src="images/22.jpg" onclick="multiscreen('template2');">
            </div>
            <div class="col-md-3">
               <img src="images/33.jpg" onclick="multiscreen('template3');">
            </div>
            <div class="col-md-3">
               <img src="images/44.jpg" onclick="multiscreen('template4');">
            </div>
          </div>
         </div>

         <div class="rows">
          <div class="col-md-12">
            <div class="col-md-3">
               <img src="images/55.jpg" onclick="multiscreen('template5');">
            </div>
            <div class="col-md-3">
               <img src="images/66.jpg" onclick="multiscreen('template6');">
            </div>
            <div class="col-md-3">
               <img src="images/77.jpg" onclick="multiscreen('template7');">
            </div>
            <div class="col-md-3">
            </div>
          </div>
         </div>
         
          
     
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <center>
          <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#multiregion').hide();document.getElementById('single').checked = true;">Close</button></center>
    
        </div>
        
      </div>
    </div>
  </div>

<!-- The Modify Modal -->
 <div class="modal" id="ModifyFilesList">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" style="text-align:center;">Media List
            <span type="button" class="close" data-dismiss="modal" onclick="$('#ModifyFilesList').hide();">&times;</span></h4>

            <div class="col-md-3"></div>
            <div class="col-md-4 offset-md-3" style="width:50%;">
              <select name="default_Channel1" id="default_Channel1" class="selectpicker form-control" required onchange="ScreenConnection1('modify');">
               <?php 

                  $query = "SELECT Channel.names as ch_names,Channel.ch_id as ch_id FROM (SELECT ch_id FROM user_channels WHERE user_id = ".$_SESSION['user_id']." ) as UserChannel INNER JOIN channel_table as Channel ON UserChannel.ch_id = Channel.ch_id";

                  // $res=mysqli_query($link,"select * from channel_table");
                  $res=mysqli_query($link,$query);
                  // $res1=mysqli_query($link,"SELECT ch_id FROM user_channels WHERE user_id='" .$res."'");
                  while($row=mysqli_fetch_array($res)){
                  ?>
                <option value="<?php echo $row["ch_id"]; ?>"><?php echo $row["ch_names"]; ?></option>
                <?php
              }
              ?>
              </select>
            </div>

         
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style="overflow-y:auto;height:300px;">
         
           <div id="modify_list_display"></div>
           <input type="hidden" name="modify_channel_path" id="modify_channel_path" >
     
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <center>
          <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#ModifyFilesList').hide();document.getElementById('add').checked = true;">Close</button></center>
    
        </div>
        
      </div>
    </div>
  </div>

<!-- The Delete Modal -->
  <div class="modal" id="DeleteFilesList">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" style="text-align:center;">Select Media
          <span type="button" class="close" data-dismiss="modal" onclick="$('#DeleteFilesList').hide();document.getElementById('add').checked = true;">&times;</span></h4>

          <div class="col-md-3"></div>
            <div class="col-md-4 offset-md-3" style="width:50%;">
              <select name="default_Channel2" id="default_Channel2" class="selectpicker form-control" required onchange="ScreenConnection1('delete');">
               <?php 

                  $query = "SELECT Channel.names as ch_names,Channel.ch_id as ch_id FROM (SELECT ch_id FROM user_channels WHERE user_id = ".$_SESSION['user_id']." ) as UserChannel INNER JOIN channel_table as Channel ON UserChannel.ch_id = Channel.ch_id";

                  // $res=mysqli_query($link,"select * from channel_table");
                  $res=mysqli_query($link,$query);
                  // $res1=mysqli_query($link,"SELECT ch_id FROM user_channels WHERE user_id='" .$res."'");
                  while($row=mysqli_fetch_array($res)){
                  ?>
                <option value="<?php echo $row["ch_id"]; ?>"><?php echo $row["ch_names"]; ?></option>
                <?php
              }
              ?>
              </select>
            </div>

        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style="overflow-y:auto;height:250px;">
         
             <div id="list_display"></div>
             <input type="hidden" name="delete_channel_path" id="delete_channel_path" >
     
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <center>
          <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#DeleteFilesList').hide();document.getElementById('add').checked = true;">Close</button>
          <button type="button" class="btn btn-success" onclick="DeleteFiles();">Delete</button>
       </center>
        </div>
        
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

        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <center>
            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#ModifyURL').hide();">Close</button>
		        <button type="button" class="btn btn-success" onclick="ModifyDisplaySubmit();">Submit</button>
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

			     <div class="checkbox">
                <label id="modify_play_audio_checkbox_label_image" onclick="ModifyCheckUncheck()"><input type="checkbox" id="modify_play_audio_checkbox_image" >  Play Audio with Media</label>
            </div>


            <input type="hidden" id="modify_image_resource">
			<input type="hidden" id="modify_bg_audio_name">
			<input type="hidden" id="modify_bg_audio_boolean">
                  
            <div class="form-group" id="modify_audio_record_block" style="display:none;">
                 
                    
                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 col-12 text-center modify_audio_image_preview" >
                      <!--<i class="fa fa-music" ></i><br>-->
                    <label class="btn btn-primary"><span class="icon-music"><input type="file" name="modify_input-file-audio-preview" accept="audio/*"style="display:none;"/>     Attach Audio File</span></label><br>
                    <p id="modify_assign_name_to_audio"></p>
					
                
                      
                </div>      
            </div>
            
            <input type="hidden" name="modify_image_channel" id="modify_image_channel">
         
		 <br><br>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <center>
           <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#ModifyImage').hide();">Close</button>
		   <button type="button" class="btn btn-success" onclick="ModifyImageDisplaySubmit();">Submit</button></center>
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
		 
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <center>
           <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#ModifyVideo').hide();">Close</button>
		   <button type="button" class="btn btn-success" onclick="ModifyVideoDisplaySubmit();">Submit</button></center>
        </div>
        
      </div>
    </div>
  </div>


   <div class="modal" id="ScreeSelectionByUserforDelete">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" style="text-align:center;">Select Screen
          <span type="button" class="close" data-dismiss="modal" onclick="$('#ScreeSelectionByUserforDelete').hide();document.getElementById('add').checked = true;">&times;</span></h4>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
         
            <div class="input-wrap">
            <!--   <label>Choose Screen : *</label> -->
                <select name="Channel" id="Channel_Channel_delete" class="form-control"  required>
                  <option>Select Screen</option>
                    <?php 
                      $res=mysqli_query($link,"select * from screen");
                      while($row=mysqli_fetch_array($res)){
                                  ?>
                      <option value="<?php echo $row["name"]; ?>"><?php echo $row["name"]; ?></option>
                      <?php
                    }
                  ?>
                </select>
            </div>
     
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <center>
          <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#ScreeSelectionByUserforDelete').hide();document.getElementById('add').checked = true;">Close</button>
          <button type="button" class="btn btn-success" onclick="ScreenConnection('delete');">Submit</button>
          </center>
        </div>
        
      </div>
    </div>
  </div>

  
  <div class="modal" id="ScreeSelectionByUserforModify">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" style="text-align:center;">Select Screen
          <span type="button" class="close" data-dismiss="modal" onclick="$('#ScreeSelectionByUserforModify').hide();document.getElementById('add').checked = true;">&times;</span></h4>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
         
            <div class="input-wrap">
             <!--  <label>Choose Screen : *</label> -->
                <select name="Channel" id="Channel_Channel_modify" class="form-control"  required>
                  <option>Select Screen</option>
                    <?php 
                      $res=mysqli_query($link,"select * from screen");
                      while($row=mysqli_fetch_array($res)){
                                  ?>
                      <option value="<?php echo $row["name"]; ?>"><?php echo $row["name"]; ?></option>
                      <?php
                    }
                  ?>
                </select>
            </div>
     
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <center>
          <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#ScreeSelectionByUserforModify').hide();document.getElementById('add').checked = true;">Close</button>
          <button type="button" class="btn btn-success" onclick="ScreenConnection('modify');">Submit</button>
          </center>
        </div>
        
      </div>
    </div>
  </div>

  <!-- Modify Text -->
  <div class="modal" id="ModifyText">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" style="text-align:center;">Modify Text
          <span type="button" class="close" data-dismiss="modal" onclick="$('#ModifyText').hide();">&times;</span></h4>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style="overflow-y:auto;height:300px;">
     
              <div class="form-group">
                  <label for="exampleInputPassword1">Rich Text : </label>
                   <!--  <input type="text" class="form-control" placeholder="Enter your text" name="media_name" id="media_name"> -->
                  <textarea class="form-control" placeholder="Enter your text" name="modify_text_media_name" id="modify_text_media_name"></textarea>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Media Name : </label>
                <input type="text" class="form-control" placeholder="Enter media name" name="modify_text_file_name" id="modify_text_file_name" readonly>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Text for Media : </label>
                <input type="text" class="form-control" placeholder="Enter scrolling Text for Media" name="modify_text_text_media" id="modify_text_text_media">
              </div>

              <div class="form-group">
                <label for="exampleInputPassword2">Duration in Second(s) : </label>
                <input type="number" class="form-control" placeholder="Enter Duration(Sec)" name="modify_text_duration" id="modify_text_duration">
                <p>Default Duration:10s</p>
              </div>  

              <div class="form-group">
                <label for="exampleInputPassword2">Text Size :</label>
                <input type="number" class="form-control" placeholder="Enter Font Size" name="modify_text_font_size" id="modify_text_font_size">
                <p>Default Font Size:40</p>
              </div> 

              <div class="rows">
              </div> 

              <div class="rows">
                <div class="col-md-4">

                  <div class="form-group">
                    <label for="exampleInputEmail1">Text Color : </label>
                    <input class="jscolor {zIndex:9999} form-control" value="" id="modify_text_color">
                  </div>
                </div> 

                <div class="col-md-4"> 
                  <div class="form-group">
                    <label for="exampleInputEmail1">Text Background Color : </label>
                    <input class="jscolor {zIndex:9999} form-control"  id="modify_text_background" >
                  </div>
                </div>   

                <div class="col-md-4"> 
                  <div class="form-group">
                  <label for="exampleInputEmail1">Text Alignment : </label>
                  <select class="form-control" id="modify_text_alignment">
                    <option>Select Alignment</option>
                    <option value="3">LEFT</option>
                    <option value="5">RIGHT</option>
                    <option value="17">CENTER</option>
                    <option value="48">TOP</option>
                    <option value="80">BOTTOM</option>
                    <option value="1">CENTER_VERTICAL</option>
                    <option value="16">CENTER_HORIZONTAL</option>
                  </select>
                  </div>
                </div>

                <input type="hidden" name="modify_text_channel" id="modify_text_channel">

              </div>
           
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <center>
      <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#ModifyText').hide();document.getElementById('add').checked = true;">Close</button>
       <button type="button" class="btn btn-success" onclick="ModifyTextDisplaySubmit();">Submit</button>
       </center>
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
                    <label for="exampleInputEmail1">Zoom Level : </label>
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

             <input type="hidden" id="modify_files_file_name"> 

            <input type="hidden" name="modify_files_channel" id="modify_files_channel">
     
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <center>
           <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#Modify_Files').hide();">Close</button>
           <button type="button" class="btn btn-success" onclick="Modify_FilesDisplaySubmit();">Submit</button></center>
        </div>
        
      </div>
    </div>
  </div>


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

            <input type="hidden" name="modify_multiregion_josnformat" id="modify_multiregion_josnformat">

        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <center>
            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#ModifyMultiRegion').hide();">Close</button>
            <button type="button" class="btn btn-success" onclick="ModifyMultiRegionDisplaySubmit();">Submit</button>
          </center>
        </div>
        
      </div>
    </div>
  </div>





<script>
  
   /* var x = location.hostname;
         var domain = ['127.0.0.1','localhost'];
      
            var domainlength = domain.length;
            for(var i=0;i<domainlength;i++)
            {
              var format = domain[i];
              if(format==x){
               $('#superuser').show();  
                $('#superuser1').show();
          }else{
             $('#superuser').hide();  
             $('#superuser1').hide();   
          }
            
            }*/


document.getElementById('single').checked = true;

var arrayGlobal=["local_gc/"];
 console.log(JSON.stringify(arrayGlobal));

// $('#default_Channel').change(function(){
//   arrayGlobal=[];
//     $('#default_Channel option:selected').each(function(){
//         //alert($(this).val());
        

//         arrayGlobal.push($(this).val());

        
//     });

//     console.log(JSON.stringify(arrayGlobal));
// })





	var modify_audio_file_name;

	var arrayVal = [];

	$(".modify_audio_image_preview input:file").change(function (){     
          var modify_audio_file = this.files[0];
          document.getElementById('modify_assign_name_to_audio').innerHTML = modify_audio_file.name;
          //console.log("audio file name=="+audio_file.name);
          modify_audio_file_name = this.files[0];
            
        });


	function getListofFiles(value)
	{



		if(value=='delete')
		{
      $('#ScreeSelectionByUserforDelete').show();


		}else if(value=='modify')
		{
      $('#ScreeSelectionByUserforModify').show();


		}
	
	}



  function ScreenConnection(val,Channel_Channel)
  {
    

    if(Channel_Channel=='Select Screen' || Channel_Channel=='' || Channel_Channel==null){
        swal({
            title: 'Please select channel.!',
            timer: 2000
          });
            return false;
        }

   ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>Please wait...!");
    var form_data = new FormData();
        form_data.append('channel_id',Channel_Channel);
      
        $.ajax({
        type: "POST",
        dataType: 'text',
        url: "drive.php",
            cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
         
         success: function(data){
             console.log("result in connecting screen"+data);
            
             ajaxindicatorstop();
           
               var jsonResponse = JSON.parse(data);

               if(jsonResponse.statusCode==0)
               {
               
                       
                    if(jsonResponse.value==true)
                    {
                     

                      if(val=='delete')
                      {
                        $('#DeleteFilesList').show();
                       
                        getDeleteList('delete',Channel_Channel);

                        $('#ScreeSelectionByUserforDelete').hide();
                        

                      }else if(val=='modify')
                      {
                        $('#ModifyFilesList').show();
                        
                        getDeleteList('modify',Channel_Channel);

                        $('#ScreeSelectionByUserforModify').hide();
                      }
                      // else if(val=='multi')
                      // {
                      //   $('#multiregion').show();             
                      // }

                    }else if(jsonResponse.value==false)
                    {
                      swal(" Please check the connections of channel "+jsonResponse.name+".");                
                    }

                  }else if(jsonResponse.statusCode==1)
                  {
                
                      swal(jsonResponse.status);
                  }


                }
            });
  }

	function getDeleteList(val,Channel_Channel)
	{


		ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>Please wait...!");

  		var form_data = new FormData();
      		form_data.append('channel_path',Channel_Channel);
      
        $.ajax({
        type: "POST",
        dataType: 'text',
        url: "php/deleteFiles.php",
            cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
         
         	success: function(data)
         	{       
             ajaxindicatorstop();

           
               var jsonResponse = JSON.parse(data);

               if(jsonResponse.statusCode==0)
               {
                  

                  DisplayFilesList(jsonResponse.value,val,Channel_Channel);


	            }else if(jsonResponse.statusCode==1)
	            {
	              swal(jsonResponse.status);

	              if(val=='delete')
	              {
	              	$('#list_display').empty();
	              }
	              else if(val=='modify')
	              {
	              	$('#modify_list_display').empty();
	              }
	              
	               
	            }


            }
        });


	}

	function DisplayFilesList(values,name,Channel_Channel)
	{
		var totalen = values.length;

		if(name=='delete')
		{
			$("#list_display").empty();

      document.getElementById('delete_channel_path').value = Channel_Channel; 

			for(var i=0;i<totalen;i++)
			{
			var record = values[i];

			var recVal = getFileName(record);

			var newRows = "<div id='deletelist_"+i+"' style='border:1px solid orange;border-radius:5px;margin-bottom:5px;padding-left: 10px;'>";

				newRows +="<div class='checkbox '><label onclick='boxclick();'><input type='checkbox' class='checkbx_links_keyword' value='"+record+"' style='margin-top:7px;'> "+getFileName(record)+" </label></div>"

				newRows +="</div>"

			$("#list_display").append(newRows);
			}

		}else if(name=='modify')
		{
			$("#modify_list_display").empty();

      document.getElementById('modify_channel_path').value = Channel_Channel;

			for(var i=0;i<totalen;i++)
			{
				var record = values[i];

				var recVal = getFileName(record);

				var newRows = "<div id='modifylist_"+i+"' style='border:1px solid orange;border-radius:5px;margin-bottom:5px;padding: 10px;'>";

				newRows +="<p id='modify_name_"+i+"' style='margin:0px;'>"+getFileName(record)+"<span id='modify_edit_"+i+"' class='fa fa-pencil-square-o' onclick='ReadFileContent(\""+record+"\",\""+Channel_Channel+"\");' style='float:right;margin-right:10px;padding-top:5px;'>"+"</span>"+"</p>"



				newRows +="</div>"

				$("#modify_list_display").append(newRows);
			}

		}	

	}
	
	function getFileName(val)
	{
		var res = val.substr(0, val.lastIndexOf('.'));
		return res;
	}

	function boxclick()
	{
		arrayVal = [];
		  $(".checkbx_links_keyword").change(function () {
		      arrayVal = $(".checkbx_links_keyword:checked").map(function (i) {
		          return $(this).val();
		      }).get();

		      console.log(JSON.stringify(arrayVal));
		  });
  
		
	}


	function ReadFileContent(filename,Channel_Channel)
	{

		if(filename!=null)
		{

		ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>Please wait...!");

	  		var form_data = new FormData();
	      		form_data.append('filename',filename);
            form_data.append('channel_path',Channel_Channel);
	      
	        $.ajax({
	        type: "POST",
	        dataType: 'text',
	        url: "php/getReadFileContent.php",
	            cache: false,
	                contentType: false,
	                processData: false,
	                data: form_data,                         
	                type: 'post',
	         
	         	success: function(data)
	         	{
	            
	              ajaxindicatorstop();

	              if(data!=null)
	              {


	              	var jsonResponse = JSON.parse(data);

		                if(jsonResponse.statusCode==0)
		                {		      		                  
		                console.log("file Content=="+jsonResponse.value);

		                Readtextinsidefile(jsonResponse.value,filename,Channel_Channel);

			            }else if(jsonResponse.statusCode==1)
			            {
			              swal(jsonResponse.status);
			            }
	              	
	              }

	            }
	        });

		}
	}


	function Readtextinsidefile(list,filename,Channel_Channel)
	{

		var lists = JSON.parse(list);

		if(lists.type=='Url')
		{

			$('#ModifyURL').show();
			document.getElementById('modify_url').value = lists.url;
			document.getElementById('modify_media_name').value = filename;

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

			

     document.getElementById('modify_url_channel').value =Channel_Channel; 

		}else if(lists.type=='Image')
		{
			$('#ModifyImage').show();

			document.getElementById('modify_image_media_name').value = lists.media_name;


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

	        document.getElementById('modify_bg_audio_boolean').value = lists.play_bg_audio;

	        if(lists.play_bg_audio==true || lists.play_bg_audio=="true")
	        {

	          document.getElementById('modify_play_audio_checkbox_image').checked=true;

	          document.getElementById('modify_assign_name_to_audio').innerHTML=lists.bg_audio;

	          

	          $('#modify_audio_record_block').show();

	        }else if(lists.play_bg_audio==false || lists.play_bg_audio=="false")
	        {
	        	document.getElementById('modify_play_audio_checkbox_image').checked=false;

	        	$('#modify_audio_record_block').hide();
	        }

          document.getElementById('modify_image_channel').value =Channel_Channel;

		}else if(lists.type=='Video')
		{
			$('#ModifyVideo').show();

			document.getElementById('modify_video_media_name').value = lists.media_name;


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
      }else if(lists.display_scroll_txt==false)
      {
        document.getElementById('modify_video_media_checkbox').checked=false;
      }

      document.getElementById('modify_video_channel').value =Channel_Channel;

		}
    else if(lists.regions[0]['type']=='text')
    {
      $('#ModifyText').show();

      document.getElementById('modify_text_file_name').value=filename;
      document.getElementById('modify_text_media_name').value=lists.regions[0]['media_name'];
      document.getElementById('modify_text_duration').value=lists.duration;


      if(lists.offer_text==undefined || lists.offer_text=="undefined" || lists.offer_text=="" || lists.offer_text==" ")
      {
        document.getElementById('modify_text_text_media').value= "";
      }else 
      {
        document.getElementById('modify_text_text_media').value= lists.offer_text;
      } 

      document.getElementById('modify_text_font_size').value=lists.regions[0]['properties']['textSize'];

      document.getElementById('modify_text_color').value=Removehashintext(lists.regions[0]['properties']['textColor']);

      document.getElementById('modify_text_alignment').value=lists.regions[0]['properties']['textAlignment'];

      document.getElementById('modify_text_background').value=
      Removehashintext(lists.regions[0]['properties']['textBgColor']);

      document.getElementById('modify_text_channel').value=Channel_Channel;



    }

    else if(lists.regions[0]['type']=='File')
    {

      //console.log("===neee==="+lists.regions[0]['type']);

      $('#Modify_Files').show();

      document.getElementById('modify_files_file_name').value=filename;
      document.getElementById('modify_files_media_name').value=lists.regions[0]['media_name'];
      document.getElementById('modify_files_duration').value=lists.duration;


      document.getElementById('modify_files_zoomLevel').value=lists.regions[0].properties['zoomLevel'];

      document.getElementById('modify_files_scrollingSpeed').value=lists.regions[0].properties['scrollingSpeed'];


      if(lists.regions[0].properties['isFitToScreen']==true)
      {
          console.log(lists.regions[0].properties['isFitToScreen']);
          document.getElementById('modify_files_fitscreen').checked=true;

          $('#modify_files_zoomLevel').hide();

      }
      else
      {
          console.log(lists.regions[0].properties['isFitToScreen']);
          document.getElementById('modify_files_fitscreen').checked=false;
          $('#modify_files_zoomLevel').show();

      }


      if(lists.offer_text==undefined || lists.offer_text=="undefined" || lists.offer_text=="" || lists.offer_text==" ")
      {
        document.getElementById('modify_files_text_media').value= "";
      }else 
      {
        document.getElementById('modify_files_text_media').value= lists.offer_text;
      } 


      document.getElementById('modify_files_channel').value=Channel_Channel;


    }
    else if(lists.type=='multi_region')
    {
        console.log("Multi Region==="+lists.regions[0]['type']);

        $('#ModifyMultiRegion').show();

        document.getElementById('modify_multiregion_media_name').value=filename;

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

        document.getElementById('modify_multiregion_channel').value=Channel_Channel;


        document.getElementById('modify_multiregion_josnformat').value=list;
     

    }





	}


	function ModifyDisplaySubmit()
	{

	 	var url_url = document.getElementById('modify_url').value;
	 	var media_name = document.getElementById('modify_media_name').value;
	 	var duration = document.getElementById('modify_duration').value;
	 	var text_media = document.getElementById('modify_text_media').value;
	 	var Channel_Channel = document.getElementById('modify_url_channel').value;


		if(duration==null || duration=="" || duration==" " || duration=="Enter Duration(Sec)")
		{
		  duration = 10;
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
        

            var data = JSON.stringify(datastring);
        ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>Please wait...!");
          
          var form_data = new FormData();     
              form_data.append('media_name',media_name);
              form_data.append('path',Channel_Channel);             
            form_data.append('data',data);
    
               $.ajax({
                type: "POST",
                dataType: 'text',
                  url: "php/modifyurl.php",
                  cache: false,
                  contentType: false,
                  processData: false,
                  data: form_data,                         
                  type: 'post',
                 
                 success: function(data){

                  ajaxindicatorstop();
                   try
                   {
                    var jsonResponse = JSON.parse(data);
                    if(jsonResponse.statusCode==0)
                    {
                      
                      swal(jsonResponse.status);

                      $('#ModifyURL').hide();

                    }else
                    {
                       swal(jsonResponse.status);
                    }
                   }catch(Exception)
                   {
                     alert('Error,please contact technical support..!');
                   } 

                  }
                });

	}




	function ModifyVideoDisplaySubmit()
	{
	 	 var modify_resource = document.getElementById('modify_video_resource').value;
	 	var media_name = document.getElementById('modify_video_media_name').value;
	 	var text_media = document.getElementById('modify_video_text_media').value;
	 	var Channel_Channel = document.getElementById('modify_video_channel').value;


		
		if(media_name=='Enter Media Name' || media_name=='' || media_name==null){
		  swal({
		  title: 'Please enter media name',
		  timer: 2000
		});
		  return false;
		} 

  		var datastring = {}
          
            datastring['type'] = "Video";
            datastring['offer_text'] = text_media;
            datastring['resource'] = modify_resource;
            datastring['display_scroll_txt'] = false;
            
            datastring['media_name'] = media_name;
            

            var data = JSON.stringify(datastring);
           
         ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>Please wait...");
          var form_data = new FormData();     
              form_data.append('media_name',media_name);
              form_data.append('path',Channel_Channel);             
            form_data.append('data',data);
    
               $.ajax({
                type: "POST",
                dataType: 'text',
                  url: "php/modifyvideo.php",
                  cache: false,
                  contentType: false,
                  processData: false,
                  data: form_data,                         
                  type: 'post',
                 
                 success: function(data){

                  ajaxindicatorstop();
                   try
                   {
                    var jsonResponse = JSON.parse(data);
                    if(jsonResponse.statusCode==0)
                    {
                      
                      swal(jsonResponse.status);

                      $('#ModifyVideo').hide();

                    }else
                    {
                       swal(jsonResponse.status);
                    }
                   }catch(Exception)
                   {
                     alert('Error,please contact technical support..');
                   } 

                  }
                });

	}



	function ModifyImageDisplaySubmit()
	{
		var media_name = document.getElementById('modify_image_media_name').value;
		var text_media = document.getElementById('modify_image_text_media').value;
		var duration = document.getElementById('modify_image_duration').value;

		var modify_resource = document.getElementById('modify_image_resource').value;
		var  modify_bg_audio_name = document.getElementById('modify_bg_audio_name').value;
		var  modify_bg_audio_boolean = document.getElementById('modify_bg_audio_boolean').value;

    var Channel_Channel = document.getElementById('modify_image_channel').value;

		if(duration==null || duration=="" || duration==" " || duration=="Enter Duration(Sec)")
		{
		  duration = 10;
		}

		if(media_name=='Enter Media Name' || media_name=='' || media_name==null)
		{
		  swal({
		  title: 'Please enter media name',
		  timer: 2000
		});
		  return false;
		} 


    if(document.getElementById('modify_play_audio_checkbox_image').checked==true)
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

    }


  
       
        var datastring = {}
          
              datastring['type'] = "Image";
              datastring['media_name'] = media_name;
              datastring['offer_text'] = text_media;
              datastring['resource'] = modify_resource;
              datastring['duration'] = duration;
              datastring['display_scroll_txt'] = false;
            
              datastring['bg_audio'] = aud_name;
              datastring['play_bg_audio'] = aud_booblean;
          
            var data = JSON.stringify(datastring);

            console.log("===0fhds"+data);
            
       ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>Please wait...");
        var form_data = new FormData(); 
           //form_data.append('duration_name',file_new_name);
           form_data.append('audio_name',aud_name);
           form_data.append('path',Channel_Channel); 
           form_data.append('AudiofileName',modify_audio_file_name); 
           form_data.append('media_name',media_name);
           form_data.append('data',data);
    
            $.ajax({
                type: "POST",
                dataType: 'text',
                  url: "php/modifyimage.php",
                  cache: false,
                  contentType: false,
                  processData: false,
                  data: form_data,                         
                  type: 'post',
                 
                 success: function(data){

                   ajaxindicatorstop();
                   try
                   {
                    var jsonResponse = JSON.parse(data);
                    if(jsonResponse.statusCode==0)
                    {
                      
                      swal(jsonResponse.status);

                      $('#ModifyImage').hide();

                    }else
                    {
                       swal(jsonResponse.status);
                    }
                   }catch(Exception)
                   {
                      alert('Error,please contact technical support..');
                   } 

                  }
                });
	}
	
	function DeleteFiles()
	{
		
    var Channel_Channel = document.getElementById('delete_channel_path').value;

		if(arrayVal!=null && arrayVal.length>=1)
		{			
      ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>Please wait...");

			var form_data = new FormData(); 
           	form_data.append('channel_path',Channel_Channel);
          	form_data.append('deletedata',JSON.stringify(arrayVal));
    
            $.ajax({
                type: "POST",
                dataType: 'text',
                  url: "php/deleteSelectedFilesInDir.php",
                  cache: false,
                  contentType: false,
                  processData: false,
                  data: form_data,                         
                  type: 'post',
                 
                 success: function(data){
                  console.log("deletefiles==" +data);
                  ajaxindicatorstop();
                   try
                   {
                    var jsonResponse = JSON.parse(data);
                    if(jsonResponse.statusCode==0)
                    {
                      
                      swal(jsonResponse.status);

                      $('#DeleteFilesList').hide();

                      setTimeout(function(){
                        window.location.reload();
                      }, 2000);
                       
                    }else
                    {
                       swal(jsonResponse.status);
                    }
                   }catch(Exception)
                   {
                    alert('Error,please contact technical support..');
                   } 

                  }
                });

		}else 
		{

			swal("Select the files to delete");

		}


		
	}

	 function onkeyValuepress()
    {
        var fname = document.getElementById("modify_video_text_media").value;
    
          if(fname.length>=1)
          {
            
            $('#modify_video_media_checkbox_label').show();
          }
          else {
           
            $('#modify_video_media_checkbox_label').hide();
          }
        
    }


    function ModifyCheckUncheck()
    {
        if(document.getElementById('modify_play_audio_checkbox_image').checked==true)
        {
           $('#modify_audio_record_block').show();
        }else 
        {
           $('#modify_audio_record_block').hide();
        }
        
    }


    function ModifyonkeyValuepressImage()
    {
        var fname = document.getElementById("modify_image_text_media").value;
    
        if(fname.length>=1)
        {
            $('#modify_media_checkbox_label_image').show();
        }
        else 
        {
            $('#modify_media_checkbox_label_image').hide();
        }
        
    }

    function file_get_ext(filename)
    {
        return typeof filename != "undefined" ? filename.substring(filename.lastIndexOf(".")+1, filename.length).toLowerCase() : false;
    }



    function Removehashintext(text)
    {

          
          return text.replace( /#/g, "" );

    }



  function ModifyTextDisplaySubmit()
  {
      var file_name = document.getElementById('modify_text_file_name').value;
      var media_name = document.getElementById('modify_text_media_name').value;
      var duration = document.getElementById('modify_text_duration').value;
      var text_media = document.getElementById('modify_text_text_media').value;
      var text_size = document.getElementById('modify_text_font_size').value;
      var text_color = document.getElementById('modify_text_color').value;

      var text_alignment = document.getElementById('modify_text_alignment').value;
      var text_background = document.getElementById('modify_text_background').value;
      var Channel_Channel = document.getElementById('modify_text_channel').value;

      text_color="#"+text_color;
      text_background="#"+text_background;

      if(duration==null || duration=="" || duration==" " || duration=="Enter Duration(Sec)")
      {
        duration = 10;
      }

      if(text_size==null || text_size=="" || text_size==" " || text_size=="Enter Font Size")
      {
        text_size = 40;
      }

      if(media_name=='Enter your text' || media_name=='' || media_name==null){
        swal({
        title: 'Please enter text',
        timer: 2000
      });
        return false;
      } 
      else if(file_name=='Enter media name' || file_name=='' || file_name==null){
        swal({
        title: 'Please enter media name',
        timer: 2000
      });
        return false;
      } 
 
      else if(text_alignment=='Select Alignment' || text_alignment=='' || text_alignment==null){
        swal({
                  title: 'Select text alignment on screen to display.',
                  timer: 2000
                });
                  return false;
      }
      else if(Channel_Channel=='Select Screen' || Channel_Channel=='' || Channel_Channel==null){
        swal({
                  title: 'Please select channel.',
                  timer: 2000
                });
                  return false;
      }


          var data1 = ({ "textBgColor":text_background,"textColor":text_color,"textSize":Number(text_size),"isScrollAnim":false,"textAlignment":Number(text_alignment)});


          var datastring = ([{"type":"text","width":100,"height":100,"top_margin":0,"bottom_margin":0,"left_margin":0,"right_margin":0,"media_name":media_name,"is_self_path":false,'properties':data1}]);


           var data = JSON.stringify(datastring);
            
        ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>Please wait...");
          var form_data = new FormData();     
            form_data.append('file_name',file_name);
            form_data.append('path',Channel_Channel);             
            form_data.append('data',data);
            form_data.append('offer_text',text_media);
            form_data.append('duration',duration);
            form_data.append('text',media_name);
            
            

               $.ajax({
                type: "POST",
                dataType: 'text',
                  url: "php/modifytext.php",
                  cache: false,
                  contentType: false,
                  processData: false,
                  data: form_data,                         
                  type: 'post',
                 
                 success: function(data){

                  ajaxindicatorstop();
                   try
                   {
                 
                    var jsonResponse = JSON.parse(data);
                    if(jsonResponse.statusCode==0)
                    {
                      
                      swal(jsonResponse.status);

                      $('#ModifyText').hide();

                    }else
                    {
                       swal(jsonResponse.status);
                    }

                   }catch(Exception)
                   {
                     alert('Error,please contact technical support..');
                   } 

                  }
        });
     

  }


  function SelectScreen(name)
  {
    // alert(name);
    // var option = document.getElementById('default_Channel').value;

    // console.log("qwqwq"+option);

    // if(option=='Select Screen' || option=='' || option==null || option==' ' || option==undefined || option=='undefined')
    // {
    //     setTimeout(function() {
    //     swal({
    //         title: "",
    //         text: "Please select channel.!",
    //         type: ""
    //     }, function() {
    //         window.location = "home.php";
    //     });
    // }, 2000);

    //     return false;
    // }else 
    // {


        var url = "/smweb/";

        if(name=="Image")
        {
          window.location.href = url+"image.php?screen='"+JSON.stringify(arrayGlobal)+"'&mode='local' ";

        }else if(name=="Video")
        {
          window.location.href = url+"video.php?screen='"+JSON.stringify(arrayGlobal)+"'&mode='local' ";

        }else if(name=="Text")
        {
           window.location.href = url+"text.php?screen='"+JSON.stringify(arrayGlobal)+"'&mode='local' ";

        }else if(name=="File")
        {
           window.location.href = url+"file.php?screen='"+JSON.stringify(arrayGlobal)+"'&mode='local' ";

        }else if(name=="Url")
        {
           window.location.href = url+"url.php?screen='"+JSON.stringify(arrayGlobal)+"'&mode='local' ";

        }
        else if(name=="multi")
        {
          // ScreenConnection('multi',JSON.stringify(arrayGlobal));
                        $('#multiregion').show();                     
        }



    // }


  }

  // multiregion function
  function multiscreen(name)
  {

    //console.log("====xnfjsn=="+JSON.stringify(arrayGlobal));

    // var option = document.getElementById('default_Channel').value;

    // console.log("qwqwq"+option);

    // if(option=='Select Screen' || option=='' || option==null || option==' ' || option==undefined || option=='undefined')
    // {

    //      setTimeout(function() {
    //     swal({
    //         title: "",
    //         text: "Please select channel.!",
    //         type: ""
    //     }, function() {
    //         window.location = "home.php";
    //     });
    // }, 2000);

    //     return false;
    // }else 
    // {
        var url = "/smweb/multiregion/";

        if(name=="template1")
        {
          window.location.href = url+"template1.php?screen='"+JSON.stringify(arrayGlobal)+"'&mode='local' ";

        }else if(name=="template2")
        {
          window.location.href = url+"template2.php?screen='"+JSON.stringify(arrayGlobal)+"'&mode='local' ";

        }else if(name=="template3")
        {
           window.location.href = url+"template3.php?screen='"+JSON.stringify(arrayGlobal)+"'&mode='local' ";

        }else if(name=="template4")
        {
           window.location.href = url+"template4.php?screen='"+JSON.stringify(arrayGlobal)+"'&mode='local' ";

        }
        else if(name=="template5")
        {
           window.location.href = url+"template5.php?screen='"+JSON.stringify(arrayGlobal)+"'&mode='local' ";

        }
        else if(name=="template6")
        {
           window.location.href = url+"template6.php?screen='"+JSON.stringify(arrayGlobal)+"'&mode='local' ";

        }
        else if(name=="template7")
        {
           window.location.href = url+"template7.php?screen='"+JSON.stringify(arrayGlobal)+"'&mode='local' ";

        }

    }


  // }

//start modify functionality
// function SelectScreen1(name)
//   {
//         if(name=="modify")
//         {
           
//            console.log(name);
//            $('#ModifyFilesList').show();

           
//            ScreenConnection1(name);

//         }else if(name=="delete")
//         {
           
//            console.log(name);
//            $('#DeleteFilesList').show();

          
//            ScreenConnection1(name);

//         }


//   }

  function ScreenConnection1(val)
  {

    if(val=="modify")
    {
      var Channel_Channel = document.getElementById('default_Channel1').value;
    }else if(val=="delete")
    {
      var Channel_Channel = document.getElementById('default_Channel2').value;
    }

    
    console.log(val+"==="+Channel_Channel);

    if(Channel_Channel=='Select Screen' || Channel_Channel=='' || Channel_Channel==null)
    {
        swal({
            title: 'Please select channel.',
            timer: 2000
          });
            return false;
    }

    var datastring =[Channel_Channel];

      console.log(JSON.stringify(datastring));

   ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>Please wait...");
    var form_data = new FormData();
        form_data.append('channel_id',JSON.stringify(datastring));
      
        $.ajax( {
        type: "POST",
        dataType: 'text',
        url: "drive.php",
            cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
         
         success: function(data){
             console.log("result in connecting screen1"+data);
            
             ajaxindicatorstop();
           
               var jsonResponse = JSON.parse(data);

               if(jsonResponse.statusCode==0)
               {
               
                       
                    if(jsonResponse.value==true)
                    {
                     

                      if(val=='delete')
                      {
                        // $('#DeleteFilesList').show();
                       
                        getDeleteList('delete',Channel_Channel);

                        $('#ScreeSelectionByUserforDelete').hide();
                        

                      }else if(val=='modify')
                      {
                        // $('#ModifyFilesList').show();
                        
                        getDeleteList('modify',Channel_Channel);

                        $('#ScreeSelectionByUserforModify').hide();
                      }

                    }else if(jsonResponse.value==false)
                    {
                      swal("Please check the connections of channel "+jsonResponse.name+".");                
                    }

                  }else if(jsonResponse.statusCode==1)
                  {
                
                      swal(jsonResponse.status);
                  }


                }
            });


  }
//end modify functionality


  function Modify_FilesDisplaySubmit()
  {
      var media_name = document.getElementById('modify_files_media_name').value;
      var duration = document.getElementById('modify_files_duration').value;
      var text_media = document.getElementById('modify_files_text_media').value;
      var zoomLevel = document.getElementById('modify_files_zoomLevel').value;
      var scrollingSpeed = document.getElementById('modify_files_scrollingSpeed').value;

      var file_name = document.getElementById('modify_files_file_name').value;


      var Channel_Channel = document.getElementById('modify_files_channel').value;


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


         if(media_name=='Enter Media Name' || media_name=='' || media_name==null){
          swal({
          title: 'Please enter media name',
          timer: 2000
        });
          return false;
        } 

        console.log(media_name+"...."+duration);

        var data2 = ({"zoomLevel":Number(zoomLevel),"scrollingSpeed":Number(scrollingSpeed),"isFitToScreen":isFitToScreen});

        var datastring = ([{"type":"File","width":100,"height":100,"top_margin":0,"bottom_margin":0,"left_margin":0,"right_margin":0,"media_name":media_name,"is_self_path":false,'properties':data2}]);

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

          ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>File transfer in progress<br/> Please wait...");
          
          var form_data = new FormData();     
            form_data.append('fileName',file_name);
            form_data.append('path',Channel_Channel);             
            form_data.append('data',data);
            form_data.append('data1',data1);
            form_data.append('offer_text',text_media);
            form_data.append('duration',duration);
            form_data.append('media_name',media_name);
           

               $.ajax({
                type: "POST",
                dataType: 'text',
                  url: "php/modifyfiles.php",
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
                      
                      swal(jsonResponse.status);

                      $('#Modify_Files').hide();

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


    function fitscreen()
    {
      if(document.getElementById('modify_files_fitscreen').checked==true)
      {
        $('#modify_files_zoomLevel').hide();
      }else 
      {
        $('#modify_files_zoomLevel').show();
      }
        
    }


  function ModifyMultiRegionDisplaySubmit()
  {
      var media_name = document.getElementById('modify_multiregion_media_name').value;

      var duration = document.getElementById('modify_multiregion_duration').value;

      var text_media = document.getElementById('modify_multiregion_text_media').value;

      var array_Jsonformat = document.getElementById('modify_multiregion_josnformat').value;

      var Channel_Channel = document.getElementById('modify_multiregion_channel').value;

        //console.log(media_name+"...."+duration+"==="+array_Jsonformat);

          ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>File transfer in progress<br/> Please wait...");
          
          var form_data = new FormData();     
            //form_data.append('fileName',file_name);
            form_data.append('path',Channel_Channel);             
            form_data.append('data',array_Jsonformat);
            //form_data.append('data1',data1);
            form_data.append('offer_text',text_media);
            form_data.append('duration',duration);
            form_data.append('media_name',media_name);
           

               $.ajax({
                type: "POST",
                dataType: 'text',
                  url: "php/ModifyMultiRegionFiles.php",
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
                      
                      swal(jsonResponse.status);

                      $('#ModifyMultiRegion').hide();

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


</script>

<!-- Load JS here for greater good =============================-->
<script src="js/jquery-.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/anim.js"></script>



</body>
</html>