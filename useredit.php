<?php
  include("connection.inc.php");
  include("common.inc.php");
  include("checkLogin.inc.php");
  
  require_userlevel(3);
  
  $moduserid = getReqVar('userid', null);
  $action = getReqVar('action', null);
  
  if (!$moduserid && ($action != "Add")) {
  	redirectNoError("userlist.php");
  } elseif ($action) {
    if ($action == "Update") {
    	$db->Execute("UPDATE users SET login=?, userlevel=? WHERE id=?",
    	  array($_REQUEST['username'], $_REQUEST['usertype'], $moduserid));
    	if (strlen($_REQUEST['password']) > 0) {
    		$db->Execute("UPDATE users SET password=PASSWORD(?) WHERE id=?",
    		  array($_REQUEST['password'], $moduserid));
    	}
    	redirectNoError("userlist.php");
    } elseif ($action == "Delete") {
    	$db->Execute("DELETE FROM users WHERE id=?", array($moduserid));
        redirectNoError("userlist.php");
    } elseif ($action == "Add") {
    	$db->Execute("INSERT INTO users (login) VALUES (?)", 
    	  array($_REQUEST['username']));
    	$newuserid = $db->Insert_ID();
        redirectNoError("useredit.php?userid=$newuserid");
      } elseif ($action == "Cancel") {
        redirectNoError("userlist.php");
      } else {
        echo "Unknown action";
        die;
      }
  } else {
    $rs = $db->Execute("SELECT login, userlevel FROM users WHERE id=?", 
      array($moduserid));
  }

?><? include("header.php") ?>
<form>
<input type="hidden" name="userid" value="<?= $moduserid ?>" />
<table>
<tr><td class="label">Login:</td><td><input name="username" value="<?= $rs->fields[0] ?>" /></td></tr>
<tr><td class="label">Password:</td><td><input type="password" name="password" /></td></tr>
<tr><td class="label">Type:</td><td><select name="usertype">
  <option value="1" <?= selected_if($rs->fields[1] == 1) ?>>User</option>
  <option value="2" <?= selected_if($rs->fields[1] == 2) ?>>Order Admin</option>
  <option value="3" <?= selected_if($rs->fields[1] == 3) ?>>Admin</option>
</select>
</td></tr>
</table>
<input type="submit" name="action" value="Update" />
<input type="submit" name="action" value="Delete" />
<input type="submit" name="action" value="Cancel" />
</form>
<? include("footer.php") ?>
  
