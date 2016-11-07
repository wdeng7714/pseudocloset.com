<?php
	session_start();
	include_once "connectdb.php";
	if (!isset($_SESSION['userid'])){
		header("Location: index.php");
	}
	include_once "updateclothes.php";

	if( isset($_GET['outfitselectionid'])){
		$query = 'SELECT * FROM outfits WHERE userid = ' . $_SESSION['userid'] . ' AND id = ' . $_GET['outfitselectionid'] ." ORDER BY name";
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


	$outfitquery = "SELECT * FROM outfits WHERE userid =". $_SESSION['userid'] . " ORDER BY name";
	$outfitresult = mysqli_query($con, $outfitquery);
    $clothingquery = "SELECT * FROM clothing WHERE userid = ". $_SESSION['userid']. " ORDER BY name";
    $clothingresult =mysqli_query($con, $clothingquery);
    $display=0;
    $max_per_page=20;

    $plansquery = "SELECT * FROM plans WHERE userid = " . $_SESSION['userid'] . " ORDER BY date" ;
    $plansresult = mysqli_query($con, $plansquery);

    $todayquery = "SELECT * FROM plans WHERE userid = " . $_SESSION['userid'] . " AND date = CURDATE() ORDER BY date";
    $todayresult = mysqli_query($con, $todayquery);

?>
<!DOCTYPE html>
<html>
	<head>
		<title> View Closet | PseudoCloset </title>
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
							<li class = "active">
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


		<div class = "container" >
			<div class = "row">
				<div class = "col-md-12">
					<h2 class = "page-header text-center"> Outfit planner </h2>
				</div>
				<div class = "col-md-8 col-md-offset-2  <?php if(mysqli_num_rows($todayresult) > 0) echo "item-hide";?>">
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
						<a type = "submit" id = "today-button" class = "btn btn-primary pull-right" >Submit plan</a>
						
						</div>
					</div>
				</div>

				
				
				<?php //START HERE

					while ($plans_row = mysqli_fetch_array($plansresult)){
					?>
						<div class = "col-md-8 col-md-offset-2">
							<div class = "panel panel-info">
								<div class ="panel-heading clearfix">
									<h5 class = "pull-left">Your outfit for <?php echo $plans_row['date'] . " is ". $plans_row['name']; ?> </h5>
									<div class = "pull-right">
										<a href = "editplan.php?planid=<?php echo $plans_row['id']; ?>"  type = "button" class = "btn btn-default" id = "edit-plan-button">
											<span class="glyphicon glyphicon-pencil"></span>
										</a>
										<button type = "button" class = "delete-plan-button btn btn-default" planid = "<?php echo $plans_row['id'];?>">
											<span class="glyphicon glyphicon-trash"></span>
										</button>
									</div>
								</div>
								<div class ="panel-body">
									<div class = "owl-carousel col-md-12">											
										<?php
											$parts = explode(" ", $plans_row['parts']);
											for($i = 0; $i < $plans_row['numparts']; $i++){
												$query = "SELECT * FROM clothing WHERE id=" . $parts[$i] . " ORDER BY name";
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

				<?php } ?>
			</div>
		</div>
		<div class="modal fade" id="item-modal" role="dialog">
			<div class = "modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"></h4>
					</div>
					<div class="modal-body">
						<div class = "container-fluid">
							<div class = "row center">
								<div class = "col-md-6 col-xs-12">
									<img src = "" class = "item-img center-block"/>
								</div>
								<div class = "col-md-6 col-xs-12 well">
									<div class = "row">
 										<dl>
  											<dt class = "col-xs-12">Color</dt>
  											<dd class = "col-xs-12 item-color"><p> &nbsp; </p></dd>
  											<dt class = "col-xs-12">Times worn</dt>
  											<dd class = "item-timesworn col-xs-12"><p></p></dd>
  											<dt class = "col-xs-12">Last worn</dt>
  											<dd class = "col-xs-12 item-lastworn"><p></p></dd>
										</dl>
										<a type = "button" class = "btn btn-primary col-xs-offset-1" id = "edit-button">
											<span class="glyphicon glyphicon-pencil"></span>
											Edit
										</a>
										<button type = "button" class = "btn btn-danger" id = "delete-clothing-button">
											<span class="glyphicon glyphicon-trash"></span>
											Delete
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type = "button" class = "btn btn-success">
							<i class="fa fa-plus" aria-hidden="true"></i> 
							Laundry Basket
						</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
			        if(counter<2){
			            $('#outfit-selection-error').text("Please select at least 2 article of clothing");
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
	</body>
</html>