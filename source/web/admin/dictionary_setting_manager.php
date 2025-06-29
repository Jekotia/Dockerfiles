<?php 
include("dictionary_setting_class.php");

class dictionary_setting_manager
{
	function chkvalidation($addmemberclass,$editid)
	{
		 global $db;		
		 $error			=	array();
		 $postvar 		= 	$addmemberclass->getPostVar();
		 // $root 			= 	trim($postvar['root']);
	   	 // $part_of_speech =  trim($postvar['part_of_speech']);
	   	 // $meaning 		= 	trim($postvar['meaning']);
	   	 // $ipa 			= 	trim($postvar['ipa']);
	  	 // $source 		= 	trim($postvar['source']);
		 // $sound			=	$_FILES['sound']['name'];
		 // $sound_type	= 	$_FILES['sound']['type'];
		 // $ext 			= 	pathinfo($sound, PATHINFO_EXTENSION);
		 // $allowedExts   = 	array("mp3", "mp4", "wav");
	   
	   // if($root == "")
	   // {
	   	// $error[0] = "Please Enter Root";
	   // }
	    // if($part_of_speech == "")
	   // {
	   	// $error[1] = "Please Enter Part Of Speech";
	   // }
	    // if($meaning == "")
	   // {
	   	// $error[2] = "Please Enter Meaning";
	   // }
	    // if($ipa == "")
	   // {
	   	// $error[3] = "Please Enter IPA";
	   // }
	   // if($source == "")
	   // {
	   	// $error[4] = "Please Enter Source";
	   // }
	   
	   // $sq2		= "select sound from tbl_dictionary where `id`='$editid'";
	   // $sq_sel	= $db->select_data($sq2);
	   // $db_sound= $sq_sel[0]['sound'];
// 		
// 		
// 		
		// if($sound=="" && $db_sound=="" && $editid !="" )
		// {
			// $error[5] = "Please select File";
		// }else
		// if($sound!=="" && !in_array($ext, $allowedExts))
		// {
			 // $error[5]="Please select file with .mp3 or .mp4 or .wav  extentions";			 
		// }	
		 
		return $error;
	  
		 
	}//function validate
	
