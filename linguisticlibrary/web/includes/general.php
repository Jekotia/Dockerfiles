<?php
//client side pagination added by Atul
function get_pagination($tblname,$whereqry,$passurl,$limit,$targetpage)
{
	global $db;
/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT COUNT(*) as num FROM $tblname WHERE $whereqry";
	
	 $total_pages = @mysql_fetch_array(mysql_query($query));
     $total_pages = $total_pages[num];
	
	
	// $total_pages 		 = $db->select_data($total_pages);
	// $tour_title  	 = $total_pages[0]['tour_title']; 
	// $tour_image 	 = $total_pages[0]['image'];
	// $all_img    	 = explode(",", $tour_image);
	// $tot_img    	 = count($all_img);
	// $first_img  	 = $all_img[0]; 
// 	
	// $adult_price  	 = $total_pages[0]['adult_price'];
	// $child_price  	 = $total_pages[0]['child_price'];
// 	
// if($lang_code=='en')
 // {	
	// $tour_duration 	 = $total_pages[0]['duration'];
	// $tour_date    	 = $total_pages[0]['tour_date']; 
 	// $info         	 = $total_pages[0]['info'];
	// $tour_highlight  = $total_pages[0]['tour_highlight']; 
	// $inclusions   	 = $total_pages[0]['inclusions'];
	// $exclusions   	 = $total_pages[0]['exclusions'];
	// $notes        	 = $total_pages[0]['notes'];
	// $redem_ins    	 = $total_pages[0]['redmptn_instrn'];
	// $departure_pt 	 = $total_pages[0]['departure_point'];
 // }
// 	
 // else if($lang_code=='spn')
 // {
// 	
	// $tour_duration 	 = $total_pages[0]['spn_duration'];
	// $tour_date    	 = $total_pages[0]['spn_tour_date']; 
 	// $info         	 = $total_pages[0]['spn_info'];
	// $tour_highlight  = $total_pages[0]['spn_tour_highlight'];
 	// $inclusions   	 = $total_pages[0]['spn_inclusions'];
	// $exclusions   	 = $total_pages[0]['spn_exclusions'];
	// $notes        	 = $total_pages[0]['spn_notes'];
	// $redem_ins    	 = $total_pages[0]['spn_redmptn_instrn'];
	// $departure_pt 	 = $total_pages[0]['spn_departure_point'];
 // }
// 	 
	/* Setup vars for query. */
	//$targetpage = "tour.php"; 	//your file name  (the name of this file)
	//$limit =2; 								//how many items to show per page
	$page1 = $_GET['page'];
	if($page1) 
		$start = ($page1 - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	

    $sql = "SELECT * FROM $tblname WHERE $whereqry LIMIT $start, $limit";

	$result3 =$db->select_data($sql);
	/* Setup page vars for display. */
	if($page1 == 0) $page1 = 1;					//if no page var is given, default to 1.
	$prev = $page1 - 1;							//previous page is page - 1
	$next = $page1 + 1;							//next page is page + 1
    $lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
    $pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page1 > 1) 
			if($show=="")
			{
			$pagination.= "<a href=\"$targetpage?page=$prev$passurl\">previous</a>";
			}
			else
			{
				$pagination.= "<a href=\"$targetpage?show=$show&page=$prev$passurl\">previous </a>";
			}
		else
			$pagination.= "<span class=\"disabled\">previous </span>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page1)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					if($show=="")
					{
						$pagination.= "<a href=\"$targetpage?page=$counter$passurl\">$counter</a>";
					}	
					else
					{
						$pagination.= "<a href=\"$targetpage?show=$show&page=$counter$passurl\">$counter</a>";
					}				
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page1 < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					
					if ($counter == $page1)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						if($show=="")
						{
							$pagination.= "<a href=\"$targetpage?page=$counter$passurl\">$counter</a>";
						}	
						else 
						{
						$pagination.= "<a href=\"$targetpage?show=$show&page=$counter$passurl\">$counter</a>";
						}				
				}
				$pagination.= "...";
				if($show=="")
				{
					$pagination.= "<a href=\"$targetpage?page=$lpm1$passurl\">$lpm1</a>";
					$pagination.= "<a href=\"$targetpage?page=$lastpage$passurl\">$lastpage</a>";
				}		
				else 
				{
					$pagination.= "<a href=\"$targetpage?show=$show&page=$lpm1$passurl\">$lpm1</a>";
					$pagination.= "<a href=\"$targetpage?show=$show&page=$lastpage$passurl\">$lastpage</a>";
				}
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page1 && $page1 > ($adjacents * 2))
			{
				if($show=="")
				{
					$pagination.= "<a href=\"$targetpage?page=1$passurl\">1</a>";
					$pagination.= "<a href=\"$targetpage?page=2$passurl\">2</a>";
				}
				else 
				{
					$pagination.= "<a href=\"$targetpage?show=$show&page=1$passurl\">1</a>";
					$pagination.= "<a href=\"$targetpage?show=$show&page=2$passurl\">2</a>";
				}
				$pagination.= "...";
				for ($counter = $page1 - $adjacents; $counter <= $page1 + $adjacents; $counter++)
				{
					if ($counter == $page1)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						if($show=="")
						{
							$pagination.= "<a href=\"$targetpage?page=$counter$passurl\">$counter</a>";
						}	
						else 
						{
							$pagination.= "<a href=\"$targetpage?show=$show&page=$counter$passurl\">$counter</a>";
						}				
				}
				$pagination.= "...";
				if($show=="")
				{
					$pagination.= "<a href=\"$targetpage?page=$lpm1$passurl\">$lpm1</a>";
					$pagination.= "<a href=\"$targetpage?page=$lastpage$passurl\">$lastpage</a>";
				}		
				else
				{
					$pagination.= "<a href=\"$targetpage?show=$show&page=$lpm1$passurl\">$lpm1</a>";
					$pagination.= "<a href=\"$targetpage?show=$show&page=$lastpage$passurl\">$lastpage</a>";
				}
			}
			//close to end; only hide early pages
			else
			{
				if($show=="")
				{
					$pagination.= "<a href=\"$targetpage?page=1$passurl\">1</a>";
					$pagination.= "<a href=\"$targetpage?page=2$passurl\">2</a>";
				}
				else
				{
					$pagination.= "<a href=\"$targetpage?show=$show&page=1$passurl\">1</a>";
					$pagination.= "<a href=\"$targetpage?show=$show&page=2$passurl\">2</a>";
				}
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page1)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						if($show=="")
						{
							$pagination.= "<a href=\"$targetpage?page=$counter$passurl\">$counter</a>";
						}
						else
						{
							$pagination.= "<a href=\"$targetpage?show=$show&page=$counter$passurl\">$counter</a>";
						}					
				}
			}
		}
		
		//next button
		if ($page1 < $counter - 1) 
			$pagination.= "<a href=\"$targetpage?page=$next$passurl\">next</a>";
		else
			$pagination.= "<span class=\"disabled\">next</span>";
		    $pagination.= "</div>\n";		
	
	}

/****  End ****/	  
   return array($pagination,$result3);	
}	  


//============================================================================================================================
// Google Ad size category

function Check_Block_User_Index($uid)
{
		global $db;
		 $sql_check_block_members = "SELECT user_id FROM ad_member_blocked WHERE user_id='".$uid."'";
		$res_check_block_members = $db->select_data($sql_check_block_members);
			$all_block_id = $res_check_block_members[0]['user_id'];
		
		return $all_block_id;
}

function Check_Block_User($uid)
{
		global $db;
		 $sql_check_block_members = "SELECT user_id FROM ad_member_blocked WHERE user_id='".$uid."' and blocked_id='".$_SESSION['USER_ID']."'";
		$res_check_block_members = $db->select_data($sql_check_block_members);
		$all_block_id = $res_check_block_members[0]['user_id'];
		
		return $all_block_id;
}

function get_blog_comm_cnt($bid)
	{
		global $db;			
		$sql_select= "select count(*) as cnt from kb_blog_comment where status='Y' and blog_id='$bid'";
		$res_catnm = $db->select_data($sql_select);
		return $res_catnm[0]['cnt'];
	}
function get_user_name($uid)
	{
		global $db;			
		$sql_select= "select fname,username from kb_member where user_id='$uid'";
		$res_catnm = $db->select_data($sql_select);
		
		if($res_catnm[0]['fname']!="")
		{
			$usernm = $res_catnm[0]['fname'];
		}elseif($res_catnm[0]['username']!=""){
			$usernm = $res_catnm[0]['username'];
		}
		
		return $usernm;
	}
	
function getCatList($catid)
	{
		global $db;
		$sql_cat="SELECT * FROM `kb_blog_category` where status='Y'";
		$res_cat=$db->select_data($sql_cat);
		if(count($res_cat)>0)
		{
			$CatList	= "<option value='' selected>Select</option>";
			for($i=0;$i<count($res_cat);$i++)			
			{
				$metroId		= $res_cat[$i]['cat_id'];
				$metroName	= $res_cat[$i]['cat_name'];
				if($catid==$metroId)
				{
					$CatList	.="<option value=".$metroId." selected>$metroName</option>";
				}
				else
				{
					$CatList	.="<option value=".$metroId.">$metroName</option>";
				}
			} // for
			return $CatList;
		}
						
	} // optlist

	function getGoogleSizeCat($catid)
	{
		global $db;
		$sql_cat="SELECT * FROM `rs_google_ads_format`";
		$res_cat=$db->select_data($sql_cat);
		if(count($res_cat)>0)
		{
			$formatCategory	= "<option value='' selected>Select</option>";
			for($i=0;$i<count($res_cat);$i++)			
			{
				$formatid		= $res_cat[$i]['f_id'];
				$format_size	= $res_cat[$i]['f_text'];
				if($catid==$formatid)
					$formatCategory	.="<option value=".$formatid." selected>$format_size</option>";
				else
					$formatCategory	.="<option value=".$formatid.">$format_size</option>";
				
			} // for
			return $formatCategory;
		}
						
	}
//============================================================================================================================
  // childcare category

	function getMetroList($catid)
	{
		global $db;
		$sql_cat="SELECT * FROM `ch_metroarea`";
		$res_cat=$db->select_data($sql_cat);
		if(count($res_cat)>0)
		{
			$metroList	= "<option value='' selected>Select</option>";
			for($i=0;$i<count($res_cat);$i++)			
			{
				$metroId		= $res_cat[$i]['metro_id'];
				$metroName	= $res_cat[$i]['metro_area'];
				if($catid==$metroId)
					$metroList	.="<option value=".$metroId." selected>$metroName</option>";
				else
					$metroList	.="<option value=".$metroId.">$metroName</option>";
				
			} // for
			return $metroList;
		}
						
	}
//============================================================================================================================
  // childcare type

	function getChildcareType($catid)
	{
		global $db;
		$sql_cat="SELECT * FROM `ch_childcare_type` where is_active='Y'";
		$res_cat=$db->select_data($sql_cat);
		if(count($res_cat)>0)
		{
			$chTypeList	= "<option value='' selected>Select</option>";
			for($i=0;$i<count($res_cat);$i++)			
			{
				$chTypeId		= $res_cat[$i]['ch_type_id'];
				$chTypeName		= $res_cat[$i]['ch_type_name'];
				if($catid==$chTypeId)
					$chTypeList	.="<option value=".$chTypeId." selected>$chTypeName</option>";
				else
					$chTypeList	.="<option value=".$chTypeId.">$chTypeName</option>";
				
			} // for
			return $chTypeList;
		}
						
	}
//============================================================================================================================

// childcare rent

	function getChildcareRent($catid)
	{
		global $db;
		$sql_cat="SELECT * FROM `ch_rent`";
		$res_cat=$db->select_data($sql_cat);
		if(count($res_cat)>0)
		{
			//$chTypeList	= "<option value='' selected>Select</option>";
			$chTypeList="";
			for($i=0;$i<count($res_cat);$i++)			
			{
				$chTypeId		= $res_cat[$i]['rent_id'];
				$chTypeName		= $res_cat[$i]['rent_type'];
				if($catid==$chTypeId)
					$chTypeList	.="<option value=".$chTypeId." selected>$chTypeName</option>";
				else
					$chTypeList	.="<option value=".$chTypeId.">$chTypeName</option>";
				
			} // for
			return $chTypeList;
		}
						
	}
//============================================================================================================================

// function for get the record from tablename 
// $id = where , $name = reqfield , $value = where value
	
		function getTypeName($tablename,$id,$name,$value)
		{
			global $db;
			if((!$id=="") &&(!$tablename=="")&&(!$value=="")&&(!$name==""))
			{
			   	  $sql_data="SELECT $name FROM $tablename WHERE $id='$value'";
				$res_data=$db->select_data($sql_data);
				if(count($res_data) > 0)
				{
					return $res_data[0][$name];
				}else
				{
					return false;
				}
			}
		}// end of function getTypeName
		
