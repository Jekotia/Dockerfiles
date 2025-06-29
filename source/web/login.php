<?php
include('header.php');
include_once('includes/applicationTop.php');
include_once("templateclass/login_manager.php");
$loginObject			= new login_class();
$loginManager			= new login_manager();
if(isset($_SESSION['reader'])||isset($_SESSION['author'])||isset($_SESSION['ADMIN_NAME']))
{
	header("location:profile_update.php");
}


if(isset($_POST['login']))
{
	

	$loginObject->setPostVar($_POST);
//  print_r($loginObject);
	$funReturnVal	=	$loginManager->checkPostVar($loginObject);
	 
	if(count($funReturnVal)==0)
	{
		//echo "valid";
		$loginObject->setPostVar($_POST);
		
		
		 $msg=$loginManager->do_login($loginObject);
	}
	else if(count($funReturnVal)>0)
	{
		//echo "welcome";
		//echo count($funReturnVal);
		if(is_array($funReturnVal))
		{
			for($n=0;$n<=count($funReturnVal);$n++)
			{
				  $error.=$funReturnVal[$n];
			}
		}
	}
}	//end of is isset($_POST)	

 if(isset($_POST['logout']))
{
	header('Location: logout.php');
}
?>
<link rel="stylesheet" type="text/css" href="css/style_homepage.css">
<style>
	 
	body{
	margin: 0;
	font-family: Arial;
	font-size: 14px;
	background-color: #fff !important;
	}
	.pro_login {
	color: #333;
	padding-top: 40px;
	}
</style>
</head>
<div class="container">
<div class="main_wrap" style="height:469px;">
<div class="profile_title">Login</div>
		
		<form method="post" name="login" id="login" >
			<table class="pro_login" align="center">
				<tr><td><b>Email</b></td><td><input type="text" id="logemail" name="logemail" placeholder="Email"></td></tr>
				<tr><td><b>Password</b></td><td><input type="password"  name="logpwd" placeholder="Password"></td></tr>
				<tr><td><b>
					
					<?php
				 
				  
				  echo $error;
				 
				 if($msg[0])
				 {
				  echo $msg[0];
				 }
				 ?>
				 </b></td></tr>
				 <tr><td colspan="2"><input type="submit" id="login" name="login" value="login" style="margin-left: 311px;">
				 <input type="reset" value="Clear"/></td></tr>
				
			</table>
		</form>

</div>
</div>	

<?php 
include('footer.php');
?>