	function csv_valid()
	{
		$csvfile   = $_FILES["sel_csvfile1"]["name"];		
		$is_csv    = strpos($csvfile, ".csv");
        
		if ($is_csv===FALSE)
		{
			$error[6] = "Please Upload CSV File";
		}	
		if (count($error)==0)
		{
		 	   $message	= $this->csv();
		}
		return $error;
	}
	function csv()
	{
		global $db;
		//$postvar = $addmemberclass -> getPostVar();
		 
		$csvfile     = $_FILES["sel_csvfile1"]["tmp_name"];
		$handle      = fopen($csvfile, 'r');
	 
	    $get_cols = "SHOW COLUMNS FROM `tbl_dictionary`";
		$res=$db->select_data($get_cols);
		$tot_cols = count($res);//Get Total columns from `agent_history` table
		 
		$row=-1;
		//Note : Date Format in csv file is mm/dd/yy
		while (($data = fgetcsv($handle, 1000, "@")) !== FALSE)
		{
			
				$colnms="";
				$values="";
				$upcolumn="";
				$row++;			
				
				 
				 $word=$data[0];
				 $ipa=$data[1];
				 $part_of_speech=$data[2];
				 $meaning=$data[3];
				 $source=$data[4];
				
				if ($row>0)
				{					
	                $select_p = "SELECT * FROM `tbl_dictionary` where `word`='$word'";
					$res_p    = $db->select_data($select_p);					
				    $cnt      = count($res_p);		
				 
				 
	
		              
				    if ($cnt>0)
					{
						$curr_id = $res_p[0]['id'];
				        $up_qry="UPDATE `tbl_dictionary` SET `word`='$word',`ipa`='$ipa',`part_of_speech`='$part_of_speech',`meaning`='$meaning',`source`='$source' WHERE `id`='$curr_id'";					  
					    $res_up=$db->update_data($up_qry);
						 
						 					    
				    }
					if($cnt==0)
					{
						 
						 $ins_qury="INSERT INTO `tbl_dictionary`(word,ipa,part_of_speech,meaning,source) VALUES('$word','$ipa','$part_of_speech','$meaning','$source')";						 					 	
						 $db->insert_data($ins_qury);	
						 
						 			
					}
				}
		}//while		
		
	}
   
    
	function register($addmemberclass,$editid)
	{ 
		global $db;		
		$postvar 	= 	$addmemberclass->getPostVar();
		$root 		= 	trim($postvar['root']);
	   	$part_of_speech = trim($postvar['part_of_speech']);
	   	$meaning 	= 	addslashes(trim($postvar['meaning']));
	   	$ipa 		= 	trim($postvar['ipa']);
	  	$source 	= 	trim($postvar['source']);
		$sound	    =	$_FILES['sound']['name'];
		$name       =   $postvar['name1'];
		$word_space = $postvar['word_space'] ;
		 
		 
		if($sound=="" )
		{
			$path="";
		}		
		else 
		{
			$path 		 = $this->uploadImg('sound','sound_file/');
			$resize_path = "sound_file/".$path;
			$image1 	 = new ImageHadler1();
			$image1->load($resize_path);
			// $a		= 300;
			// $b		= 154;
			// $image1->resize($a,$b);					
			//$image1->save('upload/slider/thumb/'.$path);
		}
		
		if($root!=''||$part_of_speech!=''||$meaning!=''||$ipa!=''||$source!=''||$sound!='')		
		{					
			$sql 		=	"INSERT INTO  tbl_dictionary(`word`, `ipa`, `part_of_speech`, `meaning`, `source`,`sound`)VALUES('$root','$ipa','$part_of_speech','$meaning','$source','$path')";	
			$res_insert	=	$db->insert_data($sql);
			$in_id   	= 	mysql_insert_id();
			if(count($res_insert)>0)
			{
				$msg="Record of Root Inserted Successfully";
			 
										
			}			
					
		}
		    $qry="select *from visibility";
			$res_qry=$db->select_data($qry);
			
			
		    $count=count($res_qry);
		     
			for($i=0;$i<$count;$i++)
			{
				$disp='display'.$i;
				
				$display=$postvar[$disp];
				$pagename=$name[$i];
			
				$id=$res_qry[$i]['id'];
				$query="UPDATE `visibility` SET `is_page_display`='$display',`page_name`='$pagename' WHERE id='$id'";
			    
				$res_sql=$db->update_data($query);
				
			}	
			
			$qry1="select *from  abbriviations_settings";
			$res_qry1=$db->select_data($qry1);
			
			
		    $count1=count($res_qry1);
		    
			for($i=0;$i<$count1;$i++)
			{
				$disp='display1'.$i;
				$display=$postvar[$disp];
				 
			
				$id=$res_qry[$i]['id'];
				$query="UPDATE `abbriviations_settings` SET `page_display`='$display' WHERE id='$id'";
			    
				$res_sql=$db->update_data($query);
				
			}
			
			$qry2="select * from  words_spacing";
			$res_qry2=$db->select_data($qry2);
			$words_spacing= $res_qry2[0]['word_spacing'];
			$count2=count($res_qry2);
		    
		    
			
			  $query="UPDATE `words_spacing` SET `word_spacing`='$word_space' WHERE id=1";
			    
				$res_sql=$db->update_data($query);
				
			
			if(count($res_sql)>0)
			{
				$msg.="<br/>"."Record of  Language Settings Updated Successfully";
				return $msg;
				
			}
			
	} // reg
	function updat($editid)
	{
	   global $db;
	   $sq2="select * from words_spacing where `id`='$editid'";
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