<?php
  include("connection.inc.php");
  include($adopath."toexport.inc.php");
  include("common.inc.php");
  
  include("checkLogin.inc.php");
  
  $eventid = $_REQUEST['eventid'];

  $event = array_shift($db->GetActiveRecords('events', 'id=?', array($eventid)));
  
  $orders = $db->GetActiveRecords('orders', 'event_id=? and deleted=0', array($eventid));
  
  $rs = $db->Execute(
    "SELECT li.orderid as orderid, od.cust_name as customer, sv.description as service, li.quantity as quantity, od.location as location, stat.name as status, sc.description as category"
    . " FROM order_lineitems li"
    . " LEFT JOIN orders od ON li.orderid=od.id"
    . " LEFT JOIN services sv ON li.serviceid=sv.id"
    . " LEFT JOIN order_status ON od.id=order_status.orderid"
    . " LEFT JOIN statustypes stat ON order_status.status=stat.id"
    . " LEFT JOIN service_categories sc ON sv.category=sc.id"
    . " WHERE od.event_id=?",
    array($eventid)) or die ($db->ErrorMsg());
    
    if (isset($_REQUEST['format']) && $_REQUEST['format'] == 'csv') {
      // Output CSV file instead
	  header('Content-Type: text/comma-separated-values');
	  header('Content-Disposition: attachment; filename=eventreport'.$eventid.'.csv');
	  print rs2csv($rs);
	  exit;
    }
    
    // Otherwise proceed with HTML report
  
?><? include("header.php") ?>

<a href="orderlist.php">Return to order listings</a><p />

<h3>Orders for event "<?= $event->name ?>"</h3>

<table>
<tr><td class="header">Order ID</td>
    <td class="header">Customer</td>
    <td class="header">Service</td>
    <td class="header">Quantity</td>
    <td class="header">Location</td>
    <td class="header">Status</td>
    <td class="header">Category</td>
</tr>

<? while (!$rs->EOF) { ?>
<tr><td><a href="orderdetail.php?orderid=<?= $rs->fields[0] ?>"><?= $rs->fields[0] ?></a></td>
    <td><?= $rs->fields[1] ?></td>
    <td><?= $rs->fields[2] ?></td>
    <td><?= $rs->fields[3] ?></td>
    <td><?= nl2br($rs->fields[4]) ?></td>
    <td><?= $rs->fields[5] ?></td>
    <td><?= $rs->fields[6] ?></td>
</tr>
<? $rs->MoveNext(); } ?>

</table>

<p><a href="eventreport.php?eventid=<?= $eventid ?>&format=csv">Download as CSV</a></p>

<? include("footer.php"); ?>
