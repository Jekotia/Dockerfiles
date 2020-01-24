<?php
ob_start();
session_start();
include("includes/applicationTop.php");
include("header.php");
$_SESSION['UID']="";
unset($_SESSION['reader']);
unset($_SESSION['author']);
unset($_SESSION['ADMIN_NAME']);
unset($_SESSION['ADMIN_ID']);
 
session_destroy();
echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';
exit;
?>

