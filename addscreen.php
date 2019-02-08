<?php

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
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="_css/Icomoon/style.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet">
<script src="js/sweetalert.js"></script>
<link rel="stylesheet" href="js/sweetalert.css">
<script type="text/javascript" src="js/default_busy_loader.js"></script>
<link rel="stylesheet" href="Font-Awesome-5.5.0/web-fonts-with-css/css/fontawesome-all.min.css">
<style type="text/css">
  html, body{
  margin:0;
  padding:0;
  height:100%;
}
section.kitty {
  position: relative;
  border: 1px solid #000;
  padding-top: 37px;
  background: #500;
  width: 80%;
}
section.positioned {
  position: absolute;
  top:100px;
  left:100px;
  width:800px;
  box-shadow: 0 0 15px #333;
}
.container1 {
  overflow-y: auto;
  height: 200px;
}
table {
  border-spacing: 0;
  width:100%;
}
td + td {
  border-left:1px solid #eee;
}
td, th {
  border-bottom:1px solid #eee;
  background: #ddd;
  color: #000;
  padding: 10px 25px;
}
th {
  height: 0;
  line-height: 0;
  padding-top: 0;
  padding-bottom: 0;
  color: transparent;
  border: none;
  white-space: nowrap;
}
th div{
  position: absolute;
  background: transparent;
  color: #fff;
  padding: 9px 25px;
  top: 0;
  margin-left: -25px;
  line-height: normal;
  border-left: 1px solid #800;
}
th:first-child div{
  border: none;
}
</style>
</head>
<body style="
    background-color: darkgray;
">

<!-- HEADER =============================-->
<header class="item header margin-top-0">
<div class="wrapper">
	<?php if( !empty($user) ): ?>
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
			<!-- 	<li id="propClone" class="propClone" ><a href="addscreen.php">Add Screen</a></li> -->
				<li id="propClone" class="propClone"><a href="index.php"><span class='icon-home'></span></a></li>
				<li id="logout" class="propClone"><a href="logout.php">Logout</a></li>
			</ul>
		</div>
	</div>
	</nav>

	
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<div class="text-pageheader">
					<div class="subtext-image" data-scrollreveal="enter bottom over 1.7s after 0.1s" >
						<br /><h1>Welcome to Signage Manager</h1><h2><span style="color: orange;"><?= $user['email']; ?></span></h2>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</header>

<!-- CONTENT =============================-->
<!--  <center ><button onclick="addchannel();" style="margin-right:20px;">Add Channel</button><button onclick="addscreens();">Add Screen</button></center> -->
 <br/> <br/>
<section class="item content" style="background-color: darkgray;">
<div class="container toparea">
	<div class="underlined-title">
		<div class="editContent">
			<span id='message'></span>
	<!-- 		<h1 class="text-center latestitems">Add Screen</h1> -->
     <!--  <center ><button onclick="addchannel();" style="margin-right:20px;">Add Channel</button><button onclick="addscreen();">Add Screen</button></center> -->
		</div>
    <div>
      <center ><button onclick="addchannel();" style="margin-right:20px;">Add Channel</button><button onclick="addscreens();">Add Screen</button></center>
      <br/>
    </div>
<!-- 		<div class="wow-hr type_short">
			<span class="wow-hr-h">
			<i class="fa fa-star"></i>
			<i class="fa fa-star"></i>
			<i class="fa fa-star"></i>
			</span>
		</div> -->
	</div>
	<div class="rows" id="screens" style="display: none;">
							

                            <div class="form-group">
                              <label for="exampleInputPassword2">Select Channel Name *</label>
                               <select name="Channel" id="Channel_Channel" class="form-control"  required>
                                <option>Select Channel</option>
                                  <?php 
                                    $res=mysqli_query($link,"select * from channel_table");
                                    while($row=mysqli_fetch_array($res)){
                                                ?>
                                    <option value="<?php echo $row["ch_id"]; ?>"><?php echo $row["names"]; ?></option>
                                    <?php
                                  }
                                ?>
                              </select>
                            </div>

                            <div class="form-group">
                              <label for="exampleInputEmail1">Drive Path *</label>
                              <input type="text" class="form-control" placeholder="Enter drive path like E:/" name="path" id="path">
                            </div>

                             <div class="form-group">
                              <label for="exampleInputPassword2">Device Name *</label>
                             <input type="text" class="form-control" placeholder="Enter Device Name" name="ip" id="ip">
                            </div>
                            
                              <p></p>
       <center>     
       <a href="index.php"><button class="btn btn-danger" style="display:inline-block;">Close</button></a>          
