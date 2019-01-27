<?php
  include("connection.inc.php");
  include("common.inc.php");
  include("checkLogin.inc.php");
  
  $orderid = $_REQUEST['orderid'];
  $action = $_REQUEST['action'];
  
  if ($action == 'Change') {
  	$orderstatus = $_REQUEST['orderstatus'];
  	$db->Execute("UPDATE order_status SET status=?, modified_by=?, modified_at=NOW() WHERE orderid=?",
  	  array($orderstatus, $userid, $orderid));
  	
  	$statusname = $db->GetOne("SELECT name FROM statustypes WHERE id=?", array($orderstatus));
  	$db->Execute("INSERT INTO order_notes (order_id, note, created_by) VALUES (?, ?, ?)",
  	  array($orderid, "Status changed to $statusname", $userid));
  } elseif ($action == 'Set Location') {
  	$location = stripslashes($_REQUEST['location']);
  	$db->Execute("UPDATE orders SET location=? WHERE id=?",
  	  array($location, $orderid));
  } elseif ($action == 'Change Event') {
	$event_id = $_REQUEST['event'];
	$db->Execute("UPDATE orders SET event_id=? WHERE id=?",
		array($event_id, $orderid));
  }
  
  redirectNoError("orderdetail.php?orderid=$orderid");
?>
