<?php
  include("connection.inc.php");
  include("common.inc.php");
  include("checkLogin.inc.php");
  
  require_userlevel(3);
  
  $catid = getReqVar('catid', null);
  $action = getReqVar('action', null);
  
  if (!$catid && ($action != "Add")) {
  	redirectNoError("servicelist.php");
  } elseif ($action) {
    if ($action == "Update") {
    	$db->Execute("UPDATE service_categories SET description=?, recipients=? WHERE id=?",
    	  array($_REQUEST['description'],
    	        $_REQUEST['recipients'],
    	        $catid));
    	redirectNoError("servicelist.php");
    } elseif ($action == "Delete") {
    	$db->Execute("UPDATE service_categories SET deleted=1 WHERE id=?", array($catid));
        redirectNoError("servicelist.php");
    } elseif ($action == "Add") {
    	$db->Execute("INSERT INTO service_categories (description) VALUES (?)",
    	  array($_REQUEST['description']));
        redirectNoError("servicelist.php");
      } elseif ($action == "Cancel") {
        redirectNoError("servicelist.php");
      } else {
        echo "Unknown action";
        die;
      }
  } else {
    $rs = $db->Execute("SELECT description, recipients FROM service_categories WHERE id=?", 
      array($catid));
  }

?><? include("header.php") ?>
<form>
<input type="hidden" name="catid" value="<?= $catid ?>" />
<table>
<tr><td class="label">Description:</td><td><input name="description" size="64" value="<?= $rs->fields[0] ?>" /></td></tr>
<tr><td class="label">Recipients:</td><td><input name="recipients" size="128" value="<?= $rs->fields[1] ?>" /></td></tr>
</table>
<input type="submit" name="action" value="Update" />
<input type="submit" name="action" value="Delete" />
<input type="submit" name="action" value="Cancel" />
</form>
<? include("footer.php") ?>
