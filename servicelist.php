<?php
  include("connection.inc.php");
  include("common.inc.php");
  include("checkLogin.inc.php");

  require_userlevel(3);

  $categories = $db->GetActiveRecords("service_categories", "deleted=0");
  $services = $db->GetActiveRecords("services", "deleted=0");
  
  foreach ($categories as $category) {
  	$catdesc[$category->id] = $category->description;
  }
  
  foreach($services as $service) {
  	$svcdesc[$service->id] = $service->description;
  }
  
?><? include("header.php") ?>

<a href="orderlist.php">Return to order listings</a><p />

<div style="margin-top: 40px">
<h3>Categories</h3>
<table border="0">
<tr><td class="header">Description</td><td>Notification Recipients</td></tr>

<? foreach ($categories as $category) { ?>
  <tr><td><a href="categoryedit.php?catid=<?= $category->id ?>"><?= $category->description ?></td>
      <td><?= $category->recipients ?></td>
  </tr>
<? } ?>

</table>

<p />
<form method="post" action="categoryedit.php">
<input type="hidden" name="action" value="Add" />
<input name="description" />
<input type="submit" value="Add Category" />
</form>

</div>

<div style="margin-top: 40px">
<h3>Services</h3>
<table border="0">
<tr><td class="header">Description</td>
    <td class="header">Cost</td>
    <td class="header">Category</td>
    <td class="header">Addon To</td></tr>

<? foreach ($services as $service) { ?>
  <tr><td><a href="serviceedit.php?svcid=<?= $service->id ?>"><?= $service->description ?></a></td>
      <td>$<?= $service->cost ?></td>
      <td><?= $catdesc[$service->category] ?></td>
      <td><?= ($service->addon) ? $svcdesc[$service->addon] : '-None-' ?></td>
  </tr>
<? } ?>

</table>

<p />
<form method="post" action="serviceedit.php">
<input type="hidden" name="action" value="Add" />
<input name="description" />
<input type="submit" value="Add Service" />
</form>

</div>
<? include("footer.php") ?>

