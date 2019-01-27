<?php
  include("connection.inc.php");
  include("common.inc.php");
  
  include("checkLogin.inc.php");
  
  $eventid = $_REQUEST['eventid'];

  $event = array_shift($db->GetActiveRecords('events', 'id=?', array($eventid)));
  
  $orders = $db->GetActiveRecords('orders', 'event_id=? and deleted=0', array($eventid));
  
  $rs = $db->Execute(
    "SELECT SUM(order_lineitems.quantity) AS itemtotal, services.description as itemdesc"
    . " FROM order_lineitems"
    . " LEFT JOIN orders ON order_lineitems.orderid=orders.id"
    . " LEFT JOIN services ON order_lineitems.serviceid=services.id"
    . " LEFT JOIN events on orders.event_id=events.id"
    . " WHERE events.id=?"
    . " GROUP BY order_lineitems.serviceid"
    . " HAVING itemtotal > 0",
    array($eventid));
  
?><? include("header.php") ?>

<a href="orderlist.php">Return to order listings</a><p />

<h3>Items for event "<?= $event->name ?>"</h3>

<table>
<tr><td class="header">Service item</td>
    <td class="header">Total quantity</td></tr>

<? while (!$rs->EOF) { ?>
<tr><td><?= $rs->fields[1] ?></td>
    <td><?= $rs->fields[0] ?></td></tr>
<? $rs->MoveNext(); } ?>

</table>

<? include("footer.php") ?>
