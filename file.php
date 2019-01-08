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
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
<link href="css/bootstrap.min.css" rel="stylesheet">
<script src="js/js/popper.min.js"></script>
<script src="js/js/jquery.min.js"></script>
<script src="js/js/bootstrap.min.js"></script>
<link href="css/style.css" rel="stylesheet">
<link rel="stylesheet" href="js/sweetalert.css">
<script src="js/sweetalert.js"></script>
<script src="js/pdf.js"></script>
<script src="js/pdf.worker.js"></script>
<script type="text/javascript" src="js/default_busy_loader.js"></script>
<link href="_css/Icomoon/style.css" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Roboto:200,300,400,500,600,700" rel="stylesheet">
<style type="text/css">

.item.content,.item.portfolio,.item.team,.item.pricing,.item.contact 
  {
    height:600px;
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

#upload-button {
  width: 150px;
  display: block;
  margin: 0px auto;
}

#file-to-upload {
  display: none;
}

#pdf-main-container {
  width: 400px;
  margin: 20px auto;
}

#pdf-loader {
  display: none;
  text-align: center;
  color: #999999;
  font-size: 13px;
  line-height: 100px;
  height: 100px;
}

#pdf-contents {
  display: none;
}

#pdf-meta {
  overflow: hidden;
  margin: 0 0 20px 0;
}

#pdf-buttons {
  float: left;
}

#page-count-container {
  float: right;
}

#pdf-current-page {
  display: inline;
}

#pdf-total-pages {
  display: inline;
}

#pdf-canvas {
  border: 1px solid rgba(0,0,0,0.2);
  box-sizing: border-box;
}

#page-loader {
  height: 100px;
  line-height: 100px;
  text-align: center;
  display: none;
  color: #999999;
  font-size: 13px;
}

</style>
</header>

<!-- CONTENT =============================-->
<section class="item content" style="
    background-color: darkgray;height: 100%;
">
<div class="container toparea" >
  <div class="underlined-title">
    <div class="editContent">
      <span id='message'></span>
      <h1 class="text-center latestitems">FILE(S)</h1>
    </div>
  </div>
  <div class="rows">
      <div class="col-md-6" style = "border-width:4px; border-style:groove;">
      <p style="text-align: center;" id="hidetext">Please select pdf file to preview</p>


        <div id="pdf-main-container"  >
    <div id="pdf-loader">Loading document ...</div>
    <div id="pdf-contents">
    <div id="pdf-meta">
      <div id="pdf-buttons">
        <button id="pdf-prev">Previous</button>
        <button id="pdf-next">Next</button>
      </div>
      <div id="page-count-container">Page <div id="pdf-current-page"></div> of <div id="pdf-total-pages"></div></div>
    </div>
    <canvas id="pdf-canvas" width="400" height="350px"></canvas>
    <div id="page-loader">Loading page ...</div>
  </div>
  </div>


      </div>

        <div class="col-md-6">
          <br/>
          <br/>
          <label for="exampleInputEmail1">Choose File(s) : *</label>
          <div class="input-group image-preview col-md-12">
             <div class="col-md-3" style="margin: 0px;padding: 0px;">
           <div class="btn btn-outline-primary image-preview-input" style="border-radius:0px;line-height:26px;padding: 0px;">
          <button class="image-preview-input-title" id="upload-button">Select PDF</button> 
          <input type="file" id="file-to-upload" accept="application/pdf" name="input-file-preview"/>
          </div>


<script>

var __PDF_DOC,
  __CURRENT_PAGE,
  __TOTAL_PAGES,
  __PAGE_RENDERING_IN_PROGRESS = 0,
  __CANVAS = $('#pdf-canvas').get(0),
  __CANVAS_CTX = __CANVAS.getContext('2d');

function showPDF(pdf_url) {
  $("#pdf-loader").show();

  PDFJS.getDocument({ url: pdf_url }).then(function(pdf_doc) {
    __PDF_DOC = pdf_doc;
    __TOTAL_PAGES = __PDF_DOC.numPages;
    
    // Hide the pdf loader and show pdf container in HTML
    $("#pdf-loader").hide();
    $("#pdf-contents").show();
    $("#pdf-total-pages").text(__TOTAL_PAGES);

    // Show the first page
    showPage(1);
  }).catch(function(error) {
    // If error re-show the upload button
    $("#pdf-loader").hide();
    $("#upload-button").show();
    
    alert(error.message);
  });;
}

