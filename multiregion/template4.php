<?php
// require("Constants.php");
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
<link href="../css/style.css" rel="stylesheet">
<script src="../js/sweetalert.js"></script>
<link rel="stylesheet" href="../js/sweetalert.css">
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/default_busy_loader.js"></script>
<link href="../_css/Icomoon/style.css" rel="stylesheet" type="text/css" />
<script src="../js/js/popper.min.js"></script>
<link rel="stylesheet" href="Font-Awesome-5.5.0/web-fonts-with-css/css/fontawesome-all.min.css">

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
      
          .wrap {
    width: 540px;
    height: 280px;
    padding: 0;
    overflow: hidden;
        border: 1px solid black;
 
}
.frame {
    width: 2138px;
    height: 1090px;
    border: 0;
    -ms-transform: scale(0.25);
    -moz-transform: scale(0.25);
    -o-transform: scale(0.25);
    -webkit-transform: scale(0.25);
    transform: scale(0.25);
    
    -ms-transform-origin: 0 0;
    -moz-transform-origin: 0 0;
    -o-transform-origin: 0 0;
    -webkit-transform-origin: 0 0;
    transform-origin: 0 0;
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
"> <img src="../images/signage.png" alt="" class="logo" style="width: 80px;height: 70px;margin: -15px 0px;">Signage Manager </a>
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
        <div class="text-pageheader">
          <div class="subtext-image" data-scrollreveal="enter bottom over 1.7s after 0.1s" >
            <h2><span style="color: orange;"><?= $user['email']; ?></span></h2>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</header>

<!-- CONTENT =============================-->
<section class="item content" style="background-color: darkgray;">
<div class="container toparea" >
  <div class="underlined-title">
    <div class="editContent">
      <h1 class="text-center latestitems">TEMPLATE 4</h1><span class="btn btn-warning" style="float:right;margin-bottom: 10px;" onclick="javascript:location.reload();" >Clear</span>
    </div>
  </div>
    <div class="rows">
       <div class="col-md-12">
        <div class="rows">
      <div class="col-md-12">
        
     <div class="col-md-3">
      </div>
        <div class="col-md-6">
      
   <div class="wrap">
       <iframe class="frame" id="region1" src="../images/plus333.png" >Please click here to select content</iframe>
        <textarea class="frame" id="textregion1" style="display: none;" disabled></textarea>
       </div>
        </div>
         <div class="col-md-3">
      </div>
      </div>
    </div>
    <div class="rows">
      <div class="col-md-12" >
          
     <div class="col-md-3">
      </div>
        <div class="col-md-6">
   <div class="wrap">
         <iframe class="frame" id="region2" src="../images/plus333.png" ></iframe>
         <textarea class="frame" id="textregion2" style="display: none;" disabled></textarea>
      </div> </div>
         <div class="col-md-3">
      </div>
       </div>
     </div>
       <center>
          <a href="../index.php"><button class="btn btn-danger" style="display:inline-block;">Close</button></a> 
      <button class="btn btn-success" onClick="validation();" style="margin:10px 10px;">Send</button>
      </center>
      
     

     


      </div>
    </div>
       

  </div>
<!-- </div> -->
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
       $('#propClone').hide(); 
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

<!-- select option -->
  <div class="modal fade" id="selectoption" style="z-index: 1400;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" style="text-align:center;">Select Media
          <span type="button" class="close" data-dismiss="modal" onclick="$('#selectoption').hide();">&times;</span></h4>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" >
        
 <div class="row">
  <div class="col-md-3">
   <div class="productbox" style="border: 2px solid orange;" onclick="selectimage();">
     <!--  <div class="product-details" data-toggle="modal" data-target="#pushimage"> -->
       <div class="product-details" >
          <img src="../images/image.png" alt="">
          <h5>IMAGE</h5>
      </div>
   </div>
  </div>

  <div class="col-md-3">
   <div class="productbox" style="border: 2px solid orange;" onclick="selectvideo();"> 
   <!--  <div class="product-details" data-toggle="modal" data-target="#pushvideo"> -->
     <div class="product-details" >
      <img src="../images/video.png" alt="">
     <h5>VIDEO</h5>
    </div>
   </div>
  </div>

  <div class="col-md-3">
   <div class="productbox" style="border: 2px solid orange;">
    <div class="product-details" data-toggle="modal" data-target="#pushtext">
      <img src="../images/text.png" alt="">
     <h5>TEXT</h5>
    </div>
    <!-- </a> -->
   </div>
  </div>


   <div class="col-md-3">
   <div class="productbox" style="border: 2px solid orange;">
    <div class="product-details" data-toggle="modal" data-target="#pushurl">
      <img src="../images/url.png" alt="">
     <h5>URL</h5>
    </div>
   </div>
  </div>  
<input type="text" id="regionid" style="display: none;">

</div>
      
           
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <center>
      <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#selectoption').hide();">Close</button>
      <!--  <button type="button" class="btn btn-success" onclick="">Submit</button> -->
       </center>
        </div>
        
      </div>
    </div>
  </div>
<!-- select option -->




<!-- IMAGE -->
  <div class="modal fade" id="pushimage" style="z-index:1600;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" style="text-align:center;">IMAGE
          <span type="button" class="close" data-dismiss="modal" onclick="$('#pushimage').hide();">&times;</span></h4>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style="overflow-y:auto;">
          
            <div class="rows">

                <div class="col-md-12">

                    <label for="exampleInputEmail1">Choose Image File : *</label>
                    <div class="input-group image-preview col-md-12">
                   
                    <!-- image-preview-input -->
                    <div class="btn btn-outline-primary image-preview-input col-md-2" style="border-radius:0px;">
                      <span class="glyphicon glyphicon-folder-open"></span>
                      <span class="image-preview-input-title">Browse</span>
                      <input type="file" accept="image/*" name="input-file-preview" id="imagename"/> <!-- rename it -->
                    </div>
                   
                   
                    <div class="col-md-8" style="margin: 0px;padding: 0px;">
                      <input type="text" class="form-control image-preview-filename" disabled="disabled" id="multiimage_file"> <!-- don't give a name === doesn't send on POST/GET -->
                    </div>

                    <div class="col-md-2">
                      <span class="input-group-btn">
                        <!-- image-preview-clear button -->
                        <button type="button" class="btn btn-outline-warning image-preview-clear" style="display:none;border-radius:0px;">
                          <span class="glyphicon glyphicon-remove"></span> Clear
                        </button> 
                      </span>
                    </div>

                  </div><!-- /input-group image-preview [TO HERE]--> 

              <!--     <br > -->

                </div>


                       <!--  <div class="col-md-12">

                            <div class="col-md-6" style="padding-left:0px;padding-right:0px;">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Media Name : *</label>
                                   <input type="text" class="form-control" placeholder="Enter Media Name" name="media_name" id="media_name">
                                </div>
                          </div>

                            <div class="col-md-6" style="padding-right:0px;">
                              <div class="form-group">
                                 <label for="exampleInputPassword2">Play Duration : </label>
                                  <input type="number" class="form-control" placeholder="Enter Duration in Second(s)" name="duration" id="duration">
                              </div>
                            </div>

                        </div> -->

                          <!-- <div class="col-md-12"> -->
<!-- 
                              <div class="form-group">
                                <label for="exampleInputEmail1">Scrolling Text : </label>
                                <input type="text" class="form-control" placeholder="Enter Scrolling Text that will be displayed on the bottom of the Screen" name="text_media" id="text_media" >
                              </div>

                              <div class="form-group">
                                <label id="media_checkbox_label_image" style="display:none;"><input type="checkbox" id="media_checkbox_image"> </label>
                              </div>


                              <div class="checkbox">
                                <label id="play_audio_checkbox_label_image" onclick="CheckUncheck()"><input type="checkbox" id="play_audio_checkbox_image" >  Play Audio with Media : </label>
                              </div> -->
                  
                           <!--    <div class="form-group" id="audio_record_block" style="display:none;">
                              <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 col-12 audio_image_preview" >
                         
                                    <label class="btn btn-primary"><span class="icon-music"><input type="file" name="input-file-audio-preview" accept="audio/*" style="display:none;"/>     Attach Audio File</span></label><br>
                                    <p id="assign_name_to_audio"></p>
                              </div>
                              </div> -->

                      <!--      </div> -->

                    
       
        </div>
    </div>

        <div class="modal-footer">
        <center>     
                 <button class="btn btn-danger"  data-dismiss="modal" onclick="$('#pushimage').hide();">Close</button>       
                  <button class="btn btn-success" id="submit" onclick="multicontent('IMAGE');">Ok</button>
        </center>
         
        </div>
        
      </div>
    </div>
  </div>
<!-- IMAGE -->

<!-- VIDEO -->
  <div class="modal fade" id="pushvideo" style="z-index:1600;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" style="text-align:center;">VIDEO
          <span type="button" class="close" data-dismiss="modal" onclick="$('#pushvideo').hide();">&times;</span></h4>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style="overflow-y:auto;">
           <div class="col-md-12">

           <label for="exampleInputEmail1">Choose Video File : *</label>
              <div class="input-group video-preview col-md-12">
                    
                 
                  <div class="btn btn-outline-primary video-preview-input col-md-2" style="border-radius:0px;">
                    <span class="glyphicon glyphicon-folder-open"></span>
                    <span class="video-preview-input-title">Browse</span>
                    <input type="file" accept="video/*" name="input-file-preview" id="videopath"/> <!-- rename it -->
                  </div>
                   
                   
                   <div class="col-md-8" style="margin: 0px;padding: 0px;">
                    <input type="text" class="form-control video-preview-filename" disabled="disabled" id="video_file"> <!-- don't give a name === doesn't send on POST/GET -->
                  </div>
                   <div class="col-md-2">
                    <span class="input-group-btn">
                      <!-- image-preview-clear button -->
                      <button type="button" class="btn btn-outline-warning video-preview-clear" style="display:none;border-radius:0px;">
                        <span class="glyphicon glyphicon-remove"></span> Clear
                      </button>
                    </span>
                  </div>


                </div>

           <!--        <br>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Media Name : *</label>
                    <input type="text" class="form-control" placeholder="Enter Media Name" name="media_name" id="video_media_name">               
                  </div> -->


          </div>
       
        </div>

        <div class="modal-footer">
        <center>     
                 <button class="btn btn-danger"  data-dismiss="modal" onclick="$('#pushvideo').hide();">Close</button>       
                   <button class="btn btn-success" id="submit" onclick="multicontent('VIDEO');">Ok</button>
        </center>
         
        </div>
        
      </div>
    </div>
  </div>
<!-- VIDEO -->

<!-- Text -->
  <div class="modal fade" id="pushtext" style="z-index:1600;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" style="text-align:center;">Text
          <span type="button" class="close" data-dismiss="modal" onclick="$('#pushtext').hide();">&times;</span></h4>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style="overflow-y:auto;">
     
        <div class="form-group">
          <label for="exampleInputPassword1">Rich Text : *</label>
            <textarea class="form-control" placeholder="Enter your text need to be displayed" name="media_name" id="textmedia_name"></textarea>
        </div>

         
        <!-- <div class="col-md-6" style="padding-left:0px;padding-right:0px;">
            <div class="form-group">
              <label for="exampleInputEmail1">Media Name : *</label>
              <input type="text" class="form-control" placeholder="Enter media name" name="file_name" id="file_name">
            </div>

        </div>  

        <div class="col-md-6" style="padding-right:0px;">

            <div class="form-group">
              <label for="exampleInputPassword2">Play Duration :</label>
              <input type="number" class="form-control" placeholder="Enter Duration in Second(s)" name="duration" id="duration">
            </div>

        </div>             -->

        
        <div class="col-md-6" style="padding-left:0px;padding-right:0px;">
          <div class="form-group">
            <label for="exampleInputPassword2">Text Size :</label>
            <input type="number" class="form-control" placeholder="Enter Font Size" name="font_size" id="text_size" value=40>
          </div> 
        </div>



        <div class="col-md-6" style="padding-right:0px;">
          <div class="form-group">
            <label for="exampleInputEmail1">Text Color :</label>
            <input class="jscolor {zIndex:9999} form-control" value="000000" id="text_color">
          </div>

        </div>



        <div class="col-md-6" style="padding-left:0px;padding-right:0px;">
          <div class="form-group">
            <label for="exampleInputEmail1">Text Background Color :</label>
            <input class="jscolor {zIndex:9999} form-control" value="FFFFFF" id="text_background">
          </div>
        </div>

        <div class="col-md-6" style="padding-right:0px;">

          <div class="form-group">
            <label for="exampleInputEmail1">Text Alignment : *</label>
              <select class="form-control" id="text_alignment">
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

        
     <!--    <div class="form-group">
          <label for="exampleInputEmail1">Scrolling Text : </label>
          <input type="text" class="form-control" placeholder="Enter Scrolling Text that will be displayed on the bottom of the Screen" name="text_media" id="text_scrollmedia">
        </div> -->

        </div>

        <div class="modal-footer">
        <center>     
                 <button class="btn btn-danger"  data-dismiss="modal" onclick="$('#pushtext').hide();">Close</button>       
                  <button class="btn btn-success" id="submit" onclick="multicontent('TEXT');">Ok</button>
        </center>
         
        </div>
        
      </div>
    </div>
  </div>
<!-- Text -->

<!-- URL-->
  <div class="modal fade" id="pushurl" style="z-index:1600;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" style="text-align:center;">URL
          <span type="button" class="close" data-dismiss="modal" onclick="$('#pushurl').hide();">&times;</span></h4>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style="overflow-y:auto;">
     
                <div class="col-md-12">

          <!-- <form class="feedback" name="feedback"> -->
              <div class="form-group">
                <label for="exampleInputEmail1">URL : *</label>
                <input type="text" class="form-control" value="https://www." name="url" id="url" focus>
                <span>Enter url address like https://www.xyz.com</span>
              </div>

             <!--  <div class="col-md-6" style="padding-left:0px;padding-right:0px;">
                <div class="form-group">
                  <label for="exampleInputPassword1">Media Name : *</label>
                  <input type="text" class="form-control" placeholder="Enter Media Name" name="media_name" id="media_name">      
                </div>
              </div>


              <div class="col-md-6" style="padding-right:0px;">
                 <div class="form-group">
                    <label for="exampleInputPassword2">Play Duration  :</label>
                    <input type="number" class="form-control" placeholder="Enter Duration(Sec)" name="duration" id="duration">
                  </div> 
              </div>


              <div class="form-group">
                <label for="exampleInputEmail1">Scrolling Text :</label>
                <input type="text" class="form-control" placeholder="Enter Scrolling Text that will be displayed on the bottom of the Screen" name="text_media" id="text_media">
              </div> -->
          </div>
        </div>

        <div class="modal-footer">
        <center>     
                 <button class="btn btn-danger"  data-dismiss="modal" onclick="$('#pushurl').hide();">Close</button>       
                  <button class="btn btn-success" id="submit" onclick="multicontent('URL');">Ok</button>
        </center>
         
        </div>
        
      </div>
    </div>
  </div>
<!-- URL -->

<!-- SEND-->
  <div class="modal fade" id="pushcontent" style="z-index:1600;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" style="text-align:center;">Template Name
          <span type="button" class="close" data-dismiss="modal" onclick="$('#pushcontent').hide();">&times;</span></h4>
          <center><img id="loading" src="../images/ajax-loader.gif" alt="Updating ..." style="display: none;" /></center>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style="overflow-y:auto;">
     
                <div class="col-md-12">

          <!-- <form class="feedback" name="feedback"> -->
    
               <div class="form-group">
                  <label for="exampleInputPassword1">Media Name : *</label>
                  <input type="text" class="form-control" placeholder="Enter Media Name" name="media_name" id="file_media_name">      
                </div>

              <div class="col-md-6" style="padding-left:0px;padding-right:10px;">

              <div class="form-group">
                <label for="exampleInputEmail1">Scrolling Text :</label>
                <input type="text" class="form-control" placeholder="Enter Scrolling Text that will be displayed on the bottom of the Screen" name="text_media" id="file_text_media">
              </div> 
            </div>

              <div class="col-md-6" style="padding-left:0px;padding-right:0px;">
                 <div class="form-group">
                    <label for="exampleInputPassword2">Play Duration (sec):</label>
                    <input type="number" class="form-control" placeholder="Enter Duration(Sec)" value="10" name="duration" id="file_duration">
                  </div> 
                   </div>

            

          </div>
        </div>

        <div class="modal-footer">
        <center>     
                 <button class="btn btn-danger"  data-dismiss="modal" onclick="$('#pushcontent').hide();">Close</button>       
                  <button class="btn btn-success" id="submit" onclick="ScreenConnection();">Submit</button>
        </center>
         
        </div>
        
      </div>
    </div>
  </div>
<!-- SEND-->

<!-- Load JS here for greater good =============================-->
<script src="../js/jquery-.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/anim.js"></script>
<script src="../js/jscolor.js"></script>
 <script src="../js/js/Videopage.js"></script>
 <script src="../js/js/Imagepage.js"></script>



<script type="text/javascript">

        function selectimage(){
    document.getElementById("imagename").click();
  }
       function selectvideo(){
    document.getElementById("videopath").click();
  }

  function validation(){
    var regions1 = document.getElementById("region1").src;
     var regions11 = document.getElementById("textregion1").value;
     var regions2 = document.getElementById("region2").src;
     var regions22 = document.getElementById("textregion2").value;

     console.log(regions1+" "+regions11);

     if(regions1=="http://localhost/smweb/images/plus44.png" && regions11==""){
      swal("please select region 1");
     }else if(regions2=="http://localhost/smweb/images/plus44.png" && regions22==""){
      swal("please select region 2");
     }else{
       $('#pushcontent').modal('show');
     }

  }

    var currentdate = new Date();
           var datetime = currentdate.getDate() + "-"
                + (currentdate.getMonth()+1)  + "-" 
                + currentdate.getFullYear() + "_"  
                + currentdate.getHours() + "-"  
                + currentdate.getMinutes() + "-" 
                + currentdate.getSeconds();
           document.getElementById("file_media_name").value=datetime;

$(document).ready(function(){
    $("#region1").load(function(){
        $(this).contents().on("mousedown, mouseup, click", function(){
           showmedia('r1');
        });
    });
});
$(document).ready(function(){
    $("#region2").load(function(){
        $(this).contents().on("mousedown, mouseup, click", function(){
           showmedia('r2');
        });
    });
});
</script>
<script type="text/javascript">
  var imagetmppath;
  var videotmppath;
  //image and video preview
  $('#imagename').change( function(event) {
     imagetmppath = URL.createObjectURL(event.target.files[0]);
    // $("#imagepreview").fadeIn("fast").attr('src',URL.createObjectURL(event.target.files[0]));
    console.log(imagetmppath);
    // $("#disp_tmp_path").html("Temporary Path(Copy it and try pasting it in browser address bar) --> <strong>["+tmppath+"]</strong>");
});
    $('#videopath').change( function(event) {
     videotmppath = URL.createObjectURL(event.target.files[0]);
    // $("#imagepreview").fadeIn("fast").attr('src',URL.createObjectURL(event.target.files[0]));
    console.log(videotmppath);
    // $("#disp_tmp_path").html("Temporary Path(Copy it and try pasting it in browser address bar) --> <strong>["+tmppath+"]</strong>");
});
</script>
<script>
  var multidatastring1;
  var multidatastring2;


        function videoclearEvent()
        {
              // Clear event
            //$('.image-preview-clear').click(function(){
              $('.video-preview').attr("data-content","").popover('hide');
              $('.video-preview-filename').val("");
              $('.video-preview-clear').hide();
              $('.video-preview-input input:file').val("");
              $(".video-preview-input-title").text("Browse"); 
            //}); 
        }


</script>
<script type="text/javascript">
   var videopath1;
    var videopath2;
   var videofile_name;
   var file_new_name1;
   var file_new_name2;

        var video_format = ['wmv','avi','mpeg','mpg','3gp','webm','mp4','mkv'];
        
        $(".video-preview-input input:file").change(function (){     
          var file = this.files[0];
          
          //file_name = this.files[0];

          var matching_format_res = videoFormats(videofile_get_ext(file.name));

          //console.log(matching_format_res);

          if(matching_format_res==true)
          {
              videofile_name = this.files[0];
          }else 
          {
                swal("File format not supported..");
              videoclearEvent();
          }
            
        }); 
  
  

         function videoFormats(res_format)
        {
          var res = false;
          if(video_format!=null && video_format.length>=1)
          {
            var totalength =video_format.length;
            for(var i=0;i<totalength;i++)
            {
              var format = video_format[i];

             // console.log(format);

              if(format==res_format)
              {
                  
                  res = true;

                  return res;

              }

            }

            return res;

          }

        }



       

         function videofile_get_ext(filename)
        {
          return typeof filename != "undefined" ? filename.substring(filename.lastIndexOf(".")+1, filename.length).toLowerCase() : false;
        }

  
  //image
   var file_name;
   var imagepath1;
    var imagepath2;
    var imagefile_new_name1;
   var imagefile_new_name2;

    var image_format = ['jpg','jpeg','png','bmp','gif'];

      $(".image-preview-input input:file").change(function (){     
          var file = this.files[0];

          var matching_format_res = Formats(file_get_ext(file.name));

          //console.log(matching_format_res);

          if(matching_format_res==true)
          {
              file_name = this.files[0];
          }else 
          {
               swal("File format not supported..");
              imageclearEvent();
          }

          //var format_result = file_get_ext(file.name);
            
        }); 

         function Formats(res_format)
        {
          var res = false;
          if(image_format!=null && image_format.length>=1)
          {
            var totalength = image_format.length;
            for(var i=0;i<totalength;i++)
            {
              var format = image_format[i];

             // console.log(format);

              if(format==res_format)
              {
                  
                  res = true;

                  return res;

              }

            }

            return res;

          }

        }

 function file_get_ext(filename)
        {
          return typeof filename != "undefined" ? filename.substring(filename.lastIndexOf(".")+1, filename.length).toLowerCase() : false;
        }


   var screen_name = <?php echo $_REQUEST['screen']; ?>;

   var screen_mode = <?php echo $_REQUEST['mode']; ?>;

   console.log("screen_name==" + screen_name +"==="+ screen_mode );

  function ScreenConnection1()
  {
    ScreenConnection();
  }

function ScreenConnection()
{

  if(screen_mode=="enterprise")
  {

       MultiSubmit(screen_mode,screen_name);
       //console.log("Enterprise mode is on");

  }else if(screen_mode=="local")
    {
       //MultiSubmit(screen_mode);
       MultiSubmit(screen_mode,screen_name);
       //console.log("Enterprise mode is on");
    }else 
  {

      // ajaxindicatorstart("<img src='../images/ajax-loader.gif'><br/>File transfer in progress<br/> Please wait...!");
      $(document).ajaxSend(function () {
        $("#loading").show();
      });

      var form_data = new FormData();
          form_data.append('channel_id',screen_name);
      
        $.ajax({
        type: "POST",
        dataType: 'text',
        url: "../drive.php",
            cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
         
         success: function(data){
           
            
             // ajaxindicatorstop();
              $(document).ajaxComplete(function () {
                $("#loading").hide();
              });
        
               var jsonResponse = JSON.parse(data);

               if(jsonResponse.statusCode==0)
               {
                 
                       
                    if(jsonResponse.value==true)
                    {
                    //console.log("successfully");
                       MultiSubmit(screen_mode,screen_name);
                 
              }else if(jsonResponse.value==false)
              {
                // swal("Unable to push the content to player. Please check the connections of screen "+jsonResponse.name+".");
                swal({
                title: "Unable to push the content to player. Please check the connections of screen "+jsonResponse.name+". Are you sure?",
                text: "Note: check drive map connections are in green ",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-success",
                confirmButtonText: "Yes, Try Again ",
                cancelButtonText: "No, Cancel ",
                closeOnConfirm: false,
                closeOnCancel: false
              },function(isConfirm) {
                if (isConfirm) {
                ScreenConnection1();
              } else {
                  swal("Cancelled", "content not published", "error");
                }
              });
           
              }

           }else if(jsonResponse.statusCode==1)
           {
              
              swal(jsonResponse.status);
           }


        }
      });

  }

}

function MultiSubmit(screenmode,path)
{

  if(screenmode=="enterprise")
  {
     var url_mode = "http://localhost/smweb/enterprise/Api/PublishCampaign.php";
  }
  else if(screenmode=="local")
  {
    var url_mode = "http://localhost/smweb/local/multi/pushtemplate.php";
  }else
  {
     var url_mode = "php/pushtemplate.php";
  }

  console.log("Url=="+url_mode);

  var file_media_name = document.getElementById('file_media_name').value;
  var file_text_media = document.getElementById('file_text_media').value;
  var file_duration = document.getElementById('file_duration').value;
  var regionid = document.getElementById('regionid').value;

  console.log(videopath1+"path"+videopath2);
  console.log(imagepath1+"path"+imagepath2);


   if(file_media_name=='Enter Media Name' || file_media_name=='' || file_media_name==null)
   {
      swal({
        title: 'Please enter media name',
        timer: 2000
      });
    return false;
  } 

if(file_duration==null || file_duration=="" || file_duration==" " || file_duration=="Enter Duration(Sec)")
{
  file_duration = 10;
}

 var properties1 = ({"scaleType":"fillScreen"});

if(multidatastring1==undefined || multidatastring1==null || multidatastring1==""){

    var datastring1 = {"type":"Image","width":100,"height":50,"top_margin":0,"bottom_margin":0,"left_margin":0,"right_margin":0,"media_name":"default",'is_self_path':false,'properties':properties1};

   var data1 = JSON.stringify(datastring1);

}else{


    var data1 = JSON.stringify(multidatastring1);
  
}

if(multidatastring2==undefined || multidatastring2==null || multidatastring2==""){

   
  var datastring2 = {"type":"Image","width":100,"height":50,"top_margin":50,"bottom_margin":0,"left_margin":0,"right_margin":0,"media_name":"default",'is_self_path':false,'properties':properties1};

   var data2 = JSON.stringify(datastring2);

}else{

   var data2 = JSON.stringify(multidatastring2);

  
}

      console.log(data1+"sdfsdfsd"+data2);



          ajaxindicatorstart("<img src='../images/ajax-loader.gif'><br/>File transfer in progress<br/> Please wait...");

          var form_data = new FormData();     
           form_data.append('regions_count',2);  
            form_data.append('path',path);             
            form_data.append('data1',data1);
            form_data.append('data2',data2);
            form_data.append('media_name',file_media_name);
            form_data.append('offer_text',file_text_media);
            form_data.append('duration',file_duration);
            form_data.append('fileName1',videopath1);
            form_data.append('fileName2',videopath2);
            form_data.append('videodurationfileName1',file_new_name1);
            form_data.append('videodurationfileName2',file_new_name2);
            form_data.append('imagefileName1',imagepath1);
            form_data.append('imagefileName2',imagepath2);
            form_data.append('imagedurationfileName1',imagefile_new_name1);
            form_data.append('imagedurationfileName2',imagefile_new_name2);
            
        
       
           

               $.ajax({
                type: "POST",
                dataType: 'text',
                  url: url_mode,
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
                 
                     if(screenmode=="enterprise")
                      {
                         var jsonResponse = JSON.parse(data);

                          if(jsonResponse.statusCode==0)
                          {
                            
                          

                            setTimeout(function () { 
                            swal({
                              title: "success",
                              text: jsonResponse.status,
                              type: "success",
                              confirmButtonText: "OK"
                            },
                            function(isConfirm){
                              if (isConfirm) {
                            
                                window.location = "/smweb/enterprise.php";
                              }
                            }); }, 1000);

                          }else if(jsonResponse.statusCode==1)
                          {
                    
                                
                          swal({
                                title: "Alert",
                                text: jsonResponse.status,
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: '#DD6B55',
                                confirmButtonText: 'Yes, Resend!',
                                cancelButtonText: "No, Close!",
                                closeOnConfirm: false,
                                closeOnCancel: false
                             },
                             function(isConfirm){

                               if (isConfirm){
                                 
                                ScreenConnection1();
                                }else{
                                  swal("Please try again later");
                                }
                             });
                        
                          }
                          else if(jsonResponse.statusCode==2)
                          {
                            
                          swal({
                                title: "Alert",
                                text: jsonResponse.status,
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: '#DD6B55',
                                confirmButtonText: 'Yes, Resend!',
                                cancelButtonText: "No, Close!",
                                closeOnConfirm: false,
                                closeOnCancel: false
                             },
                             function(isConfirm){

                               if (isConfirm){
                                  MultiSubmit("enterprise",JSON.stringify(jsonResponse.ip));
                                }else{
                                  swal("Please try again later");
                                }
                             });
                            }
                      }else if(screenmode=="local")
                      {
                
                          if(data == "New record created successfully")
                          {
                            
              
                            
                            setTimeout(function () { 
                            swal({
                              title: "success",
                              text: "Campaign has been saved in C:/Campaign",
                              type: "success",
                              confirmButtonText: "OK"
                            },
                            function(isConfirm){
                              if (isConfirm) {
                                 window.location.href="http://localhost/smweb/local.php";
                              }
                            }); }, 1000);
                            
                          }else
                          {
                             console.log("Error");
                          }
                        }
                      else
                      {
                          if(data == "New record created successfully")
                          {
                            
                            setTimeout(function () { 
                            swal({
                              title: "success",
                              text: "Media has been sent successfully",
                              type: "success",
                              confirmButtonText: "OK"
                            },
                            function(isConfirm){
                              if (isConfirm) {
                                  window.location.href="../home.php";
                              }
                            }); }, 1000);

                          }else
                          {
                             swal("Error, Please contact technial support.");
                          }
                      }
                    
                   }catch(Exception)
                   {
                    alert('Dear user, Unable to push content please try again');
                   } 

                  }
                });
         
}

