<?php
	session_start();
	include_once "connectdb.php";
	if (!isset($_SESSION['userid'])){
		header("Location: index.php");
	}

	$query = "SELECT * FROM clothing WHERE userid = " . $_SESSION["userid"] . " AND timesworn > 0 ORDER BY timesworn DESC";
	$result = mysqli_query($con, $query);

	$item_display=0;
	$max_per_page=8;
	
	if(isset($_GET['clothingid'])){
		$clothingitem=explode(" ", $_GET['clothingid']);
		$items = $_GET['items'];
		
		for($i = 0; $i < $items ; $i++){
		
			$updatequery = "UPDATE clothing SET timesworn = 0 WHERE clothing.id = ". $clothingitem[$i]. " AND userid = ". $_SESSION['userid'];
			if(mysqli_query($con, $updatequery)){
				$successmsg = "Wash registered successfully! The selected clothes are now marked clean";
			}else{
				$failmsg ="Unable to update wash, try again later";
			}
		}
	header("Location: laundrybasket.php");
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<title> Laundry Basket | PseudoCloset </title>
		<meta content = "width = device.width , initial-scale = 1.0" name = "viewport">
		<link rel = "stylesheet" href = "vendor/font-awesome/css/font-awesome.min.css"/>
		<link rel = "stylesheet" href = "vendor/bootstrap/css/bootstrap.min.css" type="text/css"/>
		<link rel = "stylesheet" href = "vendor/owl-carousel/css/owl.carousel.css" type="text/css"/>
		<link rel = "stylesheet" href = "vendor/owl-carousel/css/owl.theme.css" type="text/css"/>
		<link rel = "stylesheet" href = "vendor/owl-carousel/css/owl.transitions.css" type="text/css"/>
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

        <div class = "container"> 
			<div class ="row" >
				
					<h2 class = "text-center page-header">Laundry Basket</h2>
							
				<div class = "panel panel-info">
					<div class = "panel-heading clearfix">
						<div class = "col-md-6">
							<h5><i class="icon-tint" aria-hidden="true"></i> These are clothes are dirty </h5>
						</div>
						<div class = "col-md-6">
							<span class = "text-success"><?php if(isset($successmsg)) echo $successmsg;?>
							</span>
							<span class = "text-danger"><?php if(isset($errormsg)) echo $errormsg;?>
							</span>
							<button class = "btn btn-default pull-right" id = "submitwash">Washed</button>
						</div>
					</div>
					<div class = "panel-body">
						<div class = "owl-carousel col-md-10 col-offset-11">
					<?php
						$totalitems = mysqli_num_rows($result);
							
						for($i=0; $i < round($totalitems/$max_per_page); ++$i){
							echo "<div class = 'row item'>";
							for ($j = 0; $j < $max_per_page; $j++){
								$row = mysqli_fetch_array($result);
								if($row){
									echo '<div class = "col-lg-3 col-md-4 col-sm-6 col-xs-12 thumbnail-item planner-item col-eq-height" ><a class = "thumbnail" color ="' . $row['color'] .'" timesworn="' . $row['timesworn'] . '" name = "' . $row['name'] . '" url = "' . $row['url'] .'" lastworn = "' . $row['lastworn'] . '" type = "'.$row['type'].'" id = "'. $row['id'] .'"><p>' . $row['name'] . '<span class = "pull-right"><i class="icon-check-empty" id = "checkbox' .$row['id'] . '"></i></span></p><img src="' . $row["url"] . '"></a></div>';
								}
								
							}
							echo "</div>";
						}
						
						
					?>	
				</div>
					</div>
					
				</div>
					
				
			</div>
		</div>
		<script src = "vendor/jquery/jquery-2.1.1.min.js"></script>
        <script src = "vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src = "vendor/owl-carousel/js/owl.carousel.min.js"></script>
        <script src = "js/main.js"></script>
        <script>
			$('.owl-carousel').owlCarousel({
				loop: true,
				singleItem: true
			});
		</script>
		<script>
			$('#submitwash').click(function(){
				var clothingid="";
				var counter = 0;
				$('.icon-check').each(function(){
					clothingid += ($(this).attr("id")).substring(8) + " ";	
					counter++;
				})
				if(counter>0){
					window.location.href = "laundrybasket.php?clothingid=" + clothingid + "&items=" +counter;
				}
			})
		</script>
	</body>
</html>
