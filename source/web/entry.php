<?php
include("header.php");
mysql_set_charset("UTF-8");
$author_id    = $_SESSION['author_id'];
$reader_id    = $_SESSION['reader_id'];
$author       = $_SESSION['author'];
$admin        = $_SESSION['ADMIN_NAME'];
$postid	  	  =	$_GET['id'];
$postname	  =	$_GET['postname'];
$link_page 	  = $_GET['link_page'];
$acc_type 	  = $_GET['acc_type'];
$recent_value = $_GET['value'];
$search_type  = $_GET['search_type'];
 
if(isset($_POST['delete']))
   {
   		 
		$query="DELETE FROM `add_post` WHERE id='$postid'";
		$res_query=$db->delete_data($query);
		
		$query="DELETE FROM `add_new_entry` WHERE post_id='$postid'";
		$res_query=$db->delete_data($query);
		
		$query1="DELETE FROM `bookmark` WHERE post_id='$postid'";
		$res_query1=$db->delete_data($query1);
		
		$msg=" ";
		 
   } 

$get_Postid   = "SELECT `user_id`,`user_type` FROM `add_post` WHERE `id`='$postid'";
$get_user     = $db->select_data($get_Postid);
$get_userid   = $get_user[0]['user_id'];
$get_usertype = $get_user[0]['user_type'];
//$show_name    = get_name($get_user_type,$get_userid);
		$auth_qry  = "SELECT name FROM user_register WHERE id='$get_userid'";
		$admin_qry = "SELECT admin_name FROM admin WHERE admin_id='$get_userid'";
		if ($get_usertype=="author"){		   
		   $user_name    = $db->select_data($auth_qry);			
  		   $show_name   = $user_name[0]['name'];
		}
		else {
			$user_name    = $db->select_data($admin_qry);
			$show_name   = $user_name[0]['admin_name'];
		}

$get_spacing = "SELECT * FROM `words_spacing` WHERE `id`=1";
$res_spacing = $db->select_data($get_spacing);
$space_allowed = $res_spacing[0]['word_spacing'];
		
//$space_allowed = 'Y';		
//$space_allowed = 'N';

/*if ($space_allowed=='')
    $space_allowed='Y';*/

if ($space_allowed=='Y')
    $space_allowed='&nbsp';
if ($space_allowed=='N')
    $space_allowed='';

   
?> 
<?php 
if($msg!='')
{
	
?>
<font color="black"><b><?php echo $msg;?></b></font>
<script type="text/javascript">
	setTimeout(function(){
		window.location.href="library.php";
	},100);
	
</script>

<?php } ?>
<link rel="stylesheet" type="text/css" href="css/style_homepage.css">
<link rel="stylesheet" type="text/css" href="css/style_3column.css">
 <style>	 
	body{
	margin: 0;
	font-family: Arial;
	font-size: 14px;
	}
</style>
<style>
.span_style
{
	background-color: yellow;
}
.word_div
{
  float: left;
  margin: 0;	   
}
</style>
<style>

