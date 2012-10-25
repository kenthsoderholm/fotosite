<?php
	session_start();
	if (!isset($_SESSION['loggedIn']) || $_SESSION['level']== "viewer") {
		header('location: index.php');
	}
	require_once('includes/conn.php');
	$conn = mysqli_connect($hostname, $username, $password, $database);
	
	if (isset($_POST['action'])) {
		if ($_POST['action'] == "delete") {
			$categoryID = $_POST['categoryID'];
			$query = "delete from categories where categoryID = '$categoryID'";
			if (mysqli_query($conn, $query)) {
				$token = "<h3>Kategori raderad</h3>";				
			}

		}
		elseif ($_POST['action'] == "edit") {
			$categoryID = $_POST['categoryID'];
			$categoryName = $_POST['categoryName'];
			$query = "update categories set categoryName='$categoryName' where categoryID='$categoryID'";
			if (mysqli_query($conn, $query)) {
				$token = "<h3>Kategorinamn uppdaterat</h3>";
			}
		}
		else {
			$categoryName = $_POST['categoryName'];
			$query = "insert into categories (categoryID, categoryName) values (null, '$categoryName')";
			mysqli_query($conn, $query);
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
					$query = "select categoryID, categoryName from categories";
					$result = mysqli_query($conn, $query);
					$rows = mysqli_num_rows($conn, $result);
					while ($row = mysqli_fetch_assoc($result)) {
							$categoryID = $row['categoryID'];
							$categoryName = $row['categoryName'];
							echo '
								<p class="leftFloat">'.$categoryName.'</p>
		
								<form method="post" action="editAddCategories.php" class="leftFloat">
									<input type="hidden" value="'.$categoryID.'" name="categoryID">
									<input type="text" name="categoryName">
									<input type="hidden" value="edit" name="action">
									<input type="submit" value="Ändra namn">
								</form>
		
								<form method="post" action="editAddCategories.php" class="leftFloat">
									<input type="hidden" value="'.$categoryID.'" name="categoryID">
									<input type="hidden" value="delete" name="action">
									<input type="submit" value="Radera">
								</form>
		
								</p>
		
								<hr>
							';
						}
				?>
				<form method="post" action="editAddCategories.php" class="leftFloat">
					<label for="categoryName">Kategorinamn</label><input type="text" name="categoryName">
					<input type="hidden" value="add" name="action">
					<input type="submit" value="Lägg till kategori">
				</form>
				<br>
				<?php
					if (isset($token)) {
						echo $token;
					}
				?>
			</div>
			
			<div id="footer"><p>Kenth Söderholm &copy;</p></div>
		</div>
	</body>
</html>