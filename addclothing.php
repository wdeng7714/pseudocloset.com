<?php
	session_start();
	if(!isset($_SESSION['userid'])){
		header("Location: index.php");
	}

	include_once 'connectdb.php';

	$error = false;

	if(isset($_POST['addclothing'])){
		echo "hi";
		$name = mysqli_real_escape_string($con, $_POST['name']);
		$type = mysqli_real_escape_string($con, $_POST['type']);
		$color = mysqli_real_escape_string($con, $_POST['color']);
		$timesworn = mysqli_real_escape_string($con, $_POST['timesworn']);
		$lastworn = mysqli_real_escape_string($con, $_POST['lastworn']);


		echo $name.$type.$color.$timesworn.$lastworn;
	}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        

        <title>Add Clothing | PseudoCloset</title>

        <link rel = "stylesheet" href = "vendor/font-awesome/css/font-awesome.min.css"/>
        <link rel = "stylesheet" href = "vendor/bootstrap/css/bootstrap.min.css" type="text/css"/>
        <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet"/> 
        <link rel = "stylesheet" href = "css/main.css" type = "text/css"/>
        <link rel = "stylesheet" href = "vendor/datepicker/datepicker.css"/>
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
                                <p class = "navbar-text">
                                    Signed in as <?php echo $_SESSION['username'];?>
                                </p>
                            </li>
                            <li>
                                <a href = "logout.php">Logout</a>
                            </li>
                        <?php } else { ?>
                            <li>
                                <a href = "login.php">Login</a>
                            </li>
                            <li>
                                <a href = "register.php">Sign Up</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>

<!-- add clothing form -->
        <div class = "container">
            <div class = "row">
                <div class = "col-md-6 col-md-offset-3 well">
                    <form role = "form" action = "<?php echo $_SERVER['PHP_SELF']; ?>" nethod = "post" name = "addclothingform">
                        <fieldset>
                            <legend>
                                <span class="glyphicon glyphicon-plus">
                                </span>
                                Add clothing
                            </legend>
                            <div class = "form-group">
                                <label for = "name">Name</label>
                                <input type = "text" name = "name" placeholder = "American eagle sweater" required value = "<?php if($error) echo $name; ?>" class = "form-control"/>
                                <span class = "text-danger"><?php if(isset($name_error)) echo $name_error;?>
                                </span>
                            </div>
                            <div class = "form-group">
                                <label for = "type">Type</label>
                                <select name = "type" class = "form-control">
                                    <option>sweater</option>
                                    <option>shirt</option>
                                    <option>pants</option>
                                    <option>socks</option>
                                    <option>jacket</option>
                                </select>
                            </div>
                            <div class = "form-group">
                                <label for = "color">Color</label>
                                <input class = "jscolor form-control" name = "color"/>
                            </div>
                            <div class = "form-group">
                                <label for = "timesworn">Times worn</label>
                                <input type = "number" name = "timesworn" min="0" class = "form-control" required value = "0"/>
                            </div>

                            <div class = "form-group">
                                <label for = "lastworn">Last worn</label>
                                <div class='input-group date' id='datepicker'>
                                    <input type='text' class="form-control" required placeholder = "MM/DD/YYYY" name = "lastworn"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar">
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <div class = "form-group">
                            	<button type = "submit" name = "addclothing" class = "btn btn-primary">
                            		Submit
                            	</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>

		<script src = "vendor/jquery/jquery-2.1.1.min.js"></script>
        <script src = "vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src = "vendor/datepicker/locales.js"></script>
        <script src = "vendor/datepicker/datepicker.js"></script>
        <script src = "vendor/jscolor/jscolor.js"></script>
        <script src = "js/main.js"></script>
    </body>
</html>