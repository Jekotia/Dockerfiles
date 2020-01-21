<?php
include("charset_listing_class.php");

class charset_listing_manager
{
		//activate single reecord
		function activate_single($id)
		{
			global $db;
			$up_sql = "UPDATE charset SET is_active = 'Y' WHERE id='$id'";
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
			   $up_sql = "UPDATE charset SET is_active = 'N' WHERE id='$id'";
			   $res_sql = $db->update_data($up_sql);
	           if(count($res_sql)>0)
				{
					$msg = "Record De-activated Successfully";
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
					$sql_delete		=	"DELETE FROM `charset` WHERE id='".$del."'";
					$res_delete		=	$db->delete_data($sql_delete);
				}
			}
			$msg = "Record deleted successfully";
			return $msg;
		} // end function delete
		
		function activate_selected($adminObject)
		{
			global $db;
			$status_id	=	$adminObject->getpostvar();			
			for($i=0;$i<count($status_id);$i++)
			{
				 $sql_update	=	"UPDATE `charset` SET is_active='Y' WHERE id='".$status_id[$i]."'";				
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
		     $sql 		  =	"select * from charset ORDER BY `id` DESC";
			 $collection  =   $db->select_data($sql);
			 if(count($collection)>0)
			 {
				return $collection;
			 } else {
				return false;
			}
		}
		function delete_single($delete_id)
		{
			global $db;
		    $sql_delete		=	"DELETE FROM charset WHERE id='".$delete_id."'";
		    $res_delete		=	$db->delete_data($sql_delete);
			if(count($res_delete)>0)
			{
				$msg="Record Deleted Successfully";
				return $msg;
			}
		}
		
}//class
?>