table{
	width :100%;
	margin-top: -1px;
}
.table_td td
{
	color:white;
		background-color: #191919;
		border-top: 1px dotted #777;
		height: auto;
}
	#titles {
		/*width: 100%;
		height: auto;*/
	}
	.article {	
	
		padding: 1% 4%;
		font-size: 24px;
		color: white;
	}	
	.table_td
	{
		background-color: #191919;
		border-top: 1px dotted #777;
		height: auto;
	}
	audio
	{
		width:100px;
		height:50px;
	}		
	.first_hr
	{
		border:1px solid black;
	}
 	   .abc
	{
		color: #777;
	}
	.author_sty {
		padding-left: 10px;
		font-size:18px;
	}
	.mnop {
		font-size: 24px;
	}
	.main_wrap {
 	height:469px;
	background-color: #fff;
}
</style>	  
<script>
	function set_hover(id,occurance_ids,curr_type,val,alpha_info,img_hover_ids,dictionary_info)
	{
		//alert('Image Hover IDS='+img_hover_ids);
		//alert('Occurance='+occurance_ids);		 
		
	    var occ_id,make_id;
	    if (curr_type=='syn_')
	       set_type = 'eng_';
	    if (curr_type=='eng_')
	       set_type = 'syn_';   
		
	//	alert('id='+id+'occu ids='+occurance_ids+'curr_type='+curr_type+'annotation='+val);
		
	/*	var menu_title_info = get_unique_array(menu_title);
		var menu_abbr       = get_unique_array(abbrevation);
		var note            = get_unique_array(note);*/
		var tname = 'title_'+id;
	
	
	    if (document.getElementById(tname)){
	    	var title_menu = document.getElementById(tname).value;
	    	var menu_title_info = title_menu.split('**@@##@@**');
	    	
	    }
	 	if (document.getElementById('abbr_'+id)){
	 		var abbr_val   = document.getElementById('abbr_'+id).value;
	 		var menu_abbr       = abbr_val.split('**@@##@@**');
	 	}
	 	if (document.getElementById('note_'+id)){
	 		var note_val   = document.getElementById('note_'+id).value;
	 		var note            = note_val.split('**@@##@@**');
	 	}
	 	
		 
		var tot_g = menu_title_info.length;
		var set_grammer;
		set_grammer='<table class="dictionary_info">';
		var dictionary_data = dictionary_info.split('@');
		for (var sh=0;sh<dictionary_data.length;sh++){
			if(dictionary_data[sh])
			/*if (sh==0)
			  set_grammer+='<tr><td><b>'+dictionary_data[sh]+'</b></td></tr>';
			else*/
			 set_grammer+='<tr><td>'+dictionary_data[sh]+'</td></tr>';
		}
		   		
		set_grammer+='<tr><td><hr></td></tr>';
		for (md=0;md<tot_g;md++){
		    set_grammer+='<tr><td class="di_1"><font style="font-size: 16px; font-weight:bold; color: #444;">'+menu_title_info[md]+' </font> ';
		    if (menu_abbr[md])
		       set_grammer+=' <em>'+menu_abbr[md]+'</em> ';
		    if (note[md])   
		       set_grammer+=' '+note[md]+'<hr></td></tr>';
		    set_grammer+='<tr><td></td></tr>';
		}	   
		set_grammer+='<tr><td><font style="font-size: 18px;">Note: </font>'+val+'</td></tr>';
		set_grammer+='</table>'; 
		//alert(set_grammer);
		
		var grammer_col_exist = document.getElementById('gram');
		if (grammer_col_exist!=null)                                 // If exist in the document
		{
			document.getElementById('gram').innerHTML=set_grammer;
		}

			$("#"+id).addClass('span_style');
			//alert('Ocuurance IDs='+occurance_ids);
			var get_occurance_ids = occurance_ids.split(',');
			for (occ=0;occ<get_occurance_ids.length;occ++){
	 		    occ_id  = get_occurance_ids[occ];	   
		   		make_id = '#'+set_type+''+occ_id;
		 		//  alert(make_id);
		   		$(make_id).addClass('span_style');
			}//for
	    
		
        var alpha_exist = document.getElementById('alpha_info');
        if(alpha_exist!=null){                                       // If exist in the document
			if (alpha_info){
				   var all_hovers = img_hover_ids.split(',');
							for (occ=0;occ<img_hover_ids.length;occ++){
					 		    occ_id  = all_hovers[occ];	   
						   		imgmake_id = '#letterimg_'+occ_id;
						 		//alert(imgmake_id);
						 		var img_exist = document.getElementById(imgmake_id);
						 		if (imgmake_id)
						   		   $(imgmake_id).addClass('span_style');
							}//for						
			}			   
        } 
		   
	}
	function get_unique_array(menu_title)
	{
		var menu_title_info = menu_title.split('**@@##@@**');
		menu_title_info = menu_title_info.filter(function(v){return v!==''});
		menu_title_info = jQuery.unique( menu_title_info );
		return menu_title_info;
	}
	
	function get_hover(id,occurance_ids,curr_type,img_occurance_ids)
	{
	    var occ_id,make_id;
  		/*var gets_no = id.split('_');
		var get_no  = gets_no[1];
		var hover_letter    = '#letterimg_'+get_no;
		//var hover_letterimg = '#letter_'+get_no;
		$(hover_letter).removeClass('span_style');*/
		//$(hover_letterimg).removeClass('span_style');
		
	    if (curr_type=='syn_')
	       set_type = 'eng_';
	    if (curr_type=='eng_')
	       set_type = 'syn_';		  
	  	  
		$("#"+id).removeClass('span_style');
		var get_occurance_ids = occurance_ids.split(',');
		for (occ=0;occ<get_occurance_ids.length;occ++){
		   occ_id  = get_occurance_ids[occ];
		   make_id = '#'+set_type+''+occ_id;
		   $(make_id).removeClass('span_style');
		}
            
        var alpha_exist = document.getElementById('alpha_info');
        if(alpha_exist!=null){                                       // If exist in the document
			if (alpha_info){
				var img_occ_ids = img_occurance_ids.split(',');
							for (occ=0;occ<img_occ_ids.length;occ++){
					 		    occ_id  = img_occ_ids[occ];	   
						   		imgmake_id = '#letterimg_'+occ_id;
						 		// alert(make_id);
						 		var img_exist = document.getElementById(imgmake_id);
						 		if (imgmake_id)
						   		   $(imgmake_id).removeClass('span_style');
							}//for						
			}			   
        } 
	    
		//document.getElementById('gram').innerHTML='';
	}
