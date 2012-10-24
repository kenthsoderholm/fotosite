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
					<a href="upload.php">Ladda upp bilder</a>
				</p>
			</div>
			
			<div id="footer"><p>Kenth Söderholm &copy;</p></div>
		</div>
	</body>
</html>