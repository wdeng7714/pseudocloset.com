<?php
	session_start();
	include_once "connectdb.php";
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
								<a href = "viewcloset.php">View closet</a>
							</li>
							<li>
								<a href = "planner.php">Planner</a>
							</li>
							<li class = "active">
								<a href = "addclothing.php">
									Add clothing
								</a>
							</li>
							<li>
								<a href = "laundrybasket.php">Laundry basket</a>
							</li>
                            <li>
                            	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            		<i class="fa fa-user" aria-hidden="true"></i>
                             		 <?php echo $_SESSION['username'];?>
                             		<span class="caret"></span>
                             	</a>
								<ul class="dropdown-menu">
									<li>
										<a href="logout.php">
											<span class = "glyphicon glyphicon-log-out"></span>
											 Logout
										</a>
									</li>
								</ul>
                            </li>
						<?php } else { ?>
							<li>
								<a href = "register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a>
							</li>
							<li>
								<a href = "login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</nav>
		
		<?php
			if (isset($_SESSION['userid'])){ ?>

			<div class = "container">
				<div class = "row">
					<div class = "col-md-12">
						<h2 class = "text-center">
							Welcome to <?php echo $_SESSION['username'];?>'s PseudoCloset
						</h2>
					</div>
				</div>
				<div class = "row">
					<div class = "col-md-8 well">
						<h3 class = "text-center"> Alerts </h3>
						<?php 
							$query = "SELECT * FROM clothing WHERE userid = " . $_SESSION["userid"];
							$result = mysqli_query($con, $query);
							while($row = mysqli_fetch_array($result)){
								if ($row['timesworn']>=1){
									echo "<div> <p>". $row["name"]. " has been worn ". $row["timesworn"] . " times, it's time for a wash! " . $row["name"] ." has been placed in your laundry basket. </p> </div>";	
								}
							}
						?> 
						
					</div>
					<div class = "col-md-4">
						<ul>
							<a href = "viewcloset.php" class = "btn btn-default btn-block">View Closet</a>
							<a href = "planner.php" class = "btn btn-default btn-block">Planner</a>
							<a class = "btn btn-default btn-block" href = "addclothing.php">Add Clothing
							</a>
							<a href = "laundrybasket.php" class = "btn btn-default btn-block">Laundry Basket
							</a>
						</ul>
					</div>
				</div> 
			</div>

		<?php }else{?>
			<div class = "jumbotron">
				<div class = "container">
					<h1>Welcome to PseudoCloset</h1>
					<p>
						You ever had that moment when you stare blankly into your cloest and can't figure out what to wear? Well worry no more because you have found just the right place for all your problems...
					</p>
					<button class = "btn btn-primary">
						Learn more &raquo
					</button>
				</div>
			</div>

			<footer class="footer">
				<div class="container">
					<p class="text-muted text-center">&copy; Copyright Angela Chang and Wendy Deng 2016, All Rights Reserved</p>
				</div>
			</footer>
		<?php }?>
		<script src = "vendor/jquery/jquery-3.1.0.min.js"></script>
		<script src = "vendor/bootstrap/js/bootstrap.min.js"></script>
	</body> 
</html>