<?php
  include("connection.inc.php");
  include("common.inc.php");
  
  include("checkLogin.inc.php");
  
  require_userlevel(2);

  $events = $db->GetActiveRecords("events", "start_date is not null AND deleted=0 ORDER BY start_date DESC");
  
?><? include("header.php") ?>

<a href="orderlist.php">Return to order listings</a><p />

<table>
<tr><td class="header">Name</td><td class="header">Start Date</td><td class="header">End Date</td></tr>

<? foreach ($events as $event) { ?>
  <tr><td><a href="eventedit.php?eventid=<?= $event->id ?>"><?= $event->name ?></td>
      <td><?= $event->start_date ?></td>
      <td><?= $event->end_date ?></td>
  </tr>
<? } ?>
</table>

<p />
<h4>Add Event:</h4>
<form method="post" action="eventedit.php">
<input type="hidden" name="action" value="Add" />
<table border="0">
<tr><td align="right">Event name:</td>
    <td><input name="eventname" /></td></tr>
<tr><td align="right">Start date:</td>
    <td><input name="startdate" /></td></tr>
<tr><td align="right">End date:</td>
    <td><input name="enddate" /></td></tr>
</table>
  <input type="submit" value="Add Event" /></td></tr>
</form>

<? include("footer.php") ?>
