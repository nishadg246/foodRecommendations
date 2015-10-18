<?php
session_start();
if(!isset($_SESSION['login_user'])){
header("location: index.html");
}
?>

<html>
<body>
<b>
<?php
if(strpos($_SESSION['login_user'],"@andrew.cmu.edu")!= false){
	echo "Carnegie Mellon";
}
elseif(strpos($_SESSION['login_user'],"upenn.edu")!= false){
	echo "UPenn";
} elseif(strpos($_SESSION['login_user'],"harvard")!= false){
	echo "Harvard";
}
?>
</b>
</body>
</html>