//============================================================================================================================		

	function sectionVarCount($fld,$id)
	{
		global $db;
		//echo "<br> ".$id;
		$sql_cnt = "select count(*) as cnt from $fld where parent_id=$id";		
		$res_cnt = $db->select_data($sql_cnt);
		return $res_cnt[0]['cnt'];
		
	}
//============================================================================================================================
 
 function pageInclude($pg_id="")
	{	
		global $db;
	 	$sql_include = "select * from cr_page_include_details where Is_active='Y'";
		$res_include = $db->select_data($sql_include);
		if(count($res_include)>0)
		{
			$page_sel	="";
			$page_sel	= "<option value=0 selected>Please Select</option>"; 
			for($i=0;$i<count($res_include);$i++)			
			{
				$page_id		=	$res_include[$i]['page_id'];
				$page_title		=	$res_include[$i]['title'];				
				$page_name		=	$res_include[$i]['name'];
				
				if($pg_id==$page_id)
					$page_sel	.="<option value=".$page_id." selected>$page_title ($page_name)</option>";
				else
					$page_sel	.="<option value=".$page_id.">$page_title ($page_name)</option>";
			}
			return $page_sel;
		}
				
	} // end of function pageInclude
 
//============================================================================================================================


function replaceplainString($st)
{
	if($st!="")
	{
		$newSt		= str_replace(" ","_",$st);
		$newSt		= str_replace("/","_",$newSt);
		$newSt		= str_replace("?","_",$newSt);
		return $newSt;
	}

} // end of fucntion replaceplainString

//***********************************************************************************************//

	function getCountryList($cId="")
	{	
		global $db;
		
		$sql_country="select * from hd_country order by name asc";
		$res_country=$db->select_data($sql_country);
		if(count($res_country) > 0)
		{
			//$countryOption	= "<option value='' selected>All</option>";
			for($i=0;$i<count($res_country);$i++)
			{
				$countryName	= $res_country[$i]["name"];
				$countryId		= $res_country[$i]["con_id"];
				
				if($countryId==$cId)
					$countryOption	.="<option value=".$countryId." selected>$countryName</option>";
				else
					$countryOption	.="<option value=".$countryId.">$countryName</option>";
			}
			return $countryOption;
		}

	} // end of function getCountryList



function getAllCountryList($cId="")
	{	
		global $db;
		 $sql_country="select * from hd_country";
		$res_country=$db->select_data($sql_country);
		if(count($res_country) > 0)
		{
			$countryOption	= "<option value='' selected>Select Country</option>";
			for($i=0;$i<count($res_country);$i++)
			{
				$countryName	= $res_country[$i]["name"];
				$countryId		= $res_country[$i]["con_id"];
				
				if($countryId == $cId)
				{
					$countryOption	.="<option value=".$countryId." selected>$countryName</option>";
				}
				elseif($countryId != $cId)
					$countryOption	.="<option value=".$countryId.">$countryName</option>";
			}
			return $countryOption;
		}

	} // end of function getCountryList

//***********************************************************************************************//
	function getStateList($cId="",$sId="")
	{	
		global $db;
		if($cId=="")
		$cId	= '223';
		$sql_state	= "select * from hd_state WHERE country_id = '{$cId}' order by state_name asc";
		$res_state	= $db->select_data($sql_state);


		if(count($res_state) > 0)
		{
			$stateOption	= "<option value=''>Select State</option>";
			for($i=0;$i<count($res_state);$i++)
			{
				$stateId		= $res_state[$i]["state_id"];
				$stateName		= $res_state[$i]["state_name"];
				if($stateId==$sId)
				{				
					$stateOption	.="<option value=".$stateId." selected >$stateName</option>";	
				}
				else
					$stateOption	.="<option value=".$stateId.">$stateName</option>";	
			}
			return $stateOption;
		}

	} // end of function getStateList
//***********************************************************************************************//	
//***********************************************************************************************//
	function getCityList($cId="",$sId="",$ctId="")
	{	
		global $db;
		if($cId=="" && $sId=="")
		{
		$cId	= '223';
		$sId	= '3435';
		}
	$sql_city	= "select * from hd_cities WHERE con_id = '{$cId}' and `sta_id`='{$sId}' order by name asc";
	
		$res_city	= $db->select_data($sql_city);


		if(count($res_city) > 0)
		{
			$cityOption	= "<option value=''>Select City</option>";
			for($i=0;$i<count($res_city);$i++)
			{
				$cityId			= $res_city[$i]["cty_id"];
				$cityName		= $res_city[$i]["name"];

				if($cityId==$ctId)
					$cityOption	.="<option value=".$cityId." selected>$cityName</option>";	
				else
					$cityOption	.="<option value=".$cityId.">$cityName</option>";	
			}
			return $cityOption;
		}

	} // end of function getStateList
//***********************************************************************************************//	

function getState($cId="",$sId="")
	{	
		global $db;
		if($cId=="")
		$cId	= '223';

		$sql_state	= "select * from eg_state WHERE country_id = '{$cId}' order by state_name asc";
		$res_state	= $db->select_data($sql_state);


		if(count($res_state) > 0)
		{
			$stateOption = $res_state[0]['state_id'];
			
			return $stateOption;
		}

	} // end of function getState

function getStateid($state_abbr="")
	{	
		global $db;
		if($cId=="")
		$cId	= '223';

		$sql_state	= "select * from ad_state WHERE `short_name` = '{$state_abbr}' order by state_name asc";
		$res_state	= $db->select_data($sql_state);


		if(count($res_state) > 0)
		{
			$stateOption = $res_state[0]['state_id'];
			
			return $stateOption;
		}

	} // end of function getState
	
function getCityid($city_vaue="")
	{	
		//echo "ct--".$city_vaue;
		//$city_name=str_replace("-", " ", $city_vaue); 
		/*$city_name=$city_vaue;
		global $db;
		if($cId=="")
		$cId	= '223';

		  $sql_city	= "select * from `ad_cities` WHERE `name` = '{$city_name}' and `sta_id`='$state_id_value'";
		$res_city	= $db->select_data($sql_city);


		if(count($res_city) > 0)
		{
			$city_id = $res_city[0]['cty_id'];
			
			return $city_id;
		}*/
		
		$city_array=explode("-",$city_vaue);
		$reverse_city_array=array_reverse($city_array);
		return $city_id=$reverse_city_array[0];

	} // end of function getState	
	
	function getCityName($city_id="")
	{	
		global $db;
		

		$sql_city	= "select * from ad_cities WHERE `cty_id` = '{$city_id}'";
		$res_city	= $db->select_data($sql_city);


		if(count($res_city) > 0)
		{
			$cityname = $res_city[0]['name'];
			
			return $cityname;
		}

	} // end of function getCityName
//***********************************************************************************************//	

        function isValidImage($image)
		{
	     	global $db;
		
			if (($image == "image/gif") || ($image == "image/jpeg") || ($image == "image/pjpeg") 	|| ($image == "image/jpg") || ($image == "image/png"))
				return 1;
			else
				return 0;
		
		}
		
//***********************************************************************************************//	

		function setWidthHeight($width, $height, $maxWidth, $maxHeight)
		{
			global $db;
			$ret = array($width, $height);
			$ratio = $width / $height;
			if ($width > $maxWidth || $height > $maxHeight) 
			{
				$ret[0] = $maxWidth;
				$ret[1] = $maxHeight;
				$ret[1] = $ret[0] / $ratio;
				if ($ret[1] > $maxHeight) 
				{
					$ret[1] = $maxHeight;
					$ret[0] = $ret[1] * $ratio;
				}
			}
			return $ret;
		}
//***********************************************************************************************//	

	    function createthumb1($img, $new_width, $new_height, $destpath)
	    {
	      	global $db;
	
			if(is_file($img)) 
			{
				if ($cursize = getimagesize ($img)) 
				{
					$newsize = setWidthHeight($cursize[0],$cursize[1],$new_width,$new_height);
					$thepath = pathinfo ($img);
					$dst = imagecreatetruecolor($newsize[0],$newsize[1]);
					$filename = str_replace (".".$thepath['extension'], "", $thepath["basename"]);
					$filename = $thepath["dirname"]."/".$destpath."/".$filename . "" . $size . "." . $thepath['extension'];
					$types = array('jpg' => array('imagecreatefromjpeg', 'imagejpeg'),
					'jpeg' => array('imagecreatefromjpeg', 'imagejpeg'),
					'gif' => array('imagecreatefromgif', 'imagegif'),
					'png' => array('imagecreatefrompng', 'imagepng'));
					$x_type = strtolower($thepath['extension']);
					$func = $types[$x_type][0];
					$src = $func($img);
					imagecopyresampled($dst, $src, 0, 0, 0, 0,$newsize[0], $newsize[1],$cursize[0], $cursize[1]);
					$func = $types[$x_type][1];
					$func($dst, $filename);
					return $filename;
			   }
		     }
	     }
//***********************************************************************************************//	
		 
		function displayEventImage($IMAGENAME,$ImageType,$OriginPath)
		{
	
			global $db;
		
			if(($IMAGENAME!="") || ($ImageType!=""))
			{
				if(!empty($IMAGENAME))
				{
					if($IMAGENAME == "no_photo.jpg")
					{
						$photoPath	= $OriginPath.$IMAGENAME;
					}
					else if($ImageType=="THUMBNAIL")
					{
						$photoPath	= $OriginPath."event_images/thumb_photos_small/".$IMAGENAME;
					}
					else if($ImageType=="MEDIUM")
					{
						$photoPath	= $OriginPath."event_images/thumb_photos_medium/".$IMAGENAME;
					}
					else
					{
						$photoPath	= $OriginPath."event_images/".$IMAGENAME;
					}
					$eventImage	= "<img src=\"".$photoPath."\" alt=\"photo\" border=\"0\" />";
				}
				
			}
		return $eventImage;
	}
	
//***********************************************************************************************//			 
// get album name  
 
    function getAlbumName($al_id)
	{	
		global $db;
		$sql_album="SELECT * FROM `cr_album` where is_active='Y'";
		$res_album=$db->select_data($sql_album);
		if(count($res_album)>0)
		{
			$AlbumOption = "<option value=0 selected>Please select</option>";			
			for($i=0;$i<count($res_album);$i++)
			{
			  	$album_id = $res_album[$i]['album_id'];
				
				$sql = "select album_name from cr_album_name where album_id=$album_id and lang_id=1";
				$res = $db->select_data($sql);
				$album_name = $res[0]['album_name'];
				
				if($album_id==$al_id)
					$AlbumOption	.="<option value=".$album_id." selected>$album_name</option>";
				else
					$AlbumOption	.="<option value=".$album_id.">$album_name</option>";	
			}
		 return $AlbumOption;		
		}
		
		
	} // end of function getLanguages

//============================================================================================================================
function display_album_image($IMAGENAME,$ImageType){
	
		global $db;
		
		if(($IMAGENAME!=""))
		{
					
					if($ImageType=="THUMBNAIL")
					{
						$photoPath	=  DISPLAY_IMAGE_PATH."album_images/thumb_photos_small/".$IMAGENAME;
					}else if($ImageType=="MEDIUM")
					{
						$photoPath	= DISPLAY_IMAGE_PATH."album_images/thumb_photos_medium/".$IMAGENAME;
					}
					else
					{
						$photoPath	= DISPLAY_IMAGE_PATH."album_images/".$IMAGENAME;
					}
					    $userImage	= "<img src=\"".$photoPath."\" alt=\"photo\" border=\"0\" />";
		}else
		{
			//$userImage	= "<img src=\"".DISPLAY_IMAGE_PATH."no_photo.jpg\" alt=\"photo\" border=\"0\"  />";
		}
		return $userImage; 
	}// end of function display_album_image   

//***********************************************************************************************//	
// function for album Images count
function albumImagesCnt($album_id)
{
		global $db;
		//echo "<br> ".$id;
		$sql_cnt = "select count(*) as cnt from cr_album_images where album_id=$album_id";		
		$res_cnt = $db->select_data($sql_cnt);
		return $res_cnt[0]['cnt'];
		
} // end of function albumImagesCnt
//============================================================================================================================
// function for date format 
function getAdminDateTimeFormat($date)
{
   		$post_date1=split(" ", $date);
		$post_date2=split("-", $post_date1[0]);
		$post_date=$post_date2[2]."/".$post_date2[1]."/".$post_date2[0];
		return $post_date;
		
} // end of function getDateFormat

function getAdminDTFormat($date)
{
   		$post_date1=split(" ", $date);
		$post_date2=split("-", $post_date1[0]);
		$post_date=$post_date2[2]."/".$post_date2[1]."/".$post_date2[0];
		return $post_date."<br>".$post_date1[1];
		
}

