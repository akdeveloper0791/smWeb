<?php
// require("Constants.php");
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


?>


<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel='shortcut icon' type='image/x-icon' href='images/signage.ico' />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="generator" content="">
<link href="css/bootstrap.min.css" rel="stylesheet">
<script src="js/js/popper.min.js"></script>
<script src="js/js/jquery.min.js"></script>
<script src="js/js/bootstrap.min.js"></script>
<link href="css/style.css" rel="stylesheet">
<link rel="stylesheet" href="js/sweetalert.css">
<script src="js/sweetalert.js"></script>
<script type="text/javascript" src="js/default_busy_loader.js"></script>
<link href="_css/Icomoon/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="Font-Awesome-5.5.0/web-fonts-with-css/css/fontawesome-all.min.css">
<style type="text/css">
video{

}

.item.content,.item.portfolio,.item.team,.item.pricing,.item.contact 
  {
    height:380px;
    padding-top:40px;
    padding-bottom:20px;

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
      <a href="index.php" class="navbar-brand brand" style="
    display: inline-flex;
"> <img src="images/signage.png" alt="" class="logo" style="width: 80px;height: 70px;margin: -15px 0px;">Signage Manager </a>
    </div>
    <div id="navbar-collapse-02" class="collapse navbar-collapse">
      <ul class="nav navbar-nav navbar-right">
        <!-- <li class="propClone"><a href="index.html">Home</a></li> -->
        <li id="propClone" class="propClone"><a href="index.php"><span class='icon-home'></span></a></li>
       <!--  <li class="propClone"><a href="addscreen.php">Add Screen</a></li> -->
        <!-- <li class="propClone"><a href="#">Delete Screen</a></li> -->
      <!--  <li class="propClone"><a href="checkout.html">Checkout</a></li> -->
        <!-- <li class="propClone"><a href="contact.html">Contact</a></li> -->
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
            <!-- <br /><h1>Welcome to Signage Manager</h1> -->
            <h2><span style="color: orange;"><?= $user['email']; ?></span></h2>
             <img id="loading" src="images/ajax-loader.gif" alt="Updating ..." style="display: none;" />
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</header>

<!-- CONTENT =============================-->
<section class="item content" style="
    background-color: darkgray;
">
<div class="container toparea" >
  <div class="underlined-title">
    <div class="editContent">
      <span id='message'></span>
      <h1 class="text-center latestitems">Video</h1>
    </div>
  </div>
  <div class="rows">
         <div class="col-md-12">
           <div class="col-md-6">
              <iframe id="region1" src="images/plus33.png" style='height:300px;width:100%;object-fit: fill' >Please click here to select content</iframe>
         </div>

        <div class="col-md-6">

         <!--  <label for="exampleInputEmail1">Choose Video File : *</label> -->
              <div class="input-group image-preview col-md-12" style="display:none;">
                    
                  <!-- image-preview-input -->
                  <div class="btn btn-outline-primary image-preview-input col-md-2" style="border-radius:0px;">
                    <span class="glyphicon glyphicon-folder-open"></span>
                    <span class="image-preview-input-title">Browse</span>
                    <input type="file" accept="video/*" name="input-file-preview" id="videopath"/> <!-- rename it -->
                  </div>
                   
                   
                   <div class="col-md-8" style="margin: 0px;padding: 0px;">
                    <input type="text" class="form-control image-preview-filename" disabled="disabled" id="image_file"> <!-- don't give a name === doesn't send on POST/GET -->
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

                  <br>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Media Name : *</label>
                    <input type="text" class="form-control" placeholder="Enter Media Name" name="media_name" id="media_name">
                       
                  </div>


                  <div class="form-group">
                    <label for="exampleInputEmail1">Scrolling Text  : </label>
                    <input type="text" class="form-control" placeholder="Enter Scrolling Text that will be displayed on the bottom of the Screen" name="text_media" id="text_media" >

                    <!-- onkeyup="onkeyValuepress()" -->
                  </div>

                  <div class="checkbox">
                    <label id="media_checkbox_label" style="display:none;"><input type="checkbox" id="media_checkbox" checked ></label>
                  </div>


          </div>


                  
              
                              <p></p>
        <center>      
         <a href="index.php"><button class="btn btn-danger" style="display:inline-block;">Close</button></a>              
          <button class="btn btn-success" id="submit" style="display: inline-block;" onclick="ScreenConnection()">Send</button>
        </center>
  <p></p>  <p></p>
</div>
</div>

<!-- </form> -->

</section>

<!-- CALL TO ACTION =============================-->
<!-- <section class="content-block" style="background-color:#00bba7;">
<div class="container text-center">
<div class="row">
  <div class="col-sm-10 col-sm-offset-1">
    <div class="item" data-scrollreveal="enter top over 0.4s after 0.1s">
      <h1 class="callactiontitle"> Promote Items Area Give Discount to Buyers <span class="callactionbutton"><i class="fa fa-gift"></i> WOW24TH</span>
      </h1>
    </div>
  </div>
</div>
</div>
</section> -->
  <?php else: ?>

    <br/><br/><br/><br/><br/><br/><br/>
  <center>
  <div style="height: 20%;">

    <h1 style="color:white;text-align: center;">Please <a href="index.php">Login</a> <!-- or <a href="register.php">Register</a> -->
    </h1>
    <!-- <a href="login.php">Login</a> or
    <a href="register.php">Register</a> -->

</div>
</center>
    <script type="text/javascript">
       $('#propClone').hide(); 
       $('#logout').hide(); 
    </script>
 <br/><br/><br/><br/><br/>
    <br/><br/><br/><br/>

  <?php endif; ?>
<!-- FOOTER =============================-->
<div class="footer text-center">
<div class="container">
  <div class="row">
  <!--  <p class="footernote">
       Connect with Scorilo
    </p>
    <ul class="social-iconsfooter">
      <li><a href="#"><i class="fa fa-phone"></i></a></li>
      <li><a href="#"><i class="fa fa-facebook"></i></a></li>
      <li><a href="#"><i class="fa fa-twitter"></i></a></li>
      <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
      <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
    </ul> -->
    <p>
      Copyright (c) 2018 SignageServ, All Rights Reserved. Powered by AdsKite India Pvt. Ltd.

    </p>
  </div>
</div>
</div>

<!-- Load JS here for greater good =============================-->
<script src="js/jquery-.js"></script>
<!-- <script src="js/bootstrap.min.js"></script> -->
<script src="js/anim.js"></script>
<script type="text/javascript">
   var currentdate = new Date();
           var datetime = currentdate.getDate() + "-"
                + (currentdate.getMonth()+1)  + "-" 
                + currentdate.getFullYear() + "_"  
                + currentdate.getHours() + "-"  
                + currentdate.getMinutes() + "-" 
                + currentdate.getSeconds();
           document.getElementById("media_name").value=datetime;
    var duration = 10;//seconds      
    var videotmppath;
 

    $('#videopath').change( function(event) {
     
     videotmppath = URL.createObjectURL(event.target.files[0]);
    // $("#imagepreview").fadeIn("fast").attr('src',URL.createObjectURL(event.target.files[0]));
    console.log(videotmppath);
    var iframe = document.getElementById("region1");
    iframe.src = videotmppath;

    var video = document.createElement('video');
    video.preload = 'metadata';

    video.onloadedmetadata = function() {
    window.URL.revokeObjectURL(video.src);
    duration = parseInt(video.duration);
    
    }
    video.src = videotmppath;
    // $("#disp_tmp_path").html("Temporary Path(Copy it and try pasting it in browser address bar) --> <strong>["+tmppath+"]</strong>");
});

    $(document).ready(function(){
    $("#region1").load(function(){
        $(this).contents().on("mousedown, mouseup, click", function(){
         
          document.getElementById("videopath").click();
        });
    });
});

</script>

 
<script type="text/javascript">

        var file_name;

        var video_format = ['wmv','avi','mpeg','mpg','3gp','webm','mp4','mkv'];
        
        $(".image-preview-input input:file").change(function (){     
          var file = this.files[0];
          
          //file_name = this.files[0];

          var matching_format_res = Formats(file_get_ext(file.name));

          //console.log(matching_format_res);

          if(matching_format_res==true)
          {
              file_name = this.files[0];
              
          }else 
          {
              swal("File Format Not Supported..!");
              imageclearEvent();
          }
            
        }); 


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
         //MultiSubmit(screen_mode);
        DisplaySubmit(screen_mode,screen_name);
         //console.log("Enterprise mode is on");
      }else 
      {
          // var Channel_Channel = document.getElementById('Channel_Channel').value;
          // //alert(Channel_Channel);
          // if(Channel_Channel=='Select Screen' || Channel_Channel=='' || Channel_Channel==null){
          //       swal({
          //         title: 'Select Respective Screen to Display.!',
          //         timer: 2000
          //       });
          //         return false;
          // }

          //alert(screen_name);

          // ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>File transfer in progress<br/> Please wait...!");

          $(document).ajaxSend(function () {
            $("#loading").show();
          });

          var form_data = new FormData();
              form_data.append('channel_id',screen_name);
      
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
             // console.log("result in connecting screen"+data);
            $(document).ajaxComplete(function () {
              $("#loading").hide();
            });
            
             // ajaxindicatorstop();

           
               var jsonResponse = JSON.parse(data);

               if(jsonResponse.statusCode==0)
               {
                 //console.log(JSON.stringify(jsonResponse.name));
                       
                    if(jsonResponse.value==true)
                    {
                     //console.log(jsonResponse.status);
                       DisplaySubmit(screen_mode,screen_name);
                      //swal("success");
 
                      //window.location.reload();
                    }else if(jsonResponse.value==false)
                    {
                        // swal("Unable to push the content to player. Please check the connections of screen "+jsonResponse.name+".");
                       swal({
                            title: "Unable to push the content to player. Please check the connections of screen "+jsonResponse.name+". Are you sure?",
                            text: "Note: check drive map connections are in green !",
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
                              swal("Cancelled", "content not Published", "error");
                            }
                          });
                    }
             }else if(jsonResponse.statusCode==1)
             {
                //swal("All Screens are in active state");
                swal(jsonResponse.status);
             }

          }
        });

      }

  }



  function DisplaySubmit(screenmode,path)
  {

    if(screenmode=="enterprise")
    {
      var url_mode = "/smweb/enterprise/Api/PublishSingleRegCampaign.php";
    }
    else
    {
      var url_mode = "php/videojsoncreation.php";
    }

    console.log("Url=="+url_mode);


    /*var url_url = document.getElementById('url').value;
    var media_name = document.getElementById('media_name').value;
    var duration = document.getElementById('duration').value;
    var text_media = document.getElementById('text_media').value;
    var Channel_Channel = document.getElementById('Channel_Channel').value;*/

    var media_name = document.getElementById('media_name').value;
    var text_media = document.getElementById('text_media').value;
    //var duration = document.getElementById('duration').value;

    //var Channel_Channel = document.getElementById('Channel_Channel').value;

    // if(duration==null || duration=="" || duration==" " || duration=="Enter Duration(Sec)")
    // {
    //   duration = 10;
    // }

    //console.log("==="+duration);

    if(media_name=='Enter Media Name' || media_name=='' || media_name==null){
      swal({
      title: 'Please Enter media name!',
      timer: 2000
    });
      return false;
    } 
    // else if(text_media=='Enter Text for Media' || text_media=='' || text_media==null){
    //   swal({
    //             title: 'Please Enter Scrolling text!',
    //             timer: 2000
    //           });
    //             return false;
    // }
    // else if(Channel_Channel=='Select Screen' || Channel_Channel=='' || Channel_Channel==null){
    //   swal({
    //             title: 'Select Respective Screen to Display.!',
    //             timer: 2000
    //           });
    //             return false;
    // }

          if(file_name==undefined || file_name==null )
          {
             swal("Select Video file...!");
             
          }else 
          {    
              var now = new Date();
          
                  if(file_name.name!=null && file_name.name!=undefined)
                  {
                    var file_new_name = 'DNDM-'+now.getTime()+'.'+file_get_ext(file_name.name);

                    var fileee_name = 'DNDM-'+ media_name + '.'+file_get_ext(file_name.name);

                    //console.log(file_new_name);
                  }else 
                  {
                    var file_new_name = "default.jpg";
                    var fileee_name ="";
                  }
                  
                  // if(document.getElementById('media_checkbox').checked==true)
                  // {
                  //   var boolean_scroll_txt = true;
                  // }else 
                  // {
                  //   var boolean_scroll_txt = false;
                  // }
      var newDatastring = {};
      newDatastring['type'] = "multi_region";
      newDatastring['offer_text'] =  text_media;
      newDatastring['display_scroll_txt'] =  false;
      newDatastring['resource'] = fileee_name;
      newDatastring['duration'] = duration;
       var regions = [];
       var regionInfo = getVideoRegionInfo(fileee_name);
       regions.push(regionInfo);
      newDatastring['regions'] =  regions;
                                      
                      var data = JSON.stringify(newDatastring);
                     console.log("prepared data "+data);
                      ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>File transfer in progress<br/> Please wait...!");
                      var form_data = new FormData(); 
                          //form_data.append('duration',file_new_name);
                          form_data.append('fileName',file_name); 
                          form_data.append('data',data);
                          form_data.append('path',path);
                          form_data.append('media_name',media_name);
                          
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
                           ajaxindicatorstop();
                          console.log("data==="+data);
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
                                   DisplaySubmit("enterprise",JSON.stringify(jsonResponse.ip));
                                }else{
                                  swal("Please try again later");
                                }
                             });
                            } 
                              }else 
                              {
                                //var jsonResponse = JSON.parse(data);
                                if(data == "New record created successfully")
                                {
                                  
                                 // imageclearEvent();
                                  
                                  setTimeout(function () { 
                                  swal({
                                    title: "success!",
                                    text: "Media has been sent successfully!",
                                    type: "success",
                                    confirmButtonText: "OK"
                                  },
                                  function(isConfirm){
                                    if (isConfirm) {
                                       window.location.href="home.php";
                                    }
                                  }); }, 1000);
                                  
                                }else
                                {
                                   console.log("Error");
                                }

                            }

                           }catch(Exception)
                           {
                            alert('Dear user, Unable to push content please try again');
                           }
                           

                          }
                    });

              }
        }


        function onkeyValuepress()
        {
          var fname = document.getElementById("text_media").value;
    
          if(fname.length>=1)
          {
             //var x = document.getElementById("media_desc");
            // x.value = x.value.toUpperCase();
            //document.getElementById('media_checkbox').style.display="block";
            $('#media_checkbox_label').show();
          }
          else {
            //console.log("Length is  0");
            //document.getElementById('media_checkbox').style.display="none";
            $('#media_checkbox_label').hide();
          }
        
        }


        function Formats(res_format)
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

        function file_get_ext(filename)
        {
          return typeof filename != "undefined" ? filename.substring(filename.lastIndexOf(".")+1, filename.length).toLowerCase() : false;
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

  function getVideoRegionInfo(mediaName)
  {
    return regionInfo = {"type":"Video","width":100,"height":100,"top_margin":0,"bottom_margin":0,"left_margin":0,"right_margin":0,"media_name":mediaName,"is_self_path":false,"properties":{"isStretch":true,"volume":100}}
  }
</script>
<!-- modal -->


<script src="js/js/Imagepage.js"></script>

</body>
</html>