<?php
// Developer Name  : Atul
// Date Modified   : 28-02-2015 
// Database Connection
include("../includes/connectdb.php");
// Fetch Record from Database
$output			= "";
$sql 			= mysql_query("SELECT * FROM tbl_dictionary");
$columns_total 	= mysql_num_fields($sql);
// Get File Pointer
$fp = fopen("myFile.csv","w"); 
// Get The Field Name
$field_arr = array();
for ($i = 1; $i < $columns_total; $i++) {
	 $heading	=	mysql_field_name($sql, $i);
	 $field_arr[]=$heading;
}
fputcsv($fp, $field_arr,"@");
unset($field_arr);
// Get Records from the table
while ($row = mysql_fetch_array($sql)) {
	for ($i = 1; $i < $columns_total; $i++) {
		$field_arr[]=$row[$i];
    }
	fputcsv($fp, $field_arr,"@");
	unset($field_arr);
}
fclose($fp);
header("Location:myFile.csv");
exit;
?>