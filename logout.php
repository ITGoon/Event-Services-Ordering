<?php
	include("connection.inc.php");
	include("common.inc.php");

	$_SESSION = array();
	session_destroy();
	
	redirectNoError('login.php');
?>