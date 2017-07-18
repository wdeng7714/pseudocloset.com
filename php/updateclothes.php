<?php
	session_start();
	if(!isset($_SESSION['userid'])){
		header("Location: index.php");
	}

	include_once "connectdb.php";

	$query = "SELECT * FROM admin WHERE userid=" . $_SESSION['userid'];
	$result = mysqli_query($con, $query);
	$row = mysqli_fetch_array($result);

	if($row){
		$updatedate = $row['updatedate'];
		$today = date("Y-m-d");
		if($today > $updatedate){
			$query = "SELECT * FROM plans WHERE date = CURDATE() AND userid=" . $_SESSION['userid'];
			$planresult = mysqli_query($con,$query);

			$partstoday = "";
			while($planrow = mysqli_fetch_array($planresult)){
				$partstoday = $partstoday . $planrow['parts'] . " ";
				$parts = explode(" ", $planrow['parts']);
				$numparts = $planrow['numparts'];
				for($i = 0; $i < $numparts; $i++){
					$query = "SELECT * FROM clothing WHERE id = " . $parts[$i] . " AND userid=" .$_SESSION['userid'];
					$clothingresult = mysqli_query($con, $query);
					$clothingrow = mysqli_fetch_array($clothingresult);
					if($clothingrow){
						$query = "UPDATE clothing SET timesworn = " . ($clothingrow['timesworn'] + 1) ." WHERE id=" . $clothingrow['id'] . " AND userid=" .$_SESSION['userid'];
						$result = mysqli_query($con, $query);
						if(!$result){
							echo "Could not reach server. Please try again later";
						}
					}
				}
			}

			$query = "UPDATE admin SET updatedate = CURDATE() WHERE userid =" .$_SESSION['userid'];
			if(!mysqli_query($con, $query)){
				echo "Could not reach server. Please try again later";
			}
		}
		
	}else{
		$query = "SELECT * FROM plans WHERE date = CURDATE() AND userid=" . $_SESSION['userid'];
			$planresult = mysqli_query($con,$query);
			$partstoday = "";
			while($planrow = mysqli_fetch_array($planresult)){
				$partstoday = $partstoday . $planrow['parts'] . " ";
				$parts = explode(" ", $planrow['parts']);
				$numparts = $planrow['numparts'];
				for($i = 0; $i < $numparts; $i++){
					$query = "SELECT * FROM clothing WHERE id = " . $parts[$i] . " AND userid=" .$_SESSION['userid'];
					$clothingresult = mysqli_query($con, $query);
					$clothingrow = mysqli_fetch_array($clothingresult);
					if($clothingrow){
						$query = "UPDATE clothing SET timesworn = " . ($clothingrow['timesworn'] + 1) ." WHERE id=" . $clothingrow['id'] . " AND userid=" .$_SESSION['userid'];
						$result = mysqli_query($con, $query);
						if(!$result){
							echo "Could not reach server. Please try again later";
						}
					}
				}
			}

		$query = "INSERT into admin (updatedate, partstoday, userid) VALUES (CURDATE(),'". $partstoday."'," . $_SESSION['userid'] . ")";

		if(!mysqli_query($con, $query)){
			echo "Could not reach server. Please try again later";
		}

	}

?>