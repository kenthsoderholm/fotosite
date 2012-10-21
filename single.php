<?php
	session_start();
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
			<?php
				require_once('includes/header.php');
			?>
			
			<div id="menu">
				<a href="index.php">Startsidan</a> | <a href="backend.php">Backend</a>
			</div>
			
			<div id="content">
				<?php
					$conn = mysqli_connect($hostname, $username, $password, $database);
					if (mysqli_connect_errno()) {
						echo "Fel: ".mysqli_connect_errno();
					}
					$query = "select imageLink, imageWatermarkLink, imageDescription from images_v1 where imageID = '$id'";
					$result = mysqli_query($conn, $query);
					while ($row = mysqli_fetch_assoc($result)) {
						$imageLink = $row['imageLink'];
						$imageWatermarkLink = $row['imageWatermarkLink'];
						$imageDescription = $row['imageDescription'];
						if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
						echo '<p><img class="display" src="'.$imageLink.'" alt="'.$imageDescription.'" title="'.$imageDescription.'"><br>För inloggade visas denna.<br>klicka <a href="'.$imageLink.'">här</a> för full storlek.</p> <br>';
						}
						else {
							echo '<p><img class="display" src="'.$imageWatermarkLink.'" alt="'.$imageDescription.'" title="'.$imageDescription.'"><br>För andra visas denna.<br>klicka <a href="'.$imageWatermarkLink.'">här</a> för full storlek.</p>';
						}
						
					}
				?>
			</div>
			
			<div id="footer"></div>
		</div>

	</body>
</html>