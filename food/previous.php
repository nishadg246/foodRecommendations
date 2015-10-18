
<?php

// $restaurant = "'".$_POST['arg1']."'";
// $like = $_POST['arg2'];
// $connection = mysqli_connect("us-cdbr-azure-east2-d.cloudapp.net", "ba2928c9e0cc3a", "08b53d25", "spacepenguins");
// if (mysqli_connect_errno()) {
// printf("Connect failed: %s\n", mysqli_connect_error());
// exit();
// }
//$result = mysqli_query($connection, "CALL add_prev('nishadgothoskar@gmail.com', $restaurant, $like)");
$servername = "us-cdbr-azure-east2-d.cloudapp.net";
$username = "ba2928c9e0cc3a";
$password = "08b53d25";
$dbname = "spacepenguins";

$res = $_POST['arg1'];
$tp = $_POST['arg3'];
$rating = $_POST['arg2'];
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "INSERT INTO Restaurants (res, rating,foodtype)
VALUES ('$res', $rating, '$tp')";

if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
 ?>
