<?php
  include("connection.inc.php");
  include("common.inc.php");
  include("checkLogin.inc.php");
  if ($userLevel < 2) {
      echo "<p>You do not have sufficient permissions to access this page.</p>";
      echo "<p><a href=\"orderlist.php\">Return to order list</a></p>";
  } else {
  	$orderid = $_REQUEST['orderid'];
  	if ($orderid) {
  		$db->Execute("UPDATE orders SET deleted=1 WHERE id=?", array($orderid));
  	}
  	redirectNoError("orderlist.php");
  }
?>
