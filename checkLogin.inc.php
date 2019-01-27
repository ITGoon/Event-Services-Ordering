<?php

  if (isset($_SESSION['userid'], $_SESSION['userlevel'])) {
  	$userid = $_SESSION['userid'];
  	$userLevel = $_SESSION['userlevel'];
  } else {
  	redirectWithError('login.php', 'Not logged in or session timed out');
  }

?>