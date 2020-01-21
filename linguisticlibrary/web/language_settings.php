<?php
include("header.php");
include_once("admin_templateclass/add_language_setting_manager.php");
$classObject		= 	new add_language_setting_class();
$managerObject 		=	new add_language_setting_manager();
 

 
 
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
 
function createTreeView($array, $currentParent, $currLevel = 0, $prevLevel = -1) {

foreach ($array as $categoryId => $category) {
$id = $category['id'];
if ($currentParent == $category['parent_id']) {                       
    if ($currLevel > $prevLevel) echo " <ol class='tree'>"; 

    if ($currLevel == $prevLevel) echo " </li> "; 	
    echo '<li> <label for="subfolder2">'.$category['menu_title'].'</label>';   
   
   ?>
   <a class="black_txt" href="add_submenu_p.php?id=<?php echo $id;?>&curent_id=<?php echo $currentParent;?>&current_menu=submenu" onClick="return hs.htmlExpand(this, { contentId: 'highslide-html', objectType:   'iframe',height: 'auto',width: '400' })" title="ADD NEW ITEM"><i class="icon-plus-sign"></i></a>
   <a href="language_settings.php?edit_id=<?php echo $edit_id; ?>&del_id=<?php echo $id; ?>" onclick="return confirm('Are you sure to Delete Menu?')" title="DELETE MENU ITEM">	     
	 <i class="icon-remove-sign"></i>
   </a>
   
   <a class="black_txt" href="add_submenu_p.php?id=<?php echo $id;?>&curent_id=<?php echo $currentParent;?>&current_menu=menu" onClick="return hs.htmlExpand(this, { contentId: 'highslide-html', objectType:   'iframe',height: 'auto',width: '400' })" title="ADD SUB MENU">ADD SUB MENU</a>
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

}
ol > li {
line-height: 20px;
background-color: #eee;
padding: 15px;
border: 1px solid white;
}
ol li:hover {
background-color:#dedede;
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
             	                  
					                 <!-------------------------------Form2------------------------> 
					                
					                <label class="control-label"><b>Abbriviations:</b></label>	
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
             	                   
					                <label class="control-label"><b>Dictionary Database:</b></label>
					                <div class="controls" style="margin-top:12px;">					               
						                   <table style="border : none;">
						                		<tr rowspan="2"></tr>
						                		<tr>
							                			<td>Import:</td>
								                	    <td>
								                	   	  <input   type="file" name="sel_csvfile1" id="sel_csvfile1" style="width: 213px;vertical-align: top;" />
								                	   	  <input class="btn btn-info" name="btn_submit" type="submit" value="Import" />
								                        	<div id="csvfileval"><?php echo $err[6]; ?></div>	
								                        </td>
								                        <table>
								                	   	  	<th>Sequence of Columns for CSV Upload:</th>
								                	   	  </table>
								                	   	  <table border="2">
								                	   	  <tr>
								                	   	  <td>
								                	   	  	Root
								                	   	  </td>
								                	   	  <td>
								                	   	  	Part of Speech
								                	   	  </td>
								                	   	  <td>
								                	   	  	Meaning
								                	   	  </td> 
								                	   	  <td>
								                	   	  	IPA
								                	   	  </td>
								                	   	  <td>
								                	   	  	Source
								                	   	  </td>
								                	   	  
								                	   	  	
								                	   	  </tr>	
								                	   	  	
								                	   	  </table>
								                	   	  <table>
								                	   	  	<th>Examples of CSV Upload:</th>
								                	   	  </table>
								                	   	  <table border="2">
								                	   	   
								                	   	  <tr>
								                	   	  <td>Sr. No.</td>
								                	   	  <td>
								                	   	  	Root
								                	   	  </td>
								                	   	  <td>
								                	   	  	Part of Speech
								                	   	  </td>
								                	   	  <td>
								                	   	  	Meaning
								                	   	  </td> 
								                	   	  <td>
								                	   	  	IPA
								                	   	  </td>
								                	   	  <td>
								                	   	  	Source
								                	   	  </td>	
								                	   	  </tr>	
								                	   	 <tr><td>1</td><td>torech</td><td>noun</td><td>secret hole, lair</td><td>tôrétƒ</td><td>PEC17:89</td></tr> 
								                	   	 <tr><td>2</td><td>torechww</td><td>verb</td><td></td><td></td><td></td></tr> 
								                	   	  
								                	   	  </table>
						                   		 </tr>
						                    	 <tr>
							                			<td>Export:</td>
								                	    <td>
								                	   	  <input type="button" class="text" name="image" id="image" type="file" value="download"/>
								                        </td>
						                    	</tr>
						                    </table>
					                </div>
					              
					                <!-------------------------Form4----------------------->					                
					                <label class="control-label"><b>Add New Root</b></label>
					                <div class="controls" style="margin-top:12px;">
					               
					                <table style="border : none;">
					                	<tr rowspan="2"></tr>
					                	<tr>
					                		<td>Root:</td>
					                	    <td>
					                	   	  <input type="text" name="root" class="input-x" value="<?php echo $root;?>"/>
					                	   	 <?php if($err[0]!=""){ ?>
                                        <span class="help-inline"><?php echo $err[0]; ?></span>
                                        <?php } ?>
					                        </td>
					                    </tr>
					                    
					                    <tr>
					                		<td>Part Of Speech:</td>
					                	    <td>
					                	   	  <input type="text" name="part_of_speech" class="input-x" value="<?php echo $part_of_speech;?>"/>
					                        <?php if($err[1]!=""){ ?>
	                                        <span class="help-inline"><?php echo $err[1]; ?></span>
	                                        <?php } ?>
					                        
					                        </td>
					                    </tr>
					                    <tr>
					                		<td>Meaning:</td>
					                	    <td>
					                	   	 <textarea name="meaning" class="span12 wysihtmleditor5" placeholder="Description" rows="6"><?php echo $meaning;?></textarea>                       
					                        <?php if($err[2]!=""){ ?>
	                                        <span class="help-inline"><?php echo $err[2]; ?></span>
	                                        <?php } ?>
					                        
					                        </td>
					                    </tr>
					                    <tr>
					                		<td>IPA:</td>
					                	    <td>
					                	   	  <input type="text" name="ipa" class="input-x" value="<?php echo $ipa;?>"/>
					                        <?php if($err[3]!=""){ ?>
	                                        <span class="help-inline"><?php echo $err[3]; ?></span>
	                                        <?php } ?>
					                        
					                        </td>
					                    </tr>
					                    <tr>
					                		<td>Source:</td>
					                	    <td>
					                	   	  <input type="text" name="source" class="input-x" value="<?php echo $source;?>"/>
						                        <?php if($err[4]!=""){ ?>
		                                        <span class="help-inline"><?php echo $err[4]; ?></span>
		                                        <?php } ?>
					                        
					                        </td>
					                    </tr>
					                     <tr>
				                		<td>Sound File:</td>
				                	    <td>
				                	   	  <input class="text" name="sound" id="sound" type="file" >
				                	   	  <?php if($sound != ""){echo $sound;}?>
				                        	<?php if($err[5]!=""){ ?>
                                        <span class="help-inline"><?php echo $err[5]; ?></span>
                                        <?php } ?>
				                        
				                        </td>
				                    </tr>                       
					                    </table>
					                </div>
					              <label class="control-label"><b>Add Morphology</b></label>
					                <div class="controls" style="margin-top:12px;">
					                	<table>  <!-- CODE OF CLONE -->					                		
					                		<tr>
					                			<td><input style="width: 20px;" type="hidden" name="my_in_id" id="my_in_id" ></td>
					                			<td><input style="width: 20px;" type="hidden" name="my_chek" id="my_chek" ></td>
					                			<td style="border: 1px solid black;"><a class="black_txt" href="add_menu_p.php?type=menu" onClick="return hs.htmlExpand(this, { contentId: 'highslide-html', objectType:   'iframe',height: 'auto',width: 'auto' })" title="View Description">Create New Menu</a></td>					                							                							                			
					                			<td id="clone_td"></td>
					                		</tr>
					                		<tr>
						                			<td colspan="5">
						                			<?php
															$qry = "SELECT * FROM tbl_menu";
															$result=mysql_query($qry);
															
															
															$arrayCategories = array();
															
															while($row = mysql_fetch_assoc($result)){ 
															$arrayCategories[$row['id']] = array("id" => $row['id'],"parent_id" => $row['parent_id'], "menu_title" =>$row['menu_title']);   
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
