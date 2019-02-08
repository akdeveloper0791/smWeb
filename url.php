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
<link href="css/style.css" rel="stylesheet">
<script src="js/sweetalert.js"></script>
<link rel="stylesheet" href="js/sweetalert.css">
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/default_busy_loader.js"></script>
<link href="_css/Icomoon/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="Font-Awesome-5.5.0/web-fonts-with-css/css/fontawesome-all.min.css">
<style type="text/css">
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

      
      .wrap {
    width: 540px;
    height: 280px;
    padding: 0;
    overflow: hidden;
 
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
<style type="text/css">

.item.content,.item.portfolio,.item.team,.item.pricing,.item.contact 
  {
    height:400px;
    padding-top:40px;
    padding-bottom:20px;

  }
</style>
</header>

<!-- CONTENT =============================-->
<section class="item content" style="
    background-color: darkgray;
">
<div class="container toparea">
  <div class="underlined-title">
    <div class="editContent">
      <span id='message'></span>
      <h1 class="text-center latestitems">URL</h1>
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
       <div class="col-md-12">
         <div class="col-md-6">
            <div class="wrap">
          <iframe id="region1" class="frame" src="images/plus333.png">Please click here to select content</iframe>
       </div>
     </div>
      <div class="col-md-6">

          <!-- <form class="feedback" name="feedback"> -->
              <div class="form-group">
                <label for="exampleInputEmail1">URL : *</label>
                <input type="text" class="form-control" value="https://www." name="url" id="url" focus>
                <span>Enter url address like https://www.xyz.com</span>
              </div>

              <div class="col-md-6" style="padding-left:0px;padding-right:0px;">
                <div class="form-group">
                  <label for="exampleInputPassword1">Media Name : *</label>
                  <input type="text" class="form-control" placeholder="Enter Media Name" name="media_name" id="media_name">      
                </div>
              </div>


              <div class="col-md-6" style="padding-right:0px;">
                 <div class="form-group">
                    <label for="exampleInputPassword2">Play Duration (sec):</label>
                    <input type="number" class="form-control" value="10" placeholder="Enter Duration(Sec)" name="duration" id="duration">
                  </div> 
              </div>


              <div class="form-group">
                <label for="exampleInputEmail1">Scrolling Text :</label>
                <input type="text" class="form-control" placeholder="Enter Scrolling Text that will be displayed on the bottom of the Screen" name="text_media" id="text_media">
              </div>
              
         

          
                              <p></p>
          <center>     
            <a href="index.php"><button class="btn btn-danger" style="display:inline-block;">Close</button></a>             
            <button class="btn btn-success" id="submit" style="display: inline-block;" onclick="ScreenConnection()">Send</button>
          </center>
          <p></p>  <p></p>

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
    <!-- <a href="login.php">Login</a> or
    <a href="register.php">Register</a> -->

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
           document.getElementById("media_name").value=datetime;
 $('#url').change( function(event) {
    var urlmedianame = document.getElementById("url").value;
    console.log(urlmedianame);
    document.getElementById("region1").src = urlmedianame;
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
            DisplaySubmit(screen_mode,screen_name);
      }else if(screen_mode=="local")
    {
       //MultiSubmit(screen_mode);
        DisplaySubmit(screen_mode,screen_name);
       //console.log("Enterprise mode is on");
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
         
         success: function(data)
         {
             console.log("result in connecting screen"+data);
            
             // ajaxindicatorstop();
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
                         DisplaySubmit(screen_mode,screen_name);
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
        }    
    }


  function DisplaySubmit(screenmode,path)
  {
    if(screenmode=="enterprise")
    {
      var url_mode = "/smweb/enterprise/Api/PublishSingleRegCampaign.php";
    }
    else if(screenmode=="local")
      {
        //console.log("successfully");
        var url_mode = "local/localurljsoncreation.php";
      }else
    {
      var url_mode = "php/urljsoncreation.php";
    }

      var url_url = document.getElementById('url').value;
      var media_name = document.getElementById('media_name').value;
      var duration = document.getElementById('duration').value;
      var text_media = document.getElementById('text_media').value;
      //var Channel_Channel = document.getElementById('Channel_Channel').value;

      if(duration==null || duration=="" || duration==" " || duration=="Enter Duration(Sec)")
      {
        duration = 10;
      }

        //console.log("==="+duration);
        if(url_url=='Enter url address like https://www.example.com ' || url_url=='' || url_url==null || url_url=='https://www.'){
          swal({
            title: 'Please enter URL',
            timer: 2000
          });
          return false;
          }else if(media_name=='Enter Media Name' || media_name=='' || media_name==null){
          swal({
          title: 'Please enter media name',
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
        
          ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>File transfer in progress<br/> Please wait...");

          var form_data = new FormData();     
              form_data.append('media_name',media_name);
              form_data.append('path',path);             
              form_data.append('data',data);
           
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
                      //var jsonResponse = JSON.parse(data);
                      if(data == "New record created successfully")
                      { 
                        // imageclearEvent();
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
                      swal('Dear user, Unable to push content please try again');
                   }

                }
                });

          }
        
</script>
<!-- modal -->

</body>
</html>