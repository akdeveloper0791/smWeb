<?php

session_start();
require 'database.php';
$link=mysqli_connect($server,$username,$password);
mysqli_select_db($link,$database);
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
<link href="https://fonts.googleapis.com/css?family=Roboto:200,300,400,500,600,700" rel="stylesheet">


<script src="js/sweetalert.js"></script>
<link rel="stylesheet" href="js/sweetalert.css">
<script type="text/javascript" src="js/default_busy_loader.js"></script>

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
				<li class="propClone"><a href="">+91 9845770360</a></li>
				<li class="propClone"><a href="index.php">Login</a></li>
			</ul>
		</div>
	</div>
	</nav>

		<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<div class="text-pageheader">
					<div class="subtext-image" data-scrollreveal="enter bottom over 1.7s after 0.1s" style="padding-top: 20px;padding-bottom: 20px;">
						 Welcome to Signage Manager
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</header>

<!-- CONTENT =============================-->
<section class="item content">
<div class="container toparea" style="padding:5px 0px;">
	<div class="underlined-title">
		<div class="editContent">
			<h1 class="text-center latestitems">Register</h1>
		</div>
		<div class="wow-hr type_short">
			<span class="wow-hr-h">
			<i class="fa fa-star"></i>
			<i class="fa fa-star"></i>
			<i class="fa fa-star"></i>
			</span>
		</div>
	</div>
	<div class="row">
			<div class="col-md-3 ">
			</div>
			<div class="col-md-6 ">

				
						<?php if(!empty($message)): ?>
						<p style="text-align: center;color: brown;"><?= $message ?></p>
					<?php endif; ?>
				
					

					
						
											
											<div class="form-group">
									            <label for="exampleInputEmail1">User name</label>
									            <input type="text" class="form-control" placeholder="Enter user name" name="name" id="name" required autofocus>
									          </div>
											<div class="form-group">
									            <label for="exampleInputEmail1">Email address</label>
									            <input type="email" id="email" class="form-control" placeholder="Enter email" name="email" required>
									          </div>
									          <div class="rows">
									          	<div class="col-md-6" style="padding: 0 5px 0 0;">
											<div class="form-group">
									            <label for="exampleInputPassword1">New password</label>
									           <input type="password" class="form-control" placeholder="Enter password" name="password" id="password" onkeyup='check();' required>
									      <span id='message'></span>
									          </div>
									      </div>
									      <div class="col-md-6" style="padding: 0px;">
												<div class="form-group">
									            <label for="exampleInputPassword2">Confirm password</label>
									           <input type="password" class="form-control" placeholder="Re-type Password" name="confirm_password" id="confirm_password" onkeyup='check();'  required>
									   			<p style="float: right;">
									   			<input type="checkbox" id="show" name=""> Show password</p>
												
									          
									          </div>	
									          </div>
									          </div>	
									     
											<input type="submit" class="btn btn-success btn-block" onclick="userRegister();"> 
					<!-- </form> -->
					<br/><br/>

				
			</div>
					<div class="col-md-3 "></div>
	</div>
	

</div>
</section>



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







<!-- Load JS here for greater good =============================-->
<script src="js/jquery-.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/anim.js"></script>


<script type="text/javascript">

// $('#default_Channel').change(function(){
//   arrayGlobal=[];
//     $('#default_Channel option:selected').each(function(){
       

//         arrayGlobal.push($(this).val());

        
//     });

//     console.log(JSON.stringify(arrayGlobal));
// })


var check = function() {
  if (document.getElementById('password').value  ==
    document.getElementById('confirm_password').value && document.getElementById('password').value  != null && document.getElementById('password').value  != "" ) {
    document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = 'matching';
    $(":submit").removeAttr("disabled");
  } else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = 'not matching';
     $(":submit").attr("disabled", true);
  }
}

 $(document).ready(function () {
 $("#show").click(function () {
 if ($("#password").attr("type")=="password" && $("#confirm_password").attr("type")=="password")  {
 $("#password").attr("type", "text");
  $("#confirm_password").attr("type", "text");
 }
 else{
 $("#password").attr("type", "password");
 $("#confirm_password").attr("type", "password");
 }

 });
 });


 	function userRegister()
	{

		var userName = document.getElementById('name').value;
		var userEmail = document.getElementById('email').value;
		var userPassword = document.getElementById('password').value;
		var userPasswordConfirm = document.getElementById('confirm_password').value;
		// var default_Channel = document.getElementById('default_Channel').value;
		if(userName=='Enter user name' || userName=='' || userName==null){
		  swal("Enter user name");
		  return false;
		}else if(userEmail=='Enter email' || userEmail=='' || userEmail==null){
		  swal("Enter user email address");
		   return false;
		 }else if(userPassword=='Enter password' || userPassword=='' || userPassword==null){
		  swal("Enter user email address");
		   return false;
		  }
		//   else if(default_Channel=='' || default_Channel==null || default_Channel=='Select Screen'){
		//   swal("Please assign channel(s)");
		//   return false;
		// }

	
	var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (!filter.test(email.value)) {
    swal('Please provide a valid email address');
    email.focus;
    return false;
	}
		if(userPassword==userPasswordConfirm)
		{
			ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>Please wait...");

			var form_data = new FormData();
	      		form_data.append('name',userName);
	      		form_data.append('email',userEmail);
	      		form_data.append('password',userPassword);

            	// form_data.append('default_Channel',JSON.stringify(arrayGlobal));
	      
	        $.ajax({
	        type: "POST",
	        dataType: 'text',
	        url: "php/userRegister.php",
	        // url: "php/modifyuser.php",
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
                    /*var jsonResponse = JSON.parse(data);*/
                     console.log("data==="+data);
                    // if(data=="Successfully created new user")
                    // {
                      
                 var jsonResponse = JSON.parse(data);

               if(jsonResponse.statusCode==0)
               {

                      setTimeout(function () { 
                      swal({
                        title: "success",
                        text: "User account created successfully",
                        type: "success",
                        confirmButtonText: "OK"
                      },
                      function(isConfirm){
                        if (isConfirm) {
                          window.location.href="index.php";
                        }
                      }); }, 1000);

                    }else if(jsonResponse.statusCode==1)
                    {
                       swal("Dear user, Unable to create account please try again ");
                    }else if(jsonResponse.statusCode==3)
                    {
                       swal("User account already exists ");
                    }
                   }catch(Exception)
                   {
                    swal('Error, Please contact technial support.');
                   } 

	            }
	        });


		}else 
		{
			swal("Password doesn't match...");
		}

		
	}



</script>

<link rel="stylesheet" href="css/bootstrap-select.min.css">
<script src="js/jquery-.js"></script>
<script src="js/bootstrap-select.min.js"></script>
</body>
</html>