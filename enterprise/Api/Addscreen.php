<?php

session_start();

require '../../database.php';

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
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<link href="../../_css/Icomoon/style.css" rel="stylesheet" type="text/css" />
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
<link href="../../css/style.css" rel="stylesheet">
<script src="../../js/sweetalert.js"></script>
<link rel="stylesheet" href="../../js/sweetalert.css">
<script type="text/javascript" src="../../js/default_busy_loader.js"></script>
<!-- <link href="https://fonts.googleapis.com/css?family=Dosis:200,300,400,500,600,700" rel="stylesheet"> -->
<link href="https://fonts.googleapis.com/css?family=Roboto:200,300,400,500,600,700" rel="stylesheet">
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
			<a href="../../index.php" class="navbar-brand brand" style="
    display: inline-flex;
"> <img src="images/signage.png" alt="" class="logo" style="
    width: 32px;
    height:  32px;margin: 0 10px;
">Signage Manager </a>
		</div>
		<div id="navbar-collapse-02" class="collapse navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
			<!-- 	<li id="propClone" class="propClone" ><a href="addscreen.php">Add Screen</a></li> -->
				<li id="propClone" class="propClone"><a href="../../index.php"><span class='icon-home'></span></a></li>
				<li id="logout" class="propClone"><a href="../../logout.php">Logout</a></li>
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
 <br/> <br/>
<section class="item content" style="
    background-color: darkgray;
">
<div class="container toparea">
	<div class="underlined-title">
		<div class="editContent">
			<span id='message'></span>
			
		</div>
      <div>
      <center ><button onclick="modifyaccount();" style="margin-right:20px;">Modify Account</button><button onclick="deleteaccount();">Delete Account</button></center>
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
	<div class="rows" id="modify">
							

                        <div class="form-group">
                              <label for="exampleInputPassword2">Select Account *</label>
                             <select name="Channel" id="Channel_Channel_delete" class="form-control"  required>
                              <option>Select Email Address</option>
                                <?php 
                                  $res=mysqli_query($link,"select * from users");
                                  while($row=mysqli_fetch_array($res)){
                                              ?>
                                  <option value="<?php echo $row["id"]; ?>"><?php echo $row["email"]; ?></option>
                                  <?php
                                }
                              ?>
                            </select>
                            </div>  

                            <div class="form-group">
                         <label for="exampleInputPassword2">Select group(s)</label>
                              <select name="default_Channel[]" id="default_Channel" class="selectpicker form-control"  multiple required >
                                 <?php 
                                    $res=mysqli_query($link,"select * from enterprise_channel_table");
                                    while($row=mysqli_fetch_array($res)){
                                    ?>
                                  <option value="<?php echo $row["ch_id"]; ?>"><?php echo $row["names"]; ?></option>
                                  <?php
                                }
                                ?>
                              </select>
                          </div>
                            
                              <p></p>
       <center>     
       <a href="../../index.php"><button class="btn btn-danger" style="display:inline-block;">Close</button></a>          
<button class="btn btn-success" id="submit" style="display:inline-block;" onclick="modifyscreen();">Modify</button></center>
  <p></p>  <p></p>

  </div>

    <div class="rows" id="delete" style="display: none;">
              

                        <div class="form-group">
                              <label for="exampleInputPassword2">Select Account *</label>
                             <select name="Channel" id="Channel_Channel_delete1" class="form-control"  required>
                              <option>Select Email Address</option>
                                <?php 
                                  $res=mysqli_query($link,"select * from users");
                                  while($row=mysqli_fetch_array($res)){
                                              ?>
                                  <option value="<?php echo $row["id"]; ?>"><?php echo $row["email"]; ?></option>
                                  <?php
                                }
                              ?>
                            </select>
                            </div>  
                            
                              <p></p>
       <center>     
       <a href="../../index.php"><button class="btn btn-danger" style="display:inline-block;">Close</button></a>          
<button class="btn btn-success" id="submit" style="display:inline-block;" onclick="deletescreen()">Delete</button></center>
  <p></p>  <p></p>

  </div>



</div>
</section>

