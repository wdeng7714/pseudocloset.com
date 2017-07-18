<?php
	session_start();

	if(!isset($_SESSION['userid'])){
		header("Location: index.php");
	}

	include "connectdb.php";

	if(isset($_GET['id'])){
		
		//First deletes the clothing
		$query = "DELETE FROM clothing WHERE id=" . $_GET['id'] . " AND userid=" . $_SESSION['userid'];
		if(!mysqli_query($con, $query)){
			echo "Error. Please try again later";
		}

		//Then checks to delete any assoicated outfits and plans

		$queryoutfit = "SELECT * FROM outfits WHERE userid = " . $_SESSION['userid'];
		$queryplan = "SELECT * FROM plans WHERE userid = " . $_SESSION['userid'];
		
		$resultoutfit = mysqli_query($con, $queryoutfit);
		$resultplan = mysqli_query($con, $queryplan);

		// checks if used in any outfits and deletes them
		while($row = mysqli_fetch_array($resultoutfit)){
			$parts = explode(" ", $row['parts']);
			for($i = 0; $i < $row['numparts']; $i++){
				if($parts[$i] === $_GET['id']){
					//echo ('hi');
					$query = "DELETE FROM plans WHERE userid =" .$_SESSION['userid'] . " AND outfitid = " .$row['id'];

					if(!mysqli_query($con, $query)){	
						echo "Error. Please try again later";
					}	
					$query = "DELETE FROM outfits WHERE userid=" . $_SESSION['userid'] . " AND id=" . $row['id'];
					echo $query;
					if(!mysqli_query($con, $query)){
						echo "Error. Please try again later";
					}
				}
			}
		}
		// checks if used in any plans and deletes them
		while($row = mysqli_fetch_array($resultplan)){
			$parts = explode(" ", $row['parts']);
			for($i = 0; $i < $row['numparts']; $i++){
				if($parts[$i] === $_GET['id']){
					//echo ('hi');
					$query = "DELETE FROM plans WHERE userid=" . $_SESSION['userid'] . " AND id=" . $row['id'];
					echo $query;
					if(!mysqli_query($con, $query)){
						echo "Error. Please try again later";
					}
				}
			}
		}
	}

	header("Location: viewcloset.php");
?>