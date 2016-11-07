<?php
	session_start();
	if(!isset($_SESSION['userid'])){
		header("Location: index.php");
	}

	include_once "connectdb.php";

	$query = "SELECT * FROM admin";
	$result = mysqli_query($con, $query);
	$row = mysqli_fetch_array($result);

	if($row){
		$updatedate = $row['updatedate'];
		$today = date("Y-m-d");
		if($today > $updatedate){
			$query = "SELECT * FROM plans WHERE date = CURDATE()";
			$result = mysqli_query($con,$query);

			while($planrow = mysqli_fetch_array($result)){
				$parts = explode(" ", $planrow['parts']);
				$numparts = $planrow['numparts'];
				for($i = 0; $i < $numparts; $i++){
					$query = "SELECT * FROM clothing WHERE id = " . $parts[$i];
					$result = mysqli_query($con, $query);
					$clothingrow = mysqli_fetch_array($result);
					if($clothingrow){
						$query = "UPDATE clothing SET timesworn = " . ($clothingrow['timesworn'] + 1) ." WHERE id=" . $clothingrow['id'];
						$result = mysqli_query($con, $query);
						if(!$result){
							echo "Could not reach server. Please try again later";
						}
					}
				}
			}

			$query = "UPDATE admin SET updatedate = CURDATE()";
			if(!mysqli_query($con, $query)){
				echo "Could not reach server. Please try again later";
			}
		}
		
	}

?>