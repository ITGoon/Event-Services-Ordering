<?php
  include("connection.inc.php");
  include("common.inc.php");
  include("checkLogin.inc.php");
  
  if ($userLevel < 2) {
  	redirectNoError("login.php");
  }
  
  $orderid = $_REQUEST['orderid'];
  $amount = $_REQUEST['amount'];
  $note = $_REQUEST['note'];
  
  $db->Execute("INSERT INTO order_altercost (orderid, note, amount, created_by) VALUES (?, ?, ?, ?)",
    array($orderid, stripslashes($note), $amount, $userid)) or die($db->ErrorMsg());

  redirectNoError("orderdetail.php?orderid=$orderid");
?>
