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


    //Css file for choosing file

    .copyright {
        display:block;
        margin-top: 100px;
        text-align: center;
        font-family: Helvetica, Arial, sans-serif;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .copyright a {
      text-decoration: none;
      color: #EE4E44;
    }


    /****** CODE ******/

    .file-upload{display:block;text-align:center;font-family: Helvetica, Arial, sans-serif;font-size: 12px;}
    .file-upload .file-select{display:block;border: 2px solid #dce4ec;color: #34495e;cursor:pointer;height:40px;line-height:40px;text-align:left;background:#FFFFFF;overflow:hidden;position:relative;}
    .file-upload .file-select .file-select-button{background:#dce4ec;padding:0 10px;display:inline-block;height:40px;line-height:40px;}
    .file-upload .file-select .file-select-name{line-height:40px;display:inline-block;padding:0 10px;}
    .file-upload .file-select:hover{border-color:#34495e;transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-webkit-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;}
    .file-upload .file-select:hover .file-select-button{background:#34495e;color:#FFFFFF;transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-webkit-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;}
    .file-upload.active .file-select{border-color:#3fa46a;transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-webkit-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;}
    .file-upload.active .file-select .file-select-button{background:#3fa46a;color:#FFFFFF;transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-webkit-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;}
    .file-upload .file-select input[type=file]{z-index:100;cursor:pointer;position:absolute;height:100%;width:100%;top:0;left:0;opacity:0;filter:alpha(opacity=0);}
    .file-upload .file-select.file-select-disabled{opacity:0.65;}
    .file-upload .file-select.file-select-disabled:hover{cursor:default;display:block;border: 2px solid #dce4ec;color: #34495e;cursor:pointer;height:40px;line-height:40px;margin-top:5px;text-align:left;background:#FFFFFF;overflow:hidden;position:relative;}
    .file-upload .file-select.file-select-disabled:hover .file-select-button{background:#dce4ec;color:#666666;padding:0 10px;display:inline-block;height:40px;line-height:40px;}
    .file-upload .file-select.file-select-disabled:hover .file-select-name{line-height:40px;display:inline-block;padding:0 10px;}

    
</style>

<style>
  html { overflow: hidden; }
  canvas { 
    display: inline-block; 
    background: #202020; 
    width: 45%;
    height: 25%;
    box-shadow: 0px 0px 10px blue;
  }
  #controls {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-around;
    height: 20%;
    width: 100%;
  }
  #record { height: 15vh; }
  #record.recording { 
    background: red;
    background: -webkit-radial-gradient(center, ellipse cover, #ff0000 0%,lightgrey 75%,lightgrey 100%,#7db9e8 100%); 
    background: -moz-radial-gradient(center, ellipse cover, #ff0000 0%,lightgrey 75%,lightgrey 100%,#7db9e8 100%); 
    background: radial-gradient(center, ellipse cover, #ff0000 0%,lightgrey 75%,lightgrey 100%,#7db9e8 100%); 
  }
  #save, #save img { height: 10vh; }
  #save { opacity: 0.25;}
  #save[download] { opacity: 1;}

  #viz {
    height: 80%;
    width: 80%;
    display: flex;
    flex-direction: column;
    justify-content: space-around;
    align-items: center;
  }
  @media (orientation: landscape) {
    body { flex-direction: row;}
    #controls { flex-direction: column; height: 100%; width: 10%;}
    #viz { height: 80%; width: 80%;}
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
 		<div class="col-md-12">

      <div class="panel panel-danger">
        <div class="panel-heading">Audio</div>
          <div class="panel-body">

              
                <div class="anil_nepal">
                  <span> Play Audio </span>  <label class="switch switch-left-right"> 
                    <input class="switch-input" id="Play_Checkbox" type="checkbox" onchange='is_OnOFFMode(this);'>
                    <span class="switch-label" data-on="ON" data-off="OFF"></span> <span class="switch-handle"></span> </label>
                </div>

                <div style="border: 2px solid orange;border-radius:5px;text-align:center;">
                  <h5>Publish New Audio</h5>

                  <div class="col-md-6" onclick="$('#Audio_File').show()">
                     <img src="../images/music.png" alt="audio" style="width:100px;height:100px;" /><br />
                     <p> Choose </p>

                  </div>

                  <div class="col-md-6" onclick="$('#Record_File').show()">
                    <img src="../images/recorder.png" alt="record" style="width:100px;height:100px;" /><br />
                    <p> Record</p>

                  </div>
     

                </div>

                <div class="col-md-12" >

                    <h3 id="h3_text" style="border-bottom: 2px solid orange;text-align:center;padding-bottom:5px;"> Published Audio File(s) </h3>

                    <div id="ftp_audio_list_display" style='height:300px;overflow-y: auto'></div>


                </div>
              

              

          </div>
      </div>

 			

 		</div>
 	</div>
 </div>


  <div class="modal" id="Audio_File" role="dialog">
    <div class="modal-dialog modal-sm">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="$('#Audio_File').hide()" >&times;</button>
          <h4 class="modal-title">Audio</h4>
        </div>
        <div class="modal-body">
         
          <div class="file-upload">
              <div class="file-select">
                <div class="file-select-button" id="fileName">Choose File</div>
                <div class="file-select-name" id="noFile">No file chosen...</div> 
                <input type="file" name="chooseFile" id="chooseFile">
              </div>
          </div>

        </div>
        <div class="modal-footer">
          <center><button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#Audio_File').hide()"> Cancel </button>

          <button type="button" class="btn btn-success" onclick="SendAudioFile();" >Send </button></center>
        </div>
      </div>
      
    </div>
  </div>


  <div class="modal" id="Record_File" role="dialog">
    <div class="modal-dialog modal-md">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="$('#Record_File').hide()">&times;</button>
          <h4 class="modal-title">Recorder</h4>
        </div>
        <div class="modal-body" style="height:300px;overflow-y: auto;">
         
            <div id="viz" style="display: inline-block;">
              <canvas id="analyser" width="30" height="40"></canvas>
              <canvas id="wavedisplay" width="30" height="40"></canvas>
            </div>
            <div id="controls" style="display:inline-block;">
              <img id="record" src="../images/mic128.png" onclick="toggleRecording(this);">
              <a id="save" href="#"><img src="../images/save.svg"></a>
            </div>

        </div>
        <div class="modal-footer">
          <center><button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#Record_File').hide()">Cancel</button>

          <button type="button" class="btn btn-success" onclick="SendRecorderFile();" >Send </button></center>
        </div>
      </div>
      
    </div>
  </div>


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

      var file_name;
      var tmppath;

   		console.log("screen_name==" + screen_name +"==="+ screen_mode );

      $('#chooseFile').bind('change', function(event) 
      {
          var filename = $("#chooseFile").val();

          file_name = this.files[0];

          // var filepath  = file_name.path;

          var filepath = document.getElementById('chooseFile');

          console.log("file_name=="+file_name);

          tmppath = URL.createObjectURL(event.target.files[0]);

          //$("img").fadeIn("fast").attr('src',URL.createObjectURL(event.target.files[0]));

          console.log("tmppath=="+tmppath);

          if (/^\s*$/.test(filename)) 
          {
            $(".file-upload").removeClass('active');
            $("#noFile").text("No file chosen..."); 
          }
          else 
          {
            $(".file-upload").addClass('active');
            $("#noFile").text(filename.replace("C:\\fakepath\\", "")); 
          }
      });



   		function SendFTPRequestResponse()
   		{
        var ResponseVal = {"request":"media_request","action":"play_offer_audio_request"};

   		    ajaxindicatorstart("<img src='../images/ajax-loader.gif'><br/> Please wait...!");
          
          	var form_data = new FormData();                 
              form_data.append('ip_address',screen_name);
              form_data.append('request_JSON',JSON.stringify(ResponseVal));
              form_data.append('action',"play_offer_audio_request");

                $.ajax({
                	type: "POST",
                	dataType: 'text',
                  	url: "/smweb/enterprise/Api/SendFTPRequestResponseCommand.php",
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
                      
                      // var gotindexvalue = jsonResponse.index;
                       var gotResponseFile = jsonResponse.response_file;

                      // console.log(gotindexvalue+"==="+gotResponseFile);

                       getFTPAudioRequestFileList(gotResponseFile);

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


      function getFTPAudioRequestFileList(gotResponseFile)
      {
          ajaxindicatorstart("<img src='../images/ajax-loader.gif'><br/> Please wait...!");
          
            var form_data = new FormData();                 
              form_data.append('ip_address',screen_name);
              form_data.append('file_name',gotResponseFile);

                $.ajax({
                  type: "POST",
                  dataType: 'text',
                    url: "/smweb/enterprise/Api/ReadFile.php",
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

                      console.log("----"+jsonResponse.play_audio+"==="+jsonResponse.files);

                    if(jsonResponse.files!=null && jsonResponse.files.length>=1)
                    {
                      displayFTPFilesList(jsonResponse.play_audio,jsonResponse.files);

                    }else 
                    {
                        $('#ftp_audio_list_display').hide();
                        $('#h3_text').hide();

                        if(jsonResponse.play_audio==true)
                        {
                          document.getElementById('Play_Checkbox').checked=true;
                        }else 
                        {
                          document.getElementById('Play_Checkbox').checked=false;
                        }

                    }
                                     
                    if(jsonResponse.statusCode==99)
                    {
                       swal(jsonResponse.status);
                    }
                    else if(jsonResponse.statusCode==100)
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


      function displayFTPFilesList(play_audio_type,files)
      {
          var totalength = files.length;

          $("#ftp_audio_list_display").empty();

          console.log(totalength);

          if(play_audio_type==true)
          {
            document.getElementById('Play_Checkbox').checked=true;
          }else 
          {
            document.getElementById('Play_Checkbox').checked=false;
          }

          if(files!=null && totalength>=1)
          {
              for(var i=0;i<totalength;i++)
              {
                var record = files[i]; 

                var newRows = "<div id='audiolist_"+i+"' style='border:1px solid orange;border-radius:5px;margin-bottom:5px;padding: 10px;'>";

                newRows +="<p id='audio_name_"+i+"' style='margin:0px;'>"+getname(record)+"<img src='../images/delete.jpg' alt='delete.jpg' id='audio_delete_"+i+"' width='32' height='32' style='float:right;cursor:pointer;' onclick='deleteAudioFiles(\""+i+"\",\""+record+"\")'>"+"</p>"

                newRows +="</div>"

                $("#ftp_audio_list_display").append(newRows);

              }

          }

      }

      function getname(record)
      {
        return record.replace( "/data/user/0/com.ibetter.www.adskitedigi.adskitedigi/files/AdskiteDigi/Settings/Media/Audio/BgAudio/", "" ); 
      }

      function deleteAudioFiles(index,recordName)
      {

          var ResponseVal = {"request":"media_request","action":"delete_offer_audio_action_request:","bg_audio_file":recordName};

          console.log(JSON.stringify(ResponseVal));

          ajaxindicatorstart("<img src='../images/ajax-loader.gif'><br/> Please wait...!");
          
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
                      console.log("deleteRequest==="+data);

                      ajaxindicatorstop();

                   try
                   {

                    var jsonResponse = JSON.parse(data);
                    
                      if(jsonResponse.statusCode==0)
                      {

                         //document.getElementById("audiolist_"+index) = ; 
                         $("#audiolist_"+index).remove();               

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
                      }

                   }catch(Exception)
                   {
                    alert('Dear user, Unable to push content please try again');
                   } 

                  }
              });
      }

      function is_OnOFFMode(box)
      {
        if(box.checked==true)
        {
          //console.log("True");
          is_ONOFFResponse(true);
        }else 
        {
          //console.log("False");
          is_ONOFFResponse(false);
        }

      }

      function is_ONOFFResponse(type)
      {
        //console.log(type);
        var ResponseVal = {"request":"player_settings_request","action":"play_offer_text_action","play_audio":type};

        console.log(JSON.stringify(ResponseVal));

          ajaxindicatorstart("<img src='../images/ajax-loader.gif'><br/> Please wait...!");
          
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

                        swal(jsonResponse.status);               

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
                    }

                   }catch(Exception)
                   {
                    alert('Dear user, Unable to push content please try again');
                   } 

                  }
              });
      }

		
      function SendAudioFile()
      {
          if(file_name!=null && tmppath!=null)
          {   
            var fileName = document.getElementById('chooseFile').value;

            console.log(fileName);

            ajaxindicatorstart("<img src='../images/ajax-loader.gif'><br/> Please wait...!");
          
            var form_data = new FormData();                 
              form_data.append('ip_address',screen_name);
              form_data.append('AudiofileName',file_name);
              form_data.append('audio_name',fileName);
              //form_data.append('files',JSON.stringify(ResponseVal));

                $.ajax({
                  type: "POST",
                  dataType: 'text',
                    url: "/smweb/php/SendAudioToPlayerFTP.php",
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

                            SendAudioFileToPlayer(jsonResponse.fileName,jsonResponse.path);              

                        }else if(jsonResponse.statusCode==2)
                        {
                           swal(jsonResponse.status);
                        }

                       }catch(Exception)
                       {
                        alert('Dear user, Unable to push content please try again');
                       } 

                  }
              });

          }else 
          {
            swal("Select the File");
          }

      }

      function SendAudioFileToPlayer(fileName,path)
      {
          var ResponseVal = [{"file_name":"bg_audio_file_"+fileName,"file_path":path}];

          ajaxindicatorstart("<img src='../images/ajax-loader.gif'><br/> Please wait...!");

          console.log(JSON.stringify(ResponseVal));
          
            var form_data = new FormData();                 
                form_data.append('ip_address',screen_name);
                form_data.append('files',JSON.stringify(ResponseVal));

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
                      console.log(data);
                      ajaxindicatorstop();

                   try
                   {

                    var jsonResponse = JSON.parse(data);
                    
                    if(jsonResponse.statusCode==0)
                    {
                        swal(jsonResponse.status);

                        $('#Audio_File').hide();

                        DeleteAudioFileInLocal(fileName,path);             

                    }else if(jsonResponse.statusCode==1)
                    {
                       swal(jsonResponse.status);
                       DeleteAudioFileInLocal(fileName,path);
                    }
                    else if(jsonResponse.statusCode==2)
                    {
                       swal(jsonResponse.status);
                       DeleteAudioFileInLocal(fileName,path);
                    }
                    

                   }catch(Exception)
                   {
                    alert('Dear user, Unable to push content please try again');
                   } 

                  }
              });

      }

      function DeleteAudioFileInLocal(fileName,path)
      {
          ajaxindicatorstart("<img src='../images/ajax-loader.gif'><br/> Please wait...!");
          
            var form_data = new FormData();                 
                form_data.append('fileName',fileName);
                form_data.append('path',path);

                $.ajax({
                  type: "POST",
                  dataType: 'text',
                    url: "/smweb/php/DeleteAudioFileInLocalFolderFTP.php",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,                         
                    type: 'post',
                 
                  success: function(data)
                  {  
                      ajaxindicatorstop();

                   try
                   {

                      console.log(data);
                  
                   }catch(Exception)
                   {
                    alert('Dear user, Unable to push content please try again');
                   } 

                  }
              });

      }


      function SendRecorderFile()
      {



        
      }
		

   		window.onload = SendFTPRequestResponse();
</script>



<!-- Load JS here for greater good =============================-->
 <script src="../js/jquery-.js"></script>
 <script src="../js/bootstrap.min.js"></script>
 <script src="../js/anim.js"></script>
 <script src="../js/jscolor.js"></script>
 <script src="../js/js/Videopage.js"></script>
 <script src="../js/js/Imagepage.js"></script>


  <script src="../js/audiodisplay.js"></script>
  <script src="../js/recorder.js"></script>
  <script src="../js/main.js"></script>

</body>
</html>