function showPage(page_no) {
  __PAGE_RENDERING_IN_PROGRESS = 1;
  __CURRENT_PAGE = page_no;

  // Disable Prev & Next buttons while page is being loaded
  $("#pdf-next, #pdf-prev").attr('disabled', 'disabled');

  // While page is being rendered hide the canvas and show a loading message
  $("#pdf-canvas").hide();
  $("#page-loader").show();

  // Update current page in HTML
  $("#pdf-current-page").text(page_no);
  
  // Fetch the page
  __PDF_DOC.getPage(page_no).then(function(page) {
    // As the canvas is of a fixed width we need to set the scale of the viewport accordingly
    var scale_required = __CANVAS.width / page.getViewport(1).width;

    // Get viewport of the page at required scale
    var viewport = page.getViewport(scale_required);

    // Set canvas height
    __CANVAS.height = viewport.height;

    var renderContext = {
      canvasContext: __CANVAS_CTX,
      viewport: viewport
    };
    
    // Render the page contents in the canvas
    page.render(renderContext).then(function() {
      __PAGE_RENDERING_IN_PROGRESS = 0;

      // Re-enable Prev & Next buttons
      $("#pdf-next, #pdf-prev").removeAttr('disabled');

      // Show the canvas and hide the page loader
      $("#pdf-canvas").show();
      $("#page-loader").hide();
    });
  });
}

// Upon click this should should trigger click on the #file-to-upload file input element
// This is better than showing the not-good-looking file input element
$("#upload-button").on('click', function() {
  $("#file-to-upload").trigger('click');
  $("#hidetext").hide();
});

// When user chooses a PDF file
$("#file-to-upload").on('change', function() {
  // Validate whether PDF
    if(['application/pdf'].indexOf($("#file-to-upload").get(0).files[0].type) == -1) {
        alert('Error : Not a PDF');
        return;
    }

  // $("#upload-button").hide();

  // Send the object url of the pdf
  showPDF(URL.createObjectURL($("#file-to-upload").get(0).files[0]));
});

// Previous page of the PDF
$("#pdf-prev").on('click', function() {
  if(__CURRENT_PAGE != 1)
    showPage(--__CURRENT_PAGE);
});

// Next page of the PDF
$("#pdf-next").on('click', function() {
  if(__CURRENT_PAGE != __TOTAL_PAGES)
    showPage(++__CURRENT_PAGE);
});

</script>
          
                    
                  <!-- image-preview-input -->
                <!--   <div class="btn btn-outline-primary image-preview-input col-md-2" style="border-radius:0px;">
                    <span class="glyphicon glyphicon-folder-open"></span>
                    <span class="image-preview-input-title">Browse</span> -->
                   <!--  <input type="file" accept=".pdf" name="input-file-preview" class"image-preview-input" /> --> <!-- rename it -->
                 <!--  </div> -->
                   
                   </div>
                   <div class="col-md-7" style="margin: 0px;padding: 0px;">
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

                  <div class="col-md-12" style="padding: 0px;">


                  <div class="col-md-6" style="padding: 0px;">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Scrolling Text : </label>
                    <input type="text" class="form-control" placeholder="Enter Scrolling Text that will be displayed on the bottom of the Screen"  name="text_media" id="text_media">
                  </div>
                 </div>


                  <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputPassword2">Play Duration (sec):</label>
                    <input type="number" class="form-control" value="10" placeholder="Enter Duration in Second(s)" name="duration" id="duration">
                  </div>
                  </div>

             

              </div>

              <div class="col-md-12" style="padding: 0px;">


                  <div class="col-md-6" style="padding: 0px;">

                  <div class="form-group">
                    <label for="exampleInputEmail1">Zoom Level : </label>
                    <input type="number" class="form-control" value="1.0" placeholder="Enter in digits" name="zoomLevel" id="zoomLevel">
                  </div>
                  
                  <input type="checkbox" name="" id="fitscreen" onclick="fitscreen();"><label>Fit to Screen</label>

                 </div>


                  <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputPassword2">Scrolling Speed :</label>
                    <input type="number" class="form-control" value="10" placeholder="Enter Scrolling Speed Duration in Second(s)" name="scrollingSpeed" id="scrollingSpeed">
                <!--     <input type="tel" class="form-control" value="10" placeholder="Enter Scrolling Speed Duration in Second(s)" name="scrollingSpeed" id="scrollingSpeed" maxlength="2"> -->
                  </div>
                  </div>

             

              </div>

                   

                  <div class="checkbox">
                    <label id="media_checkbox_label" style="display:none;"><input type="checkbox" id="media_checkbox" checked ></label>
                  </div>


          </div>


        </div>

          <center>      
         <a href="index.php"><button class="btn btn-danger" style="display:inline-block;">Close</button></a>              
          <button class="btn btn-success" id="submit" style="display: inline-block;" onclick="ScreenConnection()">Send</button>
        </center>
      </div>
