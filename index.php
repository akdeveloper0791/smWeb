<?php

session_start();

if( isset($_SESSION['user_id']) ){
	header("Location:home.php");
}

require 'database.php';

$cookie_name = "Mode_Selection";

if(!empty($_POST['email']) && !empty($_POST['password'])):
	
	$records = $conn->prepare('SELECT id,email,password FROM users WHERE email = :email');
	$records->bindParam(':email', $_POST['email']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$message = '';

	if(count($results) > 0 && password_verify($_POST['password'], $results['password']) ){

		$_SESSION['user_id'] = $results['id'];
		header("Location: home.php");

	} else {
		$message = 'Sorry, these login credentials do not exist. Please contact your administrator.';
	}



		if(isset($_POST['optradio']))
		{
			//echo "You have selected :".$_POST['optradio'];  //  Displaying Selected Value

			$cookie_name = "Mode_Selection";
			$cookie_value = $_POST['optradio'];

			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
		}

endif;



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
 <link href="_css/Icomoon/style.css" rel="stylesheet" type="text/css" />
<!-- <link href="https://fonts.googleapis.com/css?family=Dosis:200,300,400,500,600,700" rel="stylesheet"> -->
<link href="https://fonts.googleapis.com/css?family=Roboto:200,300,400,500,600,700" rel="stylesheet">
</head>
<style type="text/css">
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   text-align: center;
}
</style>
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
				<!-- <li class="propClone"><a href="shop.html">Add Screen</a></li>
				<li class="propClone"><a href="product.html">Delete Screen</a></li> -->
				
				<li class="propClone"><a href=""><span class="icon-phone-square"></span>+91 9900819475</a></li>
				<li class="propClone" id="superuser"><a href="register.php">Create user</a></li>
			</ul>
		</div>
	</div>
	</nav>

		<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<div class="text-pageheader">
					<div class="subtext-image" data-scrollreveal="enter bottom over 1.7s after 0.1s">
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
			<h1 class="text-center latestitems">Login</h1>
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

				<form action="index.php" method="POST">
					<div class="form-group">
            			<label for="exampleInputEmail1">Email address</label>
            			<input type="text" class="form-control" placeholder="Enter email" name="email" required autofocus>
          			</div>

					<div class="form-group">
            			<label for="exampleInputPassword1">Password</label>
           				<input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
          			</div>

          			<div class="radio">
      					

      					<label ><input type="radio" name="optradio" value="Enterprise" style="width:20px;height:20px;" checked="checked"><span style="font-weight: bold;">Enterprise<span> </label>

      					<label style="margin-left:20px;"><input type="radio" name="optradio" value="NearBy" style="width:20px;height:20px;"> <span style="padding-left: 10px;font-weight: bold;">NearBy</span> </label>

      					<label style="margin-left:20px;"><input type="radio" name="optradio" value="Local" style="width:20px;height:20px;"> <span style="padding-left: 10px;font-weight: bold;">Local</span> </label>

    				</div>
				    <!-- <div class="radio">
				      	
				    </div> -->

					<p style="float: right;">
					<input type="checkbox" id="show" name=""> Show password</p>

					<input type="submit" class="btn btn-success btn-block"> 
					<p></p>
				<!-- 	<p style="float: right;">Don't have an account? <a href="register.php">Register</a></p> -->

				</form>
					
			</div>
			<div class="col-md-3 ">
			</div>
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
 <script>
  
  
          var x = location.hostname;
         var domain = ['127.0.0.1','localhost'];
      
            var domainlength = domain.length;
            for(var i=0;i<domainlength;i++)
            {
              var format = domain[i];
              if(format==x){
               $('#superuser').show();   
          }else{
             $('#superuser').hide();   
          }
            
            }


 $(document).ready(function () {
 $("#show").click(function () {
 if ($("#password").attr("type")=="password")  {
 $("#password").attr("type", "text");
  $("#confirm_password").attr("type", "text");
 }
 else{
 $("#password").attr("type", "password");
 
 }

 });
 });
</script> 
</body>
</html>