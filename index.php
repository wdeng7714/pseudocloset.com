<?php
	session_start();
	include_once "connectdb.php";
	if (!isset($_SESSION['userid'])){
		header("Location: register.php");
	}
?>

<!DOCTYPE html>

<html>
	<head>
		<title>Home | PseudoCloset</title>
		<meta content = "width = device.width , initial-scale = 1.0" name = "viewport">
		<link rel = "stylesheet" href = "vendor/font-awesome/css/font-awesome.min.css"/>
		<link rel = "stylesheet" href = "vendor/bootstrap/css/bootstrap.min.css" type="text/css"/>
		<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet"/> 
		<link rel = "stylesheet" href = "css/main.css" type = "text/css"/>
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
						PseudoCloset
					</a>
				</div>

				<div class = "collapse navbar-collapse" id = "navbar">
					<ul class = "nav navbar-nav navbar-right">
						<?php if(isset($_SESSION['userid'])){?>
							<li>
								<p class = "navbar-text">
									Signed in as <?php echo $_SESSION['username'];?>
								</p>
							</li>
							<li>
								<a href = "logout.php">Logout</a>
							</li>
						<?php } else { ?>
							<li>
								<a href = "login.php">Login</a>
							</li>
							<li>
								<a href = "register.php">Sign Up</a>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</nav>
		
		<div class = "container">
			<div class = "row">
				<div class = "col-md-12">
					<h2 class = "text-center">
						Welcome to <?php echo $_SESSION['username'];?>'s PseudoCloset
					</h2>
				</div>
			</div>
		</div>
		<script src = "vendor/jquery/jquery-3.1.0.min.js"></script>
		<script src = "vendor/bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>