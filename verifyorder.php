<?php
  include("connection.inc.php");
  include("common.inc.php");
  
  $eventName = "";
  $eventDate = "";
  
  extract ('P', 'order_');
//  import_request_variables ('P', 'order_');
  
  $orderparams = array('eventid', 'customerName', 'eventName', 
                  'eventDate', 'custContactName', 'custContactPhone',
                  'custContactEmail', 'custContactFax', 'billingAddress1',
                  'billingAddress2', 'billingCity', 'billingState',
                  'billingZip', 'onsiteContactName', 'onsiteContactPhone',
                  'onsiteAltContactName', 'onsiteAltContactPhone', 'note');
                  
  $order = array();
  foreach ($orderparams as $param) {
  	$order[$param] = $_POST[$param];
  }
  $order['items'] = array();

  $event = $db->GetRow("SELECT name, start_date FROM events WHERE id=?", array($order['eventid']));
  if ($event) {
  	$eventName = $event[0];
  	$eventDate = $event[1];
  }
  
  if ($order_eventid == 9) {
  	$eventName = $order_eventName;
  	$eventDate = $order_eventDate;
  } else {
  	$order_eventName = $eventName;
  	$order_eventDate = $eventDate;
  }

  $order['eventDate'] = $order_eventDate;
  
  $services = $db->GetActiveRecords('services');
  
  $order['cost'] = 0.0;

  foreach ($services as $service) {
    $qtystr = 'qty'.$service->id;
    if (isset($_POST[$qtystr]) && ($_POST[$qtystr] > 0)) {
      $qtyval = $_POST[$qtystr];
      $order['items'][] = array('id' => $service->id,
                                'description' => $service->description,
                                'qty' => $qtyval,
                                'cost' => $service->cost,
                                'category' => $service->category,
                                'addon' => $service->addon);
      $order['cost'] += ($qtyval * $service->cost);
    }
  }

  $verifyMessage = verifyOrder($order);
  
  $_SESSION['S_order'] = $order;

?><? include("header.php") ?>

<p />Please verify that this information is correct:
<table>
<tr><td class="label">CustomerName:</td><td><?= $order_customerName ?></td></tr>
<tr><td class="label">Event:</td><td><?= $order_eventName ?></td></tr>
<tr><td class="label">Event date:</td><td><?= $order_eventDate ?></td></tr>
<tr><td class="label">CustContactName:</td><td><?= $order_custContactName ?></td></tr>
<tr><td class="label">CustContactPhone:</td><td><?= $order_custContactPhone ?></td></tr>
<tr><td class="label">CustContactEmail:</td><td><?= $order_custContactEmail ?></td></tr>
<tr><td class="label">CustContactFax:</td><td><?= $order_custContactFax ?></td></tr>
<tr><td class="label">BillingAddress1:</td><td><?= $order_billingAddress1 ?></td></tr>
<tr><td class="label">BillingAddress2:</td><td><?= $order_billingAddress2 ?></td></tr>
<tr><td class="label">BillingCity:</td><td><?= $order_billingCity ?></td></tr>
<tr><td class="label">BillingState:</td><td><?= $order_billingState ?></td></tr>
<tr><td class="label">BillingZip:</td><td><?= $order_billingZip ?></td></tr>
<tr><td class="label">OnsiteContactName:</td><td><?= $order_onsiteContactName ?></td></tr>
<tr><td class="label">OnsiteContactPhone:</td><td><?= $order_onsiteContactPhone ?></td></tr>
<tr><td class="label">OnsiteAltContactName:</td><td><?= $order_onsiteAltContactName ?></td></tr>
<tr><td class="label">OnsiteAltContactPhone:</td><td><?= $order_onsiteAltContactPhone ?></td></tr>
<tr><td colspan="2"><table>

<? foreach ($order['items'] as $orderitem) { ?>
<tr><td class="label"><?= $orderitem['description'] ?></td>
    <td><?= $orderitem['qty'] ?> x $<?= $orderitem['cost'] ?> = $<?= ($orderitem['cost'] * $orderitem['qty']) ?></td>
</tr>
<? } ?>

<? if ($verifyMessage) { ?>
  <tr><td class="label">There is a problem with the order: <?= $verifyMessage ?></td></tr>
</table></td></tr>
</table>
Please click the "Back" button to edit your order.

<? } else { ?>
  <tr><td class="label">Total</td><td>$<?= $order['cost'] ?></td></tr>
</table></td></tr>
<tr><td class="label">Note:</td><td><?= $order['note'] ?></td></tr>
</table>
<p />If your order includes more than 5 telephone lines, please email lineorders@YOUR_DOMAIN to inquire about special pricing.

<form method="post" action="processorder.php">
<input type="submit" name="submit" value="Continue to payment form" />
<p>If your order will require manual adjustments, you may click below to place your order on hold for further processing.</p>
<input type="submit" name="submit" value="Place Order on Hold" />
</form>

<? } ?>

<? include("footer.php") ?>
