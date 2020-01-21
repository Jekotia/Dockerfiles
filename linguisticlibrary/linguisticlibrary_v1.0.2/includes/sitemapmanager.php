<?php

	//$root="../";
	//include($root."includes/applicationTop.php");
	include_once("applicationTop.php");
	class sitemanager
	{
		function select($obj)
		{
			global $db;
			$sql_sel="select * from `hd_site_title` where `id` = '0'";
			$sql_res=$db->select_data($sql_sel);
			return $sql_res;				
		}
	}
	
?>