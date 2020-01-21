<?php 
include("add_alphabet_class.php");

class add_alphabet_manager
{
	function chkvalidation($addmemberclass,$editid)
	{
		global $db;
		$error=array();
		$postvar 	 =  $addmemberclass->getPostVar();
		$name1	 =	trim($postvar['alpha_name']);
		$name 	 =  preg_replace('/\s+/', ' ', $name1); 
		$image	 =	$_FILES['image']['name'];
		$status  =  $postvar['is_active'];
		$wordtype  =  $postvar['is_tehta'];
		
		$error= array();
	
		if($name=="")
		{
			$error[0]="Please Enter Alphabet Name ";
		}
		// if(!preg_match('/^[A-Za-z0-9_~\-!@#\$%\^&\*\(\)]+$/',$name))
		// {
			// $error[0]="Please Enter Alphabet";
		// }
		$image 	        = 	$_FILES['image']['name'];
	    $image_type     = 	$_FILES['image']['type'];
		$tmp_name       =   $_FILES['image']['tmp_name'];	
		list($width, $height, $type, $attr) = getimagesize($tmp_name);
		
		if($image!=="")
		{
		     if($image_type != "image/jpeg" && $image_type != "image/gif" && $image_type != "image/jpg" 
		     && $image_type != "image/png" && $image_type != "image/JPEG" && $image_type != "image/GIF" 
			 && $image_type != "image/JPG" && $image_type != "image/PNG" && $image_type != "image/png" && $image_type != "image/BMP" && $image_type != "image/bmp")
			 {
		   		$error[1] = "Please select image with .gif or .jpg or .jpeg  or .png extentions";
			}
			
		}
	 	if($status=="")
		{
			$error[2]="Please Select Status";
		}
	 	if($wordtype=="")
		{
			$error[3]="Please Select Word Type";
		}
		
		return $error;
	}//function validate
	function register($addmemberclass,$editid)
	{
		global $db;
		$postvar 		= $addmemberclass->getPostVar();
		$name	        = $postvar['alpha_name'];
		//$name 		= preg_replace('/\s+/', ' ', $name1);  
		$image 		    = $_FILES['image']['name']; 
		$status         = $postvar['is_active'];
		$wordtype         = $postvar['is_tehta'];
		if($image=="")
		{
			$path="";
		}
		else 
		{
			$path 	     = $this->uploadImg('image','upload/');	
		}
		
		if($editid=="")
		{
		
	  		$sql="INSERT INTO `tbl_alphabet`(`alpha_name`,`image`,`is_active`,`is_tehta`) VALUES ('$name','$path','$status','$wordtype')";	
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
			
		  $up_sql = "UPDATE `tbl_alphabet` SET `alpha_name`='$name',`is_active`='$status',`is_tehta`='$wordtype'";
		   if($image!="")
			{
				$sql_img = "SELECT * FROM `tbl_alphabet` WHERE id = '$editid'";
				$res_img = $db->select_data($sql_img);
				$filename = $res_img[0]['image'];
				@unlink('upload/'.$filename);
				$up_sql .= ",`image`='$path'";
			} 
			 $up_sql .= "WHERE id = '$editid'";
			$res_sql = $db->update_data($up_sql);
			$in_id=mysql_insert_id();
			if(count($res_sql)>0)
			{
				$msg1="Record Updated Successfully";
				return $msg1;
			}
		}
	}// reg
	function update($editid)
	{
	   global $db;
	  $sq2="select * from `tbl_alphabet` where `id`='$editid'";
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