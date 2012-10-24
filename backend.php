<?php
	session_start();
	if (!isset($_SESSION['loggedIn']) || $_SESSION['level']== "viewer") {
		header('location: index.php');
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
				<p>
					<a href="upload.php">Ladda upp bilder</a><br>
					<a href="users.php">Befordra/Radera användare</a><br>
					<span class="stricken"><a href="deleteImages.php">Radera bilder</a></span>
				</p>
			</div>
			
			<div id="footer"><p>Kenth Söderholm &copy;</p></div>
		</div>
	</body>
</html>