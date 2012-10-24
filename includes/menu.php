<div id="menu">
	<?php
		if (isset($_SESSION['level'])) {
			echo '<a href="index.php">Startsidan</a>';
		}
		if (isset($_SESSION['level']) && $_SESSION['level'] != "viewer") {
			echo '<a href="backend.php">Backend</a>';			
		}
		elseif (!isset($_SESSION['loggedIn'])) {
			echo '<a href="register.php">Registrera dig</a>';			
		}
	?>
</div>