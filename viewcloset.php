<?php
	session_start();
	include_once "connectdb.php";
	if (!isset($_SESSION['userid'])){
		header("Location: index.php");
	}

	include_once "updateclothes.php";

	$query = "SELECT * FROM clothing WHERE userid = " . $_SESSION["userid"] . " ORDER BY name";
	$result = mysqli_query($con, $query);

	$item_display=0;
	$max_per_page = 20;
	$result_copy = $result;

	$outfit_display = 0;
	$outfit_query = "SELECT * FROM outfits WHERE userid = " . $_SESSION['userid']. "ORDER BY name";
	$outfit_result = mysqli_query($con, $outfit_query);
	$max_outfit_per_page = 10;



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
                        <?php if(isset($_SESSION['userid'])){?>
							<li class = "active">
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
				<div class = "col-lg-12">
					<h2 class = "text-center page-header">Closet view </h2>
				</div>
				<div class = "col-md-12">

					<!-- Centered Pills -->
					<ul class="nav nav-pills nav-justified" id = "views" >
						<li id = "all"><a href ="#" class= "" >All</a></li>
						<li id = "outfits"><a href ="#" class= "">Outfits</a></li>
						<li id = "tops"><a href ="#" class= "" >Tops</a></li>
						<li id = "bottoms"><a href ="#" class= "" >Bottoms</a></li>
						<li id = "misc"><a href ="#" class= "" >Misc</a></li>
						<li  id = "new"><a href ="addclothing.php" class= ""> <i class="icon-plus"></i></a></li>
					</ul>
				</div>

				<div class = "col-lg-12" id = "viewstage">
					<h4>View: all</h4>
					<?php
						while ($row = mysqli_fetch_array($result_copy)){
							$item_display++;
							echo '<div class = "col-lg-3 col-md-4 col-sm-6 col-xs-6 thumbnail-item col-eq-height"><a href = "#item-modal" data-toggle = "modal" class = "thumbnail" color ="' . $row['color'] .'" timesworn="' . $row['timesworn'] . '" name = "' . $row['name'] . '" url = "' . $row['url'] .'" lastworn = "' . $row['lastworn'] . '" type = "'.$row['type'].'" id = "'. $row['id'] .'"><p>' . $row['name'] . '</p><img src="' . $row["url"] . '"></a></div>';
						}
					?>

					<div class = "thumbnail-hide" id = "outfits-gallery">
						<?php include "outfits-gallery.php"; ?>
					</div>
				</div>
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
	</body>
</html>
