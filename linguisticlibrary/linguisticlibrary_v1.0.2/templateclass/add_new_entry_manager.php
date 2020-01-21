<?php

include('add_new_entry_class.php');     
header('Content-Type: text/html; charset=utf-8');
class addnew
{ 
function add_entry($addentryclass,$editid)
{
 global $db;
 $postvar    =$addentryclass->getPostVar();
 $ordersty1  =$postvar['synd_order'];
 $synd_text1 =$postvar['synd_text'];
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
		
 if(isset($_SESSION['ADMIN_ID']))
 {		
    $val        =$_SESSION['ADMIN_ID'];
	$user_type  ='admin';
 }  
 if(isset($_SESSION['author_id']))
 {		
    $val        =$_SESSION['author_id'];
	$user_type  ='author';
 }   
 //////////////////////ACCESS SUB SPLIT VALUES/////////////////////////
 $eng_txt_sub   = $postvar['eng_txt_sub'];
 
 $eng_order_sub = $postvar['eng_order_sub'];   
 $synd_txt_sub  = $postvar['synd_text_sub'];
 $synd_order_sub=$postvar['synd_order_sub'];
 $id            = $postvar['curr_id'];
	
	    $linecnt=0;
		$get_sel = "SELECT * FROM `tbl_menu` WHERE `parent_id`=0";
		$get_res = $db->select_data($get_sel);
		$get_cnt = count($get_res);
		$mfcnt=0;
		
			
  if($editid==''&& $val!='')
   {	
 $queryt     ="insert into add_post(user_id,user_type,post_name,accessibility,search_tags,added_date) values('$val','$user_type','$postname','$access','$searchtags',now())";
 $query_sql  =$db->insert_data($queryt);
 $insert_id  =mysql_insert_id();
 //echo count($ordersty);
 for($i=0;$i<count($ordersty1);$i++)
 {
 	  $ordersty2 =$ordersty1[$i];
	  $synd_text2=$synd_text1[$i];
	  $eng_order2=$eng_order1[$i];
	  $eng_txt2  =$eng_txt1[$i];
	  
	  $morpho2   =$morpho1[$i];
	  $anno2     =$anno1[$i];
	  $alpha1    =$alpha[$i];
	  $alpha_image1=$alpha_image[$i];
	  
	  $root_sty1 =$root_sty[$i];//
	  
	  
	  $sound1    =$_FILES['file_sound']['name'][$i];
	  
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
	 if ($ordersty2!='' && $synd_text2!=''&&$eng_order2!=''&&$eng_txt2!='')// &&$root_sty1!='' 
	{
    $query    ="INSERT INTO `add_new_entry`(`post_id`,`sindarin_order`, `sindarin_text`, `english_order`, `english_text`,`root_word`,`alphabetic`,`alphabetic_image`,`menu_id`,`annotation`) VALUES('$insert_id','$ordersty2','$synd_text2','$eng_order2','$eng_txt2','$root_sty1','$alpha1','$alpha_image1','$morpho3','$anno2')";
	$query_sql=$db->insert_data($query);
	$in_id=mysql_insert_id();
	 
	
	}
	 
	if ($sub_eng_text!="")
	{
      $query    ="INSERT INTO `add_new_entry`(`post_id`,`sindarin_order`, `sindarin_text`, `english_order`, `english_text`,`root_word`,`alphabetic`,`alphabetic_image`,`menu_id`,`annotation`) VALUES('$insert_id','$ordersty2','$synd_text2','$sub_eng_order','$sub_eng_text','$root_sty1','$alpha1','$alpha_image1','$morpho3','$anno2')";		
	  $query_sql=$db->insert_data($query);
	  
	}
	
	if ($synd_txt_sub1!="")
	{
      $query    ="INSERT INTO `add_new_entry`(`post_id`,`sindarin_order`, `sindarin_text`, `english_order`, `english_text`,`root_word`,`alphabetic`,`alphabetic_image`,`menu_id`,`annotation`) VALUES('$insert_id','$synd_order_sub1','$synd_txt_sub1','$eng_order2','$eng_txt2','$root_sty1','$alpha1','$alpha_image1','$morpho3','$anno2')";		
	  $query_sql=$db->insert_data($query);
	  
	}
	//$msg      ="Insert Successfully";
	
 }
  }
   header('Location:entry.php?link_page=library&id='.$insert_id.'&postname='.$postname);
 	//return $msg;	
	
}

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