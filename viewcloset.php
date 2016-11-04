<?php
	session_start();
	include_once "connectdb.php";
	if (!isset($_SESSION['userid'])){
		header("Location: register.php");
	}

	$query = "SELECT * FROM clothing WHERE userid = " . $_SESSION["userid"];
	$result = mysqli_query($con, $query);

	$display=0;
	$max_per_page = 20;
	$result_copy = $result;

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
							<li class = "active">
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
		<div class = "container"> 
			<div class ="row" >
				<div class = "col-lg-12">
					<h2 class = "text-center page-header">Closet View </h2>
				</div>
				<div class = "col-md-12">
					<div class = "btn-group btn-group-justified" id = "views">
						<a href ="#" class= "btn btn-default" id = "all"> All </a>
						<a href ="#" class= "btn btn-default" id = "outfits"> Outfits </a>
						<a href ="#" class= "btn btn-default" id = "tops"> Tops </a>
						<a href ="#" class= "btn btn-default" id = "bottoms"> Bottoms </a>
						<a href ="#" class= "btn btn-default" id = "misc"> Misc </a>
						<a href ="addclothing.php" class= "btn btn-default" id = "new"> <i class = "fa fa-plus" aria-hidden="true"></i></a>
					</div>
				</div>

				<div class = "col-lg-12" id = "viewstage">
					<h4>View: all</h4>
					<?php
						while ($row = mysqli_fetch_array($result_copy) and $display<$max_per_page){
							$display++;
							echo '<div class = "col-lg-3 col-md-4 col-sm-6 col-xs-6 thumbnail-item"><a href = "#itemmodal" data-toggle = "modal" class = "thumbnail" color ="' . $row['color'] .'" timesworn="' . $row['timesworn'] . '" name = "' . $row['name'] . '" url = "' . $row['url'] .'" lastworn = "' . $row['lastworn'] . '" type = "'.$row['type'].'"><p>' . $row['name'] . '</p><img src="' . $row["url"] . '"></a></div>';
						}
					?>
				</div>
			</div>
		</div>

			<div class="modal fade" id="itemmodal" role="dialog">
				<div class = "modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title"></h4>
						</div>
						<div class="modal-body">
							<img src = "" class = "img-responsive center-block"></img>
							<p></p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script src = "vendor/jquery/jquery-3.1.0.min.js"></script>
        <script src = "vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src = "js/main.js"></script>
	</body>
</html>