function getAdminDateFormat($date)
{
   		$post_date2=split("-", $date);
		$post_date=$post_date2[2]."/".$post_date2[1]."/".$post_date2[0];
		return $post_date;
		
} // end of function getAdminDateFormat

function getDateFormat($date="")
{
   		global $db;	
		$sql_date = "select DATE_FORMAT('$date','%b &nbsp;%d, %Y')";
		$res_date = $db->select_data($sql_date);
		return $res_date[0][0];
		
} // end of function getDateFormat
//============================================================================================================================ 
// function for getDateFormat_av
function getDateFormat_av($date="")
{
   		global $db;
		$sql_date = "select DATE_FORMAT('$date','%a %d/%b/%Y')";
		$res_date = $db->select_data($sql_date);
		return $res_date[0][0];
		
} // end of function getDateFormat_av
//============================================================================================================================ 
////////// new paging
function NewshowPaging()
		{
			global $PAGE_TOTAL_ROWS;
			global $PAGE_LIMIT;
			global $PAGE_URL;
			global $DISPLAY_PAGES;
			
			@$numofpages = ceil($PAGE_TOTAL_ROWS / $PAGE_LIMIT);
			$pages = ((empty($_GET['pages']))?1:$_GET['pages']);
			$page = ((empty($_GET['page']))?1:$_GET['page']);
			$filename = $PAGE_URL;
			$displayPages = (($DISPLAY_PAGES < 1)?10:$DISPLAY_PAGES);

			if(strlen(trim($filename)) > 0)
			{	//echo "filename : ".$filename;		
				$file = split("-",$filename);
				//echo "filename : ".print_r($file);
				if(sizeof($file) == 1)
				{
					$_file = $file[0]."?";
				}
				else
				{
					for($m=1;$m<sizeof($file);$m++)	{	$fn.= $file[$m]."&";	}
					$_file = $file[0]."?".$fn;
				}
			}			
			if($pages > 1)
			{
				$pageprev = $pages-$displayPages;
				$working_data = "<a href=".$_file."pages=".$pageprev." class=\"nopage\" style=\"color:#000000\">PREV</a>&nbsp;";
			}
					
			 for($i = 1; $i <=$numofpages; $i++)
			 {
				if($i == $page) 
				{
					$selectedPage = (($page == $i)?"style='font-weight:normal;'":"");
					$working_data.= "<a href=".$_file."pages=".$pages."&page=".$i."  class=\"selectedpage\"><strong>".$i."</strong></a>&nbsp;";
				}
				else
				{
				    $working_data.= "<a href=".$_file."pages=".$pages."&page=".$i."  class=\"nopage\">".$i."</a>&nbsp;";
				}
				
			 }
			
			if($pages + $displayPages <= $numofpages)
			{
				$pagenext = ($pages + $displayPages);
				$working_data.= "<a href=".$_file."pages=".$pagenext." class=\"grey-txt\">NEXT</a>";
			}
			
			return "<span class=\"text\">Page:  </span>".((empty($working_data))?0:$working_data);
		}
		
//////////------------------------------------------------------

function NewshowPaging2()
		{
			global $PAGE_TOTAL_ROWSS;
			global $PAGE_LIMIT1;
			global $PAGE_URL;
			global $DISPLAY_PAGES;
			
			@$numofpages = ceil($PAGE_TOTAL_ROWSS / $PAGE_LIMIT1);
			$pages = ((empty($_GET['pagesv']))?1:$_GET['pagesv']);
			$page = ((empty($_GET['pagev']))?1:$_GET['pagev']);
			$filename = $PAGE_URL;
			$displayPages = (($DISPLAY_PAGES < 1)?10:$DISPLAY_PAGES);

			if(strlen(trim($filename)) > 0)
			{			
				$file = split("-",$filename);
				if(sizeof($file) == 1)
				{
					$_file = $file[0]."?";
				}
				else
				{
					for($m=1;$m<sizeof($file);$m++)	{	$fn.= $file[$m]."&";	}
					$_file = $file[0]."?".$fn;
				}
			}			
			if($pages > 1)
			{
				$pageprev = $pages-$displayPages;
				$working_data = "<a href=".$_file."pagesv=".$pageprev." class=\"nopage\" style=\"color:#000000\">PREV</a>&nbsp;";
			}
					
			 for($i = 1; $i <=$numofpages; $i++)
			 {
				if($i == $page) 
				{
					$selectedPage = (($page == $i)?"style='font-weight:normal;'":"");
					$working_data.= "<a href=".$_file."pagesv=".$pages."&pagev=".$i."  class=\"selectedpage\"><strong>".$i."</strong></a>&nbsp;";
				}
				else
				{
				    $working_data.= "<a href=".$_file."pagesv=".$pages."&pagev=".$i."  class=\"nopage\">".$i."</a>&nbsp;";
				}
				
			 }
			
			if($pages + $displayPages <= $numofpages)
			{
				$pagenext = ($pages + $displayPages);
				$working_data.= "<a href=".$_file."pagesv=".$pagenext." class=\"grey-txt\">NEXT</a>";
			}
			
			return "<span class=\"text\">Page:  </span>".((empty($working_data))?0:$working_data);
		}
		

////------------------------------------------------------------------------------------------------------

function showPaging($query,$res_set,$PageURL)
{
   	global $db;
	
	$page     =  $_REQUEST['page'];
	$limit    =  20;
	$sql      =  $query;
	$totalcom =  count($res_set);
	$total    =  $totalcom; 
	
	$pager    =  Pager::getPagerData($total, $limit, $page);
	$offset   =  $pager->offset;  
	$limit    =  $pager->limit;  
	$page     =  $pager->page;
		
	$sql.= " limit $offset,$limit";
	$res_page  =  $db->select_data($sql);
	$total_com =  count($res_page);
	Pager::getPaging_pagenum($PageURL,$page,$pager->numPages,$pager->limit); 
	
	return $res_page;
		
}

function showPagingnew()
		{
			global $PAGE_TOTAL_ROWS;
			global $PAGE_LIMIT;
			global $PAGE_URL;
			global $DISPLAY_PAGES;
			
			
			@$numofpages = ceil($PAGE_TOTAL_ROWS / $PAGE_LIMIT);
			$pages = ((empty($_GET['pages']))?1:$_GET['pages']);
			$page = ((empty($_GET['page']))?1:$_GET['page']);
			$filename = $PAGE_URL;
			$displayPages = (($DISPLAY_PAGES < 1)?10:$DISPLAY_PAGES);

			if(strlen(trim($filename)) > 0)
			{			
				$file = split("-",$filename);
				if(sizeof($file) == 1)
				{
					$_file = $file[0]."?";
				}
				else
				{
					for($m=1;$m<sizeof($file);$m++)	{	$fn.= $file[$m]."&";	}
					$_file = $file[0]."?".$fn;
				}
			}
			
			if ($page == 1) // this is the first page - there is no previous page 
			{
				 $a="<img src='".SITE_IMAGE_PATH."/arrow_left.png' border=0><img src='".IMAGE_PATH."/arrow_left.png' border=0>&nbsp;&nbsp;";
			}
			else
			{
				
				$a= "<a href=".$_file."pages=".$pages."&page=1  class=\"textlink\"><img src='".IMAGE_PATH."/arrow_left.png' border=0><img src='".IMAGE_PATH."/arrow_left.png' border=0></a>&nbsp;&nbsp;";
			}
			//echo "<br>aaa--".$a;

			if ($page == 1) 
			{
				 $b= "<img src='".IMAGE_PATH."/arrow_left.png' border=0>"."&nbsp;&nbsp;Page ".$page." of ".$numofpages."&nbsp;&nbsp;";
			}
			else  
			{
				$r=$page-1;
				 $b= "<a href=".$_file."pages=".$pages."&page=".$r."  class=\"text\">"."<img src='".IMAGE_PATH."/arrow_left.png' border=0>"."</a>&nbsp;&nbsp;Page ".$page ." of ".$numofpages."&nbsp;&nbsp;";
			}

			//echo "<br>bbb--".$b;


			if ($page == $numofpages) 
				 $c= "<img src='".IMAGE_PATH."/arrow_right.png' border=0>&nbsp;&nbsp;";  
			else            
				 $c= "<a href=".$_file."pages=".$pages."&page=".($page+1)."  class=\"textlink\">"."<img src='".IMAGE_PATH."/arrow_right.png' border=0>"."</a>&nbsp;&nbsp;";

			//echo "<br>ccc--".$c;

			if ($page == $numofpages) 
				 $d= "<img src='".IMAGE_PATH."/arrow_right.png' border=0><img src='".IMAGE_PATH."/arrow_right.png' border=0>";  
			else 
				 $d= "<a href=".$_file."pages=".$pages."&page=".$numofpages."  class=\"textlink\">"."<img src='".IMAGE_PATH."/arrow_right.png' border=0><img src='".IMAGE_PATH."/arrow_right.png' border=0>"."</a> ";

			//echo "<br>ddd--".$d;
		  
		  return $a.$b.$c.$d;
		
		}
		
//============================================================================================================================ 
function str_breakLong($str)
{
	$str_array=str_split($str,50);
	for($i=0;$i<count($str_array);$i++)
	{
	  
	 $string=$str_array[$i]."<br>";
	 $string1.=$string;  
	}

return $string1;
}

//============================================================================================================================

function str_breakLong_comments($str)
{
	$str_array=str_split($str,70);
	for($i=0;$i<count($str_array);$i++)
	{
	  
	 $string=$str_array[$i]."<br>";
	 $string1.=$string;  
	}

return $string1;
}

//============================================================================================================================
function str_breakLong_abuse($str)
{
	$str_array=str_split($str,100);
	for($i=0;$i<count($str_array);$i++)
	{
	  
	 $string=$str_array[$i]."<br>";
	 $string1.=$string;  
	}

return $string1;
}

//============================================================================================================================


function getAudioCategories($cat_id="",$lang_id=1)
	{	
		global $db;
		//echo $lc_name;
		$sql_cat = "SELECT ad.category_name,ad.audio_cat_id
					FROM cr_audio_category ac, cr_audio_category_details ad
					WHERE ac.is_active = 'Y'
					AND ac.audio_cat_id = ad.audio_cat_id
					AND ad.lang_id=$lang_id";
					
		$res_cat = $db->select_data($sql_cat);
		
		if(count($res_cat) > 0)
		{
			$CatOption="";
			$CatOption	= "<option value=0 selected>Please select</option>";
			for($i=0;$i<count($res_cat);$i++)
			{
				$Cat_Id		= $res_cat[$i]['audio_cat_id'];
				$Cat_Name	= $res_cat[$i]['category_name'];
					
				if($cat_id == $Cat_Id)	
					$CatOption	.="<option value=".$Cat_Id." selected>$Cat_Name</option>";
				else
					$CatOption	.="<option value=".$Cat_Id." >$Cat_Name</option>";
			}
		 
		}
		return $CatOption;
	}
	
//============================================================================================================================
function isValidAudio($audio)
{
   	global $db;
	if (($audio == "audio/mpeg") || ($audio == "audio/mp3"))
		return 1;
	else
		return 0;
}
//============================================================================================================================

function display_audio_image($IMAGENAME,$ImageType){
	
		global $db;
		
		if(($IMAGENAME!=""))
		{
					
					if($ImageType=="THUMBNAIL")
					{
						$photoPath	=  DISPLAY_IMAGE_PATH."audio_images/thumb_photos_small/".$IMAGENAME;
					}else if($ImageType=="MEDIUM")
					{
						$photoPath	= DISPLAY_IMAGE_PATH."audio_images/thumb_photos_medium/".$IMAGENAME;
					}
					else
					{
						$photoPath	= DISPLAY_IMAGE_PATH."audio_images/".$IMAGENAME;
					}
					    $userImage	= "<img src=\"".$photoPath."\" alt=\"photo\" border=\"0\" />";
		}else
		{
			//$userImage	= "<img src=\"".DISPLAY_IMAGE_PATH."no_photo.jpg\" alt=\"photo\" border=\"0\"  />";
		}
		return $userImage; 
	}// end of function display_album_image 
	
// ==============================================================================================================================

function audio_category($cat_id,$lang_id)
{
	global $db;
	$sql_cat = "select category_name from cr_audio_category_details where audio_cat_id=$cat_id and lang_id=$lang_id";
	$res_cat = $db->select_data($sql_cat);
	if(count($res_cat)>0) 
	{
		return $res_cat[0]['category_name'];
	}else
	{
		return false;
	}
}

// ==============================================================================================================================

