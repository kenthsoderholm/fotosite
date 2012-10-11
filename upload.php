<?php
	
	if (isset($_FILES['filename'])) {
		require_once('includes/functions.php');
		require_once('includes/conn.php');
		
		$name = $_FILES['filename']['name'];
		if (checkFile($name)) {
			$thumbname = createThumb();
			$watermarkname = watermarkImage();
			$filename = $_FILES['filename']['name'];
			$image = $_FILES['filename']['tmp_name'];
			$imageDescription = $_POST['description'];
			if (move_uploaded_file($_FILES['filename']['tmp_name'],("images/".$filename))) {
				$token = "Du laddade upp en fil";
				$conn = mysqli_connect($hostname, $username, $password, $database);
				if (mysqli_connect_errno()) {
					echo "Fel: ".mysqli_connect_errno();
				}
				
			}
		}
		else {
			$token = "Du försökte ladda upp en otillåten filtyp";
		}
	}

?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Fotositen</title>
		<link href="mall.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div id="wrapper">
			<div id="header"></div>
			<div id="menu"><a href="index.php">Startsidan</a> | <a href="backend.php">Backend</a></div>
			
			<div id="content">
				<form action="upload.php" method="post" enctype="multipart/form-data">
				<label for="filename">Fil att ladda upp</label><input type="file" name="filename"><br>
				<label for="description">Beskrivning av bilden</label><br>
				<textarea name="description"></textarea>
				<br>
				<input type="submit" value="Ladda upp bilden">
				</form>
				<br>
				<?php
					if (isset($token)) {
						echo '<h1>'.$token.'</h1>';
					}
				?>
			</div>
			
			<div id="footer"></div>
		</div>
	</body>
</html>