</script>
 
<div class="container">
<div class="main_wrap">
<div id="titles">
<div class="article">
	<?php 
	if($show_name!='')
	{
	 $post_author = "by ".$show_name;
	}
	?>
	<?php echo $postname;?><font class="author_sty"> <?php echo $post_author;?></font>
	<?php
	if($link_page =="search_library")
	{
		$link_href ='search_library.php?acc_type='.$acc_type.'&val='.$recent_value.'&search_type='.$search_type;
	}else
	if($link_page =="library")
	{
			$link_href ='library.php';
	}	
	?>	
	<form method="post" name="entry">
	<!-- <a href="<?php echo $link_href;?>"><input type="button" value="BACK" style="float: right;" /></a> -->
	 
	 <!-- <a href="delete_post.php?id=<?php echo $postid?>&postname=<?php echo $postname?>"><input type="button" value="Delete" style="float: right;" /></a> 
	 --> 
	 <?php 
	 if($reader_id=='')
	 {
	   if(($_SESSION['author']==$show_name||$_SESSION['ADMIN_NAME']==$show_name)&&$show_name!='')
	   {  ?>
	  <input type="submit" value="Delete" name="delete" style="float: right;" />
	 
	  <a href="add_new_entryedit.php?edit_id=<?php echo $postid;?>"><input type="button" value="Edit" style="float: right;" /></a> 
<?php  } 
	 }
	?>
	
	 </form>
</div>
<?php 
$sql_sel  	      = "SELECT * FROM `visibility` WHERE `is_page_display` = 'Y'";
$res_sql  	      = $db->select_data($sql_sel);
$total    		  = count($res_sql);
$page_description = array(); 
for ($gd=0; $gd < $total; $gd++) { 
	$page_description[]=$res_sql[$gd]['page_desc'];
}
$td_width = 100/$total;
?>
</div>
<style>
	td{
		color:black;
		vertical-align: top;
		width:<?php echo $td_width; ?>%!important;	
    }