function displayAvatars($IMAGENAME,$ImageType,$OriginPath)
		{
	
			global $db;
		
			if(($IMAGENAME!="") || ($ImageType!=""))
			{
				if(!empty($IMAGENAME))
				{
					if($IMAGENAME == "no_photo.jpg")
					{
						$photoPath	= $OriginPath.$IMAGENAME;
					}
					else if($ImageType=="THUMBNAIL")

					{
						$photoPath	= $OriginPath."avatars/thumb_photos_small/".$IMAGENAME;
					}
					else if($ImageType=="MEDIUM")
					{
						$photoPath	= $OriginPath."avatars/thumb_photos_medium/".$IMAGENAME;
					}
					else
					{
						$photoPath	= $OriginPath."avatars/".$IMAGENAME;
					}
					$avatar	= "<img src=\"".$photoPath."\" alt=\"photo\" border=\"0\" />";
				}
				
			}
		return $avatar;
	}
// ==============================================================================================================================
function getAvtarNames($av_id,$lang_id)
	{	
		global $db;
		//echo $lc_name;
		$sql_avt =	"SELECT avd.name,avd.av_id 
		FROM cr_avatar as av, cr_avatar_details as avd 
		WHERE av.is_active='Y' and av.av_id=avd.av_id and avd.lang_id='$lang_id'";
			
		$res_avt = $db->select_data($sql_avt);
		print_r($res_avt);
		if(count($res_avt) > 0)
		{
			$AvOption="";
			$AvOption	= "<option value='0' selected>".E_PLEASE_SELECT."</option>";
			for($i=0; $i < count($res_avt); $i++)
			{
				$Av_Id		= $res_avt[$i]['av_id'];
				$Av_Name	= $res_avt[$i]['name'];
					
				if($Av_Id == $av_id)	
					$AvOption	.="<option value=".$Av_Id." selected>$Av_Name</option>";
				else
					$AvOption	.="<option value=".$Av_Id." >$Av_Name</option>";
			}
		 
		}
		return $AvOption;
	}
// ==============================================================================================================================

// ==============================================================================================================================
	function isValidVideo($video)
	{
   		global $db;
		if ($video == "application/octet-stream")
			return 1;
		else
			return 0;
	}
// ==============================================================================================================================
function display_video_image($IMAGENAME,$ImageType){
	
		global $db;
		
		if(($IMAGENAME!=""))
		{
					
					if($ImageType=="THUMBNAIL")
					{
						$photoPath	=  DISPLAY_IMAGE_PATH."video_images/thumb_photos_small/".$IMAGENAME;
					}
					elseif($ImageType=="MEDIUM")
					{
						$photoPath	= DISPLAY_IMAGE_PATH."video_images/thumb_photos_medium/".$IMAGENAME;
					}
					else
					{
						$photoPath	= DISPLAY_IMAGE_PATH."video_images/".$IMAGENAME;
					}
					    $videoImage	= "<img src=\"".$photoPath."\" alt=\"photo\" border=\"0\" />";
		}
		
		return $videoImage; 
	}
// ==============================================================================================================================

function getHighLightedText($textSrc,$textToHight)
{
	//global $HIGHLIGHT_TEXT_COLOR;
	
	$HIGHLIGHT_TEXT_COLOR	= "#FF00CC";
	
	if($textSrc!=""  && $textToHight!="")
	{
		
		$pos = strpos($textSrc,$textToHight);
		if($pos > 0 || $textSrc == $textToHight || $pos == false)
			//$returnText		= str_replace($textToHight,"<font color=\"$HIGHLIGHT_TEXT_COLOR\">".$textToHight."</font>",$textSrc);
		$returnText		= str_replace($textToHight,"<b style=\"color: $HIGHLIGHT_TEXT_COLOR; background-color: yellow;\">".$textToHight."</b>",$textSrc);

		else
			$returnText		= $textSrc;

		return $returnText;
	}else
		return $textSrc;
}

// ==============================================================================================================================

function getUrl($section,$pageName,$eng)
{
	global $db;
	
	$table_detail = "cr_".$section."_content_details";
	$table = "cr_".$section;
	
	if($pageName != "")
	{
		$sql_main = "select ed.*,pd.* from ".$table_detail." as ed,cr_page_include_details as pd where ed.pageinclude_id=pd.page_id and pd.name='$pageName' limit 0,1"; 			
	   
	   $res_main = $db->select_data($sql_main);
	   
	   $main_category_id	=	$res_main[0]['maincategory_id'];
		  
	   $sql_parent  =  "select eng,parent_id from ".$table." where id=$main_category_id";
		
	   $res_parent  =  $db->select_data($sql_parent);
	   $sub_cat     = replaceplainString(strtolower($res_parent[0]['eng']));
	   
	   $parent_category		=	$res_parent[0]['parent_id'];
	   
	   $sql_section  =  "select eng from ".$table." where id=$parent_category";
	 
	   $res_section  =  $db->select_data($sql_section);
	   $section_name =  replaceplainString(strtolower($res_section[0]['eng']));
   
    }	
	else
	{
		$sql_section        =  "select * from ".$table." where eng='$eng' and parent_id!=0";
		$res_section        =  $db->select_data($sql_section);
		
		$main_category_id	=  $res_section[0]['id'];
		$sub_cat            =  replaceplainString(strtolower($res_section[0]['eng'])); 
		
		$parent_category = $res_section[0]['parent_id'];
		
		$sql_parent  =  "select eng from ".$table." where id=$parent_category";
		$res_parent  = $db->select_data($sql_parent);
		
		$section_name = replaceplainString(strtolower($res_parent[0]['eng']));
	}
	
	return array($main_category_id,$sub_cat,$section_name);
}//function

// ==============================================================================================================================

function scalImage($src_w,$src_h,$dst_max_w=400,$dst_max_h=400){

               // $dst_max_w = 400;
				//$dst_max_h = 400;
				//$src_w=$imgdeatils[0];
                //$src_h= $imgdeatils[1]; 
				
				if ($src_w > $dst_max_w) {
					$thumb_w=$dst_max_w;
					$thumb_h=$src_h*($dst_max_w/$src_w);
					if ($thumb_h > $dst_max_h) {
						$thumb_h = $dst_max_h;
						$thumb_w = $src_w*($dst_max_h/$src_h);
					}
				}
				elseif ($src_h > $dst_max_h) {
					$thumb_h=$dst_max_h;
					$thumb_w=$src_w*($dst_max_h/$src_h);
					if ($thumb_w > $dst_max_w) {
						$thumb_w = $dst_max_w;
						$thumb_h = $src_h*($dst_max_w/$src_w);
					}
				}
				else {
					if ($src_w > $src_h) {
						$thumb_w = $dst_max_w;
						$thumb_h = $src_h*($dst_max_w/$src_w);
					} elseif ($src_w < $src_h) {
						$thumb_h = $dst_max_h;
						$thumb_w = $src_w*($dst_max_h/$src_h);
					} else {
						if ($dst_max_w >= $dst_max_h) {
							$thumb_w=$dst_max_h;
							$thumb_h=$dst_max_h;
						} else {
							$thumb_w=$dst_max_w;
							$thumb_h=$dst_max_w;
						}
					}
				}

$scal=array();
$scal["w"]=$thumb_w;
$scal["h"]=$thumb_h;
return  $scal;
}

//--------------------------------------------------------------------------------------------------------------------------------
function displayProductImagePath($IMAGENAME,$ImageType)
		{
	
		global $db;
		if(($IMAGENAME!="") && ($ImageType!=""))
		{
		 
               
			if(!empty($IMAGENAME))
				{
					if($ImageType=="THUMBNAIL")
					{
						 $photoPath	= "../product/thumb_photos_small/".$IMAGENAME;
					}
					else if($ImageType=="ORIGINAL")
					{
						$photoPath	="../product/".$IMAGENAME;
					}
					else if($ImageType=="MEDIUM")
					{
						$photoPath	= "../product/thumb_photos_medium/".$IMAGENAME;
					}

					else if($ImageType=="LARGE")
					{
						$photoPath	= "../product/thumb_photos_large/".$IMAGENAME;
					}
					$productImage	= "<img src=\"".$photoPath."\" alt=\"photo\" border=\"0\" />";
				}
		}
		return $productImage;
		
	}// function displayProductImage($IMAGENAME,$ImageType)
	
//-------------------------------------------------------------------------------------------------------------------------------------
	function displayProductImageBORDER($IMAGENAME,$ImageType)
		{
	
		global $db;
		if(($IMAGENAME!="") && ($ImageType!=""))
		{
		 
               
			if(!empty($IMAGENAME))
				{
					if($ImageType=="THUMBNAIL")
					{
						 $photoPath	= DOMAIN."product_image/thumb_photos_small/".$IMAGENAME;
					}
					else if($ImageType=="ORIGINAL")
					{
						$photoPath	=DOMAIN."product_image/".$IMAGENAME;
					}
					else if($ImageType=="MEDIUM")
					{
						$photoPath	= DOMAIN."product_image/thumb_photos_medium/".$IMAGENAME;
					}

					else if($ImageType=="LARGE")
					{
						$photoPath	= DOMAIN."product_image/thumb_photos_large/".$IMAGENAME;
					}else{
					$photoPath	= DOMAIN."product_image/no_photo.jpg";
					}
					$productImage	= "<img src=\"".$photoPath."\" alt=\"photo\"  style=\"border:#0B0A58 solid 10px;  padding:3px;background-color:#FFFFFF;\" />";
				}
		}
		return $productImage;
		
	}// function displayProductImage($IMAGENAME,$ImageType)
	
//------------------------------------------------------------------------------------------------------------------------------------
function displayProductImage($IMAGENAME,$ImageType)
		{
	
		global $db;
		if(($IMAGENAME!="") && ($ImageType!=""))
		{
		 
               
			if(!empty($IMAGENAME))
				{
					if($ImageType=="THUMBNAIL")
					{
						 $photoPath	= DOMAIN."product_image/thumb_photos_small/".$IMAGENAME;
					}
					else if($ImageType=="ORIGINAL")
					{
						$photoPath	=DOMAIN."product_image/".$IMAGENAME;
					}
					else if($ImageType=="MEDIUM")
					{
						$photoPath	= DOMAIN."product_image/thumb_photos_medium/".$IMAGENAME;
					}

					else if($ImageType=="LARGE")
					{
						$photoPath	= DOMAIN."product_image/thumb_photos_large/".$IMAGENAME;
					}else{
					$photoPath	= DOMAIN."product_image/no_photo.jpg";
					}
					$productImage	= "<img src=\"".$photoPath."\" alt=\"photo\" border=\"0\" />";
				}
		}
		return $productImage;
		
	}// function displayProductImage($IMAGENAME,$ImageType)
	
	function get_category_name($cat_id)
	{
	global $db;			
	$sql_select= "select * from eg_maincategory where id='$cat_id'";
	$res_catnm = $db->select_data($sql_select);
	return $res_catnm[0]['catname'];
	}
	
	function pro_category_combo($catid)
	{
	global $db;
		
				$sql_select="select * from eg_maincategory";
				$res_catnm_cnt  =  $db->select_data($sql_select);
	
				if(count($res_catnm_cnt)>0)
				{
					$opt = "<option value=''>Select</option>";
					for($r=0;$r<count($res_catnm_cnt);$r++)
					{
						if($catid == $res_catnm_cnt[$r]['id'])
						{
						$opt .= "<option value='".$res_catnm_cnt[$r]['id']."' selected='selected'>".$res_catnm_cnt[$r]['catname']."</option>";
						}else{
						$opt .= "<option value='".$res_catnm_cnt[$r]['id']."'>".$res_catnm_cnt[$r]['catname']."</option>";
						}
					}
				}
		return $opt;
	}



	/*
function displayProductImage($IMAGENAME,$ImageType)
	{
	
		if($IMAGENAME!="" && $ImageType!="")
		{
			if(!empty($IMAGENAME))
				{
					if($ImageType=="THUMBNAIL")
					{
						$photoPath	= "../product_image/thumb_photos_small/".$IMAGENAME;
					}
					else if($ImageType=="ORIGINAL")
					{
						$photoPath	="../product_image/".$IMAGENAME;
					}
					else if($ImageType=="MEDIUM")
					{
						$photoPath	= "../product_image/thumb_photos_medium/".$IMAGENAME;
					}else{
					$photoPath	="../product_image/no_photo.jpg";
					}

					$userImage	= "<img src=\"".$photoPath."\" alt=\"photo\" border=\"0\" />";
				}
		}
		else{
		$photoPath	="../product_image/no_photo.jpg";
		$userImage	= "<img src=\"".$photoPath."\" alt=\"photo\" border=\"0\" />";
		}
		return $userImage;
	}// end of function displayImage	
*/


//------------------------------------------------------------------------------------------------------------------------------
//Mail format 
function mail_fomat($path,$mail_str)
{
	ob_start(); 
	include($path."mail_format.php");

	$FORMCODE=ob_get_contents(); 
	ob_end_clean(); 
	$matter=$FORMCODE;
	$mail_matter=str_replace("#(MAIL_MESSAGE)#",$mail_str,$FORMCODE); 
	return $mail_matter;	
}

