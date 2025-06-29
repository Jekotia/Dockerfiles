<?php
include_once("admin_listing_class.php");
 class admin_listing_manager
{
		function select_admin()
		{
			global $db;
		    $sql ="select * from admin order by admin_id desc";
			$collection  =   $db->select_data($sql);
			if(count($collection)>0)
			{
				 return $collection;
			} else {
				 return false;
			}
		}
		function delete_single($del_id)
		{
			global $db;
		    $sql_delete		=	"DELETE FROM admin WHERE admin_id='".$del_id."'";
		    $res_delete		=	$db->delete_data($sql_delete);
			$query_sel	= "SELECT id FROM `add_post` WHERE user_id='$del_id'";
						$sel_qry	= $db->select_data($query_sel);
						for ($del=0; $del < count($sel_qry) ; $del++)
						{
							$id 		= $sel_qry[$del]['id']; 
							$query2		= "DELETE FROM add_post WHERE id='$id'";
						 	$sel2		= $db->delete_data($query2);
							$query3		= "DELETE FROM `add_new_entry` WHERE post_id='$id'";
						 	$sel3		= $db->delete_data($query3);
	                        $query4		= "DELETE FROM `bookmark` WHERE user_id='$del_id'";
						 	$sel4		= $db->delete_data($query4);
											
						
						}
			if(count($res_delete)>0)
			{
				$msg="User Deleted Successfully";
				return $msg;
			}
		}
		 
		function active_single($status)
		{
			global $db;
			$sql_status= "update admin set is_active='Y' where admin_id='".$status."'";
			$res_status=$db->update_data($sql_status);
			if(count($res_status)>0)
			{
				$msg="User Activate Successfully";
				return $msg;
			}
			
		} 
		function deactive_single($status)
		{
			global $db;
			$sql_status= "update admin set is_active='N' where admin_id='".$status."'";
			$res_status=$db->update_data($sql_status);
			if(count($res_status)>0)
			{
				$msg="User De-activate Successfully";
				return $msg;
			}
			
		} 
		
}//class
?>