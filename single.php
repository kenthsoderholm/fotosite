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
				require_once('includes/menu.php');
			?>
						
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
						echo '<p><img class="display" src="'.$imageLink.'" alt="'.$imageDescription.'" title="'.$imageDescription.'"><br>klicka <a href="'.$imageLink.'" target="_blank">här</a> för full storlek (öppnas i ny flik).</p>';
						}
						else {
							echo '<p><img class="display" src="'.$imageWatermarkLink.'" alt="'.$imageDescription.'" title="'.$imageDescription.'"></p>';
						}
						
					}
				?>
			</div>
			
			<div id="footer"></div>
		</div>

	</body>
</html>