<?php
  include("connection.inc.php");
  include("common.inc.php");
  
  include('checkLogin.inc.php');
  
  $orderid = $_REQUEST['orderid'];
  $notetext = $_REQUEST['notetext'];
  $db->Execute("INSERT INTO order_notes (order_id, note, created_by) VALUES (?, ?, ?)",
    array($orderid, stripslashes($notetext), $userid));
  redirectNoError('orderdetail.php?orderid='.$orderid);
?>
