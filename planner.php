<?php
	session_start();
	include_once "connectdb.php";
	if (!isset($_SESSION['userid'])){
		header("Location: index.php");
	}

	if( isset($_GET['outfitselectionid'])){
		$query = 'SELECT * FROM outfits WHERE userid = ' . $_SESSION['userid'] . ' AND id = ' . $_GET['outfitselectionid'];
		$result = mysqli_query($con, $query);
		if($result){
			$row = mysqli_fetch_array($result);

			$query = "INSERT INTO plans (userid, name, outfitid, parts, numparts, date) values (" . $_SESSION['userid'] . ', "' . $row['name'].'", "' . $row['id'] . '","' . $row['parts'] . '","' . $row['numparts'] . '",CURDATE())' ;
			if(mysqli_query($con, $query)){
				header("Location: planner.php");
				$successmsg = "Your outfit was successfully updated";
			}
			else{
				$errormsg = "Error Please try again later";
			}

		}else{
			$errormsg = "Error. Please try again later.";
		}
	}
	if( isset($_GET['outfitparts'])){
		$query = "INSERT INTO plans (userid, name, outfitid, parts, numparts, date) values (" . $_SESSION['userid'] . ', "unnamed", -1, "'.$_GET['outfitparts'] . '","' . $_GET['outfitnumparts'] .'", CURDATE())';

		if(mysqli_query($con, $query)){
			header("Location: planner.php");
			$successmsg = "Your outfit was successfully updated";
		}
		else{
			$errormsg = "Error Please try again later";
		}
	}


	$outfitquery = "SELECT * FROM outfits WHERE userid =". $_SESSION['userid'];
	$outfitresult = mysqli_query($con, $outfitquery);
    $clothingquery = "SELECT * FROM clothing WHERE userid = ". $_SESSION['userid'];
    $clothingresult =mysqli_query($con, $clothingquery);
    $display=0;
    $max_per_page=20;

    $plansquery = "SELECT * FROM plans WHERE userid = " . $_SESSION['userid'];
    $plansresult = mysqli_query($con, $plansquery);

    $todayquery = "SELECT * FROM plans WHERE userid = " . $_SESSION['userid'] . " AND date = CURDATE()";
    $todayresult = mysqli_query($con, $todayquery);

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Planner | PseudoCloset</title>
		<meta content = "width = device.width , initial-scale = 1.0" name = "viewport">
		<link rel = "stylesheet" href = "vendor/font-awesome/css/font-awesome.min.css"/>
		<link rel = "stylesheet" href = "vendor/bootstrap/css/bootstrap.min.css" type="text/css"/>
		<link rel = "stylesheet" href = "vendor/owl-carousel/css/owl.carousel.css" type="text/css"/>
		<link rel = "stylesheet" href = "vendor/owl-carousel/css/owl.theme.css" type="text/css"/>
		<link rel = "stylesheet" href = "vendor/owl-carousel/css/owl.transitions.css" type="text/css"/>
		<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet"/> 
		<link rel = "stylesheet" href = "css/main.css" type = "text/css"/>

		<script src = "vendor/jquery/jquery-2.1.1.min.js"></script>
		<script src = "vendor/bootstrap/js/bootstrap.min.js"></script>
       	<script src = "vendor/owl-carousel/js/owl.carousel.min.js"></script>
       	<script src = "js/main.js"></script>
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


		<div class = "container <?php if(mysqli_num_rows($todayresult) > 0) echo "item-hide";?>" >
			<div class = "row">
				<div class = "col-md-12">
					<h2 class = "page-header text-center"> Outfit planner </h2>
				</div>
				<div class = "col-md-8 col-md-offset-2 ">
					<div class = "panel panel-info" role = "form"  name = "outfittodayform">
						<div class ="panel-heading">
							Today's Outfit
						</div>
						<div class ="panel-body">
							<div class = "form-group">
								<label for = "inputchoice">What did you wear today?</label>
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
							<span class = "text-danger"><?php if(isset($errormsg)) echo $errormsg; ?> </span>
							<div class="collapse collapsible">
							<div class ="owl-carousel col-md-12 ">		
								<?php
									while($row = mysqli_fetch_array($clothingresult)){
										$display++;

										echo '<div class = "item planner-item"><a class = "thumbnail" color ="' . $row['color'] .'" timesworn="' . $row['timesworn'] . '" name = "' . $row['name'] . '" url = "' . $row['url'] .'" lastworn = "' . $row['lastworn'] . '" type = "'.$row['type'].'" id = "'. $row['id'] .'"><p>' . $row['name'] . '<span class = "pull-right"><i class="icon-check-empty" id = "checkbox' .$row['id'] . '"></i></span></p><img src="' . $row["url"] . '"></a></div>';
									}
								?>
								
							</div>
							</div>
						</div>		
						<div class = "panel-footer clearfix"> 
						<span class = "text-danger" id="outfit-selection-error"></span>
						<a type = "submit" id = "today-button" class = "btn btn-primary pull-right" >Submit</a>
						<script>
							$('#today-button').click(function(){
								if($('[name = "radio-outfit"]:checked').val() === "yes"){
									if($('#outfit-selection').val() === null){
										$('#outfit-selection-error').text("Please select an outfit");
									}
									else{
										var outfitid = $('#outfit-selection').val();
										window.location.href = "planner.php?outfitselectionid=" + outfitid;
									}
								}else{
									var parts = "";
									var counter = 0;

									$('.icon-check').each(function(){
										counter++;
										parts += ($(this).attr("id")).substring(8) + " "; 
									})
									if(counter===0){
										$('#outfit-selection-error').text("Please select at least 1 article of clothing");
									}
									else if(counter > 10){
										$('#outfit-selection-error').text("Please only select up to 10 items at once");
									}
									else{
										window.location.href = "planner.php?outfitparts=" + parts + "&outfitnumparts=" + counter;
									}
								}
							})
						</script>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			$('.owl-carousel').owlCarousel({
				loop: true,
				items: 3
			});
		</script>
	</body>
</html>