</style>
<div class="col_titles">
	<table cellspacing="0">
		<tr class="table_td">
			<?php
			for ($sv=0; $sv < $total; $sv++) { 
				$page_desc = $res_sql[$sv]['page_name'];
			?>
			<div class="col_<?php echo $i; ?>"><td><?php echo $page_desc; ?></td></div>
		<?php } ?>
		</tr>
		<tr>
			<!-- ++++++++++ FIRST CONTAINER ++++++++++++++++Foreign Language i.e. Considered as Sinderin-->
           <?php if (in_array("Entry Text Column", $page_description)) { ?>
			<td class="entry_cell">
					<?php
						    $get_synd_Post   = "SELECT * FROM `add_new_entry` WHERE `post_id`='$postid'  GROUP BY sindarin_order";
							$post_synd_Data  = $db->select_data($get_synd_Post);
							$tot_synd_data   = count($post_synd_Data);
							$word_id         = array();
							 
							for ($sp=0; $sp < $tot_synd_data; $sp++) {
								$synid      = $post_synd_Data[$sp]['id'];
								$synorder   = $post_synd_Data[$sp]['sindarin_order'];
								$engorder   = $post_synd_Data[$sp]['english_order'];
								$annotation = $post_synd_Data[$sp]['annotation'];
								$menu_id    = $post_synd_Data[$sp]['menu_id'];
								$alpha_info = $post_synd_Data[$sp]['alphabetic'];
								
								
								$synd_text  = $post_synd_Data[$sp]['sindarin_text'];
								$root_word  = $post_synd_Data[$sp]['root_word'];
								
								$dictionary_data   = get_dictionary_info($root_word);
								$imdictionary_data = implode("@", $dictionary_data);

		           			    $menu_data  = get_menu_data($menu_id);//get Menu data i.e title abbreavation and note for that word
									
																								
								$get_words_qry  = "SELECT id FROM `add_new_entry` WHERE `sindarin_order`='$synorder' AND `post_id`='$postid'";
								$get_wordres    = $db->select_data($get_words_qry);
								$get_word_count = count($get_wordres);
								 
								for ($gw=0; $gw < $get_word_count; $gw++) { 
									$word_id[]=$get_wordres[$gw]['id'];
								}
								$get_other_ids = "SELECT id FROM `add_new_entry` WHERE `english_order`='$engorder' AND `post_id`='$postid'";
								$get_other_res = $db->select_data($get_other_ids);
								array_push($word_id,$get_other_res[0]['id']);
								$word_id = array_unique($word_id);								
								$word_ids = implode(",", $word_id);	
								$all_imgarr = $word_ids;
								$this_id="syn_$synid";
		$imdictionary_data = str_replace("'", "", $imdictionary_data);
								$imdictionary_data = str_replace("\"", "", $imdictionary_data);						
								?> 
<input type='hidden' id='<?php echo "title_".$this_id; ?>' value='<?php echo $menu_data[0]; ?>'>		
						<input type='hidden' id='<?php echo "abbr_".$this_id; ?>' value='<?php echo $menu_data[1]; ?>'>
						<input type='hidden' id='<?php echo "note_".$this_id; ?>' value='<?php echo $menu_data[2]; ?>'>								
								
							   <div id="<?php echo $this_id; ?>" onmouseover="set_hover(this.id,'<?php echo $word_ids; ?>','syn_','<?php echo $annotation;?>','<?php echo $alpha_info; ?>','<?php echo $all_imgarr; ?>','<?php echo $imdictionary_data; ?>')" onmouseout="get_hover(this.id,'<?php echo $word_ids; ?>','syn_','<?php echo $all_imgarr; ?>')" class="word_div"><?php echo $synd_text; ?><?php echo $space_allowed; ?></div>				               
								<?php
								unset($word_id);
							}//for  ?>
			</td>
			<?php }//if first container ?>
			<!-- ++++++++++ SECOND CONTAINER ++++++++++++++++ Native Language i.e. Considered as English -->
			<?php if (in_array("Translation Column", $page_description)) { ?>
		<td class="entry_cell2">				
				<?php
				        $get_eng_Post   = "SELECT * FROM `add_new_entry` WHERE `post_id`='$postid' GROUP BY english_order";
						$post_eng_Data  = $db->select_data($get_eng_Post);
						$tot_eng_data   = count($post_eng_Data);
						 
						for ($sp=0; $sp < $tot_eng_data; $sp++) { 
							$engid      = $post_eng_Data[$sp]['id'];
							$engorder   = $post_eng_Data[$sp]['english_order'];
							$synorder   = $post_eng_Data[$sp]['sindarin_order'];
							$annotation = $post_eng_Data[$sp]['annotation'];
							$menu_id    = $post_eng_Data[$sp]['menu_id'];		
							$alpha_info = $post_eng_Data[$sp]['alphabetic'];
							$alpha_img  = $post_eng_Data[$sp]['alphabetic_image'];

																	
							$root_word  = $post_eng_Data[$sp]['root_word'];				

							$dictionary_data   = get_dictionary_info($root_word);
							$imdictionary_data = implode("@", $dictionary_data);


							$menu_data  = get_menu_data($menu_id);//get Menu data i.e title abbreavation and note for that word

							$get_words_qry  = "SELECT id FROM `add_new_entry` WHERE `english_order`='$engorder' AND `post_id`='$postid'";
							$get_wordres    = $db->select_data($get_words_qry);
							$get_word_count = count($get_wordres);
							$word_id        = array(); 
							for ($gw=0; $gw < $get_word_count; $gw++) { 
								$word_id[]=$get_wordres[$gw]['id'];
							}
							$get_other_ids = "SELECT DISTINCT id FROM `add_new_entry` WHERE `sindarin_order`='$synorder' AND `post_id`='$postid'";
							$get_other_res = $db->select_data($get_other_ids);
							array_push($word_id,$get_other_res[0]['id']);
							$word_id= array_unique($word_id);
							$word_ids = implode(",", $word_id);
							$all_imgarr = $word_ids;
						    $this_id="eng_$engid";
	$imdictionary_data = str_replace("'", "", $imdictionary_data);
								$imdictionary_data = str_replace("\"", "", $imdictionary_data);						
							?> 	
                        <input type='hidden' id='<?php echo "title_".$this_id; ?>' value='<?php echo $menu_data[0]; ?>'>		
						<input type='hidden' id='<?php echo "abbr_".$this_id; ?>' value='<?php echo $menu_data[1]; ?>'>
						<input type='hidden' id='<?php echo "note_".$this_id; ?>' value='<?php echo $menu_data[2]; ?>'>									     
							    <div id="<?php echo $this_id; ?>" class="word_div" onmouseover="set_hover(this.id,'<?php echo $word_ids; ?>','eng_','<?php echo $annotation;?>','<?php echo $alpha_info; ?>','<?php echo $all_imgarr; ?>','<?php echo $imdictionary_data; ?>')" onmouseout="get_hover(this.id,'<?php echo $word_ids; ?>','eng_','<?php echo $all_imgarr; ?>')"><?php echo $post_eng_Data[$sp]['english_text']; ?><?php echo $space_allowed; ?></div>								
							 <?php
						 	unset($word_id);
						 }//for  ?>	
			</td>
			<?php }//second container ?>
			<!-- ++++++++++ THIRD CONTAINER : Alphabetic Column ++++++++++++++++ -->
			<?php if (in_array("Alphabetic Column", $page_description)) { ?>
			<td class="entry_cell3" id="alpha_info">
				<?php
				    $get_alpha_info = "SELECT id,alphabetic FROM `add_new_entry` WHERE `post_id`='$postid'";// GROUP BY sindarin_order
					$get_alpha_data = $db->select_data($get_alpha_info);
					$tot_alpha_data = count($get_alpha_data);
					
					$image_set = array();	
					$alp_set = array();	 
					for ($sp=0; $sp < $tot_alpha_data; $sp++) {
						$alpha_id     = $get_alpha_data[$sp]['id'];
						$alpha_letter = $get_alpha_data[$sp]['alphabetic'];						
						$all_aplha    = explode(" ", $alpha_letter);
						$show_image = array();
						$txt_break = " ";



 					    	$img_cnt = count($all_aplha);
						 for ($si=0; $si < $img_cnt; $si++) {
						 	$sel_img   = "SELECT `image` FROM `tbl_alphabet` WHERE `alpha_name`='$all_aplha[$si]'";
						    	$all_img   = $db->select_data($sel_img); 							 
							$show_image[] = $all_img[0]['image'];	


						// Call up Tehta Data

							$yea = "N";
							$teh_sql = "SELECT `image` FROM `tbl_alphabet` WHERE `is_tehta`='$yea'";
							$result = mysql_query($teh_sql);
							$teh_array = array();
								while($row = mysql_fetch_array($result)){
						 			 $teh_array[] = $row['image'];
								}
							$tehtas = array_diff($show_image, $teh_array);
								 
					     }//for

						 $image_set[$alpha_id]=implode("," ,$show_image); 
													   
    				}//outer for 

					if ($image_set)					
					foreach ($image_set as $key => $value)
						{
						
						?>
						<div id="letterimg_<?php echo $key; ?>" class="word_div">
						  <?php
						     $ex_img = explode(",", $value);
							 $tot    = count($ex_img);
							 for ($si=0; $si < $tot; $si++) {
							 	if ($ex_img[$si]){ 

							// check if the letter is Tehta

								if(in_array($ex_img[$si], $teh_array))
									 {
										$tehta_t = "tehtas";
									}else {
										$tehta_t = "notehtas";
									}
								 	?>

									<?php echo $txt_break; ?>
								 	<img src="admin/upload/<?php echo $ex_img[$si]; ?>" class="<?php echo $tehta_t; ?>">&nbsp;
								 	<?php
								}//if image exist
							 }
						  ?>  
						</div>
						<?php
					}//foreach					
					?>
			</td>	
			<?php }//third container ?>	
			
			<!-- ++++++++++ FOURTH CONTAINER : GRAMMAR++++++++++++++++ -->
			<?php if (in_array("Grammar Column", $page_description)) { ?>
			<td class="entry_cell4" id="gram"></td>
			<?php }//fourth container ?>	
		</tr>		
	</table>
	</div>
	</div>				
	</div>	<!-- End of main_wrap div -->		
