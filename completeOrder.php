<?php
  include("connection.inc.php");
  include("common.inc.php");
  
  $response_code = $_REQUEST['x_response_code'];
  $auth_code = $_REQUEST['x_auth_code'];
  $trans_id = $_REQUEST['x_trans_id'];
  $orderid = $_REQUEST['x_invoice_num'];
  $response_reason = $_REQUEST['x_response_reason_text'];
  $amount = $_REQUEST['x_amount'];
  $firstName = $_REQUEST['x_first_name'];
  $lastName = $_REQUEST['x_last_name'];
  $company = $_REQUEST['x_company'];
  
  if ($response_code == 1) {
  	$db->Execute("UPDATE orders SET trans_id=?, auth_code=? WHERE id=?",
  	  array($trans_id, $auth_code, $orderid));
  }

?><? include("header.php") ?>

<? if ($response_code == 1 ) { ?>
Order completed.  You will be sent an email receipt.  You may also print this receipt for your records.

<table border="0">
<tr><td>Invoice number:</td><td><?= $orderid ?></td></tr>
<tr><td>Name:</td><td><?= $firstName ?> <?= $lastName ?></td></tr>
<tr><td>Company:</td><td><?= $company ?></td></tr>
<tr><td>Total amount:</td><td><?= $amount ?></td></tr>
<tr><td width="50">&nbsp;</td><td><table border="0">
<? $rs = $db->Execute("SELECT services.description, order_lineitems.quantity, order_lineitems.cost FROM order_lineitems, services WHERE order_lineitems.serviceid = services.id AND orderid=?",
                      array($orderid));
   while (!$rs->EOF) {
?>
  <tr><td><?= $rs->fields[0] ?></td><td><?= $rs->fields[1] ?> x <?= $rs->fields[2] ?></td></tr>
<? $rs->MoveNext(); } ?>

</table></td></tr>


<? } else { //response_code != 1 ?>
<p />The transaction failed for the following reason:
<p /><?= $response_reason ?>
<? } ?>
<p /><a href="http://YOUR_DOMAIN_HERE/eventservices/placeorder.php">Place another order</a>

<? include("footer.php") ?>
