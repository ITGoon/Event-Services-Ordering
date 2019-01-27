<?php
  include("connection.inc.php");
  include("common.inc.php");
  include("checkLogin.inc.php");
  
  require_userlevel(3);
  
  $svcid = getReqVar('svcid', null);
  $action = getReqVar('action', null);
  
  if (!$svcid && ($action != "Add")) {
  	redirectNoError("servicelist.php");
  } elseif ($action) {
    if ($action == "Update") {
    	$db->Execute("UPDATE services SET description=?, cost=?, category=?, addon=? WHERE id=?",
    	  array($_REQUEST['description'], 
    	        $_REQUEST['cost'],
    	        $_REQUEST['category'],
    	        $_REQUEST['addon'], 
    	        $svcid));
    	redirectNoError("servicelist.php");
    } elseif ($action == "Delete") {
    	$db->Execute("UPDATE services SET deleted=1 WHERE id=?", array($svcid));
        redirectNoError("servicelist.php");
    } elseif ($action == "Add") {
    	$db->Execute("INSERT INTO services (description) VALUES (?)", 
    	  array($_REQUEST['description']));
    	$newsvcid = $db->Insert_ID();
        redirectNoError("serviceedit.php?svcid=$newsvcid");
      } elseif ($action == "Cancel") {
        redirectNoError("servicelist.php");
      } else {
        echo "Unknown action";
        die;
      }
  } else {
    $rs_catdesc = $db->Execute("SELECT description, id FROM service_categories WHERE deleted=0");
    $rs_svcdesc = $db->Execute("SELECT description, id FROM services WHERE deleted=0");
    
    $rs = $db->Execute("SELECT description, cost, category, addon FROM services WHERE id=?", 
      array($svcid));
  }

?><? include("header.php") ?>
<form>
<input type="hidden" name="svcid" value="<?= $svcid ?>" />
<table>
<tr><td class="label">Description:</td><td><input name="description" size="50" value="<?= $rs->fields[0] ?>" /></td></tr>
<tr><td class="label">Cost:</td><td><input name="cost" size="10" value="<?= $rs->fields[1] ?>" /></td></tr>
<tr><td class="label">Category:</td><td><?= $rs_catdesc->GetMenu2('category', $rs->fields[2]) ?></td></tr>
<tr><td class="label">Addon To:</td><td><?= $rs_svcdesc->GetMenu2('addon', $rs->fields[3]) ?></td></tr>
</table>
<input type="submit" name="action" value="Update" />
<input type="submit" name="action" value="Delete" />
<input type="submit" name="action" value="Cancel" />
</form>
<? include("footer.php") ?>
  