<center>
<!--   <h3 style="text-align:center;">USER ACCOUNT LIST</h3>
<section class="kitty">

  <div class="container1" style="background: lightgray;">
    <table>

      <thead>

        <tr class="header" style='text-align:center;'>
          <th>
            ID
            <div>ID</div>
          </th>
          <th>
           USER
            <div>USER</div>
          </th>
          <th>
         EMAIL ID
            <div>EMAIL ID</div>
          </th>
          <th>
         SCREENS
            <div>SCREENS</div>
          </th>
          
        </tr>
      </thead>
      <tbody>
	<?php

	if ($link-> connect_error) {
		die("connection failed:".$link-> connect_error);
	}

  $sql = "SELECT b.id, b.user, b.email, a.ch_id FROM users AS b INNER JOIN user_channels as a ON (b.id=a.user_id)";

	$result = $link->query($sql);
	if ($result-> num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			echo "<tr style='padding-left:15px;'><td>". $row["id"] ."</td><td>".$row["user"] ."</td><td>". $row["email"] ."</td><td>". $row["ch_id"]."</td></tr>";

		}
		echo "</table>";
	}
	else {
		echo "<h4 style='color:crimson;'>0 results</h4>";
	}

$link-> close();
	?>
</tbody>
</table>   

</div>
</section> -->
</center>
	<?php else: ?>
		<script type="text/javascript">
			document.getElementsById('propClone').style.display="none";
		</script>
		 <br/><br/><br/><br/><br/><br/><br/>
  <center>
  <div style="height: 20%;">

    <h1 style="color:white;text-align: center;">Please <a href="../../index.php">Login</a> <!-- or <a href="register.php">Register</a> -->
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
<link rel="stylesheet" href="../../css/bootstrap-select.min.css">
<script src="../../js/jquery-.js"></script>
<script src="../../js/bootstrap-select.min.js"></script>
<script src="../../js/bootstrap.min.js"></script>
<script src="../../js/anim.js"></script>


<script type="text/javascript">
  $('#default_Channel').change(function(){
  arrayGlobal=[];
    $('#default_Channel option:selected').each(function(){
       

        arrayGlobal.push($(this).val());

        
    });

    console.log(JSON.stringify(arrayGlobal));
})

   function modifyaccount(){
document.getElementById("modify").style.display="block";
document.getElementById("delete").style.display="none";
}

 function deleteaccount(){
document.getElementById("modify").style.display="none";
document.getElementById("delete").style.display="block";
}

	function deletescreen(){
var ch_id = document.getElementById('Channel_Channel_delete1').value;
  if(ch_id=='Select Email Address' || ch_id=='' || ch_id==null){
      swal({
      title: 'Please select user account..',
      timer: 2000
    });
      return false;
    }
	console.log(ch_id);

swal({
  title: "Are you sure?",
  text: "You want to delete this user account..",
  type: "warning",
  showCancelButton: true,
  confirmButtonClass: "btn-danger",
  confirmButtonText: "Yes, delete ",
  cancelButtonText: "No, cancel ",
  closeOnConfirm: false,
  closeOnCancel: false
},function(isConfirm) {
  if (isConfirm) {
      ajaxindicatorstart("<img src='../../images/ajax-loader.gif'><br/>Update in progress<br/> Please wait...");

      var form_data = new FormData();
      form_data.append('sc_id',ch_id);
      
        $.ajax({
        type: "POST",
        dataType: 'text',
        url: "../Api/modify/deleteuser.php",
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
                title: "Screen",
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

function modifyscreen(){
var ch_id = document.getElementById('Channel_Channel_delete').value;
var default_Channel = document.getElementById('default_Channel').value;
  if(ch_id=='Select Email Address' || ch_id=='' || ch_id==null){
      swal({
      title: 'Please select user account..',
      timer: 2000
    });
      return false;
    }else if(default_Channel=='' || default_Channel==null || default_Channel=='Select Screen'){
      swal("Please Select Screen");
      return false;
    }
  console.log(ch_id);
   console.log(default_Channel);


      ajaxindicatorstart("<img src='../../images/ajax-loader.gif'><br/>Update in progress<br/> Please wait...");

      var form_data = new FormData();
      form_data.append('user_id',ch_id);
     form_data.append('ch_id',JSON.stringify(arrayGlobal));
      
        $.ajax({
        type: "POST",
        dataType: 'text',
        url: "../Api/modify/modifyscreen.php",
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
                title: "Screen",
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