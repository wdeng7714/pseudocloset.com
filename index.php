<?php
	session_start();
	include_once "connectdb.php";

	if(isset($_SESSION['userid'])){
		include_once "updateclothes.php";
	}

	if( isset($_GET['outfitselectionid'])){
		$query = 'SELECT * FROM outfits WHERE userid = ' . $_SESSION['userid'] . ' AND id = ' . $_GET['outfitselectionid'];
		$result = mysqli_query($con, $query);
		if($result){
			$row = mysqli_fetch_array($result);

			$query = "INSERT INTO plans (userid, name, outfitid, parts, numparts, date) values (" . $_SESSION['userid'] . ', "' . $row['name'].'", "' . $row['id'] . '","' . $row['parts'] . '","' . $row['numparts'] . '",CURDATE())' ;
			if(mysqli_query($con, $query)){
				header("Location: index.php");
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
			header("Location: index.php");
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

	$plansquery = "SELECT * FROM plans WHERE userid = " . $_SESSION['userid'] . " ORDER BY date" ;
	$plansresult = mysqli_query($con, $plansquery);

	$todayquery = "SELECT * FROM plans WHERE userid = " . $_SESSION['userid'] . " AND date = CURDATE()";
	$todayresult = mysqli_query($con, $todayquery);

?>

<!DOCTYPE html>

<html>
	<head>
		<title> Home | PseudoCloset </title>
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
						<?php if(isset($_SESSION['userid'])){?>
							<li>
								<a href = "viewcloset.php">View closet</a>
							</li>
							<li>
								<a href = "planner.php">Planner</a>
							</li>
							<li>
								<a href = "laundrybasket.php">Laundry basket</a>
							</li>
							<li>
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
								<a href = "register.php"><span class="glyphicon glyphicon-user"></span> Sign up</a>
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
						<h2 class = "text-center page-header">
							Welcome to <?php echo $_SESSION['username'];?>'s PseudoCloset
						</h2>
					</div>
				</div>
				<div class = "row">
				<?php //START HERE
					if(mysqli_num_rows($todayresult) > 0){
						while ($plans_row = mysqli_fetch_array($todayresult)){
						?>
						<div class = "col-md-8">
							<div class = "panel panel-info">
								<div class ="panel-heading clearfix">
									Today's Outfit
								</div>
								<div class ="panel-body">
									<div class = "owl-carousel col-md-12">											
										<?php
											$parts = explode(" ", $plans_row['parts']);
											for($i = 0; $i < $plans_row['numparts']; $i++){

												$query = "SELECT * FROM clothing WHERE id=" . $parts[$i];
												$result = mysqli_query($con, $query);
												if($result){
													$row = mysqli_fetch_array($result);
													echo '<div class = "item"><a href = "#item-modal" data-toggle = "modal" class = "thumbnail" color ="' . $row['color'] .'" timesworn="' . $row['timesworn'] . '" name = "' . $row['name'] . '" url = "' . $row['url'] .'" lastworn = "' . $row['lastworn'] . '" type = "'.$row['type'].'" id = "'. $row['id'] .'"><p>' . $row['name'] . '</p><img src="' . $row["url"] . '"></a></div>';
												}
											}
										?>
									</div>
								</div>
							</div>
						</div>

				<?php }
				} else { ?>
					<div class = "col-md-8">
						<div class = "panel panel-info">
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
								<span class = "text-danger"><?php if(isset($errormsg)) echo $errormsg; ?></span>
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
							<a type = "submit" id = "today-button" class = "btn btn-primary pull-right" >Submit plan</a>
							
							</div>
						</div>
					</div>
				<?php } ?>

					<div class = "col-md-4">
						<ul>
							<a href = "viewcloset.php" class = "btn btn-default btn-block">View closet</a>
							<a href = "planner.php" class = "btn btn-default btn-block">Planner</a>
							<a href = "laundrybasket.php" class = "btn btn-default btn-block">Laundry basket
							</a>
							<a class = "btn btn-default btn-block" href = "addclothing.php">Add clothing
							</a>
						</ul>
					</div>

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
				</div> 
			</div>

		<?php }else{?>
			<div class = "jumbotron">
				<div class = "container">
					<h1>Welcome to PseudoCloset</h1>
					<p>
						You ever had that moment when you stare blankly into your closet and can't figure out what to wear? Well worry no more because you have found just the right place for all your problems...
					</p>
					<button class = "btn btn-primary">
						Learn more &raquo
					</button>
				</div>
			</div>

			<footer class="footer">
				<div class="container">
					<p class="text-muted text-center">&copy; Copyright Angela Chang and Wendy Deng 2016, All rights reserved</p>
				</div>
			</footer>
		<?php }?>

		<script>
			$('.owl-carousel').owlCarousel({
				loop: true,
				items: 3
			});
		</script>
		<script>
			$('#today-button').click(function(){
			    if($('[name = "radio-outfit"]:checked').val() === "yes"){
			        if($('#outfit-selection').val() === null){
			            $('#outfit-selection-error').text("Please select an outfit");
			        }
			        else{
			            var outfitid = $('#outfit-selection').val();
			            window.location.href = "index.php?outfitselectionid=" + outfitid;
			        }
			    }else{
			        var parts = "";
			        var counter = 0;

			        $('.icon-check').each(function(){
			            counter++;
			            parts += ($(this).attr("id")).substring(8) + " "; 
			        })
			        if(counter<2){
			            $('#outfit-selection-error').text("Please select at least 2 article of clothing");
			        }
			        else if(counter > 10){
			            $('#outfit-selection-error').text("Please only select up to 10 items at once");
			        }
			        else{
			            window.location.href = "index.php?outfitparts=" + parts + "&outfitnumparts=" + counter;
			        }
			    }
			})
		</script>
	</body> 
</html>