<?php
  include("connection.inc.php");
  include("common.inc.php");
  include("checkLogin.inc.php");

  require_userlevel(3);

  $levelnames = array(1 => 'User',
                      2 => 'Order Admin',
                      3 => 'Admin');
  
  $users = $db->GetActiveRecords("users");
?><? include("header.php") ?>

<a href="orderlist.php">Return to order listings</a><p />

<table>
<tr><td class="header">Login</td><td class="header">Level</td></tr>

<? foreach ($users as $user) { ?>
  <tr><td><a href="useredit.php?userid=<?= $user->id ?>"><?= $user->login ?></td>
      <td><?= $levelnames[$user->userlevel] ?></td>
  </tr>
<? } ?>

</table>

<p />
<form method="post" action="useredit.php">
<input type="hidden" name="action" value="Add" />
<input name="username" />
<input type="submit" value="Add User" />
</form>

<? include("footer.php") ?>

