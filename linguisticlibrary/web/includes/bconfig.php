<?php
include("sitemapmanager.php");
//error_reporting(0);

$sitemanager	=	new	sitemanager();
$res=$sitemanager->select($obj);
$title=$res[0]['title'];
$keyword=$res[0]['keyword'];
$desc=$res[0]['description'];

echo $title;

$setting=0;
if($setting)
{
	//---query------
	$SITEURL="";
	$SITE="DVD Trader"; 
	$ADMIN_SITE = "DVD Trader";
	$titlename="Welcome to dvdtrader.com";
	$project="/dvdtrader/";
}else
{
	$SITE="DVD Trader"; 
	$titlename="Welcome to dvdtrader.com";
	$project="dvdtrader"; 
	$ADMIN_SITE ="Welcome to dvdtrader.com";
}
	
	
	

  define('SCRIPT_FOLDER',$project.'/');	
  define('DIR_WS_HTTP_CATALOG', $project.'/');
  define('HTTP_CATALOG', $project.'/');
  define('HTTPS_CATALOG', $project.'/');
 
  define('HTTP_SERVER', 'http://'.$_SERVER['HTTP_HOST']."/"); // eg, http://localhost - should not be empty for productive servers
  //define('HTTPS_SERVER', 'https://'.$_SERVER['HTTP_HOST']); // eg, https://localhost - should not be empty for productive servers
  define('ROOT_PATH',HTTP_SERVER.HTTP_CATALOG);

  define('DOMAIN',HTTP_SERVER.HTTP_CATALOG);
  define('ADMIN_PATH',HTTP_SERVER.HTTP_CATALOG.'admin/');
  define('INCLUDE_FOLDER_PATH', 'includes/');
  define('INCLUDE_HTML_FOLDER','html/');
  define('SITE_IMAGE_PATH',DOMAIN."images/");
  define('CSS_PATH',"images/");
  define('IMAGE_PATH',"images/");	
  define('SITENAME',"dvdtrader.com");
  define('SITE_NAME',"dvdtrader");  
  define('SITEURL',DOMAIN);
  define('CURRANCY',"$");
  define("ADMINMAIL","webminds.team@gmail.com"); 
  define("EMAIL_LIMIT",10);  // for refer a friend limit
  define('VIDEO_PATH',DOMAIN."video/");


    $currentPageName		= $_SERVER['PHP_SELF'];
  	$findme   = '/admin/'; 
	$pos 	= strpos($currentPageName, $findme); 

	$CURRENCY ="$";
  
//---- SERVER DOCUMENT ROOT PATH
  $dRoot	= $_SERVER['DOCUMENT_ROOT'].SCRIPT_FOLDER;
 
 
 

 ///////////////////////////////////// end start language setting //////////////////////////////////
// session_start();  
 
?>