<button class="btn btn-success" id="submit" style="display:inline-block;" onclick="savescreen()">Submit</button></center>
  <p></p>  <p></p>

<!-- table			 -->
	<!-- 	<center>
		<br/><br/> -->
  </div>

  <!-- add channel -->
  <div class="rows" id="channels" >
              

                        <div class="form-group">
                              <label for="exampleInputPassword2">Channel Name *</label>
                             <input type="text" class="form-control" placeholder="Enter channel name" name="channel" id="channel">
                            </div>  
                            
                              <p></p>
       <center>     
       <a href="index.php"><button class="btn btn-danger" style="display:inline-block;">Close</button></a>          
<button class="btn btn-success" id="submit" style="display:inline-block;" onclick="savechannel()">Submit</button></center>
  <p></p>  <p></p>
  </div>


</div>

</section>
<hr >
<center>
  <h3 style="text-align:center;">Screen Connection Table</h3>
<section class="kitty">

  <div class="container1" id="channeltable" style="background: lightgray;">
    <table>

      <thead>

        <tr class="header" style='text-align:center;'>
          <th>
            CHANNEL ID
            <div>CHANNEL ID</div>
          </th>
          <th>
           CHANNEL NAME 
            <div>CHANNEL NAME</div>
          </th>
          <th>
          DELETE
            <div>DELETE</div>
          </th>
        </tr>
      </thead>
      <tbody>
	<?php
	// require("Constants.php");
	// $conn = mysqli_connect("localhost","root","root123","auth");
	if ($link-> connect_error) {
		die("connection failed:".$link-> connect_error);
	}

	// $sql = "SELECT a.ch_id, a.names, b.path, b.ip FROM screens AS b INNER JOIN channel_table as A ON (b.ch_id=a.ch_id)";

  $sql = "SELECT ch_id,names FROM channel_table";



	$result = $link->query($sql);
	if ($result-> num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			echo "<tr style='padding-left:15px;'><td>". $row["ch_id"] ."</td><td>".$row["names"] ."</td><td><a style='cursor:pointer;color:red;' onclick='deletechannel(".$row['ch_id'].");'><span class='icon-trash' ></span></a></td></tr>";
		}
		echo "</table>";
	}
	else {
		echo "<h4 style='color:crimson;'>No Channels Record Found</h4>";
	}

// $link-> close();
	?>
</tbody>
</table>   
<!-- </div>
</center> -->
	<!-- table -->

<!-- 	</div> -->
</div>

<div class="container1" id="screentable" style="background: lightgray;display: none;">
    <table>

      <thead>

        <tr class="header" style='text-align:center;'>
          <th>
            SCREEN NAME
            <div>SCREEN NAME</div>
          </th>
          <!-- <th>
            SCREEN ID
            <div>SCREEN ID</div>
          </th> -->
          <th>
           SCREEN NO.
            <div>SCREEN NO.</div>
          </th>
          <th>
           DRIVE PATH
            <div>DRIVE PATH</div>
          </th>
          <th>
          DRIVE NAME
            <div>DRIVE NAME</div>
          </th>
          <th>
          DELETE
            <div>DELETE</div>
          </th>
        </tr>
      </thead>
      <tbody>
  <?php
  // require("Constants.php");
  // $conn = mysqli_connect("localhost","root","root123","auth");
  if ($link-> connect_error) {
    die("connection failed:".$link-> connect_error);
  }

  $sql = "SELECT a.names, b.name, b.path, b.ip FROM screens AS b INNER JOIN channel_table as A ON (b.ch_id=a.ch_id)";



  $result = $link->query($sql);
  if ($result-> num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo "<tr style='padding-left:15px;'><td>". $row["names"] ."</td><td>".$row["name"] ."</td><td>". $row["path"] ."</td><td>". $row["ip"] ."</td><td><a style='cursor:pointer;color:red;' onclick='deletescreen(".$row['name'].");'><span class='icon-trash'></span></a></td></tr>";
    }
    echo "</table>";
  }
  else {
    echo "<h4 style='color:crimson;'>No Screens Record Found</h4>";
  }

$link-> close();
  ?>
</tbody>
</table>   
<!-- </div>
</center> -->
  <!-- table -->

