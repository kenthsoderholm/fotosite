<?php
	session_start();
	$_SESSION['loggedIn'] = true;
	header('location: index.php');
?>