/*function mail_fomat($path,$mail_str)
{
	ob_start(); 
	include($path."mail_format.php");

	$FORMCODE=ob_get_contents(); 
	ob_end_clean(); 
	$matter=$FORMCODE;
	$mail_matter=str_replace("#MESG#",$mail_str,$FORMCODE); 
	return $mail_matter;	
}*/
//------------------------------------------------------------------------------------------------------------------------------

function getaadvsaBanner($size)
{
	global $db;	
	$sqlFormat 	= "SELECT * FROM `rs_google_ads_format` WHERE `f_text`='".$size."'";
	$resFormat	= $db->select_data($sqlFormat);
	
	$sql_ads 	=	"SELECT * FROM `rs_google_ads` WHERE `is_active`='Y' and `ad_size`=".$resFormat[0]['f_id']."";
	$res_ads	=	$db->select_data($sql_ads);
	
	if(count($res_ads) > 0)
	{
			$google_code = stripslashes($res_ads[0]['google_code']);
	}
	return $google_code;
}// function getaadvsaBanner()
//------------------------------------------------------------------------------------------------------------------------
//functions for IP address

function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
   		$ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
  		 $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
	  $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

//------------------------------------------------------------------------------------------------------------------------
//functions for IP address to get country, city , state etc.

function locateIp($ip){
	$d = file_get_contents("http://www.ipinfodb.com/ip_query.php?ip=$ip&output=xml");
 
	//Use backup server if cannot make a connection
	if (!$d){
		$backup = file_get_contents("http://backup.ipinfodb.com/ip_query.php?ip=$ip&output=xml");
		$answer = new SimpleXMLElement($backup);
		if (!$backup) return false; // Failed to open connection
	}else{
		$answer = new SimpleXMLElement($d);
	}
 
	$country_code = $answer->CountryCode;
	$country_name = $answer->CountryName;
	$region_name = $answer->RegionName;
	$city = $answer->City;
	$zippostalcode = $answer->ZipPostalCode;
	$latitude = $answer->Latitude;
	$longitude = $answer->Longitude;
	$gmtoffset = $answer->Gmtoffset;
	$dstoffset = $answer->Dstoffset;
 
	//Return the data as an array
	return array('ip' => $ip, 'country_code' => $country_code, 'country_name' => $country_name, 'region_name' => $region_name, 'city' => $city, 'zippostalcode' => $zippostalcode, 'latitude' => $latitude, 'longitude' => $longitude, 'gmtoffset' => $gmtoffset, 'dstoffset' => $dstoffset);
}


function get_country_value($country)
{
		
         $data = $country;
		 $data_arr=explode(" ",$data);
		 if(count($data_arr) > 1)
		 {
			 for($i=0;$i<count($data_arr);$i++)
			 {
				$str.=$data_arr[$i]."-";
			 }
			 $user_country=substr($str,0,-1);
		 }
		 else if(count($data_arr) == 1)
		 {
		 	$user_country =str_replace("-", "--", $data_arr[0]); 
			//$user_country=	$data_arr[0]; 
		 }
		 
		 $country_value			=	str_replace("'", "^", $user_country); 
		 $new_country_value 	=	str_replace(".", "~", $country_value); 
		 $new_country_value1	=	str_replace("/", "*", $new_country_value); 
		 $new_country_value2	=	str_replace("&", "_", $new_country_value1); 
		 
		return $new_country_value2;
        //return $rs->fields[be_comment];

}

function get_original_country_value($country)
{
		
         $data = $country;
		 $n = strpos($data, "--"); 
		
		 if($n == "")
		 { 
			 $data_arr=explode("-",$data);
			// print_r($data_arr);
			 for($i=0;$i<count($data_arr);$i++)
			 {
				$str.=$data_arr[$i]." ";
			 }
			 $user_country=substr($str,0,-1);
		 }
		 elseif($n != "")
		 {
		 	$user_country=str_replace("--", "-", $data); 
		 }
		 $user_country;
		 $country_value	=	str_replace("^", "'", $user_country); 
		$new_user_country =str_replace("~", ".", $country_value); 
		$new_user_country1 =str_replace("*", "/", $new_user_country); 
		$new_user_country2=str_replace("_", "&", $new_user_country1); 
		
		return $new_user_country2;
        //return $rs->fields[be_comment];

}

// function for rating Image

	function displayRating($rate)
	{
		if($rate > 0)
		{
			for($r=1;$r<=5;$r++)
			{
			
				if($r<=$rate)
				{
				 	 $rateImage.=	"<img src='".DOMAIN.SITE_IMAGE_PATH."star-yellowbg.png'>";			
				}else
				{
				    $rateImage.=	"<img src='".DOMAIN.SITE_IMAGE_PATH."star-yellowbgG.png'>";	
				}
			 }// end of for($r=1;$r<=5;$r++)
			 
		}elseif($rate == 0)
		{
			for($r=1;$r<=5;$r++)
			{
				$rateImage.=	"<img src='".DOMAIN.SITE_IMAGE_PATH."star-yellowbgG.png'>";	
			}
		}// END OF if($rate > 0)
		
		return $rateImage;
			
	} // end of function displayRating($rate)
	


// function for avarage bar rating(reviews)
	
		function avarageBarRating($barId)
		{
		
			global $db;
			if($barId > 0)
			{
				$sqlSel ="SELECT avg(`food`) as food_avg, avg(`services`)  as service_avg, avg(atmosphere)  as atmosphere_avg FROM `rs_restaurant_reviews` WHERE bar_id='".$barId."'";
				$resSel	= $db->select_data($sqlSel);
				
				$food_avg 	 	=	$resSel[0]['food_avg'];
				$service_avg 	=	$resSel[0]['service_avg'];
				$atmosphere_avg =   $resSel[0]['atmosphere_avg'];
				
				$Overallrating =(($food_avg+$service_avg+$atmosphere_avg)/3);
				return $Overallrating;
			}// end of if($barId > 0)
		}// end of function avarageBarRating($barId)
		
	// end of function for avarage bar rating(reviews)
	
		
		
		// function for calculate duration
	function Get_DayHMS($dt)
   {
	     global $db;
	      //Note arg --date in unix time stamp
		  // select UNIX_TIMESTAMP('1997-10-04 22:23:00');
		$sql_dt=" select UNIX_TIMESTAMP('$dt')";
		$res_dt=$db->select_data($sql_dt);
        //echo "<br>".$res_dt[0][0];

		 $second = 1;
		$minute = $second*60;
		$hour = $minute*60;
		$day = $hour*24;
		$week = $day*7; 

	     $time = time();
	   /* echo "<br>".	$sel_ft="SELECT FROM_UNIXTIME($time)";
		$res_ft=$db->select_data($sel_ft);
        echo "<br> current date---".$res_ft[0][0];*/
	
		$offset = $res_dt[0][0];
		$difference = $time-$offset;
				$wcount = 0;
				for($wcount = 0; $difference>$week; $wcount++) {
				   $difference = $difference - $week;
				}
				$dcount = 0;
				for($dcount = 0; $difference>$day; $dcount++) {
				    $difference = $difference - $day;
				}
				$hcount = 0;
				for($hcount = 0; $difference>$hour; $hcount++) {
				   $difference = $difference - $hour;
				}
				$mcount = 0;
				for($mcount = 0; $difference>$minute;
				$mcount++) {
				    $difference = $difference - $minute;
				} 
			       if($wcount==1)
					$Wcnt=$wcount." Week ago";
				   else
				   	$Wcnt=$wcount." Weeks ago";

					if($dcount==1)
					$Dcnt=$dcount." Day ago";
					else
					$Dcnt=$dcount." Days ago";

					if($hcount==1)
				   	$Hcnt=$hcount." Hour ago";
					else
					$Hcnt=$hcount." Hours ago";

                    if($mcount==1)
					$Mcnt=$mcount." Minute ago";
					else
					$Mcnt=$mcount." Minutes ago";

					$Scnt=$difference." Seconds ago";
         //    echo "<br>total---".  $Wcnt."<br>".$Dcnt."<br>".$Hcnt."<br>".$Mcnt."<br>".$Scnt;
					    
						if($wcount>0) {
				    	   return $Wcnt;
						  }
						else if($dcount>0){
						   return $Dcnt;
                         }
						else if($hcount>0 ){
						    return $Hcnt;
						}
						else if($mcount>0 ){
						   return $Mcnt;
					     }
						else  if($difference>0){
						  return $Scnt;
					     }
			
   }	
// ========================================================================================================================

	function countReviewComments($rid)
	{
		global $db;
		//echo "<br> ".$rid;
		$sql_cnt = "select count(*) as cnt from rs_review_comments where review_id=$rid";		
		$res_cnt = $db->select_data($sql_cnt);
		return $res_cnt[0]['cnt'];
		
	}
//==================================================================================================================================	
	function getLatitudeLongitude($city_id)
	{
		global $db;
		 $sql="SELECT *
       		  FROM `ad_cities`
			  WHERE `cty_id` = '$city_id'";
		return $res = $db->select_data($sql);	  
	}
//==================================================================================================================================	
	function getNearByCity($latitude,$longitude,$distance=10)
	{	
			global $db;
			 if($distance=="")
			 {
				$distance=15; 	
			 }
			$qry = "	SELECT * , (
			(
			(
			acos( sin( ( ".$latitude." * pi( ) /180 ) ) * sin( (
			`latitude` * pi( ) /180 ) ) + cos( ( ".$latitude." * pi( ) /180 ) ) * cos( (
			`latitude` * pi( ) /180 )
			) * cos( (
			(
			".$longitude." - `longitude`
			) * pi( ) /180 )
			)
			)
			) *180 / pi( )
			) *60 * 1.1515 * 1.609344
			) AS distance
			FROM `ad_cities`
			WHERE (
			
			SELECT (
			(
			(
			acos( sin( ( ".$latitude." * pi( ) /180 ) ) * sin( (
			`latitude` * pi( ) /180 ) ) + cos( ( ".$latitude." * pi( ) /180 ) ) * cos( (
			`latitude` * pi( ) /180 )
			) * cos( (
			(
			".$longitude." - `longitude`
			) * pi( ) /180 )
			)
			)
			) *180 / pi( )
			) *60 * 1.1515 * 1.609344
			)
			) <= $distance";
			
			return $res = $db->select_data($qry);	  
			
	}
	
	//==================================================================================================================================
	function getNearByRestaurnt($latitude,$longitude,$distance=0)
	{		global $db;
			 if($distance=="")
			 {
				$distance=4; 	
			 }
			$qry = "	SELECT * , (
			(
			(
			acos( sin( ( ".$latitude." * pi( ) /180 ) ) * sin( (
			`latitude` * pi( ) /180 ) ) + cos( ( ".$latitude." * pi( ) /180 ) ) * cos( (
			`latitude` * pi( ) /180 )
			) * cos( (
			(
			".$longitude." - `longitude`
			) * pi( ) /180 )
			)
			)
			) *180 / pi( )
			) *60 * 1.1515 * 1.609344
			) AS distance
			FROM `ad_cities`
			WHERE (
			
			SELECT (
			(
			(
			acos( sin( ( ".$latitude." * pi( ) /180 ) ) * sin( (
			`latitude` * pi( ) /180 ) ) + cos( ( ".$latitude." * pi( ) /180 ) ) * cos( (
			`latitude` * pi( ) /180 )
			) * cos( (
			(
			".$longitude." - `longitude`
			) * pi( ) /180 )
			)
			)
			) *180 / pi( )
			) *60 * 1.1515 * 1.609344
			)
			) <= $distance";
			//echo "==qry".$qry;
			return $res = $db->select_data($qry);	  
			
	}

//================================================================================================================================


	function getPhotoCount($uid)
	{
		global $db;
		$sqlPhCount ="SELECT count(*) as Pcount FROM `rs_restaurant_photos` WHERE `user_id`='".$uid."' and `add_flag`='O' and `is_active`='Y'";
		$resPhCount =$db->select_data($sqlPhCount);
		return $resPhCount[0]['Pcount'];
	}// end of function getPhotoCount($uid)

//================================================================================================================================

	function getReviewCOunt($uid)
	{
		global $db;
				
			$sql_sel = "SELECT count(*) as Rcount FROM `rs_restaurant_reviews` WHERE `user_id`='".$uid."'";
			$res = $db->select_data($sql_sel);
			return $res[0]['Rcount'];
			
	}// end of function getReviewCOunt($uid)

//================================================================================================================================
function getFavoritesCount($uid)
	{
		global $db;
		$sqlFavCount ="SELECT count(*) as Favcount FROM `rs_favorites` WHERE `user_id`='".$uid."'";
		$resFavCount =$db->select_data($sqlFavCount);
		return $resFavCount[0]['Favcount'];
	}// end of function getPhotoCount($uid)