function multicontent(type) {

  //url
  var regionvalue = document.getElementById('regionid').value;
  var urlmedianame = document.getElementById('url').value;

  //text
  var textmedia_name = document.getElementById('textmedia_name').value;
  var text_color = document.getElementById('text_color').value;
  var text_background = document.getElementById('text_background').value;
  var text_size = document.getElementById('text_size').value;
  var text_alignment = document.getElementById('text_alignment').value;
  text_color="#"+text_color;
  text_background="#"+text_background;

  //video
  // var video_media_name = document.getElementById('video_media_name').value;
  // var videopath = document.getElementById('videopath').value;


  if(type=="URL"){

      if(urlmedianame=='Enter url address like https://www.example.com ' || urlmedianame=='' || urlmedianame==null || urlmedianame=='https://www.'){
          swal({
          title: 'Please enter URL',
          timer: 2000
        });
          return false;
        }

    if(regionvalue=='r1'){
      document.getElementById("region1").src = urlmedianame;
      multidatastring1 = {"type":"Url","width":100,"height":50,"top_margin":0,"bottom_margin":0,"left_margin":0,"right_margin":0,"media_name":urlmedianame,"is_self_path":false};
    }
    if(regionvalue=='r2'){
       document.getElementById("region2").src = urlmedianame;
      multidatastring2 = {"type":"Url","width":100,"height":50,"top_margin":50,"bottom_margin":0,"left_margin":0,"right_margin":0,"media_name":urlmedianame,"is_self_path":false};
    }

     $('#pushurl').modal('hide');
      $('#selectoption').modal('hide');

      var multicontentdata1 = JSON.stringify(multidatastring1);
      var multicontentdata2 = JSON.stringify(multidatastring2);
      
      console.log(multicontentdata1);
      console.log(multicontentdata2);
       document.getElementById('url').value="http://www.";
   }
   else if(type=="TEXT"){

      if(textmedia_name=='Enter your text need to be displayed' || textmedia_name=='' || textmedia_name==null){
          swal({
          title: 'Please enter your text',
          timer: 2000
        });
          return false;
        }

    if(regionvalue=='r1'){

       $('#region1').hide();
      $('#textregion1').show();
      document.getElementById("textregion1").innerHTML = textmedia_name;
      document.getElementById("textregion1").style.color = text_color;
      document.getElementById("textregion1").style.backgroundColor = text_background;
    
      if(text_alignment=="5"){
         document.getElementById("textregion1").style.textAlign = "right";
      }else if(text_alignment=="17"){
         document.getElementById("textregion1").style.textAlign = "center";
      }else{
        document.getElementById("textregion1").style.textAlign = "left";
      }
      
      var textsizes= text_size+"px";
      document.getElementById("textregion1").style.fontSize = textsizes;

      var data1 = ({ "textBgColor":text_background,"textColor":text_color,"textSize":Number(text_size),"isScrollAnim":false,"textAlignment":Number(text_alignment)});

      multidatastring1 = {"type":"text","width":100,"height":50,"top_margin":0,"bottom_margin":0,"left_margin":0,"right_margin":0,"media_name":textmedia_name,"is_self_path":false,"properties":data1};
    }
    if(regionvalue=='r2'){

       $('#region2').hide();
      $('#textregion2').show();
      document.getElementById("textregion2").innerHTML = textmedia_name;
      document.getElementById("textregion2").style.color = text_color;
      document.getElementById("textregion2").style.backgroundColor = text_background;
    
      if(text_alignment=="5"){
         document.getElementById("textregion2").style.textAlign = "right";
      }else if(text_alignment=="17"){
         document.getElementById("textregion2").style.textAlign = "center";
      }else{
        document.getElementById("textregion2").style.textAlign = "left";
      }
      
      var textsizes= text_size+"px";
      document.getElementById("textregion2").style.fontSize = textsizes;

       var data2 = ({ "textBgColor":text_background,"textColor":text_color,"textSize":Number(text_size),"isScrollAnim":false,"textAlignment":Number(text_alignment)});

      multidatastring2 = {"type":"text","width":100,"height":50,"top_margin":50,"bottom_margin":0,"left_margin":0,"right_margin":0,"media_name":textmedia_name,"is_self_path":false,"properties":data2};
    }

     $('#pushtext').modal('hide');
    $('#selectoption').modal('hide');

     var multicontentdata1 = JSON.stringify(multidatastring1);
      var multicontentdata2 = JSON.stringify(multidatastring2);
      
      console.log(multicontentdata1);
      console.log(multicontentdata2);
       document.getElementById('textmedia_name').value="";
      document.getElementById('text_size').value="40";
      document.getElementById('text_color').value="000000";
      document.getElementById('text_background').value="FFFFFF";
      document.getElementById('text_alignment').value="3";
   }
   else if(type=="VIDEO"){


    if(regionvalue=='r1'){

        if(videofile_name==undefined || videofile_name==null )
          {
            swal({
          title: 'Please select your video',
          timer: 2000
        });
          return false;
             
          }

              var now = new Date();
          
                  if(videofile_name.name!=null && videofile_name.name!=undefined)
                  {
                   var file_new_name = 'DNDM-'+now.getTime()+'.'+videofile_get_ext(videofile_name.name);

                    // var fileee_name = 'DNDM-'+ video_media_name + '.'+file_get_ext(file_name.name);

                  }
      

                  console.log("file name1"+videofile_name);

                  videopath1 =videofile_name;
                  file_new_name1= file_new_name;

                    var iframe = document.getElementById("region1");
                  iframe.src = videotmppath;

      var data1 = ({"isStretch":true,"volume":100});

      multidatastring1 = {"type":"Video","width":100,"height":50,"top_margin":0,"bottom_margin":0,"left_margin":0,"right_margin":0,"media_name":file_new_name,"is_self_path":false,"properties":data1};


    }
    if(regionvalue=='r2'){

        if(videofile_name==undefined || videofile_name==null )
          {
            swal({
          title: 'Please select your video',
          timer: 2000
        });
          return false;
             
          }

              var now = new Date();
          
                  if(videofile_name.name!=null && videofile_name.name!=undefined)
                  {
                   var file_new_name = 'DNDM-'+now.getTime()+'.'+videofile_get_ext(videofile_name.name);

                    // var fileee_name = 'DNDM-'+ video_media_name + '.'+file_get_ext(file_name.name);

                  }
      

          console.log("file name2"+videofile_name);
           file_new_name2 = file_new_name;
           videopath2 =videofile_name;

             var iframe = document.getElementById("region2");
        iframe.src = videotmppath;


       var data2 = ({"isStretch":true,"volume":100});

      multidatastring2 = {"type":"Video","width":100,"height":50,"top_margin":50,"bottom_margin":0,"left_margin":0,"right_margin":0,"media_name":file_new_name,"is_self_path":false,"properties":data2};
    }

     $('#pushvideo').modal('hide');
    $('#selectoption').modal('hide');

     var multicontentdata1 = JSON.stringify(multidatastring1);
      var multicontentdata2 = JSON.stringify(multidatastring2);
      
      console.log(multicontentdata1);
      console.log(multicontentdata2);
       videoclearEvent();
     

   }

   else if(type=="IMAGE"){


    if(regionvalue=='r1'){

        if(file_name==undefined || file_name==null )
          {
            swal({
          title: 'Please select your image',
          timer: 2000
        });
          return false;
             
          }

              var now = new Date();
          
                  if(file_name.name!=null && file_name.name!=undefined)
                  {
                   var file_new_name = 'DNDM-'+now.getTime()+'.'+file_get_ext(file_name.name);

                    // var fileee_name = 'DNDM-'+ video_media_name + '.'+file_get_ext(file_name.name);

                  }
      

                  console.log("file name1"+file_name);

                  imagepath1 =file_name;
                  imagefile_new_name1= file_new_name;

                    document.getElementById("region1").src = imagetmppath;

      var data1 = ({"scaleType":"fillScreen"});

      multidatastring1 = {"type":"Image","width":100,"height":50,"top_margin":0,"bottom_margin":0,"left_margin":0,"right_margin":0,"media_name":file_new_name,"is_self_path":false,"properties":data1};


    }
    if(regionvalue=='r2'){

         if(file_name==undefined || file_name==null )
          {
            swal({
          title: 'Please select your image',
          timer: 2000
        });
          return false;
             
          }

              var now = new Date();
          
                  if(file_name.name!=null && file_name.name!=undefined)
                  {
                   var file_new_name = 'DNDM-'+now.getTime()+'.'+file_get_ext(file_name.name);

                    // var fileee_name = 'DNDM-'+ video_media_name + '.'+file_get_ext(file_name.name);

                  }
      

          console.log("file name2"+file_name);
           
           imagepath2 =file_name;
           imagefile_new_name2= file_new_name;

             document.getElementById("region2").src = imagetmppath;

       var data2 = ({"scaleType":"fillScreen"});

      multidatastring2 = {"type":"Image","width":100,"height":50,"top_margin":50,"bottom_margin":0,"left_margin":0,"right_margin":0,"media_name":file_new_name,"is_self_path":false,"properties":data2};
    }

     $('#pushimage').modal('hide');
    $('#selectoption').modal('hide');

     var multicontentdata1 = JSON.stringify(multidatastring1);
      var multicontentdata2 = JSON.stringify(multidatastring2);
      
      console.log(multicontentdata1);
      console.log(multicontentdata2);
        imageclearEvent();
   }


}

