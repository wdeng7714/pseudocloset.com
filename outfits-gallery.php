<?php
	session_start();
	if(!isset($_SESSION['userid'])){
		header("Location: index.php");
	}
	include_once "connectdb.php";

	$outfit_display = 0;
	$outfit_query = "SELECT * FROM outfits WHERE userid = " . $_SESSION['userid'];
	$outfit_result = mysqli_query($con, $outfit_query);
	$max_outfit_per_page = 10;

	while ($outfit_row = mysqli_fetch_array($outfit_result)){
		$outfit_display++;
?>
	<div class = "col-md-8 col-md-offset-2">
		<div class = "panel panel-default">
			<div class ="panel-heading clearfix">
				<h5 class = "pull-left"><?php echo $outfit_row['name']; ?></h5>
				<div class = "pull-right">
					<a href = "editoutfit.php?outfitid=<?php echo $outfit_row['id']; ?>"  type = "button" class = "btn btn-default" id = "edit-outfit-button">
						<span class="glyphicon glyphicon-pencil"></span>
					</a>
					<a type = "button" class = "btn btn-default delete-outfit-button" outfitid = "<?php echo $outfit_row['id'];?>">
						<span class="glyphicon glyphicon-trash"></span>
					</a>
				</div>
			</div>
			<div class ="panel-body">
				<div class = "owl-carousel col-md-12">											
					<?php
						$parts = explode(" ", $outfit_row['parts']);
						for($i = 0; $i < $outfit_row['numparts']; $i++){

							$query = "SELECT * FROM clothing WHERE id=" . $parts[$i];
							$result = mysqli_query($con, $query);
							if($result){
								$row = mysqli_fetch_array($result);
								echo '<div class = "item"><a href = "#item-modal" data-toggle = "modal" class = "thumbnail" color ="' . $row['color'] .'" timesworn="' . $row['timesworn'] . '" name = "' . $row['name'] . '" url = "' . $row['url'] .'" lastworn = "' . $row['lastworn'] . '" type = "'.$row['type'].'" id = "'. $row['id'] .'"><p>' . $row['name'] . '</p><img src="' . $row["url"] . '"></a></div>';
							}
						}
					?>
				</div>
			</div>
		</div>
	</div>

<?php } ?>
