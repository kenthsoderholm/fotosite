<?php
	session_start();
	if (!isset($_SESSION['loggedIn']) || $_SESSION['level'] == "viewer" || $_SESSION['level'] == "uploader") {
		header('location: index.php');
	}
	require_once('includes/conn.php');
	$conn = mysqli_connect($hostname, $username, $password, $database);
	if (isset($_POST['erase'])) {
		$userID = $_POST['userID'];
		$query = "delete from users where userID = '$userID'";
		mysqli_query($conn, $query);
		$token = "<h3>Användare raderad</h3>";
	}
	elseif (isset($_POST['promote'])) {
		$userID = $_POST['userID'];
		$query = "update users set level = 'uploader' where userID = '$userID'";
		mysqli_query($conn, $query);
		$token = "<h3>Användaren är numera uppladdare</h3>";
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
				<hr>
				<?php
					$query = "select userID, username, level from users";
					$result = mysqli_query($conn, $query);
					while ($row = mysqli_fetch_assoc($result)) {
						$uname = $row['username'];
						$level = $row['level'];
						$userID = $row['userID'];
						echo '
							<p class="leftFloat">Användare: '.$uname.' Behörighetsnivå: '.$level.'</p>
							<form method="post" action="users.php" class="leftFloat">
								<input type="hidden" name="userID" value="'.$userID.'">
								<input type="hidden" name="erase" value="true">
								<input type="submit" value="Radera Användare">
							</form>
						';
						if ($level == "viewer") {
							echo '
								<form method="post" action="users.php"class="leftFloat">
									<input type="hidden" name="userID" value="'.$userID.'">
									<input type="hidden" name="promote" value="true">
									<input type="submit" value="Gör användare till uppladdare">
								</form>
							
							';
						}
						echo '</p><hr>';
					}
					if (isset($token)) {
						echo $token;
					}
				?>
			</div>
			
			<div id="footer"><p>Kenth Söderholm &copy;</p></div>
		</div>
	</body>
</html>