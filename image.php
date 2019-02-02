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


//echo "-------ip".$_REQUEST['screen'];
     $screen_mode_into = $_REQUEST['mode'];

      if($screen_mode_into=="'enterprise'")
      {
          $cookie_name = "Checked_Screens";
          $cookie_value = $_REQUEST['screen'];

          setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");

      }

     


?>


<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="generator" content="">
<link rel='shortcut icon' type='image/x-icon' href='images/signage.ico' />
<!-- <link rel="stylesheet" href="js/js/bootstrap.min.css"> -->
<link href="css/bootstrap.min.css" rel="stylesheet">

<script src="js/js/popper.min.js"></script>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css?family=Roboto:200,300,400,500,600,700" rel="stylesheet">

<link href="css/style.css" rel="stylesheet">
<link rel="stylesheet" href="js/sweetalert.css">

<link href="_css/Icomoon/style.css" rel="stylesheet" type="text/css" />

<style type="text/css">


      
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
<style type="text/css">
/*.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   text-align: center;
}*/
.item.content,.item.portfolio,.item.team,.item.pricing,.item.contact 
  {
    height:380px;
    padding-top:40px;
    padding-bottom:20px;

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
"> <img src="images/signage.png" alt="" class="logo" style="
    width: 32px;
    height:  32px;margin: 0 10px;
">Signage Manager </a>
    </div>
    <div id="navbar-collapse-02" class="collapse navbar-collapse">
      <ul class="nav navbar-nav navbar-right">
        <!-- <li class="propClone"><a href="index.html">Home</a></li> -->
        <li id="propClone" class="propClone"><a href="index.php"><span class='icon-home'></span></a></li>
       <!--  <li class="propClone"><a href="addscreen.php">Add Screen</a></li> -->
        <!-- <li class="propClone"><a href="#">Delete Screen</a></li> -->
      <!--  <li class="propClone"><a href="checkout.html">Checkout</a></li> -->
        <!-- <li class="propClone"><a href="contact.html">Contact</a></li> -->
          <li class="propClone" id="logout1"><a href="logout.php">Logout</a></li>
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
           <!--  <br /><h1>Welcome to Signage Manager</h1> -->
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
      <h1 class="text-center latestitems">Image</h1>
    </div>
    <!-- <div class="wow-hr type_short">
      <span class="wow-hr-h">
      <i class="fa fa-star"></i>
      <i class="fa fa-star"></i>
      <i class="fa fa-star"></i>
      </span>
    </div> -->
  </div>
  <div class="rows">
                   <div class="col-md-6">
                    <iframe id="region1"  src="images/plus33.png" style='height:300px;width:100%;object-fit: fill'>Please click here to select content</iframe>
                  </div>
                   <div class="col-md-6">

                    <div class="col-md-12">

                   <!--  <label for="exampleInputEmail1">Choose Image File : *</label> -->
                    <div class="input-group image-preview col-md-12" style="display: none;">
                   
                    <!-- image-preview-input -->
                    <div class="btn btn-outline-primary image-preview-input col-md-2" style="border-radius:0px;display: none;">
                      <span class="glyphicon glyphicon-folder-open"></span>
                      <span class="image-preview-input-title">Browse</span>
                      <input type="file" accept="image/*" name="input-file-preview" id="imagename"  /> <!-- rename it -->
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

                  <br >

                </div>


                  

                        <div class="col-md-12">

                            <div class="col-md-6" style="padding-left:0px;padding-right:0px;">

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Media Name : *</label>
                                   <input type="text" class="form-control" placeholder="Enter Media Name" name="media_name" id="media_name">
                                </div>

                            </div>

                            <div class="col-md-6" style="padding-right:0px;">

                              <div class="form-group">
                                 <label for="exampleInputPassword2">Play Duration : </label>
                                  <input type="number" class="form-control" value="10" placeholder="Enter Duration in Second(s)" name="duration" id="duration">
                              </div>


                            </div>

                        </div>

                          <div class="col-md-12">

                              <div class="form-group">
                                <label for="exampleInputEmail1">Scrolling Text : </label>
                                <input type="text" class="form-control" placeholder="Enter Scrolling Text that will be displayed on the bottom of the Screen" name="text_media" id="text_media" >

                        
                              </div>

                              <div class="form-group">
                                <label id="media_checkbox_label_image" style="display:none;"><input type="checkbox" id="media_checkbox_image"> </label>
                              </div>


                              <div class="checkbox">
                                <label id="play_audio_checkbox_label_image" onclick="CheckUncheck()"><input type="checkbox" id="play_audio_checkbox_image" >  Play Audio with Media : </label>
                              </div>
                  
                              <div class="form-group" id="audio_record_block" style="display:none;">
                                <!-- <hr> -->
                                <!-- <h5 class="text-center">Attach Audio File</h5> -->
                    
                                  <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 col-12 audio_image_preview" >
                                    <!--<i class="fa fa-music" ></i><br>-->
                                    <label class="btn btn-primary"><span class="icon-music"><input type="file" name="input-file-audio-preview" accept="audio/*" style="display:none;"/>     Attach Audio File</span></label><br>
                                    <p id="assign_name_to_audio"></p>

                              
                                  </div>
                       
                              </div>

                          </div>
                        </div>

                        <center>       
        <a href="index.php"><button class="btn btn-danger" style="display:inline-block;">Close</button></a>           
<button class="btn btn-success" id="submit" style="display: inline-block;" onclick="ScreenConnection()">Send</button></center>
              <br/>
                          </div> 
                        </div>

                        <p></p>
       
  <p></p>  <p></p>

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
       $('#logout1').hide(); 

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
<script src="js/anim.js"></script>
<script src="js/js/jquery.min.js"></script>
<script src="js/jquery-.js"></script>
<script src="js/js/bootstrap.min.js"></script>
<script src="js/sweetalert.js"></script>
<script type="text/javascript" src="js/default_busy_loader.js"></script>
 <script type="text/javascript">
  var imagetmppath;
  //image and video preview
  $('#imagename').change( function(event) {
     imagetmppath = URL.createObjectURL(event.target.files[0]);
    console.log(imagetmppath); 
     document.getElementById("region1").src = imagetmppath;
});
    
$(document).ready(function(){
    $("#region1").load(function(){
        $(this).contents().on("mousedown, mouseup, click", function(){
         
          document.getElementById("imagename").click();
        });
    });
});
</script>
<script type="text/javascript">
   var currentdate = new Date();
           var datetime = currentdate.getDate() + "-"
                + (currentdate.getMonth()+1)  + "-" 
                + currentdate.getFullYear() + "_"  
                + currentdate.getHours() + "-"  
                + currentdate.getMinutes() + "-" 
                + currentdate.getSeconds();
           document.getElementById("media_name").value=datetime;

    var file_name;
    var audio_file_name;

    var image_format = ['jpg','jpeg','png','bmp','gif'];

    var audio_format = ['mp3','m4a','ts','flac','wav','ogg','xmf','ota'];


    var screen_name = <?php echo $_REQUEST['screen']; ?>;

    var screen_mode = <?php echo $_REQUEST['mode']; ?>;

    console.log("screen_name==" + screen_name +"==="+ screen_mode);

      //console.log(JSON.stringify(image_format));
        
        $(".image-preview-input input:file").change(function (){     
          var file = this.files[0];

          var matching_format_res = Formats(file_get_ext(file.name));

          //console.log(matching_format_res);

          if(matching_format_res==true)
          {
              file_name = this.files[0];
             // alert(file_name);
               
          }else 
          {
              swal("File format not supported..");
              imageclearEvent();
          }

          //var format_result = file_get_ext(file.name);
            
        }); 

        $(".audio_image_preview input:file").change(function (){     
            var audio_file = this.files[0];

            var matching_format_res = FormatsAudio(file_get_ext(audio_file.name));

            //console.log(matching_format_res);

          if(matching_format_res==true)
          {
              document.getElementById('assign_name_to_audio').innerHTML = audio_file.name;

              audio_file_name = this.files[0];

          }else 
          {
              swal("File format not supported..");
              
              $('#assign_name_to_audio').empty();
              // imageclearEvent();
          }
   
        });
  
        document.getElementById('media_checkbox_image').checked=true;

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


        function FormatsAudio(res_format)
        {
          var res = false;
          if(audio_format!=null && audio_format.length>=1)
          {
            var totalength = audio_format.length;
            for(var i=0;i<totalength;i++)
            {
              var format = audio_format[i];

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

    function CheckUncheck()
        {

          if(document.getElementById('play_audio_checkbox_image').checked==true)
          {
            $('#audio_record_block').show();
          }else 
          {
            $('#audio_record_block').hide();
          }
        
        }
function ScreenConnection1(){
ScreenConnection();
}
        

function ScreenConnection()
{

    if(screen_mode=="enterprise")
    {
       //MultiSubmit(screen_mode);
       DisplaySubmit(screen_mode);
       //console.log("Enterprise mode is on");
    }else if(screen_mode=="local")
    {
       //MultiSubmit(screen_mode);
       DisplaySubmit(screen_mode);
       //console.log("Enterprise mode is on");
    }else 
    {

      var image_file = document.getElementById('image_file').value;
    if(image_file==' ' || image_file=='' || image_file==null){
      swal({
      title: 'Please select image file..',
      timer: 2000
    });
      return false;
    } 
    // ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>Searching for screen(s) <br/> Please wait...!");
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
             //console.log("result in connecting screen"+data);
            
            $(document).ajaxComplete(function () {
                $("#loading").hide();
            });
           
               var jsonResponse = JSON.parse(data);
                
              if(jsonResponse.statusCode==0)
              {
                 console.log(JSON.stringify(jsonResponse.name));
                       
                    if(jsonResponse.value==true)
                    {
                     //console.log(jsonResponse.status);
                      // ajaxindicatorstop();
                       DisplaySubmit(screen_mode);
                      //swal("success");
 
                      //window.location.reload();
                    }else if(jsonResponse.value==false)
                    {
                      // swal("Unable to push the content to player. Please check the connections of screen "+jsonResponse.name+".");
                      swal({
                      title: "Unable to push the content to player. Please check the connections of screen "+jsonResponse.name+". Are you sure?",
                      text: "Note: check drive map connections are in green",
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
              //swal("All Screens are in active state");
              swal(jsonResponse.status);
            }


          }

      });
        // ajaxindicatorstop();

    }    

}

// function DisplaySubmitEnterpriseFTP(url_mode)
//     {

//         console.log("Url=="+url_mode);


//         var media_name = document.getElementById('media_name').value;
//         var duration = document.getElementById('duration').value;
//         var text_media = document.getElementById('text_media').value;
//         var zoomLevel = document.getElementById('zoomLevel').value;
//         var scrollingSpeed = document.getElementById('scrollingSpeed').value;

//         if(document.getElementById('fitscreen').checked==true)
//         {
//           var isFitToScreen = true;
//         }else 
//         {
//           var isFitToScreen = false;
//         }


//         if(duration==null || duration=="" || duration==" " || duration=="Enter Duration(Sec)")
//         {
//           duration = 10;
//         }
//         if(zoomLevel==null || zoomLevel=="" || zoomLevel==" " || zoomLevel=="Enter in digits")
//         {
//           zoomLevel = 1.0;
//         }
//         if(scrollingSpeed==null || scrollingSpeed=="" || scrollingSpeed==" " || scrollingSpeed=="Enter Scrolling Speed Duration in Second(s)")
//         {
//           scrollingSpeed = 10;
//         }


//           if(file_name==undefined || file_name==null )
//           {
//              swal("Select appropriate file format...!");
             
//           }else 
//           {
       
            
//               var now = new Date();
          
//                   if(file_name.name!=null && file_name.name!=undefined)
//                   {
//                     var file_new_name = 'DNDM-'+now.getTime()+'.'+file_get_ext(file_name.name);

//                     var fileee_name = 'DNDM-'+ media_name + '.'+file_get_ext(file_name.name);
//                     console.log("image"+fileee_name);
//                   }
                 
//           }
   
//           if(media_name=='Enter Media Name' || media_name=='' || media_name==null)
//           {
//             swal({
//               title: 'Please Enter media name!',
//               timer: 2000
//              });
//             return false;
//           } 

//           console.log(media_name+"...."+duration);

//         var data2 = ({"zoomLevel":Number(zoomLevel),"scrollingSpeed":Number(scrollingSpeed),"isFitToScreen":isFitToScreen});

//         var datastring = ([{"type":"File","width":100,"height":100,"top_margin":0,"bottom_margin":0,"left_margin":0,"right_margin":0,"media_name":fileee_name,"is_self_path":false,'properties':data2}]);

//         var inputResult = { "type":'multi_region', "regions":datastring, "offer_text":text_media,"display_scroll_txt":false, "duration":duration,"resource":fileee_name};

//         var data = JSON.stringify(inputResult);
//             console.log(data);

//           ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>File transfer in progress<br/> Please wait...!");
//           var form_data = new FormData();     
//             form_data.append('fileName',file_name);
//             form_data.append('path',screen_name);             
//             form_data.append('data',data);
      
//             form_data.append('media_name',media_name);
           
//             $.ajax({
//                 type: "POST",
//                 dataType: 'text',
//                   url: url_mode,
//                   cache: false,
//                   contentType: false,
//                   processData: false,
//                   data: form_data,                         
//                   type: 'post',
                 
//                  success: function(data)
//                  {
//                     console.log(data);
//                     ajaxindicatorstop();

//                    try
//                    {
//                       var jsonResponse = JSON.parse(data);

//                       if(jsonResponse.statusCode==0)
//                       {           
                 

//                         setTimeout(function () { 
//                           swal({
//                             title: "success!",
//                             text: jsonResponse.status,
//                             type: "success",
//                             confirmButtonText: "OK"
//                           },
//                           function(isConfirm){
//                             if (isConfirm) {
                       
//                                 window.location = "/smweb/enterprise.php";
//                             }
//                           }); }, 1000);

//                       }else if(jsonResponse.statusCode==1)
//                       {
//                         swal(jsonResponse.status);
//                       }
//                       else if(jsonResponse.statusCode==2)
//                       {
//                         swal(jsonResponse.status);
//                       } 

//                    }catch(Exception)
//                    {
//                     alert('Dear user, Unable to push content please try again');
//                    } 

//                   }
//                 });

//       }

function DisplaySubmit(screenmode)
{
      if(screenmode=="enterprise")
      {
        var url_mode = "/smweb/enterprise/Api/PublishSingleRegCampaign.php";
        // DisplaySubmitEnterpriseFTP(url_mode);

      }
      else if(screenmode=="local")
      {
        //console.log("successfully");
        var url_mode = "local/localimagejsoncreation.php";
      }else 
      {
        var url_mode = "php/imagejsoncreation.php";
      }
      console.log("Url=="+url_mode);

      /*var url_url = document.getElementById('url').value;
      var media_name = document.getElementById('media_name').value;
      var duration = document.getElementById('duration').value;
      var text_media = document.getElementById('text_media').value;
      var Channel_Channel = document.getElementById('Channel_Channel').value;*/

      var media_name = document.getElementById('media_name').value;
      var text_media = document.getElementById('text_media').value;
      var duration = document.getElementById('duration').value;

      //var Channel_Channel = document.getElementById('Channel_Channel').value;

      if(duration==null || duration=="" || duration==" " || duration=="Enter Duration(Sec)")
      {
        duration = 10;
      }

      //console.log("==="+duration);
       if(media_name=='Enter Media Name' || media_name=='' || media_name==null)
       {
        swal({
          title: 'Please enter media name',
          timer: 2000
        });
          return false;
      } 


          var now = new Date();

          if(file_name==undefined || file_name==null )
          {
             swal("Select image file...");
             
          }else 
          {
            //console.log("continue file");
            
            if(file_name.name!=null && file_name.name!=undefined)
            {
              var fil_name = 'DNDM-'+now.getTime();

              var fil_name1 =  'DNDM-'+media_name;
          
              var file_new_name = fil_name1 +'.'+file_get_ext(file_name.name);
              console.log("image"+file_new_name);

            }else 
            {
              var file_new_name = "";
            }
            
            
            
            if(audio_file_name!=null && audio_file_name!=undefined)
            {
              var audio_new_name = fil_name +'.'+file_get_ext(audio_file_name.name);
                
              var aud_name = 'DNDM-'+ media_name + '.'+file_get_ext(audio_file_name.name);
                
              var aud_booblean = true;
              
              //console.log("audio_new_name=="+audio_file_name.name);
              
            }else 
            {
              var audio_new_name = "";
                
              var aud_name ="";
                
              var aud_booblean = false;
            }
          

          //console.log("true or false=="+boolean_scroll_txt);
          ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>File transfer in progress<br/> Please wait...");

          var datastring = {}
          
            datastring['type'] = "Image";
            datastring['media_name'] = media_name;
            datastring['offer_text'] = text_media;
            datastring['resource'] = file_new_name;
            datastring['duration'] = duration;
            datastring['display_scroll_txt'] = false;
            
            datastring['bg_audio'] = aud_name;
            datastring['play_bg_audio'] = aud_booblean;
          
            var data = JSON.stringify(datastring);
            //console.log(data);
         

            var form_data = new FormData(); 
            //form_data.append('duration_name',file_new_name);
            //form_data.append('audio_name',aud_name);

            form_data.append('fileName',file_name); 
            form_data.append('AudiofileName',audio_file_name); 
            form_data.append('data',data);
            form_data.append('path',screen_name);
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
                  console.log("data==="+data);
                     ajaxindicatorstop();

                   try
                   {
                      if(screenmode=="enterprise")
                      {
                          var jsonResponse = JSON.parse(data);

                          if(jsonResponse.statusCode==0)
                          {
                            
                            //swal(jsonResponse.status);

                            setTimeout(function () { 
                            swal({
                              title: "success",
                              text: jsonResponse.status,
                              type: "success",
                              confirmButtonText: "OK"
                            },
                            function(isConfirm){
                              if (isConfirm) {
                                //window.location.reload();
                                window.location = "/smweb/enterprise.php";
                              }
                            }); }, 1000);

                          }else if(jsonResponse.statusCode==1)
                          {
                             swal(jsonResponse.status);
                          }
                          else if(jsonResponse.statusCode==2)
                          {
                             swal(jsonResponse.status);

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
                                 window.location.href="local.php";
                              }
                            }); }, 1000);
                            
                          }else
                          {
                             console.log("Error");
                          }
                      }else 
                      {
                          // var jsonResponse = JSON.parse(data);
                          // console.log(jsonResponse);

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


        function onkeyValuepressImage()
        {
          var fname = document.getElementById("text_media").value;
    
          if(fname.length>=1)
          {
             //var x = document.getElementById("media_desc");
            // x.value = x.value.toUpperCase();
            //document.getElementById('media_checkbox').style.display="block";
            $('#media_checkbox_label_image').show();
          }
          else {
            //console.log("Length is  0");
            //document.getElementById('media_checkbox').style.display="none";
            $('#media_checkbox_label_image').hide();
          }
        
        }

        function file_get_ext(filename)
        {
          return typeof filename != "undefined" ? filename.substring(filename.lastIndexOf(".")+1, filename.length).toLowerCase() : false;
        }

        

</script>
<!-- modal -->


<script src="js/js/Imagepage.js"></script>

<script>

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


</body>
</html>