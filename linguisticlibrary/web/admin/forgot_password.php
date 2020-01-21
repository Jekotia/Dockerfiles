<?php
ob_start();
session_start();
$root="../";
include($root."includes/applicationTop.php");
if(isset($_POST['submit']))
{  
	$admin_email=$_POST['admin_email'];
	$errors=array();
	if($admin_email=="")
	{
		$error[1]="Email should not be blank";
	}
	else if(!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is',$admin_email)) 
	{    
		$error[1]="Email should be in valid format";
	}
	else if($admin_email!='')
	{
		$sql_select = "SELECT * FROM `admin` where admin_email = '$admin_email'";
		$res_select = $db->select_data($sql_select);
		if(count($res_select) == 0)
		{
			$error[1]="Email address does not exists";
		}
	}
	if(count($error)==0)
	{
				$sql_select = "SELECT * FROM `admin` where admin_email='$admin_email'";
				$res_select = $db->select_data($sql_select);
				$admin_name =stripslashes($res_select[0]['admin_name']);
				$description= $SITEURL."admin_login.php";
				$user_name=$admin_name;
				$password = $res_select[0]['admin_password'];
				$uid=$res_select[0]['admin_id'];
				$admin_email = getTypeName('admin','admin_id','admin_email',$uid); 
				$to=$admin_email;
				$admin_cc_mail =ADMINMAIL;						 
				$subject ="Forgot Password Mail";
				$headers  = "MIME-Version: 1.0\r\n"; 
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
				$from = ADMINMAIL;
				$headers .= "From: $from";
				$mailmatter ='
			 	<table align="left" border="0" cellpadding="0" cellspacing="0">
 				<tr><td><b>Dear '.ucwords($user_name).',</b></td></tr>
 				<tr><td>&nbsp;&nbsp;</td></tr>
 				<tr><td>&nbsp;&nbsp;</td></tr>
 				<tr><td>Your login details are : </td><tr>
 				<tr><td>&nbsp;&nbsp;</td></tr>
				<tr><td><b>Username : </b>'.$user_name.'</td></tr>
				<tr><td><b>Password : </b>'.base64_decode($password).'</td></tr>
				<tr><td>&nbsp;&nbsp;</td></tr>
				<tr><td>For login , Please <a href="'.stripslashes($description).'">Click Here</a>.</td></tr>
				<tr><td>&nbsp;&nbsp;</td></tr>
				<tr><td>&nbsp;&nbsp;</td></tr>
            	<tr><td><b>Regards,</b></td></tr>
            	<tr><td>&nbsp;&nbsp;</td></tr>
            	<tr><td>&nbsp;&nbsp;</td></tr>
				<tr><td><a href="'.stripslashes($description).'">Data Collection Team</a></td></tr>
                </td></tr>
                </table>';						
				$message=$mailmatter;				
				@mail($to,$subject,$message,$headers); 
				$msg ="Please check your email.<br> We have sent you an email with your password." ;	
	}
}	
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
        <a class="center" id="logo" href="index.php">
            <!--<img class="center" alt="logo" src="img/logo.png">-->
            <h1 style="font-size: 70.5px;font-weight: bold;">Fundi.com</h1>
        </a>
        <!-- END LOGO -->
    </div>
   <form method="post">
   	<div class="forgot_error"><label><?php echo $msg; ?></label></div>
    <div class="login-wrap">
        <div class="metro double-size red">
            <div class="locked lock-forgot">
                <i class="icon-lock"></i>
                <span>Forgot Password</span>
            </div>
        </div>
        <div class="metro double-size green">
           
                <div class="input-append lock-input">
                    <input type="text" name="admin_email" class="" placeholder="Email Address" value="<?php echo $_POST['admin_email']?>">
                </div>
            
        </div>
       
        <div class="metro double-size terques login">
                <button type="submit" name="submit" class="btn login-btn">
                    Submit
                    <i class=" icon-long-arrow-right"></i>
                </button>
        </div>
         <div class="login-footer">
            <div class="admin_login_error"><?php echo $error[1] ?></div><!-- style="font-size: 18px; margin-left: -13px;font-weight: bold" -->
            <div class="forgot-hint pull-right">
                <a id="forget-password" class="" href="admin_login.php">Go To Login</a>
            </div>
        </div>
        
    </div>
  </form
</body>
<!-- END BODY -->
</html>