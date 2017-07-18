<?php
	session_start();

	if(!isset($_SESSION['userid'])){
		header("Location: index.php");
	}

	include "connectdb.php";

	if(isset($_GET['id'])){
		$query = "DELETE FROM plans WHERE id = " . $_GET['id'] . " AND userid=" . $_SESSION['userid'];

		if(!mysqli_query($con, $query)){
			echo "Plan was unsuccessfully deleted. Please try again later";
		}
	}


	header("Location: planner.php");
?>