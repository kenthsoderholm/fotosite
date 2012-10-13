<?php
	require_once('includes/conn.php');
	if (isset($_GET['page']) && $_GET['page'] != 0) {
		$start = $_GET['page']*10;
	}
	else {
		$start = 0;
	}
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
			<div id="header"><h1>Photos by Kenth</h1></div>
			<div id="menu"><a href="backend.php">Backend</a></div>
			
			<div id="content">
				<?php
					$conn = mysqli_connect($hostname, $username, $password, $database);
					if (mysqli_connect_errno()) {
						echo "Fel: ".mysqli_connect_errno();
					}
					$query = "select imageID, imageThumbLink, imageDescription from images_v1 order by imageID asc limit $start, 10";
					$result = mysqli_query($conn, $query);
					$count_rows = mysqli_num_rows($result);
					if ($count_rows > 0) {
						echo '<table class="thumbs">';
						while ($row = mysqli_fetch_assoc($result)) {
							$imageDescription = $row['imageDescription'];
							if ($row['imageID']%2 == 1) {
								echo '
									<tr>
										<td class="thumbs_td">
											<a href="single.php?id='.$row['imageID'].'">
												<img src="'.$row['imageThumbLink'].'" title="'.$imageDescription.'" alt="'.$imageDescription.'">
											</a>
										</td>
								';
							}
							else {
								echo '
										<td class="thumbs_td">
											<a href="single.php?id='.$row['imageID'].'">
												<img src="'.$row['imageThumbLink'].'" title="'.$imageDescription.'" alt="'.$imageDescription.'">
											</a>
										</td>
									</tr>
								';
							}
						}
						echo '</table>';
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