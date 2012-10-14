<?php
	require_once('includes/conn.php');
	if (isset($_FILES['filename'])) {
		require_once('includes/functions.php');
		
		$name = $_FILES['filename']['name'];
		if (checkFile($name)) {
			$thumbName = createThumb();			//Creates thumbnail and stores the name of the file in $thumbName
			$watermarkName = watermarkImage();	//Creates watermarked image and stores the name of the file in $watermarkName
			$filename = $_FILES['filename']['name'];
			$image = $_FILES['filename']['tmp_name'];
			$categoryID = $_POST['category'];
			if (move_uploaded_file($_FILES['filename']['tmp_name'],("images/".$filename))) {
				$token = "Du laddade upp en fil";
				$conn = mysqli_connect($hostname, $username, $password, $database);
				if (mysqli_connect_errno()) {
					echo "Fel: ".mysqli_connect_errno();
				}
				$imageDescription = mysqli_escape_string(htmlentities($_POST['description'], EN_QUOTES, "UTF-8"));
				$imageLink = "images/".$filename;
				$imageThumbLink = "thumbs/".$thumbName;
				$imageWatermarkLink = "watermarked/".$watermarkName;
				$query = "insert into images_v1 (imageID, imageThumbLink, imageLink, imageWatermarkLink, imageDescription, categoryID)  values (null, '$imageThumbLink', '$imageLink', '$imageWatermarkLink', '$imageDescription', '$categoryID')";
				mysqli_query($conn, $query);
				$token = $token." och all info sparades i databasen";
				mysqli_close($conn);
			}
		}
		else {
			$token = "Du försökte ladda upp en otillåten filtyp";
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
			<div id="header"></div>
			<div id="menu"><a href="index.php">Startsidan</a> | <a href="backend.php">Backend</a></div>
			
			<div id="content">
				<form action="upload.php" method="post" enctype="multipart/form-data">
				<label for="filename">Fil att ladda upp</label><br><input type="file" name="filename"><br>
				<label for="description">Beskrivning av bilden</label><br>
				<textarea name="description"></textarea>
				<br>
				<?php
					echo '<select name="category">';
					$conn = mysqli_connect($hostname, $username, $password, $database);
					if (mysqli_connect_errno()) {
						echo "Fel: ".mysqli_connect_errno();
					}
					$query = "select categoryID, categoryName from categories";
					$result = mysqli_query($conn, $query);
					while ($row = mysqli_fetch_assoc($result)) {
						echo '<option value="'.$row['categoryID'].'">'.$row['categoryName'].'</option>';
					}
					
					echo '</select>';
					mysqli_close($conn);
				?>
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