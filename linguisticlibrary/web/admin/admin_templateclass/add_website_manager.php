<?php 
include("add_website_class.php");

class add_website_manager
{
	function chkvalidation($addmemberclass,$editid)
	{
		 global $db;
		 $error=array();
		 $postvar 	 =  $addmemberclass->getPostVar();
		 $image1	 =	$_FILES['frontpageimage']['name'];
		 $image2	 =	$_FILES['bckimage']['name'];
		 $image3	 =	$_FILES['favicon']['name'];
		 $tmp_name   =$_FILES['frontpageimage']['tmp_name'];
		 $tmp_name1  =$_FILES['bckimage']['tmp_name'];
		  
         list($width,$height)=getimagesize($tmp_name);
		 list($width1,$height1)=getimagesize($tmp_name1);
		 
		$error= array();
	
		 
	 	if($image1!='')
		{
	 	if($width<2||$height<2)
		 {
			$error[0]="Please Upload an image larger than 2x2 pixels ";
		 }
		}
		
		 
		if($image2!='')
		{
		if($width1<3||$height1<3)
		 {
			$error[1]="Please Upload an image larger than 3x3 pixels";
		 }
		}
		 
		 
		 
		
		return $error;
	}//function validate
	function register($addmemberclass,$editid)
	{
		global $db;
		$postvar = $addmemberclass->getPostVar();
		 $image1	 =	$_FILES['frontpageimage']['name'];
		 $image2	 =	$_FILES['bckimage']['name'];
		 $image3	 =	$_FILES['favicon']['name'];
	 
		  $menu_name=$postvar['name1'];
		  $order	=$postvar['order'];
		  $url		=$postvar['url'];
		  $error=array();
		//$image3	 =	$_FILES['favicon']['name'];
		
		if($image1=="")
		{
			$path="";
		}
		else 
		{
			$path 	     = $this->uploadImg('frontpageimage','upload/');
		}
		
		
		
       if($image2=="")
		{
			$path1="";
		}
		else 
		{
			$path1 	      = $this->uploadImg('bckimage','upload/');
		}
		
		if($image3=="")
		{
			$path2="";
		}
		else 
		{
			$path2       =$this->uploadImg('favicon','upload/');
		}
		
		$name   = trim($postvar['name']);
		$desc1  = addslashes(trim($postvar['desc1']));
		$desc2  = addslashes(trim($postvar['desc2']));
		$desc3  = addslashes(trim($postvar['desc3']));
		
		if($editid!="")
		{
		
		if(!$path=="")
		{
		  $get_fbqry = "SELECT frontpage_background FROM graphics WHERE id = 1";
		  $get_fbres = $db->select_data($get_fbqry);
		  $get_fb    = $get_fbres[0]['frontpage_background'];
		  @unlink("upload/".$get_fb);	
		  $up_sql  = "UPDATE graphics SET `frontpage_background`='$path' WHERE id = 1";
		  $res_sql = $db->update_data($up_sql);
		}
		if(!$path1=="")
		{
		  $get_bbqry = "SELECT banner_background FROM graphics WHERE id = 1";
		  $get_bbres = $db->select_data($get_bbqry);
		   $get_bb    = $get_bbres[0]['banner_background'];
		   @unlink("upload/".$get_bb);
		   $up_sql1= "UPDATE graphics SET `banner_background`='$path1' where id=1";
		   $res_sql1=$db->update_data($up_sql1);
		}
		if(!$path2=="")
		{
			$get_fvqry = "SELECT favicon FROM graphics WHERE id = 1";
		    $get_fvres = $db->select_data($get_fvqry);
		    $get_fv    = $get_fvres[0]['favicon'];
		    @unlink("upload/".$get_fv);
		   $up_sql2= "UPDATE graphics SET `favicon`='$path2' where id=1";
		   $res_sql2=$db->update_data($up_sql2);
		}
		
		 $up_sql3= "update graphics set `website_name`='$name',`footer_html1`='$desc1',`footer_html2`='$desc2',`footer_html3`='$desc3' where id=1";
		 $res_sql3=$db->update_data($up_sql3);
	    }
			
		 
	    $sql_m ="select *from navigation_menu";
		$res_m =$db->select_data($sql_m);
		$cnt   =count($res_m);
		
		for($i=0;$i<$cnt;$i++)
		{
			 $j=$i+1;  
			 $menu_name1=$menu_name[$i];
			 $order1=$order[$i];
			 $url1=$url[$i];
			 $disp='display'.$i;
			 $display=$postvar[$disp];
			   
			  
		   $update_menu="UPDATE `navigation_menu` SET `page_name`='$menu_name1',`page_order`='$order1',`is_page_display`='$display',`url`='$url1' WHERE id='$j'";	 
		   $sql_menu=$db->update_data($update_menu);
		  
		  
		}	 
			if(count($res_sql)>0)
			{
				$msg1="Record Updated Successfully";
				return $msg1;
			}
 
	}// reg
	function update($editid)
	{
	   global $db;
	  $sq2="select * from graphics where `id`='$editid'";
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