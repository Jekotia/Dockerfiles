<?php
 ob_start();

	error_reporting (E_ALL ^ E_NOTICE);
	
	$myvar	= explode("/",$_SERVER['PHP_SELF']);
	
	if(in_array("admin",$myvar) || in_array("publisher-admin",$myvar) || in_array("subscriber-admin",$myvar) || in_array("chat",$myvar) )
	{
		$root="../";
	}
	else
	{
		$root="";
	}
	include_once($root."includes/connectdb.php");
	include_once($root."includes/DbSql.inc.php");
	include_once($root."includes/PicSql.inc.php");  
	include_once($root."includes/config.php");
	include_once($root."includes/pager.php");
	include_once($root."includes/general.php");
	include_once($root."includes/mime_mail_rnd.php");
	include_once($root."includes/ImageHadler.php");
///	include($root."includes/language_eng.php");
	$phpEx = substr(strrchr(__FILE__, '.'), 1);
	$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : 'forum/';
	global $cache;
	
	//end file include for facebook
	$db		= new PicSQL($DB_NAME);
	$mail	= new mime_mail_rnd($DB_NAME);
	
	if (!ini_get('register_globals')) 
   {
       $types_to_register = array('GET','POST','COOKIE','SESSION','SERVER');
       foreach ($types_to_register as $type)
       {
           if (@count(${'HTTP_' . $type . '_VARS'}) > 0)
           {
               extract(${'HTTP_' . $type . '_VARS'}, EXTR_OVERWRITE);
           }
       }
   }
   static $view;
   $page_limit=3;
   
   
   
   
?>