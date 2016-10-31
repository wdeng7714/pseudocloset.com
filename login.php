<?php
	session_start();

	// if there is already a session
	if(isset($_SESSION['userid'])!=""){
		header("Location: index.php");
	}

	include_once "connectdb.php";

	// check if form is submitted
	if(isset($_POST['login'])){
		$username = mysqli_real_escape_string($con, $_POST['username']);
		$password = mysqli_real_escape_string($con, $_POST['password']);

		$query = "SELECT * FROM users WHERE username = '" . $username . "'";
		$result = mysqli_query($con, $query);

		if($row = mysqli_fetch_array($result)){
			if($row['password'] == md5($password)){
				$_SESSION['userid'] = $row['id'];
				$_SESSION['username'] = $row['username'];
				header("Location: index.php");
			}
			else{
				$errormsg = "Username and password do not match.";
			}
		}
		else{
			$errormsg = "Username does not exist.";
		}
	}
?>

<!DOCTYPE html>

<html>
	<head>
		<title>Login | PseudoCloset</title>
		<meta content = "width = device.width, initial-scale = 1.0" name = "viewport">
		<link href = "https://fonts.googleapis.com/css?family=Ubuntu" rel = "stylesheet">
		<link rel = "stylesheet" href = "vendor/bootstrap/css/bootstrap.min.css" type = "text/css"/>
	</head>
	
	<body>
		<nav role = "navigation" class = "navbar navbar-default">
			<div class = "container-fluid">
				<!-- header -->
				<div class = "navbar-header">
					<button type = "button" class = "navbar-toggle" data-toggle = "collapse" data-target = "#navbar">
						<span class = "sr-only">Toggle navigation</span>
						<span class = "icon-bar"></span>
						<span class = "icon-bar"></span>
						<span class = "icon-bar"></span>	
					</button>
					<a class = "navbar-brand" href = "../index.php">PseudoCloset</a>
				</div>

				<!-- menu items -->
				<div class = "collapse navbar-collapse" id = "navbar">
					<ul class = "nav navbar-nav navbar-right">
						<li class = "active"><a href = "login.php">Login</a></li>
						<li><a href = "register.php">Sign Up</a></li>
					</ul>
				</div>
			</div>
		</nav>

		<div class = "container">
			<div class = "row">
				<div class = "col-md-4 col-md-offset-4 well">
					<form role = "form" action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "post" name = "loginform">
						<field>
							<legend>Login</legend>
							<div class = "form-group">
								<label for = "username">Username</label>
								<input type = "text" name = "username" placeholder = "johnsmith" required class = "form-control"/>
							</div>
							<div class = "form-group">
								<label for = "password">Password</label>
								<input type = "password" name = "password" placeholder = "Password" required class = "form-control"/>
							</div>
							<div class = "form-group">
								<button type = "submit" name = "login" class = "btn btn-primary">Login
								</button>
							</div>
						</field>
					</form>
					<span class = "text-danger"><?php if(isset($errormsg)) echo $errormsg; ?></span>
				</div>
			</div>

			<div class = "row">
				<div class = "col-md-4 col-md-offset-4 text-center">
					New user? <a href = "register.php">Register here</a>
				</div>
			</div>
		</div>
		<script src = "vendor/jquery/jquery-3.1.0.min.js"></script>
		<script src = "vendor/bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>