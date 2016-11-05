<?php
	session_start();
	if(!isset($_SESSION['userid'])){
		header("Location: index.php");
	}
	include_once "connectdb.php";

	$error = false;
	$item_counter = 0;
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
							<li>
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
<!--- add outfit form -->
		<div class = "container">
			<div class ="row">
				<div class ="col-md-6 col-md-offset-3 well">
					<form role = "form" action = "<?php echo $_SERVER['PHP_SELF']; ?>" method ="post" name = "addoutfitform">
						<fieldset>
							<legend>
								<span class ="glyphicon glyphicon-plus">
								</span>
								Add Outfit
							</legend>
							<div class ="form-group">
								<label for = "name">Name of outfit </label>
								<input type ="text" name = "name" placeholder = "Blue Plaid" required value = "<?php if($error) echo $name; ?>" class = "form-control"?>
								<span class = "text-danger"> <?php if(isset($name_error)) echo $name_error; ?>
								</span>
							</div>
							<?php for ($i = 0; $i < 2; $i++){ ?>
							<div class = "form-group">
								<label for =<?php echo '"item'. $item_counter . '">Item ' . ($item_counter + 1); ?>
								 </label>

								<select name =<?php echo '"item'. $item_counter . '"'; ?> class = "form-control">					
									<optgroup label = "Tops">
										<?php
											$query = "SELECT * FROM clothing WHERE userid = ". $_SESSION["userid"] . " AND (type = 'sweater' OR type = 'shirt' OR type ='jacket')";
											echo $query;
											$result = mysqli_query($con, $query);
											while($row = mysqli_fetch_array($result)){
												echo "<option>" . $row["name"] . "</option>";
											}
										?>
									</optgroup>
									<optgroup label = "Bottoms">
										<?php
											$query = "SELECT * FROM clothing WHERE userid = ". $_SESSION["userid"] . " AND type = 'pants'";
											echo $query;
											$result = mysqli_query($con, $query);
											while($row = mysqli_fetch_array($result)){
												echo "<option>" . $row["name"] . "</option>";
											}
										?>
									</optgroup>
									<optgroup label = "Misc">
										<?php
											$query = "SELECT * FROM clothing WHERE userid = ". $_SESSION["userid"] . " AND (type = 'socks' OR type ='underwear' OR type ='accessory')";
											echo $query;
											$result = mysqli_query($con, $query);
											while($row = mysqli_fetch_array($result)){
												echo "<option>" . $row["name"] . "</option>";
											}
										?>
									</optgroup>					
								</select>
								<?php $item_counter++ ?>
							</div>
							<?php }?>
							<div class = "form-group">
							<div class ="btn btn-success"> Add another item </div>

							</div>
							<div class ="btn btn-default">
								Submit outfit
							</div>
							<div class ="btn btn-default pull-right">
								Discard outfit
							</div>
							
						</fieldset>
				</div>
			</div>
		</div>
		<script src = "vendor/jquery/jquery-3.1.0.min.js"></script>
		<script src = "vendor/bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>