<?php
$server = 'localhost';
$username = 'root';
$password = 'adskite';
$database = 'smweb';

try{
	$conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch(PDOException $e){
	die( "Connection failed: " . $e->getMessage());
}
$email="krishna@adskite.com";
// $sql = 'SELECT email FROM users where email=$email';
//     foreach ($conn->query($sql) as $row) {
//         print $row['email'] . "\n";
       
//     }

$stmt = $conn->prepare('SELECT * FROM users WHERE email=?');
$stmt->bindParam(1, $email, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// if( ! $row)
// {
//     echo 'nothing found';
// }else{
// 	  echo 'found';
// }
?>