function showmedia(region){
  if(region=="r1"){
    $('#selectoption').modal('show');
    document.getElementById('regionid').value=region;
  }else if(region=="r2"){
    $('#selectoption').modal('show');
    document.getElementById('regionid').value=region;
  }
}

function imageclearEvent()
        {
              // Clear event
            //$('.image-preview-clear').click(function(){
              $('.image-preview').attr("data-content","").popover('hide');
              $('.image-preview-filename').val("");
              $('.image-preview-clear').hide();
              $('.image-preview-input input:file').val("");
              $(".image-preview-input-title").text("Browse"); 
            //}); 
        }
</script>
<script type="text/javascript">

          $('#multiimage_file').change(function(){
   //alert("changed");
   multicontent('IMAGE');
   $('#selectoption').hide();
});

previousVal = "";
function InputChangeListener()
{
  if($('#multiimage_file').val()
     != previousVal)
  {
   previousVal  = $('#multiimage_file').val();
   $('#multiimage_file').change();    
  }
}

setInterval(InputChangeListener, 500);

 $('#video_file').change(function(){
   //alert("changed");
   multicontent('VIDEO');
   $('#selectoption').hide();
});

previousVal1 = "";
function InputChangeListener1()
{
  if($('#video_file').val()
     != previousVal1)
  {
   previousVal1  = $('#video_file').val();
   $('#video_file').change();    
  }
}

setInterval(InputChangeListener1, 500);

        </script>
</body>
</html>