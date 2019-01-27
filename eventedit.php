<?php
  include("connection.inc.php");
  include("common.inc.php");
  include("checkLogin.inc.php");
  
  require_userlevel(3);
  
  $eventid = getReqVar('eventid', null);
  $action = getReqVar('action', null);
  
  if (!$eventid && ($action != "Add")) {
  	redirectNoError("eventlist.php");
  } elseif ($action) {
    if ($action == "Update") {
    	$db->Execute("UPDATE events SET name=?, start_date=?, end_date=? WHERE id=?",
    	  array($_REQUEST['eventname'],
    	        $_REQUEST['startdate'],
    	        $_REQUEST['enddate'],
    	        $eventid));
    	redirectNoError("eventlist.php");
    } elseif ($action == "Delete") {
    	$db->Execute("UPDATE events SET deleted=1 WHERE id=?", array($eventid));
        redirectNoError("eventlist.php");
    } elseif ($action == "Add") {
    	$db->Execute("INSERT INTO events (name, start_date, end_date) VALUES (?, ?, ?)",
    	  array($_REQUEST['eventname'],
    	        $_REQUEST['startdate'],
    	        $_REQUEST['enddate']));
        redirectNoError("eventlist.php");
      } elseif ($action == "Cancel") {
        redirectNoError("eventlist.php");
      } else {
        echo "Unknown action";
        die;
      }
  } else {
    $rs = $db->Execute("SELECT name, start_date, end_date FROM events WHERE id=?", 
      array($eventid));
  }

?><? include("header.php") ?>
<form>
<input type="hidden" name="eventid" value="<?= $eventid ?>" />
<table>
<tr><td class="label">Name:</td><td><input name="eventname" value="<?= $rs->fields[0] ?>" /></td></tr>
<tr><td class="label">Start date:</td><td><input name="startdate" value="<?= $rs->fields[1] ?>" /></td></tr>
<tr><td class="label">End date:</td><td><input name="enddate" value="<?= $rs->fields[2] ?>" /></td></tr>
</table>
<input type="submit" name="action" value="Update" />
<input type="submit" name="action" value="Delete" />
<input type="submit" name="action" value="Cancel" />
</form>

<div>
<p><a href="eventreport.php?eventid=<?= $eventid ?>">Order item report</a> for this event.</p>
<p><a href="eventitemsummary.php?eventid=<?= $eventid ?>">Order item summary</a> for this event.</p>
</div>

<? include("footer.php") ?>
