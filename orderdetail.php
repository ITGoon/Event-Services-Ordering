<?php
  include("connection.inc.php");
  include("common.inc.php");
  
  include("checkLogin.inc.php");

  $statustypes = $db->GetActiveRecords("statustypes");

  $orderid = isset($_REQUEST['orderid']) ? $_REQUEST['orderid'] : 0;
  
  $orderstatus = $db->GetOne("SELECT status FROM order_status WHERE orderid=?", array($orderid));
  
  $orders = $db->GetActiveRecords("orders", "id=?", array($orderid)) or die("order not found");
  $order = $orders[0];
  
  $orderlineitems = $db->GetActiveRecords("order_lineitems", "orderid=?", array($orderid));
  $altercosts = $db->GetActiveRecords("order_altercost", "orderid=?", array($orderid));
  
  $totalcost = 0.0;
  $totalalter = 0.0;

  $rs_events = $db->Execute("SELECT name, id from events where (start_date > NOW() OR start_date is null) AND deleted=0 ORDER BY start_date");

?><? include("header.php") ?>

<p /><a href="orderlist.php">Return to order list</a>
<p />

<form action="orderdelete.php" method="post" onsubmit="return confirm('Delete this order?')">
<input type="hidden" name="orderid" value="<?= $orderid ?>" />
<input type="submit" value="Delete" />
</form>

<form method="post" action="orderedit.php">
<table>
<tr><td class="label">Status:</td>
    <td><input type="hidden" name="orderid" value="<?= $orderid ?>" />
        <select name="orderstatus">
<? foreach ($statustypes as $statustype) { ?>
          <option value="<?= $statustype->id ?>" <?= selected_if($orderstatus == $statustype->id) ?>><?= $statustype->name ?></option>
<? } ?>
        </select><input type="submit" name="action" value="Change" />
    </td>
</tr>

<tr><td class="label">Authorize.Net transaction:</td>
  <td> <? if ($order->trans_id) { echo $order->trans_id; } else { ?>
Unbilled - <a href="processPendingOrder.php?orderid=<?= $order->id ?>">process now</a>
<? } ?>
  </td></tr>
<tr><td class="label">Location:</td><td><textarea name="location" cols="40" rows="3"><?= $order->location ?></textarea>
    <input type="submit" name="action" value="Set Location" /></td></tr>
<tr><td class="label">CustomerName:</td><td><?= htmlspecialchars($order->cust_name) ?></td></tr>
<tr><td class="label">Event:</td><td>
   <?= $rs_events->GetMenu2('event', $order->event_id, false) ?> 
   <input type="submit" name="action" value="Change Event" />
   <?= $order->event_id == 9 ? "<br />" . $order->event_name : "" ?>
</td></tr>
<tr><td class="label">CustContactName:</td><td><?= $order->cust_contact_name ?></td></tr>
<tr><td class="label">CustContactPhone:</td><td><?= $order->cust_contact_phone ?></td></tr>
<tr><td class="label">CustContactEmail:</td><td><?= $order->cust_contact_email ?></td></tr>
<tr><td class="label">CustContactFax:</td><td><?= $order->cust_contact_fax ?></td></tr>
<tr><td class="label">BillingAddress1:</td><td><?= $order->billing_address1 ?></td></tr>
<tr><td class="label">BillingAddress2:</td><td><?= $order->billing_address2 ?></td></tr>
<tr><td class="label">BillingCity:</td><td><?= $order->billing_city ?></td></tr>
<tr><td class="label">BillingState:</td><td><?= $order->billing_state ?></td></tr>
<tr><td class="label">BillingZip:</td><td><?= $order->billing_zip ?></td></tr>
<tr><td class="label">OnsiteContactName:</td><td><?= $order->onsite_contact_name ?></td></tr>
<tr><td class="label">OnsiteContactPhone:</td><td><?= $order->onsite_contact_phone ?></td></tr>
<tr><td class="label">OnsiteAltContactName:</td><td><?= $order->onsite_altcontact_name ?></td></tr>
<tr><td class="label">OnsiteAltContactPhone:</td><td><?= $order->onsite_altcontact_phone ?></td></tr>
<tr><td colspan="2"><table width="100%">
  <tr><td colspan="3">Order Items</td></tr>

<? $rs = $db->Execute("SELECT order_lineitems.cost, order_lineitems.quantity, services.description FROM order_lineitems LEFT JOIN services ON order_lineitems.serviceid=services.id WHERE order_lineitems.orderid=?", array($orderid));
   while (!$rs->EOF) {
   	$totalcost += $rs->fields[0] * $rs->fields[1];
?>
<tr><td class="label"><?= $rs->fields[2] ?></td>
    <td>$<?= $rs->fields[0] ?></td>
    <td>x <?= $rs->fields[1] ?></td>
</tr>
<? $rs->MoveNext(); } ?>

<tr><td class="label">Sub-total:</td><td>$<?= $totalcost ?></td><td>&nbsp;</td></tr>
<tr><td colspan="3">Discounts/Additional Fees (<a href="addCostChange.php?orderid=<?= $orderid ?>">Add</a>)</td></tr>

<? $rs = $db->Execute("SELECT note, amount FROM order_altercost WHERE orderid=?", array($orderid));
   while (!$rs->EOF) {
   	$totalalter += $rs->fields[1];
?> 
   <tr><td class="label"><?= $rs->fields[0] ?></td>
    <td>$<?= $rs->fields[1] ?></td><td>&nbsp;</td></tr>
<? $rs->MoveNext(); } ?>

<tr><td class="label">Sub-total:</td><td>$<?= $totalalter ?></td><td>&nbsp;</td></tr>
<tr><td colspan="3">Grand Total</td></tr>
<tr><td class="label">Total:</td><td>$<?= $totalcost + $totalalter ?></td><td>&nbsp;</td></tr>

</table></td></tr>
</table>
</form>

<p />Notes:

<?
  $rs = $db->Execute("SELECT order_notes.note, order_notes.created_at, users.login FROM order_notes LEFT JOIN users ON order_notes.created_by=users.id WHERE order_notes.order_id=?", array($orderid));
  while (!$rs->EOF) {
?>
<table><tr><td class="smallheader">Created by
<?= ($rs->fields[2]) ? $rs->fields[2] : "[submitter]" ?> on <?= $rs->fields[1] ?></td></tr>
<tr><td><?= $rs->fields[0] ?></td></tr>
</table>
<? $rs->MoveNext(); } ?>


<form method="post" action="addnote.php">
<input type="hidden" name="orderid" value="<?= $orderid ?>" />
<textarea rows="6" cols="40" name="notetext">
</textarea><br />
<input type="submit" value="Add Note" />
</form>

<? include("footer.php") ?>
