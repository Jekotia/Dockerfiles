<!-- THIS FILE HAS BEEN MODIFIED FROM THE ORIGINAL SOURCE PROVIDED -->
<?php
$connectionflg = 1;
global $DB_HOST,$DB_USER,$DB_PASS;
if($connectionflg == 1)
	{
       $DB_HOST =  $_ENV["MYSQL_HOST"];
       $DB_USER =  $_ENV["MYSQL_USER"];
       $DB_PASS =  $_ENV["MYSQL_PASSWORD"];
       $DB_NAME =  $_ENV["MYSQL_DATABASE"];
	}
if($connectionflg == 0)
	{
	   $DB_HOST = "localhost";
	   $DB_USER = "root";
	   $DB_PASS = "";
	   $DB_NAME = "custom_php_post";
  }
  $db = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die("No Connection");
  mysql_select_db($DB_NAME,$db) or  die("Error In database");
  mysql_set_charset('utf8', $db);
?>
