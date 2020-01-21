<?php
ob_start();
session_start();
include("includes/applicationTop.php");
include("header.php");

$_SESSION['ADMIN_NAME']="";
$_SESSION['ADMIN_ID']="";

header("Location:admin_login.php");
session_destroy();
session_unset();
echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';
exit;
?>