//================================================================================================================================
//================================================================================================================================


	function getBarwisePhotoCount($barid)
	{
		global $db;
		$sqlPhCount ="SELECT count(*) as PBcount FROM `rs_restaurant_photos` WHERE `bar_id`='".$barid."' and `add_flag`='O'";
		$resPhCount =$db->select_data($sqlPhCount);
		return $resPhCount[0]['PBcount'];
	}// end of function getPhotoCount($uid)

//================================================================================================================================

//============================================================================================================================
  // from country list

	function getFromList($select_id)
	{
		global $db;
		$sql_cat="SELECT * FROM `as_country`  WHERE `tag`!=''";
		$res_cat=$db->select_data($sql_cat);
		if(count($res_cat)>0)
		{
			$countryList	= "<option value='' selected>Calling From</option>";
			for($i=0;$i<count($res_cat);$i++)			
			{
				$country_id		= $res_cat[$i]['country_id'];
				$country_name	= $res_cat[$i]['description'];
				if($select_id==$country_id)
					$countryList	.="<option value=".$country_id." selected>$country_name</option>";
				else
					$countryList	.="<option value=".$country_id.">$country_name</option>";
				
			} // for
			return $countryList;
		}
						
	}
//============================================================================================================================
  // from country list
  //============================================================================================================================
  // To country list

	function getToList($select_id)
	{
		global $db;
		$sql_cat="SELECT * FROM `as_country`  WHERE `tag`!=''";
		$res_cat=$db->select_data($sql_cat);
		if(count($res_cat)>0)
		{
			$countryList	= "<option value='' selected>Calling To</option>";
			for($i=0;$i<count($res_cat);$i++)			
			{
				$country_id		= $res_cat[$i]['country_id'];
				$country_name	= $res_cat[$i]['description'];
				if($select_id==$country_id)
					$countryList	.="<option value=".$country_id." selected>$country_name</option>";
				else
					$countryList	.="<option value=".$country_id.">$country_name</option>";
				
			} // for
			return $countryList;
		}
						
	}
//============================================================================================================================
  // To country list
   // Get currency list

	function getCurrencyList($select_id)
	{
		global $db;
		$sql_cat="SELECT * FROM `as_currency`";
		$res_cat=$db->select_data($sql_cat);
		if(count($res_cat)>0)
		{
			
			for($i=0;$i<count($res_cat);$i++)			
			{
				$currency_id		= $res_cat[$i]['id'];
				$currency_name	= $res_cat[$i]['currency_name'];
				if($select_id==$currency_id)
					$currencylist	.="<option value=".$currency_id." selected>$currency_name</option>";
				else
					$currencylist	.="<option value=".$currency_id.">$currency_name</option>";
				
			} // for
			return $currencylist;
		}
						
	}
//============================================================================================================================
  // Get currency list
function getdata($value)
{
	global $db;
	$sql_cat="SELECT * FROM `as_currency_converter` WHERE `currency`='$value'";
	$res_cat=$db->select_data($sql_cat);
	return $res_cat[0]['rate'];
}
function convert($amount=1,$from="GBP",$to="USD",$decimals=2) {
		
      return(number_format(($amount/getdata($from))*getdata($to),$decimals));
   }

function get_string_between($string, $start, $end)
{
		strlen($string);
		$string;
		$string = " ".$string;
		$ini = strpos($string,$start);
		if ($ini == 0) return "";
		$ini += strlen($start);   
		$len = strpos($string,$end,$ini) - $ini;
		return substr($string,$ini,$len);
}

function get_currency_sign($currency_code_value)
{
		if($currency_code_value=='USD')
		{
			$currency_sign="$";
		}
		else if($currency_code_value=='EUR')
		{
			$currency_sign="&euro;";
		}
		else if($currency_code_value=='AUD')
		{
			$currency_sign="AU $";
		}
		else if($currency_code_value=='GBP')
		{
			$currency_sign="&pound;";
		}
		else if($currency_code_value=='NZD')
		{
			$currency_sign="NZ$";
		}
		return $currency_sign;
}

function getMemberAge($birthdate)
{
	global $db;
	$birth_date = $birthdate;
	if($birth_date != "")
	{
		$sql_birth = "SELECT DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT('$birth_date', '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT('$birth_date', '00-%m-%d')) AS age";
		$res_birth = $db->select_data($sql_birth );
		return $res_birth[0][0];
	}
}

/*function getMemberImage($userId)
{
	global $db;
	if($userId != "")
	{
		$sql_imgnm = "SELECT image_name FROM ad_member_photos WHERE user_id = '".$userId ."' and is_main = '1' and   	
is_active='Y' and is_approved = 'Y'";
		$res_imgnm = $db->select_data($sql_imgnm);
		if(count($res_imgnm) > 0)
		{
			return $res_imgnm[0]['image_name'];
		}
		else
		{
			$sql_imgnm1 = "SELECT image_name FROM ad_member_photos WHERE user_id = '".$userId ."' and is_main = '0' and   	
is_active='Y' and is_approved = 'Y'";
			$res_imgnm1 = $db->select_data($sql_imgnm1);
			if(count($res_imgnm1) > 0)
			{
				return $res_imgnm1[0]['image_name'];
			}
			else
			{
				return "";
			}
	
		}
		
	}
}*/


function displayMemImages($IMAGENAME,$ImageType,$width,$height,$userid)
		{
	
			global $db;
			$usernmm = getTypeName('ad_member','user_id','f_name',$userid);
		
			if(($IMAGENAME!="") && ($ImageType!=""))
			{
				if(!empty($IMAGENAME))
				{
					
					if($ImageType=="SMALL")
					{
						$photoPath	= DOMAIN."member_photos/thumb_member_small/".$IMAGENAME;
					}
					else if($ImageType=="MEDIUM")
					{
						$photoPath	= DOMAIN."member_photos/thumb_member_medium/".$IMAGENAME;
					}
					else
					{
						$photoPath	= DOMAIN."member_photos/".$IMAGENAME;
					}
					if($height != "" && $width != "")
					{
					$MemImage  = "<a href=\"".DOMAIN."profile.php?user_id=$userid\"><img src=\"".$photoPath."\" alt=\"".$usernmm."\" title=\"".$usernmm."\" style=\"border:solid 1px #00A3C3;\" width=\"".$width ."\" height=\"".$height."\" /></a>";			}
					else
					{
					$MemImage  = "<a href=\"".DOMAIN."profile.php?user_id=$userid\"><img src=\"".$photoPath."\"  title=\"".$usernmm."\" alt=\"".$usernmm."\"  style=\"border:solid 1px #00A3C3;\"  /></a>";		
					}
				}
				
			}
			else
			{
				$photoPath = DOMAIN."images/no_photo.jpg";
				if($height != "" && $width != "")
					{
					$MemImage  = "<a href=\"".DOMAIN."profile.php?user_id=$userid\"><img src=\"".$photoPath."\" title=\"".$usernmm."\" alt=\"".$usernmm."\"  style=\"border:solid 1px #00A3C3;\" width=\"".$width ."\" height=\"".$height."\" /></a>";			}
					else
					{
					$MemImage  = "<a href=\"".DOMAIN."profile.php?user_id=$userid\"><img src=\"".$photoPath."\" alt=\"".$usernmm."\"  title=\"".$usernmm."\" style=\"border:solid 1px #00A3C3;\"  /></a>";		
					}
			}
		return $MemImage;
	}
	
	
	function displayImgTag($IMAGENAME,$ImageType,$width,$height,$userid)
		{
	
			global $db;
			$usernmm = getTypeName('ad_member','user_id','f_name',$userid);
		
			if(($IMAGENAME!="") && ($ImageType!=""))
			{
				if(!empty($IMAGENAME))
				{
					
					if($ImageType=="SMALL")
					{
						$photoPath	= DOMAIN."member_photos/thumb_member_small/".$IMAGENAME;
					}
					else if($ImageType=="MEDIUM")
					{
						$photoPath	= DOMAIN."member_photos/thumb_member_medium/".$IMAGENAME;
					}
					else
					{
						$photoPath	= DOMAIN."member_photos/".$IMAGENAME;
					}
					if($height != "" && $width != "")
					{
					$MemImage  = "<img src=\"".$photoPath."\" alt=\"".$usernmm."\" title=\"".$usernmm."\" style=\"border:solid 1px #00A3C3;\" width=\"".$width ."\" height=\"".$height."\" />";			}
					else
					{
					$MemImage  = "<img src=\"".$photoPath."\"  title=\"".$usernmm."\" alt=\"".$usernmm."\"  style=\"border:solid 1px #00A3C3;\"  />";		
					}
				}
				
			}
			else
			{
				$photoPath = DOMAIN."images/no_photo.jpg";
				if($height != "" && $width != "")
					{
					$MemImage  = "<img src=\"".$photoPath."\" title=\"".$usernmm."\" alt=\"".$usernmm."\"  style=\"border:solid 1px #00A3C3;\" width=\"".$width ."\" height=\"".$height."\" />";			}
					else
					{
					$MemImage  = "<img src=\"".$photoPath."\" alt=\"".$usernmm."\"  title=\"".$usernmm."\" style=\"border:solid 1px #00A3C3;\"  />";		
					}
			}
		return $MemImage;
	}
	
	
	

function displayMemImages_enlarge($IMAGENAME,$ImageType)
		{
	
			global $db;
		
			if(($IMAGENAME!="") && ($ImageType!=""))
			{
				if(!empty($IMAGENAME))
				{
					
					if($ImageType=="SMALL")
					{
						$photoPath	= DOMAIN."member_photos/thumb_member_small/".$IMAGENAME;
					}
					else if($ImageType=="MEDIUM")
					{
						$photoPath	= DOMAIN."member_photos/thumb_member_medium/".$IMAGENAME;
					}else if($ImageType=="LARGE")
					{
						$photoPath	= DOMAIN."member_photos/thumb_member_large/".$IMAGENAME;
					}
					else
					{
						$photoPath	= DOMAIN."member_photos/".$IMAGENAME;
					}					
				}
				
			}
			else
			{
				$photoPath = DOMAIN."images/no_photo.jpg";				
			}
		return $photoPath;
	}
	
	
	
	
	
	
		 function GetAge($Birthdate)
  
      	{
  
              // Explode the date into meaningful variables
  
              list($BirthYear,$BirthMonth,$BirthDay) = explode("-", $Birthdate);
  
              // Find the differences
  
              $YearDiff = date("Y") - $BirthYear;
  
              $MonthDiff = date("m") - $BirthMonth;
  
              $DayDiff = date("d") - $BirthDay;
  
              // If the birthday has not occured this year
  
              if ($DayDiff < 0 || $MonthDiff < 0)
  
                $YearDiff--;
  
              return $YearDiff;
  
      }
	
	function user_address($userid)
		{
			global $db;
			$address = array();
			$sql_address = "SELECT `country`,`state`,`city` FROM ad_member where is_active='Y' and user_id='$userid'";
			$res_address=$db->select_data($sql_address);
			
			if($res_address[0]['country']!="")
			{
				 $address[] = getTypeName('ad_country','con_id','name',$res_address[0]['country']);
			}
			if($res_address[0]['state']!="")
			{
				$address[] = getTypeName('ad_state','state_id','state_name',$res_address[0]['state']);
			}
			if($res_address[0]['city']!="0")
			{
				$address[] = getTypeName('ad_cities','cty_id','name',$res_address[0]['city']);
			}
			$address2 = implode(", ",$address);
			return 	$address2;				
		}	
		
		function user_height($height2)
		{
			global $db;
			$strquots = array("\'","\"",);
			
			$h1 = str_replace($strquots,"",$height2);
			$h2 = split(" ", $h1);
			
			$toth2 = ($h2[0] * 12) + $h2[1];
			$toth3 = $toth2 * 2.54;
			
			if($toth3!="")
			{
			$totalheight = $toth3." cm";
			}else{
			$totalheight = "";
			}
			return $totalheight;
			
		}
		
		function user_weight($weight2)
		{
			$weight3 = trim($weight2);
			$uesr_w2 = $weight3 * 2.204622;
			$uesr_w = round($uesr_w2,0);
			if($weight2!="")
			{
			return "(".$uesr_w." lb)";
			}
		}
		
		////////// Function to ge6t profile image
		function getProfileImage($userid)
		{
			global $db;
			$sql_photo= "SELECT `profile_photo` FROM hd_member where member_id='".$userid."'";
			$res_phhoto=$db->select_data($sql_photo);
			$profile_photodb=$res_phhoto[0]['profile_photo'];
			return $profile_photodb;
		}
////////// get Affilliate Product id and url ///////////////////////////////////////////////		
function getAffiliateId($membershipType)
		{
		    global $db;
			$recordset = array();
 			$sel_qu="SELECT affiliate_membership_id,affiliate_membership_name,affiliate_url FROM  `hd_affiliate_setting` WHERE `is_active` = 'Y' AND affiliate_membership_name='".$membershipType."'";
			$res_qu=$db->select_data($sel_qu);
			if(count($res_qu)>0)
			{
			for($i=0;$i<count($res_qu);$i++)
				{
				   $membership_id = $res_qu[$i]['affiliate_membership_id'];
				   $affiliate_membership_name = $res_qu[$i]['affiliate_membership_name'];
				   $affiliate_url = $res_qu[$i]['affiliate_url'];
				 
				   array_push($recordset,$affiliate_membership_name.",".$membership_id.",".$affiliate_url);
				}
				return $recordset;	   
			}
			else
			{
			   return 0;
			}
		}

