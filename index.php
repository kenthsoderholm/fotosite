<?php
	session_start();
	require_once('includes/conn.php');
	require_once('includes/functions.php');
	$conn = mysqli_connect($hostname, $username, $password, $database);
	$numberOfImages = numberOfImages();	//Gets actual number of images
	if (isset($_GET['currentPage']) && $_GET['currentPage'] != 0) {
		$currentPage = $_GET['currentPage'];
		$start = $currentPage*10;
		if ($start > $numberOfImages) {
			$start = 0;
			$currentPage = 0;
		} //Checks if the $start would be greater than the actual number of images, if so make it 0
	}
	else {
		$currentPage = 0;
		$start = 0;
	}
	
	$back = $currentPage-1;
	$forward = $currentPage+1;
	

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Fotositen</title>
		<link href="mall.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div id="wrapper">
			<?php 
				require_once('includes/header.php');
				require_once('includes/menu.php');
			?>	
			<div id="content">
				<?php
	//				$conn = mysqli_connect($hostname, $username, $password, $database);
					
					$query = "select imageID, imageThumbLink, imageDescription from images_v1 order by imageID asc limit $start, 10";
					$result = mysqli_query($conn, $query);
					$count_rows = mysqli_num_rows($result);
					if ($count_rows > 0) {
						while ($row = mysqli_fetch_assoc($result)) {
							$imageDescription = $row['imageDescription'];
								echo '
									<div class="thumbs_td">
										<a href="single.php?id='.$row['imageID'].'">
											<img src="'.$row['imageThumbLink'].'" title="'.$imageDescription.'" alt="'.$imageDescription.'">
										</a>
									</div>
								';
							}
						echo '<div id="clearOnIndex"><p>Sidor: ';
						if ($currentPage > 0) {
							 echo '<a href="index.php?currentPage='.$back.'">&lt;&lt;Bakåt</a> ';
						}
						$numPages = ceil($numberOfImages/10);
						for ($i = 0; $i < $numPages; $i++) {
							$j = $i+1;
								echo '<a href="index.php?currentPage='.$i.'">'.$j.'</a> ';

						} 
						if ($forward*10 < $numberOfImages) {
							echo '<a href="index.php?currentPage='.$forward.'">Framåt &gt;&gt;</a> ';
						}
						echo '</div>';
					}
					else {
						echo "<p>Inga bilder i databasen</p>";
					}
					mysqli_close($conn);
				?>
			</div>
			
			<div id="footer">
				<p>Kenth Söderholm &copy;</p>
			</div>
		</div>
	</body>
</html>