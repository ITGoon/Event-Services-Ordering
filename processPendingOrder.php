<?php
  include("connection.inc.php");
  include("common.inc.php");
  include("simlib.php");
  
  $orderid = $_REQUEST['orderid'];
  $order = array_shift($db->GetActiveRecords('orders', 'id=?', array($orderid)));

  $cost = $db->GetOne("SELECT SUM(quantity * cost) FROM order_lineitems WHERE orderid=?", array($orderid));
  $adjust = $db->GetOne("SELECT SUM(amount) FROM order_altercost WHERE orderid=?", array($orderid));
  $ordertotal = $cost + $adjust;

  $namearr = explode(" ", $order->cust_contact_name, 2);
  $firstname = array_shift($namearr);
  $lastname = array_shift($namearr);
  
?><? include("header.php") ?>

<? if ($order->trans_id) { ?>
<p>This order has already been processed for payment.</p>
<p><a href="placeorder.php">Return to order placement page</a></p>
<? } else { ?>
<p>Preparing payment form...</p>
<form name="paymentForm" id="paymentForm" method="post" action="Authorize.net Transaction Gateway URL">
 <? InsertFP("KEY1", "KEY2", $ordertotal, mt_rand(1, 1000)) ?>
 <input type="hidden" name="x_login" value="KEY1" />
 <input type="hidden" name="x_amount" value="<?= $ordertotal ?>" />
 <input type="hidden" name="x_show_form" value="PAYMENT_FORM" />
 <input type="hidden" name="x_test_request" value="FALSE" />
 <input type="hidden" name="x_type" value="AUTH_ONLY" />

 <input type="hidden" name="x_first_name" value="<?= $firstname ?>" />
 <input type="hidden" name="x_last_name" value="<?= $lastname ?>" />
 <input type="hidden" name="x_address" value="<?= $order->billing_address1 ?>" />
 <input type="hidden" name="x_city" value="<?= $order->billing_city ?>" />
 <input type="hidden" name="x_state" value="<?= $order->billing_state ?>" />
 <input type="hidden" name="x_zip" value="<?= $order->billing_zip ?>" />
 <input type="hidden" name="x_country" value="US" />
 <input type="hidden" name="x_phone" value="<?= $order->cust_contact_phone ?>" />
 <input type="hidden" name="x_email" value="<?= $order->cust_contact_email ?>" />

 <input type="hidden" name="x_logo_url" value="YOUR LOGO URL" />
 <input type="hidden" name="x_header_html_payment_form" value="<h3>Event Orders</h3><p />Please disregard the Shipping information fields in the form below as we will not be shipping any physical products." />
 <input type="hidden" name="x_relay_response" value="TRUE" />
 <input type="hidden" name="x_relay_url" value="http://YOUR_DOMAIN_HERE/eventservices/completeOrder.php" />
 <input type="hidden" name="x_invoice_num" value="<?= $orderid ?>" />
 
 <input type="submit" name="frm_submit" id="frm_submit" />
</form>

<script type="text/javascript">
document.getElementById('frm_submit').disabled = true;
document.getElementById('paymentForm').submit();
</script>

<? } ?>

<? include("footer.php") ?>

