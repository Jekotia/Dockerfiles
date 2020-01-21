<?php
ob_start();
session_start();
include("../includes/applicationTop.php");
include_once("admin_templateclass/admin_login_manager.php");
$loginObject			= new adminLoginClass();
$loginManager			= new adminLoginManager();

if(isset($_SESSION['ADMIN_NAME']))
{
	header("location:index.php");
}
$id=base64_decode($_GET['id']);
//echo base64_decode('bWluZHMxMjM=');
if(isset($_POST['submit']))
{
	$loginObject->setPostVar($_POST);
	$funReturnVal	=	$loginManager->checkPostVar($loginObject);
	
	if(count($funReturnVal)==0)
	{
		$loginObject->setUserName($_POST['username']);
		$loginObject->setPassword($_POST['passw']);		
		$error1=$loginManager->do_login($loginObject,$id);
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
}	//end of is isset($_POST)

?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>Login Form</title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
   <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
   <link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
   <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
   <link href="css/style.css" rel="stylesheet" />
   <link href="css/style-responsive.css" rel="stylesheet" />
   <link href="css/style-default.css" rel="stylesheet" id="style_color" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="lock">
    <div class="lock-header">
        <!-- BEGIN LOGO -->
        <!-- <a class="center" id="logo" href="index.php">
            <img class="center" alt="logo" src="img/admin-logo.jpg">
        </a> -->
         
        <!-- END LOGO -->
        <div class="lock-header">
        <!-- BEGIN LOGO -->
        <a class="center" id="logo">
            <!--<img class="center" alt="logo" src="img/logo111.jpg">-->
           <h1 style="font-size: 70.5px;font-weight: bold;"><?php echo $SITE; ?></h1>
        </a>
        <!-- END LOGO -->
    </div>
    </div>
   <form method="post">
    <div class="login-wrap">
    	
        <div class="metro single-size red">
            <div class="locked">
                <i class="icon-lock"></i>
                   <span>Author</span>
            </div>
        </div>
         <div class="metro double-size green">
           
                <div class="input-append lock-input">
                     <input type="text" name="username" class="" placeholder="Username or Email" value="<?php echo $_POST['username']?>">
                </div>
            
        </div>
      
        <div class="metro double-size yellow">
            
                <div class="input-append lock-input">
                    <input type="password" name="passw" class="" placeholder="Password" value="<?php echo $_POST['passw']?>">
                </div>
           
        </div>
        <div class="metro single-size terques login">
           
                <button type="submit" name="submit" class="btn login-btn">
                    Login
                    <i class=" icon-long-arrow-right"></i>
                </button>
           
        </div>
        
        <div class="login-footer">
            <div style="font-size: 18px; margin-left: 30px;font-weight: bold"><?php echo $error;
             if($error1[0])
			 {
			 	echo $error1[0];
			 }
			 ?></div>
            <div class="forgot-hint pull-right" >
                <a id="forget-password" class="" href="forgot_password.php">Forgot Password?</a>
            </div>
        </div>
    </div>
  </form
</body>
<!-- END BODY -->
</html>