////////// get paypal business id and url //////////////////////////////////////////////////		
		function getPaypalBuissness()
		{
		    global $db;
			$sel_qu="SELECT `email` , `type` FROM  `hd_paypal` WHERE `status` = 'Y'";
			$res_qu=$db->select_data($sel_qu);
			if(count($res_qu)>0)
			{
			   $business=$res_qu[0][email];
			   $type=$res_qu[0][type];
			   
			   if($type=="S"){ $url="https://www.sandbox.paypal.com/cgi-bin/webscr";}elseif($type=="M"){ $url="https://www.paypal.com/cgi-bin/webscr"; }
			   return $business.",".$url.",".$product_no.",".$affiliate_url;
			}
			else
			{
			   return 0;
			}
		}
///////////////get gift image with image name and cost ///////////////////////////////////////////////
        function getGiftDetails($giftid)
		{
		    global $db;
			$sel_qu="SELECT * FROM  `hd_gift` WHERE `id` = '".$giftid."' and `is_active`='Y'";
			$res_qu=$db->select_data($sel_qu);
			if(count($res_qu)>0)
			{
			   return $res_qu[0][title].",".$res_qu[0][image].",".$res_qu[0][cost];
			}
			else
			{
			   return 0;
			}
		}
////////////////////////////// to get membership type /////////////////////////////////////////////////////////////
        function getMembershipType($userid)
		{
		    global $db;
			$sql_sel="select membership_type from hd_member where member_id='".$userid."'";
			$res=$db->select_data($sql_sel);
			return 	$res[0][membership_type];
		}
  ////////////// check valid  video	file //////////////////////////////////////////////////////////////////////
  function isValidVideoFile($file)
		{				
			if (($file == "flv") || ($file == "FLV")||($file == "wmv")||($file == "WMV")||($file == "MPG")||($file == "mpg")||($file == "avi")||($file == "AVI")||($file == "MOV")||($file == "mov"))
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}	
		
/******************* Find out membership type  purchase and it's validity period ***************/

	function chkMemebership_period($member_id)
		{     
			global $db;
			
		 	$sql = "SELECT *  FROM hd_membership_registration WHERE user_id='".$member_id."'
					ORDER BY id DESC LIMIT 0 , 1";
			
			$res = $db->select_data($sql);
			
			if(count($res)>0)
			{
			for($i=0; $i<count($res);$i++)
			{
				 $mem_valid_from = $res[$i]['mem_valid_from'];
				 $mem_valid_to = $res[$i]['mem_valid_to'];
				 $memebership_id = $res[$i]['membership_id'];
				 $today = date('d-m-Y',time());
				 if(($mem_valid_from <= $today)||($mem_valid_to >= $today))
				 {
				 		//echo "Memebership is alive....";
						return $memebership_alive = getMembershipName($memebership_id);
				 }
				else
				{
					//
				}
			
			}								
									
		}	
		else
		{
			$memebership_alive = "Bronze Membership";
			return $memebership_alive ;
		}
	}
	
	/********************  Get Memebeship Name  ***********************/	
	
	function getMembershipName($id)
	{
		global $db;
			
	  	$sql_memShName = "SELECT memebership_type,cost,is_active  FROM `hd_membership_feature` WHERE id='".$id."'
					AND is_active='Y' LIMIT 0 , 1";
			
			$res_memShName = $db->select_data($sql_memShName);
		
			if(count($res_memShName)>0)
			{
			return $memebership_type =	$res_memShName[0]['memebership_type'];
			/*	$cost =	$res_memShName[0]['cost'];
				$is_active =	$res_memShName[0]['is_active'];*/
			}
			
	}
	
	/************************************************************************/
	
	
	/*	===============================================================================*/	
 //			Uploade image and delete from dest folder 
/* ==============================================================================*/

	function uploadImg($imgName,$dirname="")
		{
			//$img_suffix = strtotime(date("Y-m-d i:m:s"));
			$img_suffix = rand(0, 89999);
			if($_FILES[$imgName]['name']!="")
			{
				$image_part = explode(".",$_FILES[$imgName]['name']);
				//$dest = $dirname."/".$image_part[0]."_$img_suffix.".$image_part[1];
				$dest = $dirname."/".$image_part[0]."_$img_suffix.".$image_part[1];
				if(move_uploaded_file($_FILES[$imgName]['tmp_name'],$dest))
				{
					return $image_part[0]."_$img_suffix.".$image_part[1];
				}	
			}
			else
			{
				echo "Image name is empty.";
			}
		}
	/*	===============================================================================*/	
	

	/*	=====================================================================*/	
/************** Swap two consequetive Record    28 May,2010 ***************/
/* use function  as :
		$table ="dvd_cms";
		$offset = findOffset($table,$id,"id_collection","swap_id");
		changeOrderDown($offset,$table,"id_collection",$flag);	
/* ====================================================================*/	
		
		function findOffset($table,$id,$fld,$orderBy)
		{
			global $db;
			//echo "dddddddd".print_r($fld);
		 	$sql_chk = "SELECT * FROM ".$table ." ORDER BY '".$orderBy."' ASC";
						$res_chk = $db->select_data($sql_chk);
			//print_r($res_chk);
				$current ="";
				for($i=0; $i<count($res_chk);$i++)
				{ //echo $res_chk[$i][$fld];
				if($res_chk[$i][$fld] == $id)
					{
						
						$previous = $res_chk[$i-1][$fld];
						$current = $res_chk[$i][$fld];
						$next = $res_chk[$i+1][$fld];
					}
					
				}	
			/*echo "<br>previous ".$previous;
			echo "<br>current ".$current;
			echo "<br>next ".$next;*/
			return $previous.'_'.$current.'_'.$next;
			
		}
		
		function changeOrderDown($offsets,$table,$fildnm,$flag)
		{
			global $db;
				$offset = explode('_',$offsets);
				//print_r($offset);
				$previous = $offset[0];
				$current = $offset[1];
				$next = $offset[2];
				$sawp_id_cur = getTypeName($table,$fildnm,"sortorder",$current); //echo "<br>swcurr ".$sawp_id_cur;
			    $sawp_id_next = getTypeName($table,$fildnm,"sortorder",$next);//echo "<br>swnext". $sawp_id_next;
				$sawp_id_previous = getTypeName($table,$fildnm,"sortorder",$previous);//echo "<br>swprevious".$sawp_id_previous;
				if($flag == 0)
				{
					
				$sql_down_zero = "UPDATE ".$table."
							 SET 
							 sortorder = ".$sawp_id_next."
							 WHERE ".$fildnm."=".$current;
						 $db->update_data($sql_down_zero); //
						 /*********************/
		 $sql_up_zero = "UPDATE ".$table."
							 SET 
							 sortorder = ".$sawp_id_cur."
							 WHERE ".$fildnm." =".$next.""; //echo "<br>sql_up_zero :".
						 $db->update_data($sql_up_zero);
				
				}
				elseif($flag == 1)
				{
				$sql_down_one = "UPDATE ".$table."
							 SET 
							 sortorder = ".$sawp_id_previous."
							 WHERE ".$fildnm."=".$current;
						 $db->update_data($sql_down_one); //echo "<br>sql_down_one :".
						 /*********************/
				$sql_up_one = "UPDATE ".$table."
							 SET 
							 sortorder = ".$sawp_id_cur."
							 WHERE ".$fildnm." =".$previous.""; //echo "<br>sql_up_one :".
						 $db->update_data($sql_up_one);
				}
			
				 
		}
		
		
/* ============================================================================ */	


/*************************************************************************************************************/

function getOptionList($id,$tbl,$param)
	{		
		 $DBid = trim($param[0]);
		 $DBname = trim($param[1]);
		
		 
		  $sql_opt="SELECT * FROM ".$tbl." ";
		$res = mysql_query($sql_opt);	
		
		$OptList	= "<option value='' selected>Select</option>";	
		
				
		while($res_opt = mysql_fetch_array($res))
		{
			 $optId		= $res_opt[$DBid];
			 $optName	= $res_opt[$DBname];
			if(($id!="") && ($id==$optId) )
			{
				$OptList	.="<option value=".$optId." selected>$optName</option>";
				
			}
			else
			{
				$OptList	.="<option value=".$optId.">$optName</option>";
			}
		} // for
			
		return $OptList;					
	} // optlist


/********** Following section ADDED BY AMOL Nawale **********************************************************************************************************/	

