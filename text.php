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
<link rel='shortcut icon' type='image/x-icon' href='images/signage.ico' />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="generator" content="">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">

<link href="css/style.css" rel="stylesheet">
<script src="js/sweetalert.js"></script>
<link rel="stylesheet" href="js/sweetalert.css">
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/default_busy_loader.js"></script>
<link href="_css/Icomoon/style.css" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Roboto:200,300,400,500,600,700" rel="stylesheet">
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
      <!--   <li class="propClone"><a href="addscreen.php">Add Screen</a></li> -->
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
      <h1 class="text-center latestitems">TEXT</h1>
    </div>
   <!--  <div class="wow-hr type_short">
      <span class="wow-hr-h">
      <i class="fa fa-star"></i>
      <i class="fa fa-star"></i>
      <i class="fa fa-star"></i>
      </span>
    </div> -->
  </div>
  <div class="rows">
  <script src="js/jscolor.js"></script>

     <div class="col-md-12">
       <div class="col-md-6">
          <textarea id="textregion2" style="width: 100%;height:400px;" disabled></textarea>
  </div>

    <div class="col-md-6">

        <div class="form-group">
          <label for="exampleInputPassword1">Rich Text : *</label>
            <!--  <input type="text" class="form-control" placeholder="Enter your text" name="media_name" id="media_name"> -->
            <textarea class="form-control" placeholder="Enter your text need to be displayed" name="media_name" id="media_name" ></textarea>
        </div>

         
        <div class="col-md-6" style="padding-left:0px;padding-right:0px;">
            <div class="form-group">
              <label for="exampleInputEmail1">Media Name : *</label>
              <input type="text" class="form-control" placeholder="Enter media name" name="file_name" id="file_name">
            </div>

        </div>  

        <div class="col-md-6" style="padding-right:0px;">

            <div class="form-group">
              <label for="exampleInputPassword2">Play Duration :</label>
              <input type="number" class="form-control" value="10" placeholder="Enter Duration in Second(s)" name="duration" id="duration">
             <!--  <p>Default Duration:10s</p> -->
            </div>

        </div>            

        
        <div class="col-md-6" style="padding-left:0px;padding-right:0px;">
          <div class="form-group">
            <label for="exampleInputPassword2">Text Size :</label>
            <input type="number" class="form-control" placeholder="Enter Font Size" name="font_size" id="text_size" value=40>
                             <!-- <p>Default Font Size:40</p> -->
          </div> 
        </div>



        <div class="col-md-6" style="padding-right:0px;">
          <div class="form-group">
            <label for="exampleInputEmail1">Text Color :</label>
            <input class="jscolor form-control" value="000000" id="text_color">
          </div>

        </div>



        <div class="col-md-6" style="padding-left:0px;padding-right:0px;">
          <div class="form-group">
            <label for="exampleInputEmail1">Text Background Color :</label>
            <input class="jscolor form-control" value="FFFFFF" id="text_background">
          </div>
        </div>

        <div class="col-md-6" style="padding-right:0px;">

          <div class="form-group">
            <label for="exampleInputEmail1">Text Alignment : *</label>
              <select class="form-control" id="text_alignment">
                <!-- <option>Select Alignment</option> -->
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

        
        <div class="form-group">
          <label for="exampleInputEmail1">Scrolling Text : </label>
          <input type="text" class="form-control" placeholder="Enter Scrolling Text that will be displayed on the bottom of the Screen" name="text_media" id="text_media">
        </div>

                           

                      

                              <p></p>
                <center>     
                  <a href="index.php"><button class="btn btn-danger" style="display:inline-block;">Close</button></a>             
                  <button class="btn btn-success" id="submit" style="display: inline-block;" onclick="ScreenConnection()">Send</button>
                </center>
                <p></p>  <p></p>
              </div>
            </div>
          </div>
        </div>


        <!-- </form> -->

    </div>

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
<script src="js/bootstrap.min.js"></script>
<script src="js/anim.js"></script>
<script type="text/javascript">
  var currentdate = new Date();
           var datetime = currentdate.getDate() + "-"
                + (currentdate.getMonth()+1)  + "-" 
                + currentdate.getFullYear() + "_"  
                + currentdate.getHours() + "-"  
                + currentdate.getMinutes() + "-" 
                + currentdate.getSeconds();
           document.getElementById("file_name").value=datetime;

     $('#media_name').change( function(event) {
        var media_name = document.getElementById("media_name").value;
        console.log(media_name);
        document.getElementById("textregion2").innerHTML = media_name;
      });
     $('#text_size').change( function(event) {
        var text_size = document.getElementById("text_size").value;
        console.log(text_size);
       var textsizes= text_size+"px";
      document.getElementById("textregion2").style.fontSize = textsizes;
      });
     $('#text_color').change( function(event) {
        var text_color = document.getElementById("text_color").value;
        console.log(text_color);
         document.getElementById("textregion2").style.color = "#"+text_color;
      });
     $('#text_background').change( function(event) {
        var text_background = document.getElementById("text_background").value;
        console.log(text_background);
       document.getElementById("textregion2").style.backgroundColor = "#"+text_background;
      });
     $('#text_alignment').change( function(event) {
        var text_alignment = document.getElementById("text_alignment").value;
        console.log(text_alignment);
         if(text_alignment=="5"){
         document.getElementById("textregion2").style.textAlign = "right";
      }else if(text_alignment=="17"){
         document.getElementById("textregion2").style.textAlign = "center";
      }else{
        document.getElementById("textregion2").style.textAlign = "left";
      }
      });
     