<?php 
function get_menu_data($menu_id)
{
	global $db;
	$get_menu       = "SELECT menu_title,abbrevation,note FROM `tbl_menu` WHERE `id` IN ($menu_id) AND note!=''";
							 $get_menu_info  = $db->select_data($get_menu);
							 $get_menu_count = count($get_menu_info);
							 for ($i=0; $i < $get_menu_count; $i++) 
							 { 
									$menu_title.=$get_menu_info[$i]['menu_title'];
									$abbrevation.=$get_menu_info[$i]['abbrevation'];
									$note.=$get_menu_info[$i]['note'];
									if ($i < $get_menu_count-1){
										$menu_title.="**@@##@@**";
										$abbrevation.="**@@##@@**";
										$note.="**@@##@@**";
									}
									   											
							 }
							 return array($menu_title,$abbrevation,$note);				
}
function get_dictionary_info($root_word)
{
	 global $db;
    $get_cols = "SHOW COLUMNS FROM tbl_dictionary";
    $cols_res = $db->select_data($get_cols);
	$tot_cols = count($cols_res);
	$root_column = $cols_res[1][0];//skip 1st id column
	
	$get_qry    	  = "SELECT * FROM `tbl_dictionary` WHERE $root_column='$root_word' AND $root_column!=''";
	$get_qryres 	  = $db->select_data($get_qry);
	$dictionary_vals  = array();
    for ($i=1; $i < $tot_cols; $i++) {         // store column's values from 2nd column to last  
		$dictionary_vals[]=$get_qryres[0][$cols_res[$i][0]]; 
	}	
    return $dictionary_vals;		
}
include("footer.php");
?>

