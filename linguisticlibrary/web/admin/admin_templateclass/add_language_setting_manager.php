<?php 
include("add_language_setting_class.php");


class add_language_setting_manager
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
	    // $cnt1=fgetcsv($csvfile);
	 
		$is_csv    = strpos($csvfile, ".csv");
        
		if ($is_csv===FALSE)
		{
			$error[6] = "Please Upload CSV File";
		}	
		if (count($error)==0)
		{
		 	   $message	= $this->csv();
			 
		    // echo $sql="DROP TABLE tbl_dir";
			 //     $qur=mysql_query($sql);
// 			 
			 // $column=array('word','ipa','part_of_speech','meaning','source'); 
// 			 
// 			 
// 	 
// 			 
// 			  
		// echo $sql1="CREATE TABLE IF NOT EXISTS `tbl_dir` (`id` int(11) NOT NULLAUTO_INCREMENT,`name` varchar(255) NOT NULL,PRIMARY KEY (`id`)) "; 
             // $qur1=mysql_query($sql1);
		}
		return $error;
	}
	function csv()
	{
		global $db;
		//$postvar = $addmemberclass -> getPostVar();
		
			 
		$csvfile     = $_FILES["sel_csvfile1"]["tmp_name"];
		$handle      = fopen($csvfile, 'r');
		
		 $col_cnt = fgetcsv($handle, 1000, "@");
	  $cnt=count($col_cnt);
//	print_r($col_cnt);
                 $sql="DROP TABLE tbl_dir";
			      $qur=mysql_query($sql);
          
			 
			// $column=array('word','ipa','part_of_speech','meaning','source'); 
			 
			 
			 
	
	        $sql1="CREATE TABLE IF NOT EXISTS `tbl_dir` (`id` int(11) NOT NULL AUTO_INCREMENT,";
             for($i=0;$i<$cnt;$i++)
			 {
			 		
			 	$sql1.="`$col_cnt[$i]` varchar(255) NOT NULL,"; 
             
			
			 }	
	         $sql1.="PRIMARY KEY (`id`))";
           //echo $sql1 ;
          // die; 		
		  $qur1=mysql_query($sql1); 
	 
	    // $get_cols = "SHOW COLUMNS FROM `tbl_dir`";
		// $res=$db->select_data($get_cols);
		// $tot_cols = count($res);//Get Total columns from `agent_history` table
		 
		 
		  $get_cols = $db->select_data("SHOW COLUMNS FROM `tbl_dir`");
		  $tot_cols = count($get_cols);
		  
		$row=-0;
		//Note : Date Format in csv file is mm/dd/yy
		while (($data = fgetcsv($handle, 1000, "@")) !== FALSE)
		{
			
			   
				
				$colnms="";
				$values="";
				$upcolumn="";
			 	 $row++;	
			//	 'word','ipa','part_of_speech','meaning','source'
				 // if ($row==1) //At 1st row Agent Information is provided in Agent CSV is stored here in variables
				// {
					// $ID        = $data[0];
					// $word      = $data[1];
					// $ipa       = $data[2];
					// $part_of_speech    = $data[3];
					// $meaning      =  $data[4] ;//06/23/14 date in csv converted to database compatible format for comparision operations
					  // // Replace array value by required format as it is reffered in query generation directly as it is.										
					// $source = $data[5];//$data[6] to $data[9] are taken from csv each time for insertion
// 					 								 
				// }
				// else // At later rows 1st row Agent Information is set to empty data set from csv for consistency
				// {
					// $data[0] = $ID;
					// $data[1] = $word;
					// $data[2] = $ipa;
					// $data[3] = $part_of_speech;
					// $data[4] = $meaning;					
					// $data[5] = $source;//$data[6] to $data[9] are taken from csv each time for updation
// 					 				
				// }								
				
				
				  
		//	echo	  $nuncls=count($data);
				
				if ($row>0)
				{					
	                echo	 $row;
					
	//In below for loop, the $iq=1 is set to skip 1st column `id` which is auto_increment and has no role in insert & update query 
				for ($i1=1; $i1 < $tot_cols; $i1++) { 

//Insert Query Generation
					 	$colnms.="`".$get_cols[$i1][0]."`";																	
					 	$values.="'".$data[$i1-1]."'";
					
//Update Query Generation
					 	$upvalue="'".$data[$i1-1]."'";							 						  						  
					 	$upcolumn.="`".$get_cols[$i1][0]."`"."=".$upvalue; 
					 
//Append ,(comma) to query till second last in the insert/update query
					    if ($i1 < $tot_cols-1)
						{
							$colnms.=",";
							$values.=",";
							$upcolumn.=",";
							
						}//if
						 
						 			   
		             }//for	
						 /*$ins_qury="INSERT INTO `tbl_dictionary`(word,ipa,part_of_speech,meaning,source) VALUES('$word','$ipa','$part_of_speech','$meaning','$source')";						 					 	
						 $db->insert_data($ins_qury);	*/
						 
							echo $ins_qury="INSERT INTO `tbl_dir`($colnms) VALUES($values)";						 					 	
						
						  $db->insert_data($ins_qury);		
					
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
		 
		 
		if($sound=="")
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
		
/*		if($root!=''||$part_of_speech!=''||$meaning!=''||$ipa!=''||$source!=''||$sound!='')		
		{					
			$sql 		=	"INSERT INTO  tbl_dir(`word`, `ipa`, `part_of_speech`, `meaning`, `source`,`sound`)VALUES('$root','$ipa','$part_of_speech','$meaning','$source','$path')";	
			$res_insert	=	$db->insert_data($sql);
			$in_id   	= 	mysql_insert_id();
			if(count($res_insert)>0)
			{
				$msg="Record of Root Inserted Successfully";
			 
										
			}			
					
		}*/
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