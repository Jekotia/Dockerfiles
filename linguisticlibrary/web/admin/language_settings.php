<?php
include("header.php");
include_once("admin_templateclass/add_language_setting_manager.php");
$classObject		= 	new add_language_setting_class();
$managerObject 		=	new add_language_setting_manager();
 
$del_id = $_GET['del_id'];
if ($del_id!="")
{
	/////////////////////////////////////CODE BY ANMOL //////////////////////////////
	$query      =   "SELECT *FROM `add_new_entry` WHERE menu_id!=''";
	$result     =   $db->select_data($query);
	$expected_ids = array(); 
	 
	for($i=0;$i<count($result);$i++)
	{
	  	$menu_id = $result[$i]['menu_id'];
		$id      = $result[$i]['id'];
		$menu_id1= explode(",",$menu_id);//87,88
		 
		//select all childs of this id 87 => 88,89
		 
		for($j=0;$j<count($menu_id1);$j++)//,87,88
		{
			if($del_id!=$menu_id1[$j] && $menu_id1[$j]!="")//,20,21
			{
			     $expected_ids[]=$menu_id1[$j];
			}
			  				
		}
	    $queryt ="select *from `tbl_menu` where parent_id='$del_id'";
		$result1 = $db->select_data($queryt);
		 
		for($c=0;$c<count($result1);$c++)
		{
		      
		  $rid=$result1[$c]['id'];
		  for($k=0;$k<count($expected_ids);$k++)
		  {
		    if($rid==$expected_ids[$k])
		    {    
		 	  $expected_ids[$k]=""; //clearing id of add_new_entry in menu_id column
		    }
		  }
		}
		 
	    $filter_ids        = array_filter($expected_ids);
		unset($expected_ids);
	    $save_expected_ids = implode(",",$filter_ids); //save all ids from filter_ids
		 
	    $query1  = "UPDATE `add_new_entry` SET `menu_id`='$save_expected_ids' WHERE `id`='$id'";
	 	$result1 = $db->update_data($query1);
		
	}	 
    $sql_delete	=	"DELETE FROM `tbl_menu` WHERE id='$del_id' OR parent_id='$del_id'";	
    $res_delete =   $db->delete_data($sql_delete);	 
    if(count($res_delete)!=0)
    {
     $message = "Menu deleted successfully";
	?>
	    <script type="text/javascript"> 
			setTimeout(function () {
			window.location.href= "language_settings.php" // the redirect goes here
			},4000); // 3 seconds
		</script>
<?php 
	}	
}  
if(isset($_POST['submit']))
{
	$classObject->setPostVar($_POST);
	$err	=	$managerObject->chkvalidation($classObject);
	
	if(count($err)==0)
	{
		$message	=	$managerObject->register($classObject);
		?>
		<script type="text/javascript"> 
			setTimeout(function () {
			window.location.href= "language_settings.php" // the redirect goes here
			},2000); // 3 seconds
		</script>
		<?php 
	}
}
if(isset($_POST['btn_submit']))
{
	$err	=	$managerObject->csv_valid();
	if($err==0)
	{
		$message="CSV Uploaded Successfully";
	}
}
	
