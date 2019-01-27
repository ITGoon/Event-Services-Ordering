<?php
  include("connection.inc.php");
  include("common.inc.php");

  $failMessage = null;
  
  $username = $_POST['username'];
  $password = $_POST['password'];
  
  $userid = null;
  $userLevel = null;
  
  $userinfo = $db->GetRow('SELECT id, userlevel FROM users WHERE login=? AND password=PASSWORD(?)',
    array($username, $password));
  if ($userinfo) {
  	$userid = $userinfo[0];
  	$userLevel = $userinfo[1];
  } else {
  	$failMessage = "Invalid username/password";
  }
  
  if ($failMessage) {
  	redirectWithError('login.php', $failMessage);
  } else {
  	$_SESSION['userid'] = $userid;
  	$_SESSION['userlevel'] = $userLevel;
  	redirectNoError('orderlist.php');
  }

?>