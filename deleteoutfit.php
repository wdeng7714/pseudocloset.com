<?php
	session_start();

	if(!isset($_SESSION['userid'])){
		header("Location: index.php");
	}

	include "connectdb.php";

	if(isset($_GET['id'])){
		$query = "DELETE * FROM plan WHERE userid =" .$_SESSION['userid'] . " AND outfitid =" .$_GET['id'];
		if(mysqli_query($con, $query)){
			echo "Deleted all associated plans";
		}
		$query = "DELETE FROM outfits WHERE id=" . $_GET['id'] . " AND userid=" . $_SESSION['userid'];
		if(!mysqli_query($con, $query)){
			echo "Error. Please try again later";
		}
		//$queryplan = "DELETE FROM plans WHERE userid=" . $_SESSION['userid'] . " AND ";
	}

	//header("Location: viewcloset.php");
?>