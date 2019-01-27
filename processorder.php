<?php
  include("connection.inc.php");
  include("common.inc.php");
  include("simlib.php");
  
  if (isset($_SESSION['S_order'])) {
    $order = $_SESSION['S_order'];
  } else {
    $order = array();
  }

  if (!$order['eventid']) {
    die('No event id provided');
  }

  $db->Execute("INSERT INTO orders "
             . " (cust_name, cust_contact_name,"
             . "  cust_contact_phone, cust_contact_email,"
             . "  cust_contact_fax, billing_address1,"
             . "  billing_address2, billing_city,"
             . "  billing_state, billing_zip,"
             . "  onsite_contact_name, onsite_contact_phone,"
             . "  onsite_altcontact_name, onsite_altcontact_phone,"
             . "  event_id, event_name, event_date)"
             . "  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
    array($order['customerName'],
          $order['custContactName'],
          $order['custContactPhone'],
          $order['custContactEmail'],
          $order['custContactFax'],
          $order['billingAddress1'],
          $order['billingAddress2'],
          $order['billingCity'],
          $order['billingState'],
          $order['billingZip'],
          $order['onsiteContactName'],
          $order['onsiteContactPhone'],
          $order['onsiteAltContactName'],
          $order['onsiteAltContactPhone'],
          $order['eventid'],
          $order['eventName'],
          $order['eventDate']));

  $orderid = $db->Insert_ID();

  unset($_SESSION['S_order']);

  $usedcategories = array();
  
  foreach ($order['items'] as $item) {
  	$db->Execute("INSERT INTO order_lineitems (orderid, serviceid, quantity, cost) VALUES (?, ?, ?, ?)", 
  	  array($orderid, $item['id'], $item['qty'], $item['cost']));
  	$usedcategories[$item['category']] = 1;
  }
  
  if ($order['note']) {
  	$db->Execute("INSERT INTO order_notes (order_id, note, created_by) VALUES (?, ?, 0)",
  	             array($orderid, $order['note']));
  }
  
  $db->Execute("INSERT INTO order_status (orderid, status, modified_by, modified_at)  VALUES (?, 1, 0, now())",
               array($orderid));

  $categories = $db->GetActiveRecords('service_categories');
  foreach ($categories as $category) {
  	if (isset($usedcategories[$category->id]) && $category->recipients) {
  		$catrecips = preg_split('/\s+/', $category->recipients);
  		foreach ($catrecips as $recip) {
  			mail ($recip, 
  			      'New '.$category->description.' order ('.$orderid.')',
  			      'A new '.$category->description.' order (number '.$orderid.') has been '
                  . 'entered at http://YOUR_DOMAIN/eventservices/login.php',
  			      'From: lineorders@YOUR_DOMAIN',
			      '-f lineorders@YOUR_DOMAIN');
  		}
  	}
  }

  $namearr = explode(" ", $order['custContactName'], 2);
  $firstname = array_shift($namearr);
  $lastname = array_shift($namearr);
               
?><? include("header.php") ?>

<? if ($_POST['submit'] == 'Place Order on Hold') { ?>
<p>Your order has been placed on hold.  You will be contacted at the number you have provided to complete your order.</p>
<? } else { ?>

<p>Preparing payment form...</p>
<form name="paymentForm" id="paymentForm" method="post" action="Authorize.net Transaction Gateway URL">
 <? InsertFP("KEY1", "KEY2", $order['cost'], mt_rand(1, 1000)) ?>
 <input type="hidden" name="x_login" value="KEY1" />
 <input type="hidden" name="x_amount" value="<?= $order['cost'] ?>" />
 <input type="hidden" name="x_show_form" value="PAYMENT_FORM" />
 <input type="hidden" name="x_test_request" value="FALSE" />
 <input type="hidden" name="x_type" value="AUTH_ONLY" />

 <input type="hidden" name="x_first_name" value="<?= $firstname ?>" />
 <input type="hidden" name="x_last_name" value="<?= $lastname ?>" />

 <input type="hidden" name="x_address" value="<?= $order['billingAddress1'] ?>" />
 <input type="hidden" name="x_city" value="<?= $order['billingCity'] ?>" />
 <input type="hidden" name="x_state" value="<?= $order['billingState'] ?>" />
 <input type="hidden" name="x_zip" value="<?= $order['billingZip'] ?>" />
 <input type="hidden" name="x_country" value="US" />
 <input type="hidden" name="x_phone" value="<?= $order['custContactPhone'] ?>" />
 <input type="hidden" name="x_email" value="<?= $order['custContactEmail'] ?>" />

 <input type="hidden" name="x_logo_url" value="YOUR LOGO URL" />
 <input type="hidden" name="x_header_html_payment_form" value="<h3>Event Orders</h3><p />Please disregard the Shipping information fields in the form below as we will not be shipping any physical products." />
 <input type="hidden" name="x_relay_response" value="TRUE" />
 <input type="hidden" name="x_relay_url" value="http://YOUR_DOMAIN_HERE/eventservices/completeOrder.php" />
 <!--
 <input type="hidden" name="x_receipt_link_method" value="GET" />
 <input type="hidden" name="x_receipt_link_text" value="Place another order" />
 <input type="hidden" name="x_receipt_link_url" value="http://YOUR_DOMAIN_HERE/eventservices/placeorder.php" />
 -->
 <input type="hidden" name="x_invoice_num" value="<?= $orderid ?>" />
 
 <input type="submit" name="frm_submit" id="frm_submit" />
</form>

<script type="text/javascript">
document.getElementById('frm_submit').disabled = true;
document.getElementById('paymentForm').submit();
</script>

<? } ?>

<? include("footer.php") ?>

