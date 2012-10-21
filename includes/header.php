<div id="header">
	<div id="state">
		<?php
			if (!isset($_SESSION['loggedIn'])) {
				echo '<p>Du är inte inloggad.<br><a href="login.php">Logga in</a></p>';
			}
			elseif (isset($_SESSION['loggedIn'])) {
				echo "<p>Du är inloggad<br><a href=\"logout.php\">Logga ut</a></p>";
			}
		?>
	</div>
	<h1><a href="index.php">Photos by Kenth</a></h1>
</div>
