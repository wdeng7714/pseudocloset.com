<?php
	session_start();
	if(!isset($_SESSION['userid'])){
		header("Location: index.php");
	}
	include_once "connectdb.php";

	$error = false;
	$max_items = 10;

	if(isset($_POST['editoutfit'])){
		$clothingselected = false;

		$duplicate = -1;

		for($i = 0; $i < $max_items; $i++){
			for($j = 0; $j < $max_items && $j != $i; $j++){
				if($_POST['item'. $i] != "" && ($_POST['item'. $i] == $_POST['item'. $j])){
					$duplicate = intval($_POST['item'. $i]);
				}
			}
		}


		if($duplicate >= 0){
			$query = "SELECT * FROM clothing WHERE id=" . $duplicate;
			$result = mysqli_query($con, $query);
			if($result){
				$row = mysqli_fetch_array($result);
				$itemerror = $row['name'] . " can only be used once";
			}
		}

		$numparts = 0;

		for ($i = 0 ; $i < $max_items ; $i++){
			if ($_POST['item' . $i] == ""){
			}
			else{
				if($_POST['item' . $i] != "") $clothingselected = true;
				$outfit_item[$numparts] = mysqli_real_escape_string($con, $_POST['item' . $i]);
				$numparts++;
			}
		}

		if($numparts>=2 && $duplicate == -1){
			$userid = $_SESSION['userid'];
			$name = mysqli_real_escape_string($con, $_POST['name']);
			$id = mysqli_real_escape_string($con, $_POST['id']);

			$parts = implode(" ", $outfit_item);

			$query = "UPDATE outfits SET name = '" . $name ."', parts='" . $parts ."', numparts=" .$numparts." WHERE id = " . $id . " AND userid=" . $_SESSION['userid'];

			if (mysqli_query($con, $query)){
				$successmsg = "Outfit successfully added. <a href = 'viewcloset.php'>Click here to view closet </a>";
			} else{
				$errormsg = "Outfit was not successfully added. Please try again later";
			}

		}
		else if($numparts < 2){
			$itemerror = "Please select a minimum of 2 items";
		}
	}else{
		if(!isset($_GET['outfitid']))
			header("Location: viewcloset.php");
	}

	if(isset($_POST['id']))
		$id = $_POST['id'];
	if(isset($_GET['outfitid']))
		$id = $_GET['outfitid'];

	$query = "SELECT * FROM outfits WHERE id = " . $id . " AND userid = " . $_SESSION['userid'];

	$result = mysqli_query($con, $query);
	if(!$result){
		$errormsg = 'The outfit you are trying to edit is unavailable. Please try again later';
	}

	$row = mysqli_fetch_array($result);
	$numparts = $row['numparts'];
	$parts = explode(" ", $row['parts']);

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Edit outfit | PseudoCloset</title>
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
<!--- add outfit form -->

		<div class = "container">
			<div class ="row">
				<div class ="col-md-6 col-md-offset-3 well">
					<form role = "form" action = "<?php echo $_SERVER['PHP_SELF']; ?>" method ="post" name = "editoutfitform">
						<fieldset>
							<legend>
								<span class ="glyphicon glyphicon-plus">
								</span>
								Edit Outfit
							</legend>
                            <div class = "form-group">
                            	<input type = "hidden" name = "id" value = "<?php echo $row['id']; ?>"/>
                            </div>
							<div class ="form-group">
								<label for = "name">Name of outfit </label>
								<input type ="text" name = "name" placeholder = "Blue plaid" required value = "<?php if(isset($row['name'])) echo $row['name']; ?>" class = "form-control"?>
								<span class = "text-danger"> <?php if(isset($name_error)) echo $name_error; ?>
								</span>
							</div>

							<?php for ($i = 0; $i < $max_items; $i++){ ?>
							<div class = "form-group outfit-item item-hide" name = <?php echo '"item-group'. $i . '"'; ?> >
								<label for ="<?php echo 'item' . $i; ?>" >
									<?php echo 'Item ' . ($i + 1); ?> 
								 </label>


								<select name = <?php echo '"item'. $i . '"'; ?> class = "form-control clothing-item-select">			
									
									<option value "" disabled selected hidden> Choose a piece of clothing </option>
									
									<optgroup label = "Tops">

										<?php
											$query = "SELECT * FROM clothing WHERE userid = ". $_SESSION["userid"] . " AND (type = 'sweater' OR type = 'shirt' OR type ='jacket')";
											echo $query;
											$result = mysqli_query($con, $query);
											while($row = mysqli_fetch_array($result)){
												echo "<option value = '" . $row['id'] . "'>" . $row["name"] . "</option>";
											}
										?>
									</optgroup>

									<optgroup label = "Bottoms">
										<?php
											$query = "SELECT * FROM clothing WHERE userid = ". $_SESSION["userid"] . " AND type = 'pants'";
											echo $query;
											$result = mysqli_query($con, $query);
											while($row = mysqli_fetch_array($result)){
												echo "<option value = '" .$row['id'] ."'>" . $row["name"] . "</option>";
											}
										?>
									</optgroup>

									<optgroup label = "Misc">
										<?php
											$query = "SELECT * FROM clothing WHERE userid = ". $_SESSION["userid"] . " AND (type = 'socks' OR type ='underwear' OR type ='accessory')";
											echo $query;
											$result = mysqli_query($con, $query);
											while($row = mysqli_fetch_array($result)){
												echo "<option value = '" . $row['id'] ."'>" . $row["name"] . "</option>";
											}
										?>
									</optgroup>					
								</select>
							</div>

							<script>
								// $('[name = "item<?php echo $i; ?>"]').attr('value', "<?php if(isset($parts[$i])) echo $parts[$i]; ?>" );
							</script>
							<?php }?>
							<div class = "form-group">
								<button type="button" class ="btn btn-success" id = "add-button">
									<i class="icon-plus"></i> Item
								</button>
								<button class = "btn btn-danger" id = "delete-button">
									<i class="icon-minus"></i></i> Item
								</button>
								<span class = "text-danger text-center pull-right"  id = "max-error"><?php if(isset($itemerror)) echo $itemerror; ?></span>
							</div>
							<div class = "form-group">
								<button type = "submit" class ="btn btn-default" name = "editoutfit">
									Submit changes
								</button>
								<a type = "button" href = "viewcloset.php" class ="btn btn-default pull-right">
									Discard changes
								</a>
							</div>
						</fieldset>
					</form>
                    <span class = "text-success"><?php if (isset($successmsg)) echo $successmsg; ?>
                    </span>
                    <span class = "text-danger"><?php if(isset($errormsg)) echo $errormsg;?>
                    </span> 
				</div>
			</div>
		</div>
		<script src = "vendor/jquery/jquery-3.1.0.min.js"></script>
		<script src = "vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src = "js/main.js"></script>
		<script>
			var maxitems = <?php echo json_encode($max_items); ?>;
			var minitems = 2;
			var numitems = <?php echo $numparts; ?>;
			var parts = <?php echo json_encode($parts); ?>;
			for(var i  = 0; i < numitems; ++i) {
				$('[name = "item-group' + i + '"]').removeClass("item-hide");
				$('[name = "item' + i + '"]').val(parts[i]);
			}
			if(numitems <= minitems){
				$('#delete-button').prop('disabled', true);
			}
		</script>
	</body>
</html>