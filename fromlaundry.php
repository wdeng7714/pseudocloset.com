<?php
	session_start();
	if(!isset($_SESSION['userid'])){
		header("Location: index.php");
	}

	include_once "connectdb.php";

	if(isset($_GET['clothingid'])){
		$query = "UPDATE clothing SET timesworn = 0 WHERE id=" . $_GET['clothingid'] ." AND userid=" . $_SESSION['userid'];
		if(mysqli_query($con, $query)){
			echo "<span class = 'text-success pull-left'>Item removed from laundry. <a href = 'laundrybasket.php'> Click here to view laundry</a></span>";
		}else{
			echo "<span class = 'text-danger pull-left'>Add to laundry was unsuccessful. Please try again later</span>";
		}
	}else{
		echo "<span class = 'text-danger pull-left'>Unsuccessful. Please try again later</span>";
	}
?>