function upMultImageWithThumb($destpath,$thumbPath,$file,$n_width,$n_height)
			{    $path = '';
			     while(list($key,$value) = each($_FILES[$file]["name"])) 
			     {
					if(!empty($value))
					{    if(file_exists($destpath.$_FILES[$file]["name"][$key]))
							{
								$alreadyExist[]=$_FILES[$file]["name"][$key];
							}
						else
							{
									if (($_FILES[$file]["type"][$key] == "image/gif")
									|| ($_FILES[$file]["type"][$key] == "image/jpeg")
									|| ($_FILES[$file]["type"][$key] == "image/pjpeg")
									|| ($_FILES[$file]["type"][$key] == "image/png")
									&& ($_FILES[$file]["size"][$key] < 2000000))
									{
									
											$source = $_FILES[$file]["tmp_name"][$key] ;
											$filename = $_FILES[$file]["name"][$key] ;
											
											move_uploaded_file($source, $destpath . $filename) ;
											//echo "Uploaded: " . $destpath . $filename . "<br/>" ;
											$path .= $filename.'***';
											//thumbnail creation start//
											$tsrc = $thumbPath.$_FILES[$file]["name"][$key];   // Path where thumb nail image will be stored
											//$n_width	=	100;          // Fix the width of the thumb nail images
											//$n_height	=	100;         // Fix the height of the thumb nail imaage
											
											/////////////////////////////////////////////// Starting of GIF thumb nail creation///////////
											$add=$destpath . $filename;
											if($_FILES[$file]["type"][$key]=="image/gif"){
											//echo "hello";
											$im=ImageCreateFromGIF($add);
											$width=ImageSx($im);              // Original picture width is stored
											$height=ImageSy($im);                  // Original picture height is stored
											$newimage=imagecreatetruecolor($n_width,$n_height);
											imageCopyResized($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
											if (function_exists("imagegif")) {
											//Header("Content-type: image/gif");
											ImageGIF($newimage,$tsrc);
											}
											if (function_exists("imagejpeg")) {
											//Header("Content-type: image/jpeg");
											ImageJPEG($newimage,$tsrc);
											}
											    }
											//chmod("$tsrc",0777);
											////////// end of gif file thumb nail creation//////////
											//$n_width=100;          // Fix the width of the thumb nail images
											//$n_height=100;         // Fix the height of the thumb nail imaage
											
											////////////// starting of JPG thumb nail creation//////////
											if($_FILES[$file]["type"][$key]=="image/jpeg"){
											    //echo $_FILES[$file]["name"][$key]."<br>";
											$im=ImageCreateFromJPEG($add);
											$width=ImageSx($im);              // Original picture width is stored
											$height=ImageSy($im);             // Original picture height is stored
											$newimage=imagecreatetruecolor($n_width,$n_height);                
											imageCopyResized($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
											ImageJpeg($newimage,$tsrc);
											chmod("$tsrc",0777);
											}
											////////////////  End of png thumb nail creation //////////
											if($_FILES[$file]["type"][$key]=="image/png"){
											//echo "hello";
											$im=ImageCreateFromPNG($add);
											$width=ImageSx($im);              // Original picture width is stored
											$height=ImageSy($im);                  // Original picture height is stored
											$newimage=imagecreatetruecolor($n_width,$n_height);
											imageCopyResized($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
											if (function_exists("imagepng")) {
											//Header("Content-type: image/png");
											ImagePNG($newimage,$tsrc);
											}
											if (function_exists("imagejpeg")) {
											//Header("Content-type: image/jpeg");
											ImageJPEG($newimage,$tsrc);
											}
											    }				
											// thumbnail creation end---
										}
										else{  $msg = "error in upload";
												//return $msg;
											}
							}//else
						}//if
					}//while
					$cnt 		=	strlen($path)-3;
					$pathnw			=	substr_replace($path, '', $cnt,3 );
					$renamePathArr	=	explode('***', $pathnw);
					for($rm=0;$rm<count($renamePathArr);$rm++)
					{
						$random_digit=rand(0000,999999);
						$oldFileName	=	$renamePathArr[$rm];
						$newFleName		=	$random_digit.$oldFileName;
						$retNewFileArr[]=	$newFleName;
						rename($destpath.$oldFileName,$destpath.$newFleName);
						rename($thumbPath.$oldFileName,$thumbPath.$newFleName);
					}
					$retNewFileStr	=	implode('***', $retNewFileArr);
					$return[]	= $retNewFileStr; //$pathnw;
					$return[]	= $alreadyExist;
					return $return;//$pathnw;
			}
			/*How to call fuction?
			 if(isset($_POST['submit'])){
			$destpath 	= "photos/";
			$thumbPath	= "photos/thimg/";
			$file		= "file";
			$n_width	= 100;
			$n_height	= 100;
			upMultImageWithThumb($destpath,$thumbPath,$file,$n_width,$n_height); */
			#its proper working image uploade function
function manageThumbSize($width,$height,$n_width,$n_height)
{ #this fuction is created by Amol_Nawale to manage resize hieght width of thumb
	if($width > $height){ 
			$x	=	$width/$height;
			if($n_width !='' && $n_height == ''){
				$n_height	=	$n_width /$x;			
			}else if($n_width =='' && $n_height !=''){
				$n_width	=	$x*$n_height;			
		}
	 }
	else if($height > $width) {
			$x	=	$height/$width;
			if($n_width !='' && $n_height == ''){
				$n_height	=	$n_width *$x;			
			}else if($n_width =='' && $n_height !=''){
				$n_width	=	$n_height/$x;			
		}
	}
	else if($height == $width) {	
			if($n_width !='' && $n_height == ''){
				$n_height	=	$n_width;			
			}else if($n_width =='' && $n_height !=''){
				$n_width	=	$n_height;			
		}
	}
	if($n_width == '' && $n_height	==	''){
		$n_width	=	100;
		$n_height	=	100;	
	}
	$size[]	=	$n_width;
	$size[]	=	$n_height;
	return $size;	
}

function createThumb($destpath,$thumbPath,$file,$n_width,$n_height,$rename)
{			#This fuction Created By Amol Nawale to Grenerate multiple size of thumb images 
	               
					//$filename = $_FILES[$file]["name"] ;
					$tsrc = $thumbPath.$_FILES[$file]["name"][0];   // Path where thumb nail image will be stored
					$add=$destpath .$rename;
					if($_FILES[$file]["type"][0]=="image/gif"){
					//echo "hello";
					$im=ImageCreateFromGIF($add);
					$width=ImageSx($im);              // Original picture width is stored
					$height=ImageSy($im);                  // Original picture height is stored
					$size		=	manageThumbSize($width,$height,$n_width,$n_height);
					$n_width	=	$size[0];
					$n_height	=	$size[1];
					$newimage=imagecreatetruecolor($n_width,$n_height);
					imageCopyResized($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
					if (function_exists("imagegif")) {
					//Header("Content-type: image/gif");
					ImageGIF($newimage,$tsrc);
					}
					if (function_exists("imagejpeg")) {
					//Header("Content-type: image/jpeg");
					ImageJPEG($newimage,$tsrc);
					}
					}
					//chmod("$tsrc",0777);
					////////// end of gif file thumb nail creation//////////
					//$n_width=100;          // Fix the width of the thumb nail images
					//$n_height=100;         // Fix the height of the thumb nail imaage
					
					////////////// starting of JPG thumb nail creation//////////
					if($_FILES[$file]["type"][0]=="image/jpeg"){
					    //echo $_FILES[$file]["name"]."<br>";
					$im=ImageCreateFromJPEG($add);
					$width=ImageSx($im);              // Original picture width is stored
					$height=ImageSy($im);             // Original picture height is stored
					$size		=	manageThumbSize($width,$height,$n_width,$n_height);
					$n_width	=	$size[0];
					$n_height	=	$size[1];
					$newimage=imagecreatetruecolor($n_width,$n_height);                
					imageCopyResized($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
					ImageJpeg($newimage,$tsrc);
					chmod("$tsrc",0777);
					}
					////////////////  End of png thumb nail creation //////////
					if($_FILES[$file]["type"][0]=="image/png"){
					//echo "hello";
					$im=ImageCreateFromPNG($add);
					$width=ImageSx($im);              // Original picture width is stored
					$height=ImageSy($im);                  // Original picture height is stored
					$size		=	manageThumbSize($width,$height,$n_width,$n_height);
					$n_width	=	$size[0];
					$n_height	=	$size[1];
					$newimage=imagecreatetruecolor($n_width,$n_height);
					imageCopyResized($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
					if (function_exists("imagepng")) {
					//Header("Content-type: image/png");
					ImagePNG($newimage,$tsrc);
					}
					if (function_exists("imagejpeg")) {
					//Header("Content-type: image/jpeg");
					ImageJPEG($newimage,$tsrc);
					}
				}	
				rename($tsrc,$thumbPath.$rename);			
}
function dispDurationType($offer_type)
{
	global $db;
	$res	=	$db->select_data("SELECT  *  FROM  `offer_type`   WHERE  `id` ='$offer_type'");
	return $res[0]['offer_title'];
}
function productDetails($prod_id)
{
	global $db;
	$selProd	=	"SELECT * FROM `products` WHERE `id` = '".$prod_id."'";
	$resProd	=	$db->select_data($selProd);
	
	$p_id			=	$resProd[0]['p_id'];
	$prod_type		=	$resProd[0]['prod_type'];
	$mfr_name		=	$resProd[0]['mfr_name'];
	$model			=	$resProd[0]['model'];
	$cost_probably	=	$resProd[0]['min_price'];
	$ten_days		=	$resProd[0]['ten_days'];
	$twenty_days	=	$resProd[0]['twenty_days'];
	$end_days		=	$resProd[0]['end_days'];
	$image			=	$resProd[0]['image'];
	$sim_type			=	$resProd[0]['sim_type'];
	if($prod_type=="phone")
	{
    echo '<table style="margin-left: 10px; " >
    <tr><td colspan="2">&nbsp;</td></tr>
    	<tr><td colspan="2"><b>Products Details-</b></td></tr>
    	<tr>
    		<td><img src="Upload/products_images/thumb/'.$image.'" width="60" style="padding:5px; " /></td>
    		<td>
    			<table>                            				
    				<tr>
    					<td>ID</td><td>&nbsp;&nbsp;:</td><td>&nbsp;'.$p_id.'</td>
    				</tr>
    				<tr>
    					<td>MFR Name&nbsp;</td><td>&nbsp;&nbsp;:</td><td>&nbsp;'.$mfr_name.'</td>
    				</tr>
    				<tr>
    					<td>Model</td><td>&nbsp;&nbsp;:</td><td>&nbsp;'.$model.'</td>
    				</tr>
    				<tr>
    					<td>Cost</td><td>&nbsp;&nbsp;:</td><td>&nbsp;$'.$cost_probably.'</td>
    				</tr>
    			</table>
    		</td>
    		<td>
    			<table style="margin-left: 20px; ">                            				
					<tr>
    					<td>Till 10 Days</td><td>&nbsp;&nbsp;:</td><td>&nbsp;$'.$ten_days.'</td>
    				</tr>
    				<tr>
    					<td>10 Till 20 Days</td><td>&nbsp;&nbsp;:</td><td>&nbsp;$'.$twenty_days.'</td>
    				</tr>
    				<tr>
    					<td>20 Till End Days</td><td>&nbsp;&nbsp;:</td><td>&nbsp;$'.$end_days.'</td>
    				</tr>
    				<tr>
    				<td> &nbsp;</td>
    				</tr>
    			</table>
    		</td>
    	</tr>
    </table>';
	}
	else
	{
		echo '<table style="margin-left: 10px; margin-top:10px; ">
		<tr><td colspan="2"><b>Products Details-</b></td></tr> 
			<tr>
			<td>
			<table>                          				
    				<tr>
    					<td>ID</td><td>&nbsp;&nbsp;:</td><td>&nbsp;'.$p_id.'</td>
    				</tr>
    				<tr>
    					<td>Sim Type</td><td>&nbsp;&nbsp;:</td><td>&nbsp;'.$sim_type.'</td>
    				</tr>
    				<tr>
    					<td>Cost</td><td>&nbsp;&nbsp;:</td><td>&nbsp;$'.$cost_probably.'</td>
    				</tr>
    		</table>
    		</td>
    		<td>
    			<table style="margin-left: 20px; ">                            				
					<tr>
    					<td>Till 10 Days</td><td>&nbsp;&nbsp;:</td><td>&nbsp;$'.$ten_days.'</td>
    				</tr>
    				<tr>
    					<td>10 Till 20 Days</td><td>&nbsp;&nbsp;:</td><td>&nbsp;$'.$twenty_days.'</td>
    				</tr>
    				<tr>
    					<td>20 Till End Days</td><td>&nbsp;&nbsp;:</td><td>&nbsp;$'.$end_days.'</td>
    				</tr>
      			</table>
    		</td>
    		</tr>
    	</table>';
	}
}
function clientProductDetails($prod_id)
{
	global $db;
	$selProd	=	"SELECT * FROM `products` WHERE `id` = '".$prod_id."'";
	$resProd	=	$db->select_data($selProd);
	
	$p_id			=	$resProd[0]['p_id'];
	//$prod_type		=	$resProd[0]['prod_type'];
	$mfr_name		=	$resProd[0]['mfr_name'];
	$model			=	$resProd[0]['model'];
	$cost_probably	=	$resProd[0]['min_price'];
	$image			=	$resProd[0]['image'];
	
    echo '<table style="margin-left: 10px; " >    	
    	<tr>
    		<td><img src="admin/Upload/products_images/thumb/'.$image.'" width="60" /></td>
    		<td  style=" vertical-align:top;">
    			<table style="margin-left: 10px;" >                      				
    				<tr>
    					<td style="color: #005E8D;font-size: 14px;"><b>MFR Name</b>&nbsp;</td><td style="color: #005E8D;font-size: 15px;">:</td><td style="color: #BE0202;font-size: 15px;">&nbsp;'.$mfr_name.'</td>
    				</tr>  
    				<tr>
    					<td style="color: #005E8D;font-size: 14px;"><b>Model</b></td><td style="color: #005E8D;font-size: 15px;">:</td><td style="color: #BE0202;font-size: 15px;">&nbsp;'.$model.'</td>
    				</tr>  				
    				<tr>
    					<td style="color: #005E8D;font-size: 14px;"><b>Cost</b></td><td style="color: #005E8D;font-size: 15px;">:</td><td style="color: #BE0202;font-size: 15px;">&nbsp;$'.$cost_probably.'</td>
    				</tr>
    			</table>
    		</td>
    	</tr>
    </table>';
}

function clientProductDetails_plan_select($prod_id)
{
	global $db;
	$selProd	=	"SELECT * FROM `products` WHERE `id` = '".$prod_id."'";
	$resProd	=	$db->select_data($selProd);
	
	//rent_order
	$selProd1	=	"SELECT * FROM `rent_order` WHERE `prod_id` = '".$prod_id."'";
	$resProd1	=	$db->select_data($selProd1);
	
	$p_id			=	$resProd[0]['p_id'];
	//$prod_type		=	$resProd[0]['prod_type'];
	$mfr_name		=	$resProd[0]['mfr_name'];
	$model			=	$resProd[0]['model'];
	$image			=	$resProd[0]['image'];
	$total_days     =   $resProd1[0]['total_days'];
	$cost     		=   $resProd1[0]['cost'];
	
    echo '<table style="margin-left: 10px; " >    	
    	<tr>
    		<td><img src="admin/Upload/products_images/thumb/'.$image.'" width="60" /></td>
    		<td  style=" vertical-align:top;">
    			<table style="margin-left: 10px;" >                      				
    				<tr>
    					<td style="color: #005E8D;font-size: 14px;"><b>MFR Name</b>&nbsp;</td><td style="color: #005E8D;font-size: 15px;">:</td><td style="color: #BE0202;font-size: 15px;">&nbsp;'.$mfr_name.'</td>
    				</tr>  
    				<tr>
    					<td style="color: #005E8D;font-size: 14px;"><b>Model</b></td><td style="color: #005E8D;font-size: 15px;">:</td><td style="color: #BE0202;font-size: 15px;">&nbsp;'.$model.'</td>
    				</tr>  				
    				<tr>
    					<td style="color: #005E8D;font-size: 14px;"><b>Total Days</b></td><td style="color: #005E8D;font-size: 15px;">:</td><td style="color: #BE0202;font-size: 15px;">&nbsp;'.$total_days.'</td>
    				</tr>
    				<tr>
    					<td style="color: #005E8D;font-size: 14px;"><b>Total Price</b></td><td style="color: #005E8D;font-size: 15px;">:</td><td style="color: #BE0202;font-size: 15px;">&nbsp; $'.$cost.'</td>
    				</tr>
    			</table>
    		</td>
    </table>';
}
?>