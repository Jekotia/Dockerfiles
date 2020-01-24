<?php 
include("reg_class.php");
class reg_manager
{
	function validation($addmemberclass)
	{
		global $db;
		$error=array();
		$postvar = $addmemberclass->getPostVar();
		     $name 		  =trim($_POST['disp_name']);
			
			 $email       =trim($_POST['email']);
			 $password    =trim($_POST['password']);
			 $confirm_pass=trim($_POST['cpass']);  
			 $user_type   =trim($_POST['user_type']);
			 $status      =trim($_POST['status']);
		 
		 	 $error= array();
				 
		    if($name=="")
		       {
				$error[0]="Please Enter Name";
			   }
			 if($email=='')
			 {
			 	$error[1]="Please Enter Email";
			 }  
				 if($email!="")
				  {
				  	 if(!filter_var($email, FILTER_VALIDATE_EMAIL))
	             {
	
		           $error[1]="Please enter a valid email address";
	             }
					 else{
					 if($user_type=='reader'||$user_type=='author')
					 {    
					  $grt= "SELECT * FROM `user_register` WHERE `display_email`='$email'";
			          $resw =$db->select_data($grt);
					 
					   $ret=  count($resw) ;
					  $grt1= "SELECT * FROM `admin` WHERE `admin_email`='$email'";
			          $resw1 =$db->select_data($grt1);
					 
					   $ret1=  count($resw1) ;
					  if($ret >0)
					  {
					  	 $error[1]="Please Enter Another Email Address";
					  }
					  if($ret1>0)
					  {
					  	$error[1]="Please Enter Another Email Address";
					  }					  					  
					 }
					 
					 
					 }
				  }
			     if($password=="")
				{
					 $error[2]="Please enter Password";
				}
			 	 if($password!="")
				 {
				    $m=	strlen($password);
			 	    if	($m < 6 )
					{
						$error[2]="Password Must be 6 character ";
					}
					 
				 }
				if($confirm_pass=='')
				{
					$error[3]="Please Enter Confirm Password";
				}
			    if($confirm_pass!=$password)
				{
				
					$error[3]="Please enter same password again";
				}
		    if($user_type=='')
			 {
			 	$error[6]="Please Select User Type";
			 }	
			 if($status=='')
			 {
			 	$error[7]="Please Select Status";
			 }
						 
			 
			 
		return $error;
	}//function validate	
	function register($addmemberclass)
	{
		global $db;
		$postvar = $addmemberclass->getPostVar();
	         $name 		    =trim($_POST['disp_name']);
		 
			 $email         =trim($_POST['email']);
			 $password      =base64_encode(trim($_POST['password']));
			 $original_psd 	=trim($_POST['password']);
			 $user_type     =trim($_POST['user_type']);
			 $status        =trim($_POST['status']);
			  
		 
		    if($user_type=='author'||$user_type=='reader')
			{
		     $sql="insert into user_register(name,display_email,password,user_type,date_added,is_active) values('$name','$email','$password','$user_type',now(),'$status')";
 
			 $result=$db->insert_data($sql);
			 $in_id  = mysql_insert_id();
			
		    if($in_id!=0)
		    {
		    	$aname        = 'Custom PHP Post - Admin';
				//$amail        = ADMINMAIL;
		        $to			  = $email;
				$name1		  = ucwords('Admin');
				//$pass 		  = md5($password);
				$name2		  = $name;
				$from         = ADMINMAIL;
				$loginurl 	  = SITEURL."/confirmation.php?id=".$encode_id;
				$subject      = "Linguistic Library : New Registration To Site";
				$headers  	  = "MIME-Version: 1.0\r\n"; 
			    $headers     .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
			    $headers     .= "From: ".$name2."<".$from.">";
			    
			    $mailmatter ='
				<table align="left" border="0" cellpadding="0" cellspacing="0">
				<tr><td>Hello '.$name.',</td></tr>
				<tr><td>&nbsp;&nbsp;</td></tr>
				<tr><td>You are registered successfully to our site.</td></tr>
				<tr><td>&nbsp;&nbsp;</td></tr>
				<tr><td><b>Following are login details:</b></td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>Email &nbsp;&nbsp;:</td><td>'.$email.'</td></tr>
				<tr><td>Password &nbsp;&nbsp;:</td><td>'.$original_psd.'</td></tr>
				<tr><td>&nbsp;&nbsp;</td></tr>
				<tr><td>Regards,</td></tr>
				<tr><td>sindarinlibrary.com</td></tr>
				</td></tr>
				</table>';						
			    $message=$mailmatter;	
				@mail($to, $subject, $message, $headers);
		  }
		}   //$in_id=mysql_insert_id();
		   $msg="Registration Successfully";
		   return $msg;	
		   							 
	}		 	  
}//class
?>