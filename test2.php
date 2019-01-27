<?php
include "connection.inc.php";


mysql_select_db($dbname1) or die("Could not open the db '$dbname'");

$test_query = "SHOW TABLES FROM $dbname1";
$result = mysql_query($test_query);

$tblCnt = 0;
while($tbl = mysql_fetch_array($result)) {
  $tblCnt++;
  #echo $tbl[0]."<br />\n";
}

if (!$tblCnt) {
  echo "There are no tables<br />\n";
} else {
  echo "There are $tblCnt tables you punkass<br />\n";
}