if($edit_id!="")
{
	 $btnsub="Update";
	 $sel 	=	"SELECT * FROM `tbl_dictionary` WHERE id='$edit_id'";
	 $res	=	$db->select_data($sel);
 	
     //$menu_title		=	trim($res[0]['menu_title']);
	
   $root 		   = 	$res[0]['word'];
   $part_of_speech = 	$res[0]['part_of_speech'];
   $meaning        = 	stripslashes($res[0]['meaning']);
   $ipa 		   = 	$res[0]['ipa'];
   $source 		   = 	$res[0]['source'];
   $sound		   =	$res[0]['sound'];
 
 	  $pages_Query = "SELECT * FROM `visibility`";
	  $get_Pages   = $db->select_data($pages_Query);
	  $tot_Pages   = count($get_Pages);
	  //$word_space  = $get_Pages[0]['word_space'];
     
     $sql_words    = "SELECT * FROM `words_spacing` WHERE id=1";
	 $res_words    = $db->select_data($sql_words);
	 $total        = count($res_words);
	 $word_spacing = $res[0]['word_spacing'];
   
	 $select_query = "SELECT * FROM `abbriviations_settings`";
	 $get_pg       = $db->select_data($select_query);
	 $total_pg     = count($get_pg);
}
 
   $btnsub 			= 	"Update";
   $root 			= 	trim($_POST['root']);
   $part_of_speech 	= 	trim($_POST['part_of_speech']);
   $meaning 		= 	stripslashes(trim($_POST['meaning']));
   $ipa 			= 	trim($_POST['ipa']);
   $source 			= 	trim($_POST['source']);
   $sound			=	$_FILES['sound']['name'];
   
    $pages_Query = "SELECT * FROM `visibility`";
	$get_Pages   = $db->select_data($pages_Query);
	 $tot_Pages   = count($get_Pages);
	
	$select_query = "SELECT * FROM `abbriviations_settings`";
	$get_pg       = $db->select_data($select_query);
	$total_pg     = count($get_pg);
	
	 $sql_words    = "SELECT * FROM `words_spacing`";
	 $res_words    = $db->select_data($sql_words);
	 $total        = count($res_words);
 
