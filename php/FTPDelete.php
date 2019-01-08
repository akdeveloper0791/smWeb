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

 		<div class='col-md-12 ' style="margin-bottom:20px;"><br />
 			<!-- <input type="button" class="btn btn-warning" value="Cancel" onclick='CancelRequest();' /> -->
 			<input type="button" class="btn btn-danger" value="Delete" onclick="DeleteRequest();" style="float:right;" />
 		</div>

 		<div class="col-md-12">

 			<div id="ftp_delete_list_display" style="height:400px;width:auto;overflow-y: auto"></div>

 			
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

   		var arrayVal = [];

   		console.log("screen_name==" + screen_name +"==="+ screen_mode );

   		function FTPDeleteRequestFile()
   		{

   		    ajaxindicatorstart("<img src='../images/ajax-loader.gif'><br/> Please wait...!");
          
          	var form_data = new FormData();                 
              form_data.append('ip_address',screen_name);
             // form_data.append('index',indexpos);

                $.ajax({
                	type: "POST",
                	dataType: 'text',
                  	url: "/smweb/enterprise/Api/GetCampaignFiles.php",
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
                      
                     	displayFTPFilesList(jsonResponse.files);

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


   		
   		function displayFTPFilesList(filesArray)
   		{
   			var totalen = filesArray.length;

   				for(var i=0;i<totalen;i++)
   	 			{
	   	 			var record = filesArray[i];

	   	 			var newRows = "<div id='deletelist_"+i+"' style='border:1px solid orange;border-radius:5px;margin-bottom:5px;padding: 10px;'>";

	   	 				newRows +="<p id='delete_name_"+i+"' style='margin:0px;'>"+getFileName(record)+"<input type='checkbox' id='delete_media_name_"+i+"' class='checkbx_links_keyword' name='delete_media_name_"+i+"' value='"+record+"' style='float:right;margin-right:10px;padding-top:5px;width:40px;height:20px;' onclick='boxclick();'>"+"</p>"

	   	 				
					    newRows +="</div>"

					 $("#ftp_delete_list_display").append(newRows);

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


		function CancelRequest()
		{
			window.location="http://localhost/smweb/enterprise.php";
			
		}

		function DeleteRequest()
		{
			if(arrayVal!=null && arrayVal.length>=1)
			{

				ajaxindicatorstart("<img src='../images/ajax-loader.gif'><br/> Please wait...!");

				//&request_json=%7B%22request%22:%22media_request%22,%22action%22:%22delete_action_request:%22,%22files%22:[%22facebook.txt%22]%7D

   		    	var ResponseVal = {"request":"media_request","action":"delete_action_request:","files":arrayVal};

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
                      
                      //document.getElementById('is_skip_value_'+indexval).checked=booleanvalue;
                      swal(jsonResponse.status);

                      setTimeout(function(){
                        window.location.reload();
                      }, 2000);

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

			}else 
			{
				swal("Please Select Files to Delete..!");
			}

		}


   		window.onload = FTPDeleteRequestFile();
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