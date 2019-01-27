<?php

function verifyOrder($order) {
	$errmsg = "";
	foreach ($order['items'] as $item) {
		$addons = 0;
		$hasParent = true;
		if ($item['addon']) { $hasParent = false; }
		foreach ($order['items'] as $item2) {
			if ($item2['addon'] == $item['id'])	 {
				$addons += $item2['qty'];
			}
			if ($item['addon'] == $item2['id']) {
				$hasParent = true;
			}
		}
		if (!$hasParent) {
			$errmsg .= 'Item "' . $item['description'] . '" depends on another item that was not selected.<br />';
		}
		if ($addons > $item['qty']) {
			$errmsg .= 'Item "' . $item['description'] . '" has too many dependent items chosen.<br />';
		}
	}
	return $errmsg;
}

function redirectWithError($nextPage, $errorMsg) {
	// if nextPage has a query delimiter already, don't add another.
	if (strpos($nextPage, "?") > 0) {
		header("Location: $nextPage&errorMsg=".urlencode($errorMsg));
	} else {
		header("Location: $nextPage?errorMsg=".urlencode($errorMsg));
	}
	exit;
}

function redirectNoError($nextPage) {
	header("Location: $nextPage");
	exit;
}

function checked_if($boolVal) {
	if ($boolVal) {
		return 'checked="checked"';
	} else {
		return '';
	}
}

function selected_if($boolVal) {
	if ($boolVal) {
		return 'selected="selected"';
	} else {
		return '';
	}
}

function getReqVar($reqvar, $defval) {
	if (isset($_REQUEST[$reqvar])) {
		return $_REQUEST[$reqvar];
	} else {
		return $defval;
	}
}

function require_userlevel($level) {
	global $userLevel;
	if ($userLevel < $level) {
		echo "<p>You do not have sufficient permissions to access this page.</p>";
		echo "<p><a href=\"orderlist.php\">Return to order list</a></p>";
		die;
	}
}
/*
        public String verifyOrder() {
                for (int i = 0; i < items.size(); i++) {
                        ArrayList<Integer> addonIDs = new ArrayList<Integer>();
                        OrderItem item = items.get(i);
                        int addons = 0;
                        for (int j = 0; j < items.size(); j++) {
                                OrderItem item2 = items.get(j);
                                if (item2.addon == item.serviceid) {
                                        addons += item2.quantity;
                                        addonIDs.add(item2.serviceid);
                                }
                        }
                        if (addons > item.quantity) {
                                StringBuilder sb = new StringBuilder();
                                sb.append ("Quantity of ");
                                for (int j = 0; j < addonIDs.size(); j++) {
                                        sb.append("\"" + addonIDs.get(j) + "\"");
                                        if (j < addonIDs.size() - 1) {
                                                sb.append(" + ");
                                        }
                                }
                                sb.append(" can not be greater than quantity of ");
                                sb.append("\"" + item.serviceid + "\"");
                                return sb.toString();
                        }
                }
                return null;
        }
*/
?>