<? include("header.php"); ?>
<? if (isset($_REQUEST['errorMsg'])) { ?>
    <p class="message"><?= $_REQUEST['errorMsg'] ?></p>
<? } ?>

<form action="processLogin.php" method="post">
<table>
<tr><td align="right">Username: </td>
    <td align="left"><input name="username" /></td></tr>
<tr><td align="right">Password: </td>
    <td align="left"><input type="password" name="password" /></td></tr>
</table>
<input type="submit" value="Login" />
</form>

<hr />
<a href="placeorder.php">Order Placement</a>

<? include("footer.php") ?>
