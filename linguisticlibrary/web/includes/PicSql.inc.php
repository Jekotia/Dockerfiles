<?php
//Note Please Dont' add ane line or any code before 50 line No.
Class PicSQL extends DBSQL
{

	// Site Variables
	var $formatdate_PHP= "m-d-Y";
	var $formatdate_MYSQL= "%m-%d-%Y";	

	
	function PicSQL($DBName = "")
    {
 	  $this->DBSQL($DBName);
    }
	
	
   
   // Standard Functions

	function select_data($sql)
	{
		$result = $this->select($sql);
		return $result;
	}
	
	function selectaso_data($sql)
	{
		$result = $this->selectaso($sql);
		return $result;
	}
	//Insert data into table----------------
	function insert_data($sql)
	{
		$result = $this->insert($sql);
		return $result;
	}
	//Insert data into table----------------
	function update_data($sql)
	{
		$result = $this->update($sql);
		return $result;
	}
	//Delete data from table----------------
	function delete_data($sql)
	{
		$result = $this->delete($sql);
		return $result;
	}	
	
	// End Standard Functions
		

	

	//get date format
	function getDateFormat_new($date)
	{
			global $db;	
			$sql_date = "select DATE_FORMAT('$date','%d %b %Y')";  //%d-%b-%Y
			$res_date = $db->select_data($sql_date);
			return $res_date[0][0];
			
	}
	
	function getdateformat($timestamp,$format="")
	{

		if($format == "")
			$format = $this->formatdate_PHP;
	/*
		 $sql="SELECT FROM_UNIXTIME('$timestamp','$format')";
		$result=$this->select_data($sql);
		*/

		return @date($format,$timestamp);
	}

	function gettimeformat($timestamp,$format="")
	{
		if($format == "")
			$format = $this->formattime;
		$sql="SELECT FROM_UNIXTIME('$timestamp','$format')";
		$result=$this->select_data($sql);
		return $result[0][0];
	}
	//end get date 
	
	function getunixtime($cdate,$format)
	{
	if ($format=="dmy")	
		{
		$myarr=explode("-",$cdate);
		$mydate=$myarr[2]."-".$myarr[1]."-".$myarr[0];		
		}
	if ($format=="mdy")	
		{
		$myarr=explode("-",$cdate);
		//$mydate=$myarr[2]."-".$myarr[1]."-".$myarr[0];		
		$mydate=$myarr[0]."-".$myarr[1]."-".$myarr[2];
		}
	$sql="select UNIX_TIMESTAMP('$mydate')";
		$result=$this->select_data($sql);
		return $result[0][0];
	}
	
	

					
	function get_field($table,$destination_field,$source_field,$source_value)
	{
			
		 $sql = "select ".$destination_field." from ".$table." where ".$source_field."='".$source_value."'";
		$result = mysql_query($sql) or die(mysql_error());
		if(mysql_num_rows($result))
		{
			$destination_value = mysql_result($result,0);
			return $destination_value;
			 
		}
	}

	
	function print_image($image,$img_width,$img_height)
	{
		$width1=$img_width;
		$height1=$img_height;
		$inf = @GetImageSize($image);
		$width2=$inf[0];
		$height2= $inf[1];
		$width=$width2;
		$height=$height2;
		if($width>$width1)
		{	$factor=round(($width1/$width),2);
			$width=$width1;
			$height=$height * $factor;
			$changed=1;
		}
		if($height>$height1)
		{	$factor1=round(($height1/$height),2);
			$height=$height1;
			$width=$width * $factor1;	
			$changed=1;
		}
		
		if($image=="group_images/")
		{
			$img = "male.gif";
			$imgpath = $this->thmb_img.$img;
			return $this->print_image($imgpath,70,70);
		}
		else
		{
			$img_str = "<img src='$image' width='$width' height='$height' border=0>";
			return $img_str;
		}

	}

	function print_image_resized($image,$img_width=80,$img_height=100)
	{
		
		//width='$img_width' height='$img_height
								$cgh=$image;
								$cgh1=str_replace("mem_images/","mem_images/$img_width_$img_height",$image);
								if(!is_file($cgh1)) 
								$this->resize_jpg($cgh,$cgh1,$img_width,$img_height);
		$img_str = "<img src='$cgh1'  border=0 >";
		

		return $img_str;

	}
 function resize_jpg($sourcefile,$dest,$x,$y)
{
		
		$image = @getImageSize($sourcefile); # $info, only to handle problems with earlier php versions...
		switch($image[2]) {
		  case 1:
		  # GIF image
		$srcImage = @imageCreateFromGIF($sourcefile);
		break;
		case 2:
		  # JPEG image
		$srcImage = @imageCreateFromJPEG($sourcefile);
		break;
		case 3:
		  # PNG image
		$srcImage = @imageCreateFromPNG($sourcefile);
		break;
		}

	//	$srcImage=imagecreatefromjpeg($sourcefile);

				$src_w=@imageSX($srcImage);
    			$src_h=@imageSY($srcImage);

				// Calculate thumbnail's height and width (a "maxpect" algorithm)
				$dst_max_w = $x;
				$dst_max_h = $y;
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
				$time=time();
				$dstImage=@ImageCreateTrueColor($thumb_w,$thumb_h);
				    			
				@imagecopyresampled($dstImage,$srcImage,0,0,0,0,$thumb_w,$thumb_h,$src_w,$src_h);
				switch($image[2])
					{
					  case 1:
					# GIF image
					//header("Content-type: image/gif");
					@imageGIF($dstImage,$dest);
					case 2:
					# JPEG image
					//header("Content-type: image/jpeg");
					@imagejpeg($dstImage,$dest,25);
					case 3:
					# PNG image
					//header("Content-type: image/png");
					@imagePNG($dstImage,$dest);
					}

				//imagejpeg($dstImage,$dest);
				@imagedestroy($dstImage);
    			@imagedestroy($srcImage);
				return true;
	
}

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
					$Mcnt=$mcount."Minute ago";
					else
					$Mcnt=$mcount."Minutes ago";

					$Scnt=$difference."Seconds ago";
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
		
	function purchasecnt($mid)
	{
		global $db;
		$sql="select count('') from ms_purchase_order  where mid='$mid' and payment_flag='Y' ";
		$res=$this->select_data($sql);
		$cnt=$res[0][0];
		return $cnt;
	}

	function ageFromDOB($dob)
	{

		$age=$this->select_data("select TRUNCATE((TO_DAYS(now()) - TO_DAYS('".$dob."'))/365,0)");
		return $age[0][0];
	}



	//vote

	function showRating($artid)
	{
		//global $db;
			
		if(!empty($artid))
		{
				$sql="select * from votes_ratings where mid='$artid'";
				$res=$this->select_data($sql);
				$totalvotes=$res[0]['totalvotes'];
				
				if($totalvotes==0)
				{
					return $rating="<img src='ratingimg/empty.png' valign='middle'><img src='ratingimg/empty.png' ><img src='ratingimg/empty.png' ><img src='ratingimg/empty.png' ><img src='ratingimg/empty.png' >";
				}else
				{
						
				 $totalratings=$res[0]['awful']+$res[0]['poor']+$res[0]['good']+$res[0]['average']+$res[0]['excellent'];
				 $avgrate=round(($totalratings/$totalvotes),2);
				 
					if($avgrate >= 0.0 && $avgrate<=0.50)
					$rating="<img src='ratingimg/black-goldy.png' valign='middle'><img src='ratingimg/empty.png' ><img src='ratingimg/empty.png' ><img src='ratingimg/empty.png' ><img src='ratingimg/empty.png' >";
					else if($avgrate > 0.50 && $avgrate<=1.00)
					$rating="<img src='ratingimg/rated-full.png' ><img src='ratingimg/empty.png' ><img src='ratingimg/empty.png' ><img src='ratingimg/empty.png' ><img src='ratingimg/empty.png' >";
					else if($avgrate > 1.00 && $avgrate<=1.50)
					$rating="<img src='ratingimg/rated-full.png' ><img src='ratingimg/black-goldy.png' ><img src='ratingimg/empty.png' ><img src='ratingimg/empty.png' ><img src='ratingimg/empty.png' >";
					else if($avgrate > 1.50 && $avgrate<=2.00)
					$rating="<img src='ratingimg/rated-full.png' ><img src='ratingimg/rated-full.png' ><img src='ratingimg/empty.png' ><img src='ratingimg/empty.png' ><img src='ratingimg/empty.png' >";
					else if($avgrate > 2.00 && $avgrate<=2.50)
					$rating="<img src='ratingimg/rated-full.png' ><img src='ratingimg/rated-full.png' ><img src='ratingimg/black-goldy.png' ><img src='ratingimg/empty.png' ><img src='ratingimg/empty.png' >";
					else if($avgrate > 2.50 && $avgrate<=3.00)
					$rating="<img src='ratingimg/rated-full.png' ><img src='ratingimg/rated-full.png' ><img src='ratingimg/rated-full.png' ><img src='ratingimg/empty.png' ><img src='ratingimg/empty.png' >";
					else if($avgrate > 3.00 && $avgrate<=3.50)
					$rating="<img src='ratingimg/rated-full.png' ><img src='ratingimg/rated-full.png' ><img src='ratingimg/rated-full.png' ><img src='ratingimg/black-goldy.png' ><img src='ratingimg/empty.png' >";
					else if($avgrate > 3.50 && $avgrate<=4.00)
					$rating="<img src='ratingimg/rated-full.png' ><img src='ratingimg/rated-full.png' ><img src='ratingimg/rated-full.png' ><img src='ratingimg/rated-full.png' ><img src='ratingimg/empty.png' >";
					else if($avgrate > 4.00 && $avgrate<=4.50)
					$rating="<img src='ratingimg/rated-full.png' ><img src='ratingimg/rated-full.png' ><img src='ratingimg/rated-full.png' ><img src='ratingimg/rated-full.png' ><img src='ratingimg/black-goldy.png' >";
					else if($avgrate > 4.50 && $avgrate<=5.00)
					$rating="<img src='ratingimg/rated-full.png' ><img src='ratingimg/rated-full.png' ><img src='ratingimg/rated-full.png' ><img src='ratingimg/rated-full.png' ><img src='ratingimg/rated-full.png' >";
					else if($avgrate > 5.00)
					$rating="<img src='ratingimg/rated-full.png' ><img src='ratingimg/rated-full.png' ><img src='ratingimg/rated-full.png' ><img src='ratingimg/rated-full.png' ><img src='ratingimg/rated-full.png' >";
					
				
				}
					//echo "<br>--".$rating;
				return $rating;
		}


	
	}


	
	function getOptionList($id="",$tbl,$status,$param)
	{
		global $db;
		
		 $DBid = trim($param[0]);
		 $DBname = trim($param[1]);
		
		 $sql_opt="SELECT * FROM ".$tbl." where is_active='".$status."'";
		$res_opt=$db->select_data($sql_opt);
		if(count($res_opt)>0)
		{
			$OptList	= "<option value='' selected>Select</option>";
			for($i=0;$i<count($res_opt);$i++)			
			{
				 $optId		= $res_opt[$i][$DBid];
				 $optName	= $res_opt[$i][$DBname];
				if(($id!="")&&($id==$optId))
				{
					$OptList	.="<option value=".$optId." selected>$optName</option>";
					
				}
				else
				{
					$OptList	.="<option value=".$optId.">$optName</option>";
				}
			} // for
			return $OptList;
		}
						
	} // optlist

	
	
	

}//class
?>