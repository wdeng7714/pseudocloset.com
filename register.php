<?php
	session_start();

	if(isset($_SESSION["userid"])){
		header("Location: index.php");
	}

	include_once "connectdb.php";
?>
<!DOCTYPE html>

<html>
	<head>
		<title> Register | PseudoCloset</title>
		<meta content = "width = device-width, initial-scale = 1.0" name ="viewport">
		<link rel ="stylesheet" type ="text/css" href = "vendor/bootstrap/css/bootstrap.min.css"/>
	</head>
	<body>
		<nav class = "navbar navbar-default" role = "navigation">
			<div class ="container-fluid">
				<div class ="navbar-header">
					<button type ="button" class = "navbar-toggle" data-toggle ="collapse" data-target ="#navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href ="index.php">PseudoCloset</a>
				</div>
				<div class ="collapse navbar-collapse" id ="navbar">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="login.php">Login</a></li>
					<li class="active"> <a href="register.php">Sign up</a></li>
				</ul>
			</div>
			</div>
		</nav>
		<script src = "vendor/jquery/jquery-3.1.0.min.js"></script>
		<script src ="vendor/bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>