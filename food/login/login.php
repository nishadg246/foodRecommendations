<?php
session_start(); // Starting Session
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
if (empty($_POST['email']) || empty($_POST['pass'])) {
header("location: http://nishadg.com/food/login/index.php?error=incorrect%20information");
}
else
{
// Define $username and $password
$username=$_POST['email'];
$password=$_POST['pass'];
if($username==="nishadgothoskar@gmail.com" && $password==="nishad"){
	header("location: http://nishadg.com/food");
}else{
	header("location: http://nishadg.com/food/login/index.php?error=incorrect%20information");
}

}
}
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
 else {
header("location: http://nishadg.com/food/login/index.php?error=incorrect%20information");
}

?>