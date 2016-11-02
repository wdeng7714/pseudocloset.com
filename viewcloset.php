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
		<title> View Closet | PseudoCloset </title>
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
			<div class ="row" >
				<div class = "col-md-12">
					<h2 class = "text-center">Closet View </h2>
				</div>
				<div class = "col-md-12">
					<div class = "btn-group btn-group-justified">
						<a href ="#" class= "btn btn-default"> All </a>
						<a href ="#" class= "btn btn-default"> Outfits </a>
						<a href ="#" class= "btn btn-default"> Tops </a>
						<a href ="#" class= "btn btn-default"> Bottoms </a>
						<a href ="#" class= "btn btn-default"> Misc </a>
						<a href ="#" class= "btn btn-default"> New </a>
					</div>
				</div>
				<?php 
					$query = "SELECT * FROM clothing WHERE userid = " . $_SESSION["userid"];
					$result = mysqli_query($con, $query);
					$display=0;
					while ($row = mysqli_fetch_array($result) and $display<20){
						$display++;
						echo '<div class = "col-sm-2"><img src="' . $row["url"] . '" class="img-rounded" width = "150" height = "150" ></div>';

					}?>
			</div>
		</div>
	</body>
</html>