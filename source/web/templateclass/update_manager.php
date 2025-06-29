<?php 
include("update_class.php");
class update_manager
{
	function validation($addmemberclass)
	{
		global $db;
		$error=array();
		$postvar = $addmemberclass->getPostVar();
		     $name 		       = trim($_POST['disp_name']);
			 $change_password  = trim($_POST['change_password']);
			 $confirm_password = trim($_POST['confirm_password']);
			 $follow_tags = trim($_POST['follow_tags']);  
		 
		 	 $error= array();		 
		    
				  
			      
			 	 if($change_password!="")
				 {
				    $m=	strlen($change_password);
			 	    if	($m < 6 )
					{
						$error[2]="Password Must be 6 character ";
					}
					 
				 }
				 
			    if($confirm_password!=$change_password)
				{
				
					$error[3]="Please enter same password again";
				}
						 
			 
			 
		return $error;
	}//function validate	
	function update($addmemberclass,$id)
	{
		global $db;
		     $postvar = $addmemberclass->getPostVar();
	         $name 		= $postvar['disp_name'];
			 $change_password=$postvar['change_password'];
			 $confirm_password=$postvar['confirm_password'];
			 $follow_tags=$postvar['follow_tags'];
		  
			 $pass=base64_encode($confirm_password);
		   
		   if(isset($_SESSION['reader'])||isset($_SESSION['author']))
		   {
		   	 $_SESSION['author']=$name;
			 $_SESSION['reader']=$name;
		     $sql="UPDATE `user_register` SET `name`='$name',`follow_tags`='$follow_tags'";
		     if($pass!='')
			 {
			   $sql.= ",`password`='$pass'";
			 }
			 
		     $sql.= "WHERE id='$id'";
            
			 $result=$db->update_data($sql);
			 
	       
		   $msg="Update Successfully";
		   return $msg;
		   }
		   
		   if(isset($_SESSION['ADMIN_ID'])||isset($_SESSION['ADMIN_NAME']))
		   {
		   	        $_SESSION['ADMIN_NAME']=$name;           
	           	    $sql="UPDATE `admin` SET `admin_name`='$name',`follow_tags`='$follow_tags'";
	           	    if($pass!='')
					{
	           	    $sql.=",`admin_password`='$pass'";
					}
					
	           	    $sql.="WHERE admin_id='$id'";
 
			        $result=$db->update_data($sql);
			 
	       
		            $msg="Update Successfully";
		            return $msg;	
		   }  
			            
							 
	}
		 
	  
}//class
?>