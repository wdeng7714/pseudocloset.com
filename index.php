<?php
session_start();
include_once "connectdb.php";
if (session_status() !== PHP_SESSION_ACTIVE){
	header("Location: register.php");
}
?>

<html>
	<head>
		<title>PseudoCloset</title>
		<link rel = "stylesheet" href = "vendor/bootstrap/css/bootstrap.min.css" type="text/css"/>
</head>
<body>
	<nav class = "navbar navbar-default" role = "navigation">
		<div class = "container-fluid">
			<div class= " navbar-header">
				<button type = "button" class = "navbar-toggle" data-toggle ="collapse" data-target = "#navbar">
					<span class ="sr-only"> Toggle navigation </span>
					<span class ="icon-bar"></span>
					<span class = "icon-bar"></span>
					<span class = "icon-bar"></span>
				</button>
				<a class = "navbar-brand" href= "index.php">
					PseudoCloset </a>
				</div>

				<div class = "collapse navbar-collapse" id = "navbar">
					<ul class = "nav navbar-nav navbar-right">
						<li><a href = "login.php">Login</a></li>
						<li><a href = "register.php">Sign Up</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<div class = "text-center">Welcome to <?php echo $_SESSION['username'];?>'s PseudoCloset 
		</div>
		
		<script src = "vendor/jquery/jquery-3.1.0.min.js"></script>
		<script src = "vendor/bootstrap/js/bootstrap.min.js"></script>
	</body>
	</html>