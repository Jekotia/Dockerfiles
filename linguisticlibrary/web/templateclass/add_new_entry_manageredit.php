<?php
include('templateclass/add_new_entry_class.php');     

class addnew
{
	
 
	function add_entry($addentryclass,$editid)
	{
	 global $db;
	 $postvar    =$addentryclass->getPostVar();
	 $ordersty1  =$postvar['synd_order'];
	 $synd_text1 =$postvar['synd_text'];
	 $synd_hide  =$postvar['synd_hide'];
	 $eng_order1 =$postvar['eng_order'];
	 $eng_txt1   =$postvar['eng_txt'];
	 
	 $anno1      =$postvar['anno'];
	 $postname   =$postvar['txt1'];
	 $alpha      =$postvar['alpha']; 
	 $alpha_image=$postvar['alpha_image'];
	 
	 $root_sty   =$postvar['root_sty'];
	 $access     =$postvar['rd1'];
	 $searchtags =$postvar['searchtag'];
	 // $sound		 =$_FILES['file_sound']['name'];
			
	 $val        =$_SESSION['author_id'];
	    
	 //////////////////////ACCESS SUB SPLIT VALUES/////////////////////////
	   $eng_txt_sub   = $postvar['eng_txt_sub'];
	   $eng_order_sub = $postvar['eng_order_sub'];   
	   $synd_txt_sub  = $postvar['synd_text_sub'];
	   $synd_order_sub= $postvar['synd_order_sub'];
	   $id            = $postvar['curr_id'];
	   $hidden_arr    = $postvar['curr_id'];
		
		//$hidden_arr   = array_filter($hidden_arr);
		$edit_cnt     = count($hidden_arr);
	 	          
	
	 
	  	if($postname!='')
	  	{
	    // $queryt     ="UPDATE `add_post` SET `post_name`='$postname',`accessibility`='$access',`search_tags`='$searchtags',`added_date`='now()' WHERE id='$editid'";
	      $queryt      ="UPDATE `add_post` SET `post_name`='$postname',`accessibility`='$access',`search_tags`='$searchtags',`added_date`=now(),`modify_date`=now() WHERE id='$editid'";
	    
	      $query_sql   =$db->update_data($queryt);
	  
	    }
		
	    //echo count($ordersty1);  
	    // Update For Loop
	    $linecnt=0;
		$get_sel = "SELECT * FROM `tbl_menu` WHERE `parent_id`=0";
		$get_res = $db->select_data($get_sel);
		$get_cnt = count($get_res);
		$mfcnt=0;
	 for($i=0;$i<$edit_cnt;$i++)
	 {
	 	  $ordersty2 =trim($ordersty1[$i]);
		  $synd_text2=trim($synd_text1[$i]);
		  $eng_order2=trim($eng_order1[$i]);
		  $eng_txt2  =trim($eng_txt1[$i]);
		 
		  
		  $anno2       =$anno1[$i];
		  $alpha1      =$alpha[$i];
		  $alpha_image1=$alpha_image[$i]; 
		  $root_sty1   =$root_sty[$i];
		  $query       ="select sindarin_order from add_new_entry where sindarin_order='$ordersty2'";
		  $resquery    =$db->select_data($query);
		  $sin_order      =$resquery[0]['sindarin_order'];
		  // $sound1      =$_FILES['file_sound']['name'][$i];
		  $morpho3="";
		
		  for ($mmc=0;$mmc<$get_cnt;$mmc++)
		  {
		  	//echo "MM=$mm";
		    $val         ='morpho_'.$mfcnt;
		    $morpho1     =$postvar[$val];
		
			if (count($morpho1)>0){
				$morpho1 = implode(",", $morpho1);
				if ($mmc==0 && $morpho1!="")
				    $morpho3     =$morpho1;	
				else
				{
					if ($morpho1!="")
						$morpho3.=",".$morpho1;						
				}				
			}//if 
		  	$mfcnt++;			
		  }
		  $morpho3 = explode(",", $morpho3);
		  $morpho3 = array_filter($morpho3);
		  $morpho3 = implode(",", $morpho3);
		   
		  $id1=$id[$i];
		  
		  /////////////ACCESS SUB ENGLISH SPLIT INFORMATION///////////////////////
		 $sub_eng_order   = $eng_order_sub[$i];
		 $sub_eng_text    = $eng_txt_sub[$i];
		 $synd_txt_sub1   = $synd_txt_sub[$i];
		 $synd_order_sub1 = $synd_order_sub[$i];
		  
	      
		 
		 // if($sound1=="" )
			// {
				// $path="";
			// }		
			// else 
			// {
				// $path 		 = $this->uploadImg('file_sound','sound_file');
			    // $resize_path = "sound_file".$path;
// 			 
				// $image1 	 = new ImageHadler1();
				// $image1->load($resize_path);
// 				 
			// }
		
		//if($root!='')
		//{	
		if($eng_order2!=''&&$ordersty2!=''&&$synd_text2!=''&&$eng_txt2!='')
		{
			$linecnt++;
	     $query    ="UPDATE `add_new_entry` SET `sindarin_order`='$ordersty2',`sindarin_text`='$synd_text2',`english_order`='$eng_order2',`english_text`='$eng_txt2',`root_word`='$root_sty1',`alphabetic_image`='$alpha_image1'";
	      
	     $query.= ",`alphabetic`='$alpha1',`annotation`='$anno2'";
		  
	     if($morpho3!='')
		 {
	       $query.=",`menu_id`='$morpho3'";
		 }
		  $query.=" WHERE  id='$id1'";
		  
		 $query_sql=$db->update_data($query);
		 
		 
		 } 
		// Insertion in Update Mode for split data
		if ($sub_eng_text!="")
		{
	       $query    ="INSERT INTO `add_new_entry`(`post_id`,`sindarin_order`, `sindarin_text`, `english_order`, `english_text`,`root_word`,`alphabetic`,`alphabetic_image`,`menu_id`,`annotation`) VALUES('$editid','$ordersty2','$synd_text2','$sub_eng_order','$sub_eng_text','$root_sty1','$alpha1','$alpha_image1','$morpho3','$anno2')";		
		   $query_sql=$db->insert_data($query);		  
		}
		
		if ($synd_txt_sub1!="")
		{
	      $query    ="INSERT INTO `add_new_entry`(`post_id`,`sindarin_order`, `sindarin_text`, `english_order`, `english_text`,`root_word`,`alphabetic`,`alphabetic_image`,`menu_id`,`annotation`) VALUES('$editid','$synd_order_sub1','$synd_txt_sub1','$eng_order2','$eng_txt2','$root_sty1','$alpha1','$alpha_image1','$morpho3','$anno2')";		
		  $query_sql=$db->insert_data($query);
		 
		}
		 
		$msg="Existing Posts Updated Successfully";
	
		
	 //}
	 }

  // Insert case
	 $j=$edit_cnt;
	 for($i=$j;$i<count($ordersty1);$i++)
	 {
	 	  $ordersty2 =trim($ordersty1[$i]);
		   
		  $synd_text2=trim($synd_text1[$i]);
		  $eng_order2=trim($eng_order1[$i]);
		  $eng_txt2  =trim($eng_txt1[$i]);
		 
	      
		  $anno2     =$anno1[$i];
		  $alpha1    =$alpha[$i];
		  $alpha_image1=$alpha_image[$i];
		  $root_sty1 =$root_sty[$i];
		  // $sound1    =$_FILES['file_sound']['name'][$i];
		  
		  
		  
          $morpho3="";
		
		  for ($mmc=0;$mmc<$get_cnt;$mmc++)
		  {
		  	//echo "MM=$mm";
		    $val         ='morpho_'.$mfcnt;
		    $morpho1     =$postvar[$val];
		
			if (count($morpho1)>0){
				$morpho1 = implode(",", $morpho1);
				if ($mmc==0 && $morpho1!="")
				    $morpho3     =$morpho1;	
				else
				{
					if ($morpho1!="")
						$morpho3.=",".$morpho1;						
				}				
			}//if 
		  	$mfcnt++;			
		  }
		  $morpho3 = explode(",", $morpho3);
		  $morpho3 = array_filter($morpho3);
		  $morpho3 = implode(",", $morpho3);
		  
		  
		  $id1=$id[$i];
		  
		  $query   ="select root_word from add_new_entry where root_word='$root_sty1'";
		  $resquery=$db->select_data($query);
		  $root    =$resquery[0]['root_word'];
		  
		  /////////////ACCESS SUB ENGLISH SPLIT INFORMATION///////////////////////
		  $sub_eng_order   = $eng_order_sub[$i];
		  $sub_eng_text    = $eng_txt_sub[$i];
		  $synd_txt_sub1   = $synd_txt_sub[$i];
		  $synd_order_sub1 = $synd_order_sub[$i];
		  
	      
		 
		 // if($sound1=="" )
			// {
				// $path="";
			// }		
			// else 
			// {
				// $path 		 = $this->uploadImg('file_sound','sound_file');
			    // $resize_path = "sound_file".$path;
// 			 
				// $image1 	 = new ImageHadler1();
				// $image1->load($resize_path);
// 				 
			// }
		if($postname!=''&& $eng_order2!=''&& $ordersty2!=''&& $synd_text2!=''&& $eng_txt2!='')
		{
	    $query    ="INSERT INTO `add_new_entry`(`post_id`,`sindarin_order`, `sindarin_text`, `english_order`, `english_text`,`root_word`,`alphabetic`,`alphabetic_image`,`menu_id`,`annotation`) VALUES('$editid','$ordersty2','$synd_text2','$eng_order2','$eng_txt2','$root_sty1','$alpha1','$alpha_image1','$morpho3','$anno2')";
		$query_sql=$db->insert_data($query);
		 
		} 
		if ($sub_eng_text!="")
		{
	      $query    ="INSERT INTO `add_new_entry`(`post_id`,`sindarin_order`, `sindarin_text`, `english_order`, `english_text`,`root_word`,`alphabetic`,`alphabetic_image`,`menu_id`,`annotation`) VALUES('$editid','$ordersty2','$synd_text2','$sub_eng_order','$sub_eng_text','$root_sty1','$alpha1','$alpha_image1','$morpho3','$anno2')";		
		  $query_sql=$db->insert_data($query);
		  
		}
		
		if ($synd_txt_sub1!="")
		{
	      $query    ="INSERT INTO `add_new_entry`(`post_id`,`sindarin_order`, `sindarin_text`, `english_order`, `english_text`,`root_word`,`alphabetic`,`alphabetic_image`,`menu_id`,`annotation`) VALUES('$editid','$synd_order_sub1','$synd_txt_sub1','$eng_order2','$eng_txt2','$root_sty1','$alpha1','$alpha_image1','$morpho3','$anno2')";		
		  $query_sql=$db->insert_data($query);
		 
		}
		 
		//$msg.="<br/>And New Posts Inserted Successfully";
		
	 	
	 	}	
     return $msg;	
	}//function
	
	function uploadImg($imgName,$dirname="")
		{
				$img_suffix = rand(0, 89999);
			    $cnt=count($_FILES[$imgName]['name']);
				for($i=0;$i<$cnt;$i++)
				{
				if($_FILES[$imgName]['name'][$i]!="")
				{
					$image_part = explode(".",$_FILES[$imgName]['name'][$i]);
					$temp = $image_part[0];
					$dest = $dirname."/".$temp."_$img_suffix.".$image_part[1];
					 
					if(move_uploaded_file($_FILES[$imgName]['tmp_name'][$i],$dest))
					{
						return $image_part[0]."_$img_suffix.".$image_part[1];
					}	
				}
		}	
	
	}
}
     
?>