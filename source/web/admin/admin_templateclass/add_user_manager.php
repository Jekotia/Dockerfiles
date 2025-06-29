<?php 
include("add_user_class.php");

class add_user_manager
{
	function chkvalidation($addmemberclass,$editid)
	{
		 global $db;		
		 $error			=	array();
		 $postvar 		=   $addmemberclass->getPostVar();
		 $name 			=	trim($postvar['name']);
		 $email_id		=	trim($postvar['email']);
		 $password		=	trim($postvar['password']);
		 $cpassword		=	trim($postvar['cpassword']);  
		 $user_type		=	trim($postvar['user_type']);
		 $approval_required = trim($postvar['approval_required']);
		 $status		=	trim($postvar['is_active']);
		
		  if($user_type=="")
		 {
		 	$error[0]="Please Select User Type";
		 }	
		 if($status=="")
		 {
		 	$error[1]="Please Select Status";
		 }
		 
  		if($name=="")
	    {
			$error[2]="Please Enter Name";
		}
		
	   if($email_id=="")
		{
			$error[3]="Please Enter Email Address";
		}
		else if(!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email_id))
		{
			$error[3]="Enter Valid Email Address";
		}
		
		else 
		{
			if($editid=="")
			{
				$sql_email	=	"SELECT display_email FROM user_register WHERE display_email='".$email_id."'";
				
			}			
			else
			{
				$sql_email	=	"SELECT * FROM user_register WHERE display_email='".$email_id."' and id!='".$editid."'";
				
			}
			//echo $sql_email;
			$res_email	=	$db->select_data($sql_email);
			
			if(count($res_email)>0)
			{
				$error[3]="Email exists, enter another email address";
			}
		}
		if($editid=="")
		{
			if($password=="")
			{
				$error[4]="Please Enter Password";
			}
			elseif(strlen($password)<6)
			{
				$error[4]="Password length must be 6";
			}
			if($cpassword=="")
			{
				$error[5]="Please Enter Confirm Password";
			}
			if($cpassword!="")
			{
				if($password!=$cpassword)
				{
					$error[5]="Password and confirm password must be same";
				}
			}
		}
		else 
		{	
		if($editid!="")
		{
			if($password!="")
			{
				if(strlen($password)<5)
				{
					$error[4]="Password length must be 5";
				}
				if($cpassword=="")
				{
					$error[5]="Please Enter Confirm Password";
				}
				if($cpassword!="")
				{
					if($password!=$cpassword)
					{
						$error[5]="Password and confirm password must be same";
					}
				}
			}
		}
		}
		if($approval_required=="")
		{
			$error[6]="Please Select Approval Required";
		}
		return $error;
	}//function validate
	
	function register($addmemberclass,$editid)
	{
		global $db;		
		$postvar 		= 	$addmemberclass->getPostVar();
		$name 			= 	trim($postvar['name']);
		$email     		=	trim($postvar['email']);
		$password  		=	base64_encode(trim($postvar['password']));
		//$original_psd 	= 	trim($_POST['password']);
		$user_type 		=	trim($postvar['user_type']);
		$approval_required = trim($postvar['approval_required']);
		$status			=	trim($postvar['is_active']);
		
		
		
		if($editid=="")		
		{
			if($user_type=='author'||$user_type=='reader')
			{
		    $sql="INSERT INTO  user_register(name,display_email,password,user_type,approval_required,date_added,is_active) VALUES('$name','$email','$password','$user_type','$approval_required',now(),'$status')";		
			 
			}else if($user_type=='admin')
			{
				$sql="INSERT INTO `admin`( `admin_name`, `admin_email`, `admin_password`, `date_added`, `is_active`) VALUES ('$name','$email','$password',now(),'$status')";
			}
			
			//echo $sql;
			$res_insert	=	$db->insert_data($sql);
			$in_id   = mysql_insert_id();
			if(count($res_insert)>0)
			{
				$msg ="Record Inserted Successfully";
										
			}			
			return $msg;		
		}
		else
		{
			if($user_type=='author'||$user_type=='reader')
			{
				$qry_sel1 = "select * from admin where `admin_id`='$editid'";
	  			$qry_sel1 = $db->select_data($qry_sel1);
	  			$a_password = $qry_sel1[0]['admin_password'];
				$cnt1	 = count($qry_sel1);
				if($cnt1 > 0)
				{
					$qry_del    = "DELETE FROM `admin` WHERE `admin_id`='$editid'";
					$qry_del    = $db->delete_data($qry_del);
					$sql_ins1   = "INSERT INTO  user_register(name,display_email,password,user_type,approval_required,date_added,is_active) VALUES('$name','$email','$a_password','$user_type','$approval_required',now(),'$status')";
					$res_ins1	= $db->insert_data($sql_ins1);
					$new_user_id = mysql_insert_id();
					$update_idqry = "UPDATE add_post SET user_id='$new_user_id',user_type='$user_type' WHERE user_id='$editid'";
					$db->update_data($update_idqry);
				}
				else
				{
					$up_sql = "UPDATE `user_register` SET `name`='$name',`display_email`='$email'";			
					if($password!="")
					{
						$up_sql.=",`password`='$password'";
					}
					$up_sql.=",`user_type`='$user_type',`approval_required`='$approval_required',`is_active`='$status' WHERE id = '$editid'";
					$res_sql = $db->update_data($up_sql);
					//echo "++".$up_sql;
				}
			}else if($user_type=='admin')
			{
							
				$qry_sel = "select * from user_register where `id`='$editid'";
	  			$qry_sel = $db->select_data($qry_sel);
	  			$u_password = $qry_sel[0]['password'];
				$cnt	 = count($qry_sel);
				if($cnt > 0)
				{
					$qry_del    = "DELETE FROM `user_register` WHERE `id`='$editid'";
					$qry_del    = $db->delete_data($qry_del);
					$sql_ins2   = "INSERT INTO `admin`( `admin_name`, `admin_email`, `admin_password`, `date_added`, `is_active`) VALUES ('$name','$email','$u_password',now(),'$status')";
					$res_ins2	= $db->insert_data($sql_ins2);
					$new_admin_id = mysql_insert_id();
					$update_idqry = "UPDATE add_post SET user_id='$new_admin_id',user_type='admin' WHERE user_id='$editid'";
					$db->update_data($update_idqry);
			    }
				else
				{
					$up_sql = "UPDATE `admin` SET `admin_name`='$name',`admin_email`='$email'";			
					if($password!="")
					{
						$up_sql.=",`admin_password`='$password'";
					}
					$up_sql.=",`is_active`='$status' WHERE admin_id = '$editid'";
					$res_sql = $db->update_data($up_sql);
				}
			}
		}
		//echo $up_sql;
		if(count($res_sql)>0)
		{
			$msg1="Record Updated Successfully";
			return $msg1;
		}
	}// reg
	function updat($editid)
	{
	   global $db;
	   $sq2="select * from tbl_dictionary where `id`='$editid'";
	   $sq_updat1=$db->select_data($sq2);
	   if(count($sq_updat1)>0)
	   {
		    return $sq_updat1;
	   }
	}
	function uploadImg($imgName,$dirname="")
	{
			$img_suffix = rand(0, 89999);
			if($_FILES[$imgName]['name']!="")
			{
				$image_part = explode(".",$_FILES[$imgName]['name']);
				$temp = $image_part[0];
				$dest = $dirname."/".$temp."_$img_suffix.".$image_part[1];
				if(move_uploaded_file($_FILES[$imgName]['tmp_name'],$dest))
				{
					return $image_part[0]."_$img_suffix.".$image_part[1];
				}	
			}
	}	
}//class
?>