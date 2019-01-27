<?php
  include("connection.inc.php");
  include("common.inc.php");
  
  include("checkLogin.inc.php");
  require_userlevel(2);
  
  $orderid = $_REQUEST['orderid'];
  
?><? include("header.php") ?>

<p />Add a discount or additional fee.  For discounts enter a negative monetary amount.

<form method="post" action="processCostChange.php">
<input type="hidden" name="orderid" value="<?= $orderid ?>" />
<table>
<tr><td class="label">Amount:</td><td><input name="amount" /></td></tr>
<tr><td class="label">Note:</td><td><input name="note" /></td></tr>
</table>
<input type="submit" value="Add" /> <input type="button" value="Cancel" onClick="window.location='orderdetail.php?orderid=<?= $orderid ?>'" />
</form>

<? include("footer.php") ?>
