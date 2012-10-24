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
			?>
			<div id="menu"><a href="index.php">Startsidan</a> | <a href="upload.php">Ladda upp bilder</a></div>
			
			<div id="content">
				<?php
				
				?>
			</div>
			
			<div id="footer"></div>
		</div>
	</body>
</html>