function createTreeView($array, $currentParent, $currLevel = 0, $prevLevel = -1) {

foreach ($array as $categoryId => $category) {
$id = $category['id'];
if ($currentParent == $category['parent_id']) {                       
    if ($currLevel > $prevLevel) echo " <ol class='tree'>"; 

    if ($currLevel == $prevLevel) echo " </li> "; 	
    // echo '<li> <label for="subfolder2">'.ucwords($category['menu_title']).'</label>';
	 echo '<li><label for="subfolder2">'.$category['menu_title'].'</label> <label for="subfolder2">'.ucwords($category['abbrevation']).'</label><label for="subfolder2">'.$category['note'].'</label>';   
   
   ?>
   <a class="black_txt" href="add_submenu_p.php?edit_id=<?php echo $id;?>&curent_id=<?php echo $currentParent;?>&current_menu=submenu" onClick="return hs.htmlExpand(this, { contentId: 'highslide-html', objectType:   'iframe',height: 'auto',width: '400' })" title="Edit Item"><i class="icon-pencil"></i></a>
   <a href="language_settings.php?del_id=<?php echo $id; ?>" onclick="return confirm('Are you sure to Delete Menu?')" title="Delete Menu Item">	     
	 <i class="icon-remove-sign"></i>
   </a>
   
   <a class="black_txt" href="add_submenu_p.php?id=<?php echo $id;?>&curent_id=<?php echo $currentParent;?>&current_menu=menu" onClick="return hs.htmlExpand(this, { contentId: 'highslide-html', objectType:   'iframe',height: 'auto',width: '400' })" title="Add New Item">Add New Item</a>
   <?php
	//}
       // echo '<input type="checkbox" name="subfolder2"/>';

    if ($currLevel > $prevLevel) { $prevLevel = $currLevel; }

    $currLevel++; 

    createTreeView ($array, $categoryId, $currLevel, $prevLevel);

    $currLevel--;               
    }   

}

if ($currLevel == $prevLevel) echo " </li> </ol> ";

}
?>	

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>  <!-- Js for Clone -->
<style>
ol {
list-style-type:none;
color: white;
margin: 0px 0px 0px -3px;
}
ol > li {
line-height: 20px;
background-color: #444;
padding: 15px;
border-left: 4px solid #56b044;
border-top: 1px solid #aaa;
border-bottom: 1px solid #aaa;
border-right: 1px solid #aaa;
}
ol li:hover {
background-color:#333;
}
.lang_new_menu {
padding: 20px;
background: #7d7e7d; /* Old browsers */
background: -moz-linear-gradient(top,  #7d7e7d 0%, #0e0e0e 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#7d7e7d), color-stop(100%,#0e0e0e)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #7d7e7d 0%,#0e0e0e 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #7d7e7d 0%,#0e0e0e 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #7d7e7d 0%,#0e0e0e 100%); /* IE10+ */
background: linear-gradient(to bottom,  #7d7e7d 0%,#0e0e0e 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#7d7e7d', endColorstr='#0e0e0e',GradientType=0 ); /* IE6-9 */
border-left: 4px solid #56b044;
border-right: 1px solid #aaa;
}
.lang_new_menu a:link {
color: #fff;
}
.lang_new_menu a:visited {
color: #fff;
}
.lang_new_menu a:hover {
color: #fff;
}
.xtext{
	border : solid 1px #638a00;
	border-radius : 3px;
	moz-border-radius : 3px;
	-webkit-box-shadow : 0px 2px 2px rgba(0,0,0,0.4);
	-moz-box-shadow : 0px 2px 2px rgba(0,0,0,0.4);
	box-shadow : 0px 2px 2px rgba(0,0,0,0.4);
	font-size : 14px;
	color : #ffffff;
	padding : 4px 17px;
	background : #96c300;
	background : -webkit-gradient(linear, left top, left bottom, color-stop(0%,#96c300), color-stop(100%,#648c00));
	background : -moz-linear-gradient(top, #96c300 0%, #648c00 100%);
	background : -webkit-linear-gradient(top, #96c300 0%, #648c00 100%);
	background : -o-linear-gradient(top, #96c300 0%, #648c00 100%);
	background : -ms-linear-gradient(top, #96c300 0%, #648c00 100%);
	background : linear-gradient(top, #96c300 0%, #648c00 100%);
	filter : progid:DXImageTransform.Microsoft.gradient( startColorstr='#96c300', endColorstr='#648c00',GradientType=0 );

}
.morph_1 label{
	font-weight: bold;
	color: #3deb1b;
}
.morph {

}
/*===============*/

	.widget-body
	{
		overflow-x: scroll;
		width: 95%;
	}
	.input-xlarge 
	{
		width: 80px;
	}
	
	.form-horizontal .control-group, .control-group 
	{
		margin: 0;
	}
    .monthsty
    {
    	font-size: 12px;
		font-weight: bold;
		text-align: center;
		width: 40px;
	}
    .main_table
    {
    	width: 1700px!important;
    }
    .first_td
    {
    	width :8%;
    }
    .highslider_container
    {
    	margin-left:20px!important;
    }
    #csvfileval
	{
		color: #FF4425;
		
	}
	.help-inline
	{
	color: red;	
	}
</style>

<style type="text/css">
@-moz-document url-prefix() {
  .widget-body
	{
		overflow-x: scroll;
		width: 95%;
	}
   .input-xlarge 
	{
		width: 62px;
	}
	
	.form-horizontal .control-group, .control-group 
	{
		margin: 0;
	}
	 .main_table
    {
    	width: 1700px!important;
    }
     .monthsty
    {
    	 padding: 0 21px 0 18px;
	}
    .first_td
    {
    	padding-right: 114px;
    }
}
</style>
<script type="text/javascript">
	function validateFile()
	{
		
		var csvfile = document.lang_setting.sel_csvfile1.value;
		
		if(csvfile.trim()!="")
		{
          if (csvfile.length!=0)
          {
	          var ext = csvfile.split('.');
	          if(ext[1] == "csv")
	          {
	                document.getElementById('csvfileval').innerHTML='';
	          }        
	      	  else
	      	  {			     
	                document.getElementById('csvfileval').innerHTML='Upload CSV File Only';
	                return false;
	          }          	
          }
	    }   
	}
</script>
<script type="text/javascript" src="js/highslide/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="js/highslide/highslide.css" />
<script type="text/javascript">
    hs.graphicsDir = 'js/highslide/graphics/';
    hs.outlineType = 'rounded-white';
	hs.lang.creditsText = '';
	hs.lang.creditsTitle= '';
</script>
<h3 class="page-title">Language Settings</h3>
	<ul class="breadcrumb">
		<li>
        	<a href="index.php">Home</a>
            <span class="divider">/</span>
        </li>
                      
        <li class="active">
        	Language Settings
        </li>
    </ul>
                   <!-- END PAGE TITLE & BREADCRUMB-->
               </div>
            </div>
  <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
                <div class="span12">
                	<?php if($message) 
                	{ ?>
                    	<div class="alert alert-success">
                           <button class="close" data-dismiss="alert">×</button>
                           <strong><?php echo $message; ?></strong>
                        </div>
                    	<?php 
					} ?>
                    <!-- BEGIN SAMPLE FORMPORTLET-->
                    <div class="widget gray">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i> Language Settings</h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            </span>
                        </div>
                        
                        
                        <div class="widget-body" >
                            <!-- BEGIN FORM-->
                            
                            <form name="lang_setting" method="post" class="form-horizontal" enctype="multipart/form-data">
			                     
					               <label class="control-label"><b>Visible:</b></label>	
					                <div class="controls" >
								  <!-- <table border="0" class="main_table"> -->
								     <table style="border : none;">
                                	 <tr></tr>
                                	 <tr>
                                	 <th colspan="2"></th>
                                	 <th colspan="2">Display?</th>
                                	 <th colspan="2">Name</th>
                                	 </tr>
                                	 <?php
                                	  for ($pg=0; $pg < $tot_Pages; $pg++) 
                                	  {
                                	  	 $val=$get_Pages[$pg]['page_name']; 
                                	  	 
										
										 
										  ?>
									<tr>
									<td style="border-right:none;">
             	                    	<?php echo $get_Pages[$pg]['page_desc']; ?>
             	                       </td>
                                		
             	                    
             	                       <td colspan="2"></td>
             	                    	<td style="border-right : none;">
             	                    		<input type="radio" name="display<?php echo $pg; ?>" value="Y" <?php if ($get_Pages[$pg]['is_page_display']=='Y'){ echo 'checked'; } ?> />
             	                    	Yes
             	                    	</td>
             	                    	<td style="border-right : none;">
             	                    		<input type="radio" name="display<?php echo $pg; ?>" id="no" value="N" <?php if ($get_Pages[$pg]['is_page_display']=='N'){ echo 'checked'; } ?> />
             	                    	No
             	                    	</td>
             	                    	<td style="border-right:none;">
             	                    	<input type="text" name="name1[]" class="input-x" value="<?php echo $val; ?>"/></td>
             	                     </tr>
                                	 
             	                     <?php } ?>
             	                    </table>
             	                   </div>
             	                  <!--------------------------Word Spacing------------------------------->
             	                   <label class="control-label"><b>Words Spacing:</b></label>	
					                <div class="controls" style="margin-top:12px;">
						                <table style="border : none;">
						                <tr rowspan="2"></tr>
	                                	 <tr></tr>
	                                	 <?php
	                                	 
	                                	  	 $word_spacing =$res_words[0]['word_spacing']; 
	                                	   ?>
	                                	 <tr>
	                                	    <td colspan="2"></td>
	             	                    	<td style="border-right : none;">
	             	                    		<input type="radio" name="word_space" value="Y" <?php if ($word_spacing=='Y'){ echo 'checked'; } ?> />
	             	                    	Yes
	             	                    	</td>
	             	                    	<td style="border-right : none;">
	             	                    		<input type="radio" name="word_space" value="N" <?php if ($word_spacing=='N'){ echo 'checked'; } ?> />
	             	                    	No
	             	                    	</td>
	             	                    	
	             	                     </tr>
	             	                    
	             	                    </table> 
             	                   </div>
					                 <!-------------------------------Form2------------------------> 
					                
					                <label class="control-label"><b>Abbreviations:</b></label>	
					                <div class="controls" style="margin-top:12px;">
						                <table style="border : none;">
						                <tr rowspan="2"></tr>
	                                	 <tr></tr>
	                                	  <?php 
	                                	  for($pages=0; $pages < $total_pg; $pages++)
										  {
										  	 $abbrivation_pages = $get_pg[$pages]['page_desc']; 
											 $disp_page         = $get_pg[$pages]['page_display'];
											
	                                	  ?>
	                                	 <tr>
	                                		<td style="border-right:none;">
	             	                    	<?php echo  $abbrivation_pages; ?>
	             	                       </td>
	             	                        <td colspan="2"></td>
	             	                    	<td style="border-right : none;">
	             	                    		<input type="radio" name="display1<?php echo $pages; ?>" value="Y" <?php if ($disp_page=='Y'){ echo 'checked'; } ?> />
	             	                    	Yes
	             	                    	</td>
	             	                    	<td style="border-right : none;">
	             	                    		<input type="radio" name="display1<?php echo $pages; ?>" id="no" value="N" <?php if ($disp_page=='N'){ echo 'checked'; } ?> />
	             	                    	No
	             	                    	</td>
	             	                    	
	             	                     </tr>
	             	                    <?php 
	             	                    }
	             	                    ?>
	             	                     </table> 
             	                   </div>
             	                  
             	                  <!------------------------------form3--------------------------->
             	                   
					                <label class="control-label"><b> </b></label>
					                <div class="controls" style="margin-top:12px;">					               
						                   <table style="border : none;">
						                		<tr rowspan="2"></tr> 
						                    	 <tr>
							                			<td>Export:</td>
								                	    <td> 
								                          <a href="backup_morphology.php"> <input type="button" class="xtext"   value="Export Morphology Tree"/></a> 
								                        </td>
						                    	</tr>
						                    </table>
					                </div>
					              
					                  
					                <!-------------------------Form4----------------------->					                
					         		              <label class="control-label"><b>Add Morphology</b></label>
					                <div class="controls" style="margin-top:12px;">
					                	<table>  <!-- CODE OF CLONE -->					                		
					                		<tr>
					                			
					                			<td class="lang_new_menu" colspan="4"><a class="black_txt" href="add_menu_p.php?type=menu" onClick="return hs.htmlExpand(this, { contentId: 'highslide-html', objectType:   'iframe',height: 'auto',width: 'auto' })" title="View Description">Create New Menu</a></td>					                							                							                			
					                		</tr>
					                		<tr>
						                			<td colspan="5">
						                			<?php
														    $qry = "SELECT * FROM tbl_menu";
															$result=mysql_query($qry);
															
															
															$arrayCategories = array();
															
															while($row = mysql_fetch_assoc($result)){ 
															$arrayCategories[$row['id']] = array("id" => $row['id'],"parent_id" => $row['parent_id'], "menu_title" =>$row['menu_title'], "abbrevation" =>$row['abbrevation'], "note" =>$row['note']);   
															 //print_r($arrayCategories);
															}
															//print_r($arrayCategories);
															?>
															<div id="content" class="general-style1">
															<?php
															if(mysql_num_rows($result)!=0)
															{
															?>
															<?php 
															
															createTreeView($arrayCategories, 0); ?>
															<?php
															}
															?>
						                			
						                		</td>
					                			
					                		</tr>				                					                		
					                	</table>
					                </div>	
					            <div class="form-actions">
                                <input type="submit" name="submit" class="btn btn-info" value="<?php echo $btnsub?>">
                            	</div>
           					</form>
                            <!-- END FORM-->
                        </div>
                        
                          <!-- <div style="border:0!important;" >
                    		<img style="border:0!important;"  src="forex_bar.php">
                               </div> -->
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                </div>
            </div>
          </div>
        </div>
       </div>
       
<?php
				include ("footer.php");
 ?>
