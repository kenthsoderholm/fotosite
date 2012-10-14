<?php
	require_once('includes/conn.php');
	if (!isset($_GET['id']) || $_GET['id'] <= 0) {
		header('location: index.php');
	}
	else {
		$id = (int) $_GET['id'];
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Utvisning stora bilder</title>
		<link href="mall.css" rel="stylesheet" type="text/css">
	</head>
	
	<body>
		<div id="wrapper">
			<div id="header"><h1>Fotosite by Kenth</h1></div>
			<div id="menu">
				<a href="index.php">Startsidan</a> | <a href="backend.php">Backend</a>
			</div>
			
			<div id="content">
				<?php
					$conn = mysqli_connect($hostname, $username, $password, $database);
					if (mysqli_connect_errno()) {
						echo "Fel: ".mysqli_connect_errno();
					}
					$query = "select imageLink, imageWatermarkLink from images_v1 where imageID = '$id'";
					$result = mysqli_query($conn, $query);
					while ($row = mysqli_fetch_assoc($result)) {
						echo '
							<p>För inloggade ska denna visas: </p><img src="'.$row['imageLink'].'"> <br><p>För andra ska denna visas: </p> 
							<img src="'.$row['imageWatermarkLink'].'">
						';
					} //Now it shows both watermarked and original image, will change this after adding login
				?>
			</div>
			
			<div id="footer"></div>
		</div>

	</body>
</html>