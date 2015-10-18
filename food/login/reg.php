<!DOCTYPE html>
<html>

<head>

  <meta charset="UTF-8">

  <title>Page</title>
  <link rel="stylesheet" type="text/css" href="css/regstyle.css">

    <script src="js/prefixfree.min.js"></script>

</head>

<body>

  <div class="body"></div>
		<div class="grad"></div>
		<div class="header">
			<div>Register for Hit<span>MeUp</span></div>
		</div>
		<br>
		<div class="login">
		<form method="post" action="register.php">
				<input type="text"  id="email" name="email" placeholder="email"><br>
				<input type="password" id="pass" name="pass" placeholder="password"><br>
				<input type="submit" name="submit" value="Register">
		</form>
		</div>
		<div class="wrong"><div><?php echo $_GET["error"]; ?></div></div>


</body>

</html>