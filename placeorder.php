<?php
  include("connection.inc.php");
  
  $userid = 0;
  if (isset($_SESSION['userid'])) {
  	$userid = $_SESSION['userid'];
  }

  $categories = $db->GetActiveRecords('service_categories', 'deleted=0');
  $services = $db->GetActiveRecords('services', 'deleted=0');
  $events = $db->GetActiveRecords('events', '(start_date > NOW() OR start_date is null) AND deleted=0 ORDER BY start_date');
  
?><? include("header.php"); ?>

<script type="text/javascript">
  function verifyForm(frm) {
    if (frm['eventid'].value == 0) {
      alert('You must select an event, or select "unlisted event" and enter the event name and date');
      return false;
    }
    return true;
  }
</script>

<h2>Use this form to place orders for phone service for the specified event.</h2>

<? if (isset($_REQUEST['errorMsg'])) { ?>
<p class="message"><?= $_REQUEST['errorMsg'] ?></p>
<? } ?>

<form action="verifyorder.php" method="post" onsubmit="return verifyForm(this)">
<table border="1">
<tr><td colspan="2" class="header">Event Info</td></tr>
<tr><td class="label">Event:</td>
<td class="input"><select name="eventid" onChange="showUnlisted(this, 'unlistedevents')">
  <option value="0"></option>
  <? foreach ($events as $event) { ?>
    <option value="<?= $event->id ?>"><?= $event->name ?> [<?= ($event->start_date) ? $event->start_date : "specify below" ?>]</option>
  <? } ?>
  </select>
</td></tr>
<tr><td class="label">Customer Name:</td>
  <td class="input"><input name="customerName" size="40" /></td></tr>
<tr><td class="layout" colspan="2">
<div style="display: none" id="unlistedevents">
<table>
<tr><td class="label">Event Name for Unlisted Events:</td>
  <td class="input"><input name="eventName" size="40" /></td></tr>
<tr><td class="label">Event Date for Unlisted Events:</td>
  <td class="input"><input name="eventDate" size="20" /></td></tr>
</table>
</div>
</td></tr>

<? foreach ($categories as $category) { ?>
<tr><td class="header" colspan="2"><?= $category->description ?></td></tr>
<tr><td class="input" colspan="2"><table>
    <tr><td class="header">Service Type</td>
        <td class="header">Cost</td>
        <td class="header">Quantity</td>
    </tr>
<?   foreach ($services as $service) {
  	   if ($service->category == $category->id) { 
?>
    <tr><td class="label"><?= $service->description ?></td>
        <td class="label">$<?= $service->cost ?></td>
        <td class="input"><input name="qty<?= $service->id ?>" size="4" /></td></tr>
  		
<?     }
     } 
?>
  </table></td></tr>
<? } ?>

<tr><td colspan="2" class="header">Customer Information</td></tr>
<tr><td class="label">Contact name:</td>
  <td class="input"><input name="custContactName" size="40" /></td></tr>
<tr><td class="label">Contact phone:</td>
  <td class="input"><input name="custContactPhone" /></td></tr>
<tr><td class="label">Contact email:</td>
  <td class="input"><input name="custContactEmail" size="40" /></td></tr>
<tr><td class="label">Contact fax:</td>
  <td class="input"><input name="custContactFax" /></td></tr>

<tr><td colspan="2" class="header">Billing Information</td></tr>
<tr><td class="label">Address:</td>
  <td class="input"><input name="billingAddress1" size="40" /></td></tr>
<tr><td class="label">Address (line 2):</td>
  <td class="input"><input name="billingAddress2" size="40" /></td></tr>
<tr><td class="label">City:</td>
  <td class="input"><input name="billingCity" size="40" /></td></tr>
<tr><td class="label">State:</td>
  <td class="input"><input name="billingState" size="4" /></td></tr>
<tr><td class="label">Zip:</td>
  <td class="input"><input name="billingZip" size="10" /></td></tr>

<tr><td class="header" colspan="2">Onsite Contacts</td></tr>
<tr><td class="label">Onsite contact name:</td>
  <td class="input"><input name="onsiteContactName" size="40" /></td></tr>
<tr><td class="label">Onsite contact phone:</td>
  <td class="input"><input name="onsiteContactPhone" size="20" /></td></tr>
<tr><td class="label">Alternative contact name:</td>
  <td class="input"><input name="onsiteAltContactName" size="40" /></td></tr>
<tr><td class="label">Alternative contact phone:</td>
  <td class="input"><input name="onsiteAltContactPhone" size="20" /></td></tr>

<tr><td class="header" colspan="2">Notes</td></tr>
<tr><td class="label">Note</td>
  <td class="input"><textarea name="note" rows="5" cols="30"></textarea></td></tr>
</table>
<input type="submit" value="Continue" />
</form>

<br />
<hr />
<p>To complete a pending order, enter your order number below then click the "Process Payment" button.</p>
<form method="get" action="processPendingOrder.php">
<input type="text" name="orderid" size="4" />
<input type="submit" value="Process Payment" />
</form>

<br />
<hr />
<font size="small"><a href="login.php">login</a> for order management</font>

<? include("footer.php"); ?>
