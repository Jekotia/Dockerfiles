 <?php
include_once("admin_login_class.php");

class adminLoginManager
{
	//check post variable
	function checkPostVar($loginObject)
	{
		global $db;
		$error	=	array();	
		$postVar	=	$loginObject->getPostVar();
		
		$uname=$postVar['username'];
	    $password=base64_encode($postVar['passw']);
		if(trim($uname)=="" && trim($password)=="")
		{
			array_push($error,"Please enter user name & password.<br>");
		}
		elseif(trim($uname)=="" && trim($password)!="")
		{
			array_push($error,"Please enter username<br>");
		}
		elseif(trim($uname)!="" && trim($password)=="")
		{
			array_push($error,"Please enter password<br>");
		}
		
	   
		if(trim($password)=="")
		{
			array_push($error,"Please enter passcode.<br>");
		}
		else {
				 $sql_select="select * from admin where (admin_name='$uname' or admin_email='$uname') and admin_password='$password'";
				 $res_select=$db->select_data($sql_select);
				if(count($res_select)==0)
				{
					array_push($error,"Invalid username or password.<br>");
				}			
		}
		return $error;
	}
	
	//login
	function do_login($loginObject,$id)
	{
		global $db;
		$error1=array();
		$uname	    =	$loginObject->getUserName();		
		$password	=	base64_encode($loginObject->getPassword());		
		$sql_select="select * from admin where (admin_name='$uname'or admin_email='$uname') and admin_password='$password' and is_active='Y'";
		$res_select=$db->select_data($sql_select);
		if(count($res_select)>0)
		{
			$user_id	=	$res_select[0]['admin_id'];
			$username	=	$res_select[0]['admin_name'];
			$pass		=	$res_select[0]['admin_password'];			
			
	 	
			$_SESSION['ADMIN_NAME']	=	$username;
			$_SESSION['ADMIN_ID']	=	$user_id;
		

			
				header("location:index.php");
				
						
		}
		else 
		{
			  array_push($error1,"Your Account is not Activated");
			
		}
		return $error1;
	}			
}
?>