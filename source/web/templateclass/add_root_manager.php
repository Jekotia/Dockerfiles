<?php 
include("add_root_class.php");

class add_root_manager
{
	function chkvalidation($addmemberclass,$editid)
	{
		 global $db;		
		 $error			=	array();
		 $postvar 		=   $addmemberclass->getPostVar();
		 $root 			= 	trim($postvar['root']);
	   	 $part_of_speech=   trim($postvar['part_of_speech']);
	   	 $meaning 		= 	trim($postvar['meaning']);
	   	 $ipa 			= 	trim($postvar['ipa']);
	  	 $source 		= 	trim($postvar['source']);
	   	 $sound			=	$_FILES['sound']['name'];
		 $sound_type	= 	$_FILES['sound']['type'];
		 $ext 			= 	pathinfo($sound, PATHINFO_EXTENSION);
		 $allowedExts = array("mp3", "mp4", "wav");
		
		 
	   if($root == "")
	   {
	   	$error[0] = "Please Enter Root";
	   }
	    if($part_of_speech == "")
	   {
	   	$error[1] = "Please Enter Part Of Speech";
	   }
	    if($meaning == "")
	   {
	   	$error[2] = "Please Enter Meaning";
	   }
	    if($ipa == "")
	   {
	   	$error[3] = "Please Enter IPA";
	   }
	   if($source == "")
	   {
	   	$error[4] = "Please Enter Source";
	   }
	  		
	   $sq2="select sound from tbl_dictionary where `id`='$editid'";
	   $sq_sel=$db->select_data($sq2);
	   $db_sound = $sq_sel[0]['sound'];
		
		
		// if($sound=="" && $editid == "")
		// {
			// $error[5] = "Please select File";
		// }else	
		// if($sound=="" && $db_sound=="" && $editid !="" )
		// {
			// $error[5] = "Please select File";
		// }
		// else
		// if($sound!=="" && !in_array($ext, $allowedExts))
		// {
			 // $error[5]="Please select file with .mp3 or .mp4 or .wav  extentions";			 
		// }	
			
		return $error;
	  
		
	}//function validate
	
	function register($addmemberclass,$editid)
	{
		global $db;		
		$postvar 		= 	$addmemberclass->getPostVar();
		$root 			= 	trim($postvar['root']);
	   	$part_of_speech = 	trim($postvar['part_of_speech']);
	   	$meaning 		= 	addslashes(trim($postvar['meaning']));
	   	$ipa 			= 	trim($postvar['ipa']);
	  	$source 		= 	trim($postvar['source']);
		$sound			=	$_FILES['sound']['name'];
		if($sound=="" )
		{
			$path="";
		}		
		else 
		{
			$path 	= $this->uploadImg('sound','sound_file/');
			$resize_path = "sound_file/".$path;
			$image1 = new ImageHadler1();
			$image1->load($resize_path);
			// $a		= 300;
			// $b		= 154;
			// $image1->resize($a,$b);					
			//$image1->save('upload/slider/thumb/'.$path);
		}
		
		if($editid=="")		
		{
					
			$sql ="INSERT INTO  tbl_dictionary(`word`, `ipa`, `part_of_speech`, `meaning`, `source`,`sound`)VALUES('$root','$ipa','$part_of_speech','$meaning','$source','$path')";	
			$res_insert	=	$db->insert_data($sql);
			$in_id   = mysql_insert_id();
			if(count($res_insert)>0)
			{
				$msg ="Root Inserted Successfully";
										
			}			
			return $msg;		
		}
		else
		{
			$up_sql = "UPDATE tbl_dictionary SET `word`='$root',`ipa`='$ipa',`part_of_speech`='$part_of_speech',`meaning`='$meaning',`source`='$source' ";
		  	
		  	if($path!="")
			{
			   	 $select_sql = "SELECT * FROM tbl_dictionary WHERE id = '$editid'";
			   	 $res_select = $db->select_data($select_sql);
				 $prev_file  = $res_select[0]['sound'];
				 @unlink('sound_file/'.$prev_file);
				 //@unlink('upload/slider/thumb/'.$prev_img);
			   	 $up_sql .= ",`sound`='$path'";
			}
		  	$up_sql .= "WHERE id = '$editid'";
		  	$res_sql = $db->update_data($up_sql);
		}
			if(count($res_sql)>0)
			{
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