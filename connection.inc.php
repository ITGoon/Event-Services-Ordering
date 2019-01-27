<?php
  if (isset($_SERVER['SERVER_ADDR'])) {
    session_start();
  }
  
  error_reporting(E_ALL);
  
  $adopath = "/usr/share/php/adodb/";
  
  $dbhost1 = "localhost";
  $dbuser1 = "eventservices";
  $dbpass1 = "PASSWORD";
  $dbname1 = "lineorder_production";
  
  //-----------
  
  include($adopath."adodb.inc.php");
  include($adopath."adodb-active-record.inc.php");
  
  $db1 = ADONewConnection('mysql');
  $db1->PConnect($dbhost1, $dbuser1, $dbpass1, $dbname1);
  
  $db = $db1;

  ADOdb_Active_Record::SetDatabaseAdapter($db);
?>
