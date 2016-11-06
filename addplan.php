<?php
	session_start();
	include_once "connectdb.php";
	if (!isset($_SESSION['userid'])){
		header("Location: index.php");
	}
	$clothingquery = "SELECT * FROM clothing WHERE userid = ". $_SESSION['userid'];
	$clothingresult =mysqli_query($con, $clothingquery);
	$outfitquery = "SELECT * FROM outfits WHERE userid = ". $_SESSION['userid'];
	$outfitresult = mysqli_query($con, $outfitquery);

	if( isset($_GET['outfitselectionid'])){
		$query = 'SELECT * FROM outfits WHERE userid = ' . $_SESSION['userid'] . ' AND id = ' . $_GET['outfitselectionid'];
		$result = mysqli_query($con, $query);

		if($result){
			$row = mysqli_fetch_array($result);

			$query = "INSERT INTO plans (userid, name, outfitid, parts, numparts, date) values (" . $_SESSION['userid'] . ', "' . $row['name'].'", "' . $row['id'] . '","' . $row['parts'] . '","' . $row['numparts'] . '","'. $_GET['date'].'")' ;
			if(mysqli_query($con, $query)){

				$successmsg = "Plan successfully added. <a href = 'planner.php'>Click here to view planner</a>";
			}else{
				$errormsg = "Plan was not successfully added. Please try again later";
			}
		}else{
			$errormsg = "Plan was not successfully added. Please try again later";
		}
	}
	if( isset($_GET['outfitparts'])){
		$query = "INSERT INTO plans (userid, name, outfitid, parts, numparts, date) values (" . $_SESSION['userid'] . ', "unnamed", -1, "'.$_GET['outfitparts'] . '","' . $_GET['outfitnumparts'] .'", CURDATE())';

		if(mysqli_query($con, $query)){
			$successmsg = "Plan successfully added. <a href = 'planner.php'>Click here to view planner</a>";
		}
		else{
			$errormsg = "Plan was not successfully added. Please try again later";
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title> Add Plan | PseudoCloset </title>
		<meta content = "width = device.width , initial-scale = 1.0" name = "viewport">
		<link rel = "stylesheet" href = "vendor/font-awesome/css/font-awesome.min.css"/>
		<link rel = "stylesheet" href = "vendor/bootstrap/css/bootstrap.min.css" type="text/css"/>
		<link rel = "stylesheet" href = "vendor/owl-carousel/css/owl.carousel.css" type="text/css"/>
		<link rel = "stylesheet" href = "vendor/owl-carousel/css/owl.theme.css" type="text/css"/>
		<link rel = "stylesheet" href = "vendor/owl-carousel/css/owl.transitions.css" type="text/css"/>
		<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet"/> 
		<link rel = "stylesheet" href = "css/main.css" type = "text/css"/>
		<link rel = "stylesheet" href = "vendor/datepicker/datepicker.css"/>

		<script src = "vendor/jquery/jquery-2.1.1.min.js"></script>
        <script src = "vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src = "vendor/owl-carousel/js/owl.carousel.min.js"></script>
        <script src = "js/main.js"></script>
        <script src = "vendor/datepicker/locales.js"></script>
        <script src = "vendor/datepicker/datepicker.js"></script>
        <script src = "vendor/jscolor/jscolor.js"></script>
        
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
						<?php if(isset($_SESSION['userid'])) { ?>
							<li>
								<a href = "viewcloset.php">View closet</a>
							</li>
							<li>
								<a href = "planner.php">Planner</a>
							</li>
							<li>
								<a href = "laundrybasket.php">Laundry basket</a>
							</li>
							<li class = "active">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                             		 <i class = "icon-plus"></i> Add
                             		<span class="caret"></span>
                             	</a>
								<ul class="dropdown-menu">
									<li>
										<a href="addclothing.php">
											 Add clothing
										</a>
										<a href="addoutfit.php">
											 Add outfit
										</a>
										<a href="addplan.php">
											 Add plan
										</a>
									</li>
								</ul>
							</li>
                            <li>
                            	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            		<i class="icon-user" aria-hidden="true"></i>
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
		<div class = "container">
			<div class = "row">
				<div class ="col-md-8 col-md-offset-2 well">
					<legend>
						 <span class="glyphicon glyphicon-plus"></span>
                        Add plan
					</legend>
					<div class = "form-group">
						<label for = "datechoice">Choose a date</label>
						<div class = "input-group date" id = 'datepicker'>
							<input type = "text" class = "form-control" requrired placeholder = "YYYY-MM-DD" name = "datechoice"/>
							<span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar">
                                </span>
                            </span>
                        </div>
					</div>
					<div class = "form-group">
						<label for = "inputchoice">From outfits or from scratch?</label>
						<div class = "row">
							<div class = "col-sm-6">
								<div class = "input-group" name = "inputchoice">
									<span class = "input-group-addon" ><input type = "radio" name = "radio-outfit" value = "yes" aria-label ="radiobutton for outfit" checked>
									</span> 
									<select id = "outfit-selection" class = "form-control" > 

										<option value = "" disabled selected hidden>Choose an outfit</option>

										<?php 
										while($row = mysqli_fetch_array($outfitresult)){
											echo "<option value = '". $row['id'] . "'>" . $row['name'] . "</option>";
										}
										?>
									</select>
								</div>
							</div>
							<div class = "col-sm-6">
								<div class = "input-group" name = "inputchoice">
									<span class = "input-group-addon"><input type = "radio" name = "radio-outfit" value = "no" aria-label ="radiobutton for outfit">
									</span> 
									<div class ="form-control">No Outfit</div>
								</div>
							</div>
						</div>
					</div>
					<div class = "collapse collapsible form-group">
						<div class ="owl-carousel col-md-12 ">
							<?php
								while($row = mysqli_fetch_array($clothingresult)){
									$display++;

									echo '<div class = "item planner-item"><a class = "thumbnail" color ="' . $row['color'] .'" timesworn="' . $row['timesworn'] . '" name = "' . $row['name'] . '" url = "' . $row['url'] .'" lastworn = "' . $row['lastworn'] . '" type = "'.$row['type'].'" id = "'. $row['id'] .'"><p>' . $row['name'] . '<span class = "pull-right"><i class="icon-check-empty" id = "checkbox' .$row['id'] . '"></i></span></p><img src="' . $row["url"] . '"></a></div>';
								}
							?>
						</div>
					</div>
					<div class = "form-group">
						<button type = "submit" id = "addplan" class = "btn btn-primary">
							Submit plan
						</button>
                        <a type = "button" href = "planner.php" class ="btn btn-default pull-right">
                            Discard plan
                        </a>
					</div>
					<span id = "outfit-selection-error" class = "text-danger"></span>
					<span class = "text-danger"><?php if(isset($errormsg)) echo $errormsg;?> </span>
					<span class = "text-success" id = "successful"><?php if(isset($successmsg)) echo $successmsg;?> </span>
				</div>
			</div>
		</div>
		<script>
			$('.owl-carousel').owlCarousel({
				loop: true,
				items: 3
			});
		</script>
		<script type = "text/javascript">
        	$('#datepicker').datetimepicker({
				format: 'YYYY-MM-DD'
    		});
    	</script>
	</body>
</html>