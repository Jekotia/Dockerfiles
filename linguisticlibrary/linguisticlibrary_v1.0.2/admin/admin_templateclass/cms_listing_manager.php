<?php
include("cms_listing_class.php");

class cms_listing_manager
{
		//activate single reecord
		function activate_single($id)
		{
			global $db;
			$up_sql = "UPDATE manage_cms SET is_active = 'Y' WHERE id='$id'";
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
			   $up_sql = "UPDATE  manage_cms SET is_active = 'N' WHERE id='$id'";
			   $res_sql = $db->update_data($up_sql);
	           if(count($res_sql)>0)
				{
					$msg = "Record De-activated Successfully";
				    return $msg;
				}
		}
	//search member
		function select_cms()
		{
			 global $db;
		     $sql 		  =	"select * from manage_cms ORDER BY `manage_cms`.`id` DESC";
			 $collection  =   $db->select_data($sql);
			 if(count($collection)>0)
			 {
				return $collection;
			 } else {
				return false;
			}
		}
		
}//class
?>