<?php
	session_start();
	if (!isset($_SESSION['loggedIn']) || $_SESSION['level']== "viewer") {
		header('location: index.php');
	}
	require_once('includes/conn.php');
	$conn = mysqli_connect($hostname, $username, $password, $database);
	if (isset($_POST['imageID'])) {
		$imageID = $_POST['imageID'];
		$query = "select imageThumbLink, imageLink, imageWatermarkLink from images_v1 where imageID = '$imageID'";
		$result = mysqli_query($conn, $query);
		$row = mysqli_fetch_assoc($result);
		$imageThumbLink = $row['imageThumbLink'];
		$imageLink = $row['imageLink'];
		$imageWatermarkLink = $row['imageWatermarkLink'];
		unlink($imageThumbLink);
		unlink($imageLink);
		unlink($imageWatermarkLink);
		$query = "delete from images_v1 where imageID= '$imageID'";
		if (mysqli_query($conn, $query)) {
			$token = "<h3>Bilden raderad på disk och i databasen";
		}
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
			<?php 
				require_once('includes/header.php');
				require_once('includes/menu.php');
			?>
			
			<div id="content">
				<?php
					$query = "select imageID, imageThumbLink from images_v1";
					$result = mysqli_query($conn, $query);
					while ($row = mysqli_fetch_assoc($result)) {
						echo '
							<div class="thumbs_td">
								<img src="'.$row['imageThumbLink'].'">
								<br>
								<form method="post" action="deleteImages.php">
									<input type="hidden" value="'.$row['imageID'].'" name="imageID">
									<input type="submit" value="Radera Bilden">
								</form>
							</div>
						';
					}
					if (isset($token)) {
						echo "<hr>".$token;						
					}

				?>
			</div>
			
			<div id="footer"><p>Kenth Söderholm &copy;</p></div>
		</div>
	</body>
</html>