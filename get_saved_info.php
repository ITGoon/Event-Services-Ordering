<?php
  include("connection.inc.php");
  include("common.inc.php");

  $failMessage = null;
  
  $emailaddr = $_POST['emailaddr'];
  $password = $_POST['password'];
  
  $visitorid = null;
  
  $visitorid = $db->GetOne('SELECT id FROM visitor_info WHERE emailaddr=? AND password=?',
    array($emailaddr, $password));
  if ($visitorid) {
  	$_SESSION['visitorid'] = $visitorid;
  } else {
  	$failMessage = "Email address and/or password not found";
  }
  
  if ($failMessage) {
  	redirectWithError('placeorder.php', $failMessage);
  } else {
  	redirectNoError('placeorder.php');
  }
  
?>