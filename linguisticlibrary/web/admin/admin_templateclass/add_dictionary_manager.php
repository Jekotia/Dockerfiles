<?php 
include("add_dictionary_class.php");

class add_dictionary_manager
{
	function chkvalidation($addmemberclass,$editid,$count)
	{
		 global $db;		
		 $error			=	array();
		 $postvar 		=   $addmemberclass->getPostVar();
		 $get_cols_qry  = "SHOW COLUMNS FROM tbl_dictionary";
		 $get_cols 	    = $db->select_data($get_cols_qry);
		 $tot_cols      = count($get_cols);
		
// Get Posted Data here  .The index for posted data is Column name from table
// Apply basic blank validation 		
		for ($iq=1; $iq < $tot_cols; $iq++)  {
		    if ($postvar[$get_cols[$iq][0]]==""){
				$error[$iq-1]="Please Enter ".$get_cols[$iq][0];
			}			
		}			
		return $error;	  
     }//function validate
	function register($addmemberclass,$editid,$count)
	{
	//  echo $count;
		global $db;		
		$postvar 		= 	$addmemberclass->getPostVar();
		
        $data           = array();

		$get_cols_qry   = "SHOW COLUMNS FROM tbl_dictionary";
		$get_cols 	    = $db->select_data($get_cols_qry);
		$tot_cols       = count($get_cols);
		
// Get Posted Data here  .The index for posted data is Column name from table 		
		for ($iq=1; $iq < $tot_cols; $iq++)  {
			$data[$iq-1]=$postvar[$get_cols[$iq][0]];
		}
		//$get_data = "";
															
//In below for loop, the $iq=1 is set to skip 1st column `id` which is auto_increment and has no role in insert & update query 
			   for ($iq=1; $iq < $tot_cols; $iq++)  { 

//Insert Query Generation
					 	$colnms.="`".$get_cols[$iq][0]."`";																	
					 	$values.="'".trim($data[$iq-1])."'";
					
//Update Query Generation
					 	$upvalue="'".trim($data[$iq-1])."'";							 						  						  
					 	$upcolumn.="`".$get_cols[$iq][0]."`"."=".$upvalue; 
					 
//Append ,(comma) to query till second last in the insert/update query
					    if ($iq < $tot_cols-1)
						{
							$colnms.=",";
							$values.=",";
							$upcolumn.=",";
							
						}//if						 						 			   
		         }//for	
		             
		
		if($editid=="")		
		{
					
		    $ins_qury="INSERT INTO `tbl_dictionary`($colnms) VALUES($values)";						 					 	
			$db->insert_data($ins_qury);	
			$msg ="Record Inserted Successfully";
			return $msg;		
		}
		else
		{
			$up_qry="UPDATE `tbl_dictionary` SET $upcolumn WHERE `id`='$editid'";					  
			$res_up=$db->update_data($up_qry);
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