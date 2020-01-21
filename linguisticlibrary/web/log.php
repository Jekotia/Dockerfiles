<?php
@ob_start();
@session_start();
include("includes/applicationTop.php");
include_once("templateclass/login_manager.php");
$loginObject			= new login_class();
$loginManager			= new login_manager();

if(isset($_POST['login']))
{
	 $loginObject->setPostVar($_POST);
    $funReturnVal	=	$loginManager->checkPostVar($loginObject);
	 
	if(count($funReturnVal)==0)
	{
		$loginObject->setUserName($_POST['logemail']);
		$loginObject->setPassword($_POST['logpwd']);
		
		$loginManager->do_login($loginObject);
	}
	else if(count($funReturnVal)>0)
	{
		if(is_array($funReturnVal))
		{
			for($n=0;$n<=count($funReturnVal);$n++)
			{
				$error.=$funReturnVal[$n];
			
			}
		}
	}
}

if(isset($_POST['logout']))
{
	header('Location: logout.php');
}

?>