</script>
 
<script type="text/javascript">

    var screen_name = <?php echo $_REQUEST['screen']; ?>;

    var screen_mode = <?php echo $_REQUEST['mode']; ?>;

    console.log("screen_name==" + screen_name +"==="+ screen_mode);

    function ScreenConnection1()
    {
      ScreenConnection();
    }

  function ScreenConnection()
  {

    if(screen_mode=="enterprise")
    {
         DisplaySubmit(screen_mode);
        
    }else if(screen_mode=="local")
    {
       //MultiSubmit(screen_mode);
       DisplaySubmit(screen_mode);
       //console.log("local mode is on");
    }else 
    {
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
             //console.log("result in connecting screen"+data);
            
             // ajaxindicatorstop();
              $(document).ajaxComplete(function () {
                $("#loading").hide();
              });

              // DisplaySubmit();
               var jsonResponse = JSON.parse(data);

               if(jsonResponse.statusCode==0)
               {
                 //console.log(JSON.stringify(jsonResponse.name));
                       
                    if(jsonResponse.value==true)
                    {
                     //console.log(jsonResponse.status);
                       DisplaySubmit(screen_mode);
                      //swal("success");
 
                      //window.location.reload();
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



function DisplaySubmit(screenmode)
{

      if(screenmode=="enterprise")
      {
          var url_mode = "/smweb/enterprise/Api/PublishSingleRegCampaign.php";

          DisplaySubmitEnterpriseFTP(url_mode);
      }else if(screenmode=="local")
      {
        console.log("successfullyasdasda");
        var url_mode = "local/localtextjsoncreation.php";
      }
      else
      {
          var url_mode = "php/textjsoncreation.php";

          console.log("Url=="+url_mode);

          var file_name = document.getElementById('file_name').value;
          var media_name = document.getElementById('media_name').value;
          var duration = document.getElementById('duration').value;
          var text_media = document.getElementById('text_media').value;
          var text_size = document.getElementById('text_size').value;
          var text_color = document.getElementById('text_color').value;
          var text_alignment = document.getElementById('text_alignment').value;
          var text_background = document.getElementById('text_background').value;
          //var Channel_Channel = document.getElementById('Channel_Channel').value;

          text_color="#"+text_color;
          text_background="#"+text_background;

          if(duration==null || duration=="" || duration==" " || duration=="Enter Duration(Sec)")
          {
            duration = 10;
          }

        // if(text_size==null || text_size=="" || text_size==" " || text_size=="Enter Font Size")
        // {
        //   text_size = 40;
        // }

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

      // else if(text_media=='Enter scrolling Text for Media' || text_media=='' || text_media==null){
      //   swal({
      //             title: 'Please enter scrolling text!',
      //             timer: 2000
      //           });
      //             return false;
      // }
      // else if(text_alignment=='Select Alignment' || text_alignment=='' || text_alignment==null){
      //   swal({
      //             title: 'Select text alignment on screen to Display.!',
      //             timer: 2000
      //           });
      //             return false;
      // }
      // else if(Channel_Channel=='Select Screen' || Channel_Channel=='' || Channel_Channel==null){
      //   swal({
      //             title: 'Select respective screen to Display.!',
      //             timer: 2000
      //           });
      //             return false;
      // }

        //console.log(media_name+duration+text_media+text_size+text_color+text_alignment+text_background+Channel_Channel);
                

        /*var datastring = {}
                
                  datastring['type'] = "text";
                  datastring['width'] = 100;
                  datastring['height'] = 100;
                  datastring['top_margin'] = 0;
                  datastring['bottom_margin'] = 0;
                  datastring['left_margin'] = 0;
                  datastring['right_margin'] = 0;
                  datastring['media_name'] = text_media;
                  datastring['is_self_path'] = false;

                  // datastring['display_scroll_txt'] = "true";
                  //  datastring['duration'] = duration;
                  
                  var data = JSON.stringify(datastring);
                  console.log(data);*/


          var data1 = ({ "textBgColor":text_background,"textColor":text_color,"textSize":Number(text_size),"isScrollAnim":false,"textAlignment":Number(text_alignment)});

          var datastring = ([{"type":"text","width":100,"height":100,"top_margin":0,"bottom_margin":0,"left_margin":0,"right_margin":0,"media_name":media_name,"is_self_path":false,'properties':data1}]);

          var data = JSON.stringify(datastring);
            //console.log(data)

          ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>File transfer in progress<br/> Please wait...");

          var form_data = new FormData();     
            form_data.append('file_name',file_name);
            form_data.append('path',screen_name);             
            form_data.append('data',data);
            form_data.append('offer_text',text_media);
            form_data.append('duration',duration);
            form_data.append('text',media_name);
            
            //console.log(path);

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

  

  function DisplaySubmitEnterpriseFTP(url_mode)
  {
      console.log("Url=="+url_mode);

        var file_name = document.getElementById('file_name').value;
        var media_name = document.getElementById('media_name').value;
        var duration = document.getElementById('duration').value;
        var text_media = document.getElementById('text_media').value;
        var text_size = document.getElementById('text_size').value;
        var text_color = document.getElementById('text_color').value;
        var text_alignment = document.getElementById('text_alignment').value;
        var text_background = document.getElementById('text_background').value;
        //var Channel_Channel = document.getElementById('Channel_Channel').value;

          text_color="#"+text_color;
          text_background="#"+text_background;

          if(duration==null || duration=="" || duration==" " || duration=="Enter Duration(Sec)")
          {
            duration = 10;
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


          var data1 = ({ "textBgColor":text_background,"textColor":text_color,"textSize":Number(text_size),"isScrollAnim":false,"textAlignment":Number(text_alignment)});


          var datastring = ([{"type":"text","width":100,"height":100,"top_margin":0,"bottom_margin":0,"left_margin":0,"right_margin":0,"media_name":media_name,"is_self_path":false,'properties':data1}]);


          var inputResult = {"type":'multi_region',"regions":datastring,"offer_text":text_media,"display_scroll_txt":false,"duration":duration };


           var data = JSON.stringify(inputResult);


          //var data = JSON.stringify(datastring);
            //console.log(data);

          ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>File transfer in progress<br/> Please wait...");

            var form_data = new FormData();     
                //form_data.append('file_name',file_name);
                form_data.append('path',screen_name);             
                form_data.append('data',data);
                //form_data.append('offer_text',text_media);
                //form_data.append('duration',duration);
                form_data.append('media_name',media_name);
            
                //console.log(path);

               $.ajax({
                type: "POST",
                dataType: 'text',
                  url: url_mode,
                  cache: false,
                  contentType: false,
                  processData: false,
                  data: form_data,                         
                  type: 'post',
                 
                 success: function(data)
                 {
                    console.log("data==="+data);

                    ajaxindicatorstop();
                  try
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

                  }catch(Exception)
                  {
                    swal('Dear user, Unable to push content please try again');
                  } 

              }
          });

    }

</script>
<!-- modal -->

</body>
</html>