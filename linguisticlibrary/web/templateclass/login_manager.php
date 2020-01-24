<?php
include_once("login_class.php");

class login_manager
{
	//check post variable
	function checkPostVar($loginObject)
	{
		global $db;
		
		$error		= array();	
		
		$postVar	= $loginObject->getPostVar();
		
		  $uname		= trim($postVar['logemail']);
	       $password	= base64_encode(trim($postVar['logpwd']));
		 
         $query="select user_type from user_register where display_email='$uname'";
		 $sql=$db->select_data($query);
	      $user_type=$sql[0]['user_type'];
		  
		 
		$query1="select admin_email from admin where admin_email='$uname'";
		$sql1=$db->select_data($query1);
		  $email=$sql1[0]['admin_email'];
	 
		if($uname=="" && $password=="")
		{
			array_push($error,"Please enter email-id & password.<br>");
		}
		elseif($uname=="" && $password!="")
		{
			array_push($error,"Please enter email-id.<br>");
		}
		elseif($uname!="" && $password=="")
		{
			array_push($error,"Please enter password.<br>");
		}
		
		if($uname!="" && $password!="")
		{
		  if($user_type=='reader'||$user_type=='author')
		  { 
		          $sql_select = "select * from user_register where display_email='$uname' and  password='$password'"; 
		    	$res_select = $db->select_data($sql_select);
				 
		 
				if(count($res_select)==0)
				{
					array_push($error,"Invalid username or password.<br>");
					 
			    }
		  }
		
		 
		 
           
			 
			 if($email==$uname)
			  {
			  	$sql_select = "select * from admin where admin_email='$uname' and  admin_password='$password'"; 
			    $res_select = $db->select_data($sql_select);
			       
				if(count($res_select)==0)
				{
					array_push($error,"Invalid username or password.<br>");
					 
				}
			 }
			 if($email!=$uname&&$user_type!='author'&&$user_type!='reader')
			 {
			     array_push($error,"Invalid username or password.<br>");	 
			     
			 }
			  
			
			 	 	 
			 
			 
		}
		 	 return $error;	
	}//login
	
	function do_login($loginObject)
	{
		global $db;		
		$error1=array();
		$postvar=$loginObject->getPostVar();
		$user_email=trim($postvar['logemail']);
		 $password= base64_encode($postvar['logpwd']);
		
		$query="select user_type from user_register where display_email='$user_email'";
		$sql=$db->select_data($query);
	     $user_type=$sql[0]['user_type'];
	  
		$query1="select admin_email from admin where admin_email='$user_email'";
		$sql1=$db->select_data($query1);
		$email=$sql1[0]['admin_email'];
		
		if($user_type=='reader')
		{
	   $sql_select = "select * from  user_register where display_email='$user_email' and password='$password' and is_active='Y'"; 
	    $res_select = $db->select_data($sql_select);
	   
	     $name=$res_select[0]['name'];
		 $id=$res_select[0]['id'];
	     
		if(count($res_select)==1)
		{
			 
			header("location:profile_update.php");
			$_SESSION['reader']=$name;
			$_SESSION['reader_id']=$id;
			
			
		}
	 else
      {
	     array_push($error1,"Your Account is not Activated");
      }
	  
		
		}
		if($user_type=='author')
		{
	    	
	    $sql_select = "select * from  user_register where display_email='$user_email' and password='$password' and is_active='Y'"; 
	    $res_select = $db->select_data($sql_select);
	   
	     $name=$res_select[0]['name'];
		 $id=$res_select[0]['id'];
	     
		if(count($res_select)==1)
		{
			 
			header("location:profile_update.php");
			$_SESSION['author']=$name;
			$_SESSION['author_id']=$id;
			
			
		}	
   else
      {
	     array_push($error1,"Your Account is not Activated");
      }
 
		}
    
    if($email==$user_email)
   {
	 $sql_select = "select * from  admin where admin_email='$user_email' and admin_password='$password' and is_active='Y'"; 
	  $res_select = $db->select_data($sql_select);
	     
	    $name=$res_select[0]['admin_name'];
		$id=$res_select[0]['admin_id'];
		if(count($res_select)==1)
		{
			 
			header("location:profile_update.php");
			$_SESSION['ADMIN_NAME']=$name;
			$_SESSION['ADMIN_ID']=$id;
			
			
		}	
      else
      {
	     array_push($error1,"Your Account is not Activated");
      }
	  
	
    }
    return $error1;
		 
}
}
?>