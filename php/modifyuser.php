<?php

require '..\database.php';

$link=mysqli_connect($server,$username,$password);
mysqli_select_db($link,$database);
// $user=$_POST['name'];
// $email=$_POST['email'];
$user_id=$_POST['sc_id'];
$default_Channel = json_decode($_REQUEST['default_Channel'],true);

// $stmt = $conn->prepare('SELECT * FROM users WHERE email=?');
// $stmt->bindParam(1, $email, PDO::PARAM_INT);
// $stmt->execute();
// $row = $stmt->fetch(PDO::FETCH_ASSOC);

// if($row>0)
// {
//  echo json_encode(array('statusCode'=>3,'status'=>'user account exists'));
// }else{
try
{

	   // begin the transaction
	 // Set autocommit to off
	mysqli_autocommit($link,FALSE);

	  $isCommit = true;
		
		// $sql = "INSERT INTO users (user, email, password)
		//        VALUES ('".$user."', '".$email."', '".password_hash($_POST['password'], PASSWORD_BCRYPT)."')";

   // if ($link->query($sql) === TRUE)
   // {
  	    // $user_id = $link->insert_id;

          // $user_id = 1;
  	     $userChannelArray = array();

  	    foreach ($default_Channel as $value) {

  	    	$insertValue = "('".$user_id."', '".$value."')";

  	    	array_push($userChannelArray, $insertValue);
            $insertValue = "";
  	    	
  	    }
        
  	    $sql = "INSERT INTO user_channels (user_id, ch_id) VALUES ".implode(",", $userChannelArray);

          if($link->query($sql) == TRUE)
          {
          	
          }else{
          	$isCommit = FALSE;
          } 
			


         if($isCommit)
              {
              	mysqli_commit($link);
              
                echo json_encode(array('statusCode'=>0,'status'=>'Successfully created new user'));
              }else
              {
              	 mysqli_rollback($link);
                echo json_encode(array('statusCode'=>1,'status'=>'Sorry there must have been an issue creating your account'));
              }
}catch(Exception $e)
 {
                 // roll back the transaction if something failed
                mysqli_rollback($link);
                $status =  "Sorry there must have been an issue creating your account " . $e->getMessage();
                echo json_encode(array('statusCode'=>2,'status'=>$status));
 }









// if( isset($_SESSION['user_id']) ){
// 	header("Location: home.php");
// }


//$message = '';

//if(!empty($_POST['email']) && !empty($_POST['password'])):

// $user=$_POST['name'];
// $email=$_POST['email'];
// $stmt = $conn->prepare('SELECT * FROM users WHERE email=?');
// $stmt->bindParam(1, $email, PDO::PARAM_INT);
// $stmt->execute();
// $row = $stmt->fetch(PDO::FETCH_ASSOC);

/*if( ! $row)
{
    // Enter the new user in the database
	/*$sql = "INSERT INTO users (user, email, password) VALUES (:user, :email, :password)";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':user', $_POST['name']);
	$stmt->bindParam(':email', $_POST['email']);
	$stmt->bindParam(':password', password_hash($_POST['password'], PASSWORD_BCRYPT));

	if( $stmt->execute() ):
		$last_id = $conn->insert_id;
		$message = 'Successfully created new user';
	else:
		$message = 'Sorry there must have been an issue creating your account';
	endif;  */

	/*$sql = "INSERT INTO users (user, email, password)
       VALUES ('".$user."', '".$email."', '".password_hash($_POST['password'], PASSWORD_BCRYPT)."')";

   if ($link->query($sql) === TRUE)
   {
  	    $user_id = $link->insert_id;
  	    foreach ($_POST["default_Channel"] as $select)
		{
		$sql = "INSERT INTO user_channels (user_id, ch_id)
       VALUES ('".$user_id."', '".$select."')";
		}
		
       if ($link->query($sql) === TRUE)
       {
       	$message = 'Successfully created new user-'.$select;
       }else{
       	$message = 'Sorry there must have been an issue creating your account - '.$link->error;
       }
	}else
	{
		$message = 'Sorry there must have been an issue creating your account - '.$link->error;
	}

}else{
	  $message = 'Sorry user id already exist';
}

	
	
endif;*/

?>



	