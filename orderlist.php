<?php

  include("connection.inc.php");
  include("common.inc.php");

  include("checkLogin.inc.php");
  
  $statustypes = $db->GetActiveRecords('statustypes');
  $events = $db->GetActiveRecords('events', 'deleted=0 ORDER BY start_date DESC');
  $categories = $db->GetActiveRecords('service_categories', 'deleted=0');
  $orderyears = $db->GetCol("SELECT y FROM (SELECT DISTINCT YEAR(COALESCE(NULLIF(orders.event_date, '0000-00-00'), events.start_date)) as y FROM orders, events WHERE orders.event_id = events.id AND orders.deleted = 0) t1 WHERE y IS NOT NULL ORDER BY y DESC");
  
  $showstatus = isset($_REQUEST['showstatus']) ? $_REQUEST['showstatus'] : null;
  if ($showstatus) {
  	$_SESSION['last_showstatus'] = $showstatus;
  } else {
  	if (isset($_SESSION['last_showstatus'])) {
  		$showstatus = $_SESSION['last_showstatus'];
  	}
  }
  
  $showevent = isset($_REQUEST['showevent']) ? $_REQUEST['showevent'] : null;
  if ($showevent != null) {
  	$_SESSION['last_showevent'] = $showevent;
  } else {
  	if (isset($_SESSION['last_showevent'])) {
  		$showevent = $_SESSION['last_showevent'];
  	}
  }

  $showcategory = isset($_REQUEST['showcategory']) ? $_REQUEST['showcategory'] : null;
  if ($showcategory != null) {
    $_SESSION['last_showcategory'] = $showcategory;
  } else {
    if (isset($_SESSION['last_showcategory'])) {
      $showcategory = $_SESSION['last_showcategory'];
    }
  }

  $showyear = isset($_REQUEST['showyear']) ? $_REQUEST['showyear'] : null;
  if ($showyear != null) {
    $_SESSION['last_showyear'] = $showyear;
  } else {
    if (isset($_SESSION['last_showyear'])) {
      $showyear = $_SESSION['last_showyear'];
    } else {
      $showyear = 0;
    }
  }

  $queryString = "SELECT orders.id, orders.cust_name, events.name, events.start_date, statustypes.name, orders.event_date"
      . " FROM orders, events, order_status, statustypes"
      . " WHERE orders.event_id=events.id AND orders.id=order_status.orderid AND order_status.status=statustypes.id AND orders.deleted=0";
  $queryVars = array();
  if ($showstatus) {
      $queryString .= " AND (";
      for ($i = 0; $i < count($showstatus); $i += 1) {
      	if ($i > 0) $queryString .= " OR ";
      	$queryString .= "order_status.status=?";
      	$queryVars[] = $showstatus[$i];
      }
      $queryString .= ")";
  }
  if ($showevent && $showevent > 0) {
      $queryString .= " AND orders.event_id=?";
      $queryVars[] = $showevent;
  }

  if ($showcategory) {
    $queryString .= " AND orders.id IN (SELECT DISTINCT(orderid) FROM order_lineitems, services WHERE order_lineitems.serviceid=services.id AND category=?)";
    $queryVars[] = $showcategory;
  }

  if ($showyear) {
    $queryString .= " AND YEAR(COALESCE(NULLIF(orders.event_date, '0000-00-00'), events.start_date)) = ?";
    $queryVars[] = $showyear;
  }

  $queryString .= " ORDER BY COALESCE(NULLIF(orders.event_date, '0000-00-00'), events.start_date) DESC";
  $rs_orders = $db->Execute($queryString, $queryVars) or die($db->ErrorMsg() . "<br>" . $queryString);
  
  ?><? include("header.php") ?>
  
<table><tr>
<td><a href="logout.php">Logout</a></td>
<? if ($userLevel > 1) { ?>
  <td> | </td><td><a href="userlist.php">User List</a></td>
  <td> | </td><td><a href="eventlist.php">Event List</a></td>
  <td> | </td><td><a href="servicelist.php">Services</a></td>
<? } ?>
</tr></table>

<form method="post">
<table border="0">
<tr><td>Show orders that are:</td><td>
<? foreach ($statustypes as $statustype) { ?>
  <input type="checkbox" name="showstatus[]" value="<?= $statustype->id ?>"
    <?= checked_if(!$showstatus || in_array($statustype->id, $showstatus)) ?>><?= $statustype->name ?>
<? } ?>

</td></tr><tr><td>
For event: </td><td><select name="showevent">
  <option value="0">All Events</option>
<? foreach ($events as $event) { ?>
  <option value="<?= $event->id ?>" <?= selected_if($showevent == $event->id) ?>><?= $event->name ?></option>
<? } ?>
</select>
</td></tr>
<tr><td>In Category: </td><td><select name="showcategory">
  <option value="0">All Categories</option>
<? foreach ($categories as $category) { ?>
  <option value="<?= $category->id ?>" <?= selected_if($showcategory == $category->id) ?>><?= $category->description ?></option>
<? } ?></select></td></tr>

<tr><td>For year: </td><td><select name="showyear">
  <option value="0">All</option>
<? foreach ($orderyears as $year) { ?>
  <option <?= selected_if($showyear == $year) ?>><?= $year ?></option>
<? } ?></select></td></tr>

</table>
<input type="submit" value="Filter" />
</form>
<table>
<tr><td class="header">Order</td><td class="header">Customer</td>
    <td class="header">Event</td><td class="header">Due</td>
    <td class="header">Status</td></tr>

<? while(!$rs_orders->EOF) { ?>
      <tr><td><a href="orderdetail.php?orderid=<?= $rs_orders->fields[0] ?>"><?= $rs_orders->fields[0] ?></a></td>
          <td><a href="orderdetail.php?orderid=<?= $rs_orders->fields[0] ?>"><?= htmlspecialchars($rs_orders->fields[1]) ?></a></td>
          <td><?= htmlspecialchars($rs_orders->fields[2]) ?></td><td><?= htmlspecialchars(($rs_orders->fields[3]) ? $rs_orders->fields[3] : $rs_orders->fields[5]) ?></td>
          <td><?= htmlspecialchars($rs_orders->fields[4]) ?></td>
      </tr>
<? $rs_orders->MoveNext(); } ?>
</table>

<? include("footer.php"); ?>
