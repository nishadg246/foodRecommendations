<?php
session_start(); // Starting Session
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
if (empty($_POST['email']) || empty($_POST['pass'])) {
header("location: http://nishadg.com/hitmeup/reg.php?error=invalid%20information");
}
else
{
// Define $username and $password
$username=$_POST['email'];
$password=$_POST['pass'];
$result = filter_var($username, FILTER_VALIDATE_EMAIL );
if (!$result){
	header("location: http://nishadg.com/hitmeup/reg.php?error=invalid%20email");
}
else{
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
$connection = mysql_connect("localhost", "thehowt3_hitmeup", "soccer96");
// To protect MySQL injection for Security purpose
$username = stripslashes($username);
$password = stripslashes($password);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);
// Selecting Database
$db = mysql_select_db("thehowt3_hitmeup", $connection);
// SQL query to fetch information of registerd users and finds user match.
$query2 = mysql_query("select * from hitmeup where email='$username'", $connection);
$rows = mysql_num_rows($query2);
if ($rows == 0) {
	$query = mysql_query("INSERT INTO hitmeup (email, pass, school, other) VALUES ('$username','$password','none', 0)", $connection);
	header("location: http://nishadg.com/hitmeup/index.php?error=account%20created");

} 
else {
	header("location: http://nishadg.com/hitmeup/reg.php?error=email%20used");

}
mysql_close($connection); // Closing Connection
}
}
}
?>