<script type="text/javascript">

// Line Breaks

var divs = document.getElementsByClassName('word_div');
for (var xz = 0, len = divs.length; xz < len; ++xz) {
if (divs[xz].innerHTML.indexOf('[br]') > -1){
	divs[xz].style.width = "100%";
	divs[xz].style.height = "0px";
	divs[xz].style.marginTop = "10px";
	divs[xz].innerHTML = " &nbsp; ";

}
}

// Bold Text

var divb = document.getElementsByClassName('word_div');
for (var xb = 0, len = divb.length; xb < len; ++xb) {
if (divb[xb].innerHTML.indexOf('#') > -1){

	var rawt = " ";
	var boldword = " ";
	rawt = divb[xb].innerHTML;
	word = rawt.split('#');
	if(word.length > 2) {
		divb[xb].innerHTML = word[0] + '<b>' + word[1] + '</b>' + word[2];
	} else {
		divb[xb].innerHTML = word[0] + '<b>' + word[1] + '</b>';
	}

}
}

// Italic Text

var divi = document.getElementsByClassName('word_div');
for (var xi = 0, len = divi.length; xi < len; ++xi) {
if (divi[xi].innerHTML.indexOf('@') > -1){

	var rawti = " ";
	var boldwordi = " ";
	rawti = divi[xi].innerHTML;
	wordi = rawti.split('@');
	if(wordi.length > 2) {
		divi[xi].innerHTML = wordi[0] + '<em>' + wordi[1] + '</em>' + wordi[2];
	} else {
		divi[xi].innerHTML = wordi[0] + '<em>' + wordi[1] + '</em>';
	}

}
}

// Non-spaced Words

var divv = document.getElementsByClassName('word_div');
for (var xv = 0, len = divv.length; xv < len; ++xv) {
if (divv[xv].innerHTML.indexOf('$') > -1){

	var rawtv = " ";
	var boldwordv = " ";
	rawtv = divv[xv].innerHTML;
	wordv = rawtv.split('$');
	divv[xv].innerHTML = wordv[1];
	divv[xv].style.marginLeft = "-4px";

}
}

// Non-spaced Alphabets

var divva = document.getElementsByClassName('word_div');
for (var xva = 0, len = divva.length; xva < len; ++xva) {
if (divva[xva].innerHTML.indexOf('[s]') > -1){

	divva[xva].style.marginLeft = "-8px";

}
}

</script>