<!--  </div> -->
</div>
</section>
</center>
	<?php else: ?>
		<script type="text/javascript">
			document.getElementsById('propClone').style.display="none";
		</script>
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
 function addchannel(){
document.getElementById("channels").style.display="block";
document.getElementById("screens").style.display="none";
document.getElementById("channeltable").style.display="block";
document.getElementById("screentable").style.display="none";
}

 function addscreens(){
document.getElementById("channels").style.display="none";
document.getElementById("screens").style.display="block";
document.getElementById("channeltable").style.display="none";
document.getElementById("screentable").style.display="block";
}
</script>
<script type="text/javascript">
	function deletechannel(id){
	console.log(id);

swal({
  title: "Are you sure?",
  text: "You want to delete this channel",
  type: "warning",
  showCancelButton: true,
  confirmButtonClass: "btn-danger",
  confirmButtonText: "Yes, delete ",
  cancelButtonText: "No, cancel ",
  closeOnConfirm: false,
  closeOnCancel: false
},function(isConfirm) {
  if (isConfirm) {
      ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>Update in progress<br/> Please wait...");

      var form_data = new FormData();
      form_data.append('sc_id',id);
      
        $.ajax({
        type: "POST",
        dataType: 'text',
        url: "php/deletechannel.php",
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
                //swal(jsonResponse.status);
                swal({ 
                title: "channel",
                          text: "Deleted successfully",
                          type: "success"
                },
                function(){
                  window.location.reload();
              });

              }else 
              {
                swal(jsonResponse.status);
              }
             }catch(Exception)
             {
               alert(Exception.message);
             }

          }
        });

} else {
    swal("Cancelled", "channel is safe", "error");
  }
});
   

}

function deletescreen(id){
  console.log(id);

swal({
  title: "Are you sure?",
  text: "You want to delete this screen.",
  type: "warning",
  showCancelButton: true,
  confirmButtonClass: "btn-danger",
  confirmButtonText: "Yes, delete ",
  cancelButtonText: "No, cancel ",
  closeOnConfirm: false,
  closeOnCancel: false
},function(isConfirm) {
  if (isConfirm) {
      ajaxindicatorstart("<img src='images/ajax-loader.gif'><br/>Update in progress<br/> Please wait...");

      var form_data = new FormData();
      form_data.append('sc_id',id);
      
        $.ajax({
        type: "POST",
        dataType: 'text',
        url: "php/deletescreen.php",
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
                //swal(jsonResponse.status);
                swal({ 
                title: "screen",
                          text: "Deleted successfully",
                          type: "success"
                },
                function(){
                  window.location.reload();
              });

              }else 
              {
                swal(jsonResponse.status);
              }
             }catch(Exception)
             {
               alert(Exception.message);
             }

          }
        });

} else {
    swal("Cancelled", "screen is safe", "error");
  }
});
   

}

function savescreen(){
  // var ch_id = document.getElementById('Channel_Channel').value;
  var name = document.getElementById('Channel_Channel').value;
  var path = document.getElementById('path').value;
  var ip = document.getElementById('ip').value;
console.log("name"+name);
  if(name==' ' || name=='' || name==null){
  swal({
  title: 'Please select channel name.',
  timer: 2000
});
  return false;
} else if(path==' ' || path=='' || path==null){
  swal({
  title: 'Please enter drive mapping path.',
  timer: 2000
});
  return false;
} else  if(ip==' ' || ip=='' || ip==null){
  swal({
  title: 'Please enter device name.',
  timer: 2000
});
  return false;
} 
            var form_data = new FormData();     
            form_data.append('name',name);
            form_data.append('path',path);             
            form_data.append('drive',ip);
    
               $.ajax({
                type: "POST",
                dataType: 'text',
                  url: "php/addscreen.php",
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
                //swal(jsonResponse.status);
                swal({ 
                title: "screen",
                          text: "Added successfully",
                          type: "success"
                },
                function(){
                  window.location.reload();
              });

              }else 
              {
                swal(jsonResponse.status);
              }
             }catch(Exception)
             {
               alert(Exception.message);
             }

          }
        });
}

function savechannel(){
  // var ch_id = document.getElementById('Channel_Channel').value;
  var channel = document.getElementById('channel').value;


  if(channel==' ' || channel=='' || channel==null){
  swal({
  title: 'Please enter channel name..',
  timer: 2000
});
  return false;
} 
            var form_data = new FormData();     
            form_data.append('channel',channel);
           
    
               $.ajax({
                type: "POST",
                dataType: 'text',
                  url: "php/addchannel.php",
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
                //swal(jsonResponse.status);
                swal({ 
                title: "channel",
                          text: "Added successfully",
                          type: "success"
                },
                function(){
                  window.location.reload();
              });

              }else 
              {
                swal(jsonResponse.status);
              }
             }catch(Exception)
             {
               alert(Exception.message);
             }

          }
        });
}
</script>

</body>
</html>