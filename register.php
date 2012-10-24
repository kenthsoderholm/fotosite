<?php
	if (isset($_POST['username']) && $_POST['username'] != null && $_POST['pass'] != null) {
		require_once('includes/conn.php');
		$conn = mysqli_connect($hostname, $username, $password, $database);
		if (mysqli_connect_errno()) {
			echo "Fel inträffade: ".mysqli_connect_errno();
		}

		$uname = mysqli_real_escape_string($conn, $_POST['username']);
		$uname = htmlspecialchars($uname);

		$fname = htmlentities($_POST['fname'], ENT_QUOTES, "UTF-8");

		$lname = htmlentities($_POST['lname'], ENT_QUOTES, "UTF-8");

		$pass = $_POST['pass'];

		$mail = stripslashes($_POST['mail']);

		$salt = hash("sha256", time().$uname);
		$saltedPass = hash("sha256", $salt.$pass);
		$pass = $salt.$saltedPass;

		$query = "insert into users (userID, username, password, fname, lname, email, level) values (null, '$uname', '$pass', '$fname', '$lname', '$mail', 'viewer')";
		if (mysqli_query($conn, $query)) {
			$token = '<h2>Du är numera registrerad. <a href="login.php">Logga in här</a></h2>';
		}
		mysqli_close($conn);
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
				<form method="post" action="register.php">
					<label for="fname">Förnamn</label><input type="text" name="fname"><br>
					<label for="lname">Efternamn</label><input type="text" name="lname"><br>
					<label for="username">Användarnamn</label><input type="text" name="username"><br>
					<label for="pass">Lösenord</label><input type="password" name="pass"><br>
					<label for="mail">Epost</label><input type="email" name="mail"><br>
					<input type="submit" value="Registrera dig">
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