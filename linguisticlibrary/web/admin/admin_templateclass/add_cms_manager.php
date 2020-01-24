<?php 
include("add_cms_class.php");

class add_cms_manager
{
	function chkvalidation($addmemberclass,$editid)
	{
		global $db;
		$error=array();
		$postvar = $addmemberclass->getPostVar();
	    $cms_title = trim($postvar['title']);
		$cms_desc = trim($postvar['desc']);
		$status=$postvar['is_active'];
		//$file       =   $_FILES['file']['name'];  
		//$temp       =   $_FILES['file']['tmp_name'];  

		$error= array();
		//$ext = pathinfo($file, PATHINFO_EXTENSION);
        //$allowedExts = array("jpg","png","gif","JPG","PNG","GIF");
		 
		
		   
		if($cms_title=="")
		{
			$error[0]="Please Enter Page Title ";
		}
		if(is_numeric($cms_title))
		{
			$error[0]="Please Enter Character";
		}	
		
		if($cms_title!="")
		{
			if(preg_match('/[\'^£$%&*()}{@#~?><>0-9,|=_+¬-]/', $cms_title))
			{
			    $error[0]="Please Enter Valid Title";
			}
		}
		
		if($cms_title!="")
		{
			$check="select cms_title from manage_cms where cms_title='$cms_title'";
			$result=mysql_query($check);
			
			if($editid=="")
			{
				if(mysql_num_rows($result)>0 && $editid=="")
				{
					$error[0]="Title Already Exists,Please Try Another";
				}
			}
			else
				{
					$check_name="select cms_title from manage_cms where cms_title='$cms_title' and id!='$editid'";
					$res=mysql_query($check_name);
					if(mysql_num_rows($res)>0 && $editid!="")
					{
							$error[0]="Title Already Exists,Please Try Another ";
					}
				}
		}
		
	
		if($cms_desc=="")
		{
			$error[1]="Please Enter Page Description ";
		}
	 	if($status=="")
		{
			$error[2]="Please Select Status";
		}
		 // if($file!=="" && !in_array($ext, $allowedExts))
                // {
		  // $error[3]="Please Upload JPEG,GIF,PNG Image";
		// }
		 // $sfile = @getimagesize($_FILES['file']['tmp_name']);
		// echo $sfile[0];
// 		
		// if($sfile[0] < 500)
		// {
			// $error[3]="Please Upload Image 500*500.";
		// }
		// if($sfile[1] < 500)
		// {
			// $error[3]="Please Upload Image 500*500.";
		// }
			
		return $error;
	}//function validate
	function register($addmemberclass,$editid)
	{
		global $db;
		$postvar = $addmemberclass->getPostVar();
		$cms_title1 = $postvar['title'];
	    $cms_desc1 = $postvar['desc'];
	    $status=$postvar['is_active'];
		$cms_title = addslashes($cms_title1);
		$cms_desc = addslashes($cms_desc1);
	   // $file = $_FILES['file']['name'];
		
		if($editid=="")
		{
		//$path3 = $this->uploadImg1('file','upload/cms/');
		//$sql="insert into manage_cms (`cms_title`,`file`,`cms_desc`,`is_active`)values('$cms_title','$path3','$cms_desc','$status')";
		$sql="insert into manage_cms (`cms_title`,`cms_desc`,`is_active`)values('$cms_title','$cms_desc','$status')";
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
			$up_sql .= "UPDATE manage_cms SET `cms_title`='$cms_title', `cms_desc`='$cms_desc',`is_active`='$status' ";
		    // if($file!="")
			// {
				// $sql = "SELECT * FROM `manage_cms` WHERE id = '$editid'";
				// $res = $db->select_data($sql);
				// $filename = $res[0]['file'];
				// @unlink('upload/cms/'.$filename);
				// echo $path3 = $this->uploadImg1('file','upload/cms/');
				// $up_sql .= ",`file`='$path3'";
			// } 
			 $up_sql .= "WHERE id = '$editid'";
		}
		$res_sql = $db->update_data($up_sql);
		$in_id=mysql_insert_id();
			if(count($res_sql)>0)
			{
				$msg1="Record Updated Successfully";
				return $msg1;
			}
	}// reg
	function updat($editid)
	{
	   global $db;
	   $sq2="select * from manage_cms where `id`='$editid'";
	   $sq_updat1=$db->select_data($sq2);
	   if(count($sq_updat1)>0)
	   {
		    return $sq_updat1;
	   }
	}
	// function uploadImg1($imgName,$dirname="")
		// {
// 			
			// $img_suffix = rand(0, 89999);
			// if($_FILES[$imgName]['name']!="")
			// {
				// $image_part = explode(".",$_FILES[$imgName]['name']);
				// $dest = $dirname."/".$image_part[0]."_$img_suffix.".$image_part[1];
				// if(@move_uploaded_file($_FILES[$imgName]['tmp_name'],$dest))
				// {
					// return $image_part[0]."_$img_suffix.".$image_part[1];
				// }	
			// }
			// else
			// {
				// echo "Sub Image name is empty.";
			// }
		// }
}//class
?>