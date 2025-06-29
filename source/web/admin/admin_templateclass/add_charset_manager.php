<?php 
include("add_charset_class.php");

class add_charset_manager
{
	function chkvalidation($addmemberclass,$editid)
	{
		global $db;
		$error=array();
		$postvar 	 =  $addmemberclass->getPostVar();
		$name1	 =	trim($postvar['char_name']);
		$name 	 =  preg_replace('/\s+/', ' ', $name1);    
		$status      =  $postvar['is_active'];
		
		$error= array();
	
		if($name=="")
		{
			$error[0]="Please Enter Charset Name ";
		}
	 	if($status=="")
		{
			$error[1]="Please Select Status";
		}
		
		
		return $error;
	}//function validate
	function register($addmemberclass,$editid)
	{
		global $db;
		$postvar 		= $addmemberclass->getPostVar();
		$name1	    = trim($postvar['char_name']);
		$name 		= preg_replace('/\s+/', ' ', $name1);    
		$status         = ($postvar['is_active']);
		
		
		if($editid=="")
		{
		
	  		$sql="INSERT INTO `charset`(`char_name`,`is_active`) VALUES ('$name','$status')";	
			$result=$db->insert_data($sql);
		    $in_id=mysql_insert_id();
			if(count($result)>0)
			{
				$msg ="Record Inserted Successfully";
				return $msg;
			}
		}
		else
		{
			
		  $up_sql = "UPDATE `charset` SET `char_name`='$name',`is_active`='$status' WHERE id = '$editid' ";
		}
			$res_sql = $db->update_data($up_sql);
			$in_id=mysql_insert_id();
			if(count($res_sql)>0)
			{
				$msg1="Record Updated Successfully";
				return $msg1;
			}
	}// reg
	function update($editid)
	{
	   global $db;
	  $sq2="select * from `charset` where `id`='$editid'";
	   $sq_updat1=$db->select_data($sq2);
	   if(count($sq_updat1)>0)
	   {
		    return $sq_updat1;
	   }
	}
}//class
?>