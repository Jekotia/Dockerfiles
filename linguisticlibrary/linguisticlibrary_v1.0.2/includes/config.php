<?php
//error_reporting(0);
$sel_admin	=	"SELECT * FROM `admin` WHERE `admin_id`='1'";
$res_admin	=	mysql_query($sel_admin);
$admin_mail	= 	@mysql_result($res_admin,0,'admin_email');

$get_websitename = "SELECT `website_name` FROM `graphics` WHERE `id`='1'";
$res_web	     =	mysql_query($get_websitename);
$SITE   	     = 	@mysql_result($res_web,0,'website_name');
 
//$SITE = '';1
//$setting=0;
$setting=1;
if($setting)
{
	//$SITE="Linguistic Library"; 
	$ADMIN_SITE ="Welcome to Linguistic Library";
	$titlename="Welcome to Linguistic Library";
	$project="custom_php_post";
}else
{
    $SITEURL="";
	//$SITE="Linguistic Library"; 
	$ADMIN_SITE ="Welcome to Linguistic Library";
	$titlename="Welcome to Your Linguistic Library";
	$project="custom_php_post";
}
	
	
  define('SCRIPT_FOLDER',$project.'/');	
  define('DIR_WS_HTTP_CATALOG', $project.'/');
  define('HTTP_CATALOG', $project.'/');//'/'
  define('HTTPS_CATALOG', $project.'/');//'/'
 
  define('HTTP_SERVER', 'http://'.$_SERVER['HTTP_HOST']."/"); // eg, http://localhost - should not be empty for productive servers
  define('HTTPS_SERVER', 'https://'.$_SERVER['HTTP_HOST']."/"); // eg, https://localhost - should not be empty for productive servers
  define('ROOT_PATH',HTTP_SERVER.HTTP_CATALOG);
  define('DOMAIN',HTTP_SERVER.HTTP_CATALOG);
  define('DOMAINS',HTTPS_SERVER);
  define('ADMIN_PATH',HTTP_SERVER.'admin/');
  define('SITE_IMAGE_PATH',HTTP_SERVER.HTTP_CATALOG.'img/');
  define('INCLUDE_FOLDER_PATH', 'includes/');
  define('INCLUDE_HTML_FOLDER','html/');
  define('AFFILIATE_PATH',HTTP_SERVER.HTTP_CATALOG);
  
  define('SITENAME',"");
  define('SITE_NAME',"");  
  define('SITEURL',DOMAIN);
  define('CURRANCY',"$");
 
  define("ADMINMAIL",$admin_mail);
  define("EMAIL_LIMIT",10);  // for refer a friend limit
  define('VIDEO_PATH',DOMAIN."video/");
  define('TITLE',"Car Parking");

    $currentPageName		= $_SERVER['PHP_SELF'];
  	$findme   = '/'; 
	$pos 	= strpos($currentPageName, $findme); 

	$CURRENCY ="$";
  
//---- SERVER DOCUMENT ROOT PATH
  $dRoot	= $_SERVER['DOCUMENT_ROOT'].SCRIPT_FOLDER;
 
 
 

 ///////////////////////////////////// end start language setting //////////////////////////////////
// session_start();
 
?>