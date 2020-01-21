<?php
include_once("user_list_class.php");
class user_list_manager
{
	
	function activate_single($id)
		{
			global $db;
			$up_sql = "UPDATE user_register SET is_active = 'Y' WHERE id='$id'";
			$res_sql = $db->update_data($up_sql);
		    if(count($res_sql)>0)
			{
				$msg = "Record Activated Successfully";
				return $msg;
			}
		}	
	//De-activate single reecord
		function Deactivate_single($id)
		{
			   global $db;
			   $up_sql = "UPDATE user_register SET is_active = 'N' WHERE id='$id'";
			   $res_sql = $db->update_data($up_sql);
	           if(count($res_sql)>0)
				{
					$msg = "Record Deactivated Successfully";
				    return $msg;
				}
		}
		function delete_selected($adminObject)
		{
			global $db;
			$delete_id	=	$adminObject->getpostvar();
			for($i=0;$i<count($delete_id);$i++)
			{
				$del = $delete_id[$i];
				if($del != "")
				{
					$sql_delete		=	"DELETE FROM `user_register` WHERE id='".$del."'";
					$res_delete		=	$db->delete_data($sql_delete);
				    	$query_sel	= "SELECT id FROM `add_post` WHERE user_id='$del'";
						$sel_qry	= $db->select_data($query_sel);
						for ($del=0; $del < count($sel_qry) ; $del++)
						{
							$id 		= $sel_qry[$del]['id']; 
							$query2		= "DELETE FROM add_post WHERE id='$id'";
						 	$sel2		= $db->delete_data($query2);
							$query3		= "DELETE FROM `add_new_entry` WHERE post_id='$id'";
						 	$sel3		= $db->delete_data($query3);
						 	$query4		= "DELETE FROM `bookmark` WHERE user_id='$del";
					        $sel4		= $db->delete_data($query4);
					
						}
											
				}
			}
			$msg = "Record deleted successfully";
			return $msg;
		} // end function delete
		
		function delete_single($del_id,$user_type)
		{
			global $db;		  
			 $query1	=   "DELETE FROM user_register WHERE id='$del_id'";
			 $sel1	=	$db->delete_data($query1);
			 		
			if($user_type=='author')
			{
				$query_sel	= "SELECT id FROM `add_post` WHERE user_id='$del_id' AND user_type='$user_type'";
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
				if(count($sel1)>0)
				{
					$msg="Record Deleted Successfully";
					return $msg;
				}
			}
		}
		
		function activate_selected($adminObject)
		{
			global $db;
			$status_id	=	$adminObject->getpostvar();			
			for($i=0;$i<count($status_id);$i++)
			{
				 $sql_update	=	"UPDATE `user_register` SET is_active='Y' WHERE id='".$status_id[$i]."'";				
				 $res_update	=	$db->update_data($sql_update);	
			} // for i
			
			$msg = "Record activate successfully";
			return $msg;
		} 
		function deactivate_selected($adminObject)
		{
			global $db;
			$status_id	=	$adminObject->getpostvar();			
			for($i=0;$i<count($status_id);$i++)
			{
			    $sql_update		=	"UPDATE `charset` SET is_active='N' WHERE id='".$status_id[$i]."'";
				$res_update		=	$db->update_data($sql_update);	
			} // for i
		    $msg = "Record de-activate successfully";
			return $msg;
		} 
	//search member
		function select_member()
		{
			 global $db;
		     $sql 		  =	"select * from user_register ORDER BY `id` DESC";
			 $collection  =   $db->select_data($sql);			 
			 return $collection;			
		}
		
			
}//class
?>