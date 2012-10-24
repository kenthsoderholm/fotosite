<?php
	session_start();
	if (isset($_POST['username']) && $_POST['username'] != null && $_POST['password'] != null) {
	
		require_once('includes/conn.php');
		$conn = mysqli_connect($hostname, $username, $password, $database);
		$uname = mysqli_real_escape_string($conn, $_POST['username']);
		$uname = htmlspecialchars($uname);
		$pass = $_POST['password'];
		
		$query = "select password, level from users where username = '$uname'";
		$result = mysqli_query($conn, $query);
		
		while ($row = mysqli_fetch_assoc($result)) {
			$saltedPass = $row['password'];
			$salt = substr($saltedPass, 0, 64);
			$pass = hash("sha256", $salt.$pass);
			$pass = $salt.$pass;
			if ($pass == $saltedPass) {
				$_SESSION['loggedIn'] = true;
				$_SESSION['level'] = $row['level'];
				if ($_SESSION['level'] == "viewer") {
					header('location: index.php');
				}
				else {
					header('location: backend.php');
				}
			}
			else {
				$token = "<h3>Felaktigt användarnamn eller lösenord.</h3>";
			}
		}
		

	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Registrering</title>
		<link href="mall.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div id="wrapper">
			<?php 
				require_once('includes/header.php');
				require_once('includes/menu.php');
			?>
			
			<div id="content">
				<form method="post" action="login.php">
				<label for="username">Användarnamn</label><input type="text" name="username"><br>
				<label for="password">Lösenord</label><input type="password" name="password"><br>
				<input type="submit" value="Logga in">
				</form>
				
				<?php
					if (isset($token)) {
						echo $token;
					}
				?>		
			</div>
			
			<div id="footer">
				<p>Kenth Söderholm &copy;</p>
			</div>
		</div>
	</body>
</html>