<br/>

                  
              
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
<!-- <script src="js/jquery-.js"></script>
<script src="js/bootstrap.min.js"></script> -->
<script src="js/anim.js"></script>

 
<script type="text/javascript">
    var currentdate = new Date();
           var datetime = currentdate.getDate() + "-"
                + (currentdate.getMonth()+1)  + "-" 
                + currentdate.getFullYear() + "_"  
                + currentdate.getHours() + "."  
                + currentdate.getMinutes() + "." 
                + currentdate.getSeconds();
           document.getElementById("media_name").value=datetime;


  function fitscreen(){

          if(document.getElementById('fitscreen').checked==true)
          {
            $('#zoomLevel').hide();
          }else 
          {
            $('#zoomLevel').show();
          }
        
        }

        var file_name;

        var video_format = ['pdf'];
        
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
              swal("File format not supported..");
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
         DisplaySubmit(screen_mode);
         //console.log("Enterprise mode is on");
      }else if(screen_mode=="local")
    {
       //MultiSubmit(screen_mode);
       DisplaySubmit(screen_mode);
       console.log("local mode is on");
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
                        }
                        else{
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



function DisplaySubmit(screenmode)
{

      if(screenmode=="enterprise")
      {
          var url_mode = "/smweb/enterprise/Api/PublishSingleRegCampaign.php";

          DisplaySubmitEnterpriseFTP(url_mode);
      }else if(screenmode=="local")
      {
        //console.log("successfully");
        var url_mode = "local/localfilejsoncreation.php";
      }
      else
      {

        var url_mode = "php/filejsoncreation.php";
   
        console.log("Url=="+url_mode);

        var media_name = document.getElementById('media_name').value;
        var duration = document.getElementById('duration').value;
        var text_media = document.getElementById('text_media').value;
        var zoomLevel = document.getElementById('zoomLevel').value;
        var scrollingSpeed = document.getElementById('scrollingSpeed').value;

        if(document.getElementById('fitscreen').checked==true)
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

        if(file_name==undefined || file_name==null )
          {
             swal("Select appropriate file format...");
             
          }else 
          {
       
            
              var now = new Date();
          
                  if(file_name.name!=null && file_name.name!=undefined)
                  {
                    var file_new_name = 'DNDM-'+now.getTime()+'.'+file_get_ext(file_name.name);

                    var fileee_name = 'DNDM-'+ media_name + '.'+file_get_ext(file_name.name);

                  }
                 
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

  var datastring = ([{"type":"File","width":100,"height":100,"top_margin":0,"bottom_margin":0,"left_margin":0,"right_margin":0,"media_name":fileee_name,"is_self_path":false,'properties':data2}]);

      var datastring1 = {}
                      datastring1['type'] = "File";
                      datastring1['media_name'] = media_name;
                      datastring1['offer_text'] = text_media;
                      datastring1['resource'] = fileee_name;
                      datastring1['duration'] = duration;
                      datastring1['path'] = screen_name;
                    
                      var data1 = JSON.stringify(datastring1);
                     console.log(data1);

            var data = JSON.stringify(datastring);
                console.log(data);

          ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>File transfer in progress<br/> Please wait...");

          var form_data = new FormData();     
            form_data.append('fileName',file_name);
            form_data.append('path',screen_name);             
            form_data.append('data',data);
            form_data.append('data1',data1);
            form_data.append('offer_text',text_media);
            form_data.append('duration',duration);
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
                  console.log(data);
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

        var media_name = document.getElementById('media_name').value;
        var duration = document.getElementById('duration').value;
        var text_media = document.getElementById('text_media').value;
        var zoomLevel = document.getElementById('zoomLevel').value;
        var scrollingSpeed = document.getElementById('scrollingSpeed').value;

        if(document.getElementById('fitscreen').checked==true)
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


          if(file_name==undefined || file_name==null )
          {
             swal("Select appropriate file format...");
             
          }else 
          {
       
            
              var now = new Date();
          
                  if(file_name.name!=null && file_name.name!=undefined)
                  {
                    var file_new_name = 'DNDM-'+now.getTime()+'.'+file_get_ext(file_name.name);

                    var fileee_name = 'DNDM-'+ media_name + '.'+file_get_ext(file_name.name);

                  }
                 
          }
   
          if(media_name=='Enter Media Name' || media_name=='' || media_name==null)
          {
            swal({
              title: 'Please enter media name',
              timer: 2000
             });
            return false;
          } 

          console.log(media_name+"...."+duration);

        var data2 = ({"zoomLevel":Number(zoomLevel),"scrollingSpeed":Number(scrollingSpeed),"isFitToScreen":isFitToScreen});

        var datastring = ([{"type":"File","width":100,"height":100,"top_margin":0,"bottom_margin":0,"left_margin":0,"right_margin":0,"media_name":fileee_name,"is_self_path":false,'properties':data2}]);

        var inputResult = { "type":'multi_region', "regions":datastring, "offer_text":text_media,"display_scroll_txt":false, "duration":duration,"resource":fileee_name};

        var data = JSON.stringify(inputResult);
            console.log(data);

          ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>File transfer in progress<br/> Please wait...");
          var form_data = new FormData();     
            form_data.append('fileName',file_name);
            form_data.append('path',screen_name);             
            form_data.append('data',data);
            //form_data.append('data1',data1);
            //form_data.append('offer_text',text_media);
            //form_data.append('duration',duration);
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
                 
                 success: function(data)
                 {
                    console.log(data);
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
                    alert('Dear user, Unable to push content please try again');
                   } 

                  }
                });

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

</script>
<!-- modal -->


<script src="js/js/Imagepage.js"></script>

</body>
</html>