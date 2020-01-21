<?php
include("add_admin_class.php");
class add_admin_manager
{
	function chkvalidation($adminObject,$edit_id)
	{
		global $db;
		$postVar	=	$adminObject->getPostVar();
		$username	=	trim($postVar['username']);
		$email		=	trim($postVar['email']);
		$password	=	trim($postVar['password']);
		$cpassword	=	trim($postVar['cpassword']);
		$approval_required = trim($postvar['approval_required']);
		$err		=	array();
		if($username=="")
		{
			$err[0]="Please Enter Username";
		}
		else if(preg_match('/[\'^£!$%&*()}{@#~?><>0-9,|=_+¬-]/', $username))
		{
			$err[0]="Enter Valid Username";
		}
		else 
		{
			if($edit_id=="")
			{
				$sql	=	"SELECT admin_name FROM admin WHERE admin_name='".addslashes($username)."' ";
			}
			else 
			{
				$sql	=	"SELECT * FROM admin WHERE admin_name='".addslashes($username)."' and admin_id!='".$edit_id."' ";
			}
			$res	=	$db->select_data($sql);
			if(count($res)>0)
			{
				$err[0]="Username exists, enter another username";
			}
		}
	
		if($email=="")
		{
			$err[1]="Please Enter Email Address";
		}
		else if(!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email))
		{
			$err[1]="Enter Valid Email Address";
		}
		else 
		{
			if($edit_id=="")
			{
				$sql	=	"SELECT admin_email FROM admin WHERE admin_email='".$email."'";
			}
			else 
			{
				$sql	=	"SELECT * FROM admin WHERE admin_email='".$email."' and admin_id!='".$edit_id."'";
			}
			$res	=	$db->select_data($sql);
			if(count($res)>0)
			{
				$err[1]="Email exists, enter another email address";
			}
		}
		if($edit_id=="")
		{
			if($password=="")
			{
				$err[2]="Please Enter Password";
			}
			elseif(strlen($password)<5)
			{
				$err[2]="Password length must be 5.";
			}
			if($cpassword=="")
			{
				$err[3]="Please Enter Confirm Password";
			}
			if($cpassword!="")
			{
				if($password!=$cpassword)
				{
					$err[3]="Password and confirm password must be same";
				}
			}
		}
		else if($edit_id!="")
		{
			if($password!="")
			{
				if(strlen($password)<5)
				{
					$err[2]="Password length must be 5.";
				}
				if($cpassword=="")
				{
					$err[3]="Please Enter Confirm Password";
				}
				if($cpassword!="")
				{
					if($password!=$cpassword)
					{
						$err[3]="Password and confirm password must be same";
					}
				}
			}
		}
		if($approval_required=="")
		{
			$error[6]="Please Select Approval Required";
		}
	
		return $err;
	}
	
	function adduser($adminObject,$edit_id)
	{
		global $db;
		$postVar	=	$adminObject->getPostVar();
		$username	=	trim($postVar['username']);
		$email		=	trim($postVar['email']);
		$password	=	base64_encode(trim($postVar['password']));
		$approval_required = $postVar['approval_required'];
		
		
		
		if($edit_id=="")
		{
			
		$sql_insert="INSERT INTO admin(admin_name,admin_email,admin_password,date_added)
					 VALUES('$username','$email','$password',now())";				
											 
			$res_insert	=	$db->insert_data($sql_insert);
			$message	=	"User Added Successfully";
			return $message;
		}
		else 
		{
			$sql_update="UPDATE `admin` SET `admin_name`='$username',`admin_email`='$email',`approval_required`='$approval_required'";
  		    if($password!="")
			{
				$sql_update.=",`admin_password`='$password' ";
			}
			
		    $sql_update.=",`date_added`=now() WHERE admin_id='$edit_id'";
			$res_update=$db->update_data($sql_update);
			$message	=	"User Updated Successfully";
			return $message;
		}
	}
}