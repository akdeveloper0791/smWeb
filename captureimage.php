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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="generator" content="">
<link rel='shortcut icon' type='image/x-icon' href='images/signage.ico' />

<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- <script src="js/js/popper.min.js"></script>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css?family=Roboto:200,300,400,500,600,700" rel="stylesheet"> -->

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
 <br/><br/><br/><br/><br/>
   
  <div class="rows">
                <br/><br/><br/><br/>
                   <div class="col-md-6">

                    <div class="col-md-12">

                   <!--  <label for="exampleInputEmail1">Choose Image File : *</label> -->
                    <div class="input-group image-preview col-md-12" style="">
                   
                    <!-- image-preview-input -->
                    <div class="btn btn-outline-primary image-preview-input col-md-2" style="border-radius:0px;">
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
                        <button type="button" class="btn btn-outline-warning image-preview-clear" style="border-radius:0px;">
                          <span class="glyphicon glyphicon-remove"></span> Clear
                        </button> 
                      </span>
                    </div>

                  </div><!-- /input-group image-preview [TO HERE]--> 

                  <br >

                </div>


                  

                

             
                        </div>

                        <center>       
        <a href="index.php"><button class="btn btn-danger" style="display:inline-block;">Close</button></a>           
<button class="btn btn-success" id="submit" style="display: inline-block;" onclick="DisplaySubmit()">Send</button></center>
              <br/>
                          </div> 
                        </div>

</section>


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
<!-- <script src="js/anim.js"></script> -->
<script src="js/js/jquery.min.js"></script>
<!-- <script src="js/jquery-.js"></script> -->
<script src="js/js/bootstrap.min.js"></script>
<script src="js/sweetalert.js"></script>
<!-- <script type="text/javascript" src="js/default_busy_loader.js"></script>
<script src="js/js/Imagepage.js"></script> -->

 <script type="text/javascript">
  var imagetmppath;
  //image and video preview
  $('#imagename').change( function(event) {
     imagetmppath = URL.createObjectURL(event.target.files[0]);
    console.log(imagetmppath); 
});
    

</script>
<script type="text/javascript">
   var currentdate = new Date();
           var datetime = currentdate.getDate() + "-"
                + (currentdate.getMonth()+1)  + "-" 
                + currentdate.getFullYear() + "_"  
                + currentdate.getHours() + "."  
                + currentdate.getMinutes() + "." 
                + currentdate.getSeconds();
          

    var file_name;
    var image_format = ['jpg','jpeg','png','bmp','gif'];
        
        $(".image-preview-input input:file").change(function (){     
          var file = this.files[0];

          var matching_format_res = Formats(file_get_ext(file.name));

          if(matching_format_res==true)
          {
              file_name = this.files[0];
              console.log("file_name"+file_name.name);
               
          }else 
          {
              swal("File format not supported..");
              imageclearEvent();
          }
            
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



function DisplaySubmit()
{
      console.log("file ppath"+file_name);
    var fileee_name = 'DNDM-'+ '.'+file_get_ext(file_name.name);
     console.log("file ppath"+fileee_name);
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


</script>


</body>
</html>