<?php
include("header.php");
mysql_set_charset("UTF8");
header('Content-Type: text/html; charset=ISO-8859-1');

include_once("admin_templateclass/dictionary_setting_manager.php");
$classObject		= 	new dictionary_setting_class();
$managerObject 		=	new dictionary_setting_manager();
 
$del_id = $_GET['del_id'];
if ($del_id!="")
{ 
	$sql_delete	=	"DELETE FROM `tbl_menu` WHERE id='".$del_id."'";			
	$res_delete	=	$db->delete_data($sql_delete);
    if(count($res_delete)!=0)
	{
     $message = "Menu deleted successfully"; 
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
	 $btnsub = "Update";
	 $sel 	 = "SELECT * FROM `tbl_dictionary` WHERE id='$edit_id'";
	 $res	 = $db->select_data($sel);
 	
     //$menu_title		=	trim($res[0]['menu_title']);
	
   $root 		   = 	$res[0]['word'];
   $part_of_speech = 	$res[0]['part_of_speech'];
   $meaning        = 	stripslashes($res[0]['meaning']);
   
   $ipa1 		   = 	$res[0]['ipa'];
   $ipa            =  stripslashes(trim(str_replace('&nbsp;', '', $ipa1)));
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
 //  $job_desc   =   stripcslashes(trim(str_replace('&nbsp;', '', $res_career	[$i]['job_desc'])));
  // $ipa                 =   stripslashes(trim(str_replace('&nbsp;', '', $desc1)));
   $ipa1			= 	trim($_POST['ipa']);
   $ipa             =   stripslashes(trim(str_replace('&nbsp;', '', $ipa1)));
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

.ytext {
    border: 1px solid #638A00;
    border-radius: 3px;
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.4);
    font-size: 14px;
    color: #FFF;
    padding: 4px 17px;
    background: -moz-linear-gradient(center top , #96C300 0%, #648C00 100%) repeat scroll 0% 0% transparent;

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
<h3 class="page-title">Dictionary Settings</h3>
	<ul class="breadcrumb">
		<li>
        	<a href="index.php">Home</a>
            <span class="divider">/</span>
        </li>
                      
        <li class="active">
        	Dictionary Settings
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
                            <h4><i class="icon-reorder"></i> Dictionary Settings</h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            </span>
                        </div>
                        
                        
                        <div class="widget-body" >
                            <!-- BEGIN FORM-->
                            
                            <form name="lang_setting" method="post" class="form-horizontal" enctype="multipart/form-data">
			                     
					             

					                 <!-------------------------------Form2------------------------> 
					                
					              

             	                  
             	                  <!------------------------------form3--------------------------->
             	                   
					                <label class="control-label"><b>Dictionary Database:</b></label>
					                <div class="controls" style="margin-top:12px;">					               
						                   <table style="border : none;">
						                		<tr rowspan="2"></tr>
						                		
						                		
						                		<tr>
			
								                	    <td colspan="2">
								                	   	  <input   type="file" name="sel_csvfile1" id="sel_csvfile1" style="width: 213px;vertical-align: top;" />
								                	   	  <input class="btn btn-info" name="btn_submit" type="submit" value="Import" />
								                      
</td>
								                </tr>       
								                <tr><td colspan="2" id="csvfileval"><?php echo $err[0]; ?></td></tr> 
								                <tr>
								                	    <td colspan="2">


<p style="font-size: 20px; padding: 20px 20px 10px 0px; color: #444;">How to Create a Database File</p>
<p style="color: #444; font-size: 14px;">Format:</p>

<ul style="color: #444; list-style-type: decimal;">
<li>The dictionary listing must be a <b>.csv</b> file.</li>
<li>The first row of the file will define the column names for the rest of the entire document.</li>
<li>The first row of the file must have names without spaces, for example "Part_of_Speech" rather than "Part of Speech".</li>
<li>The first cell of the first row must be called "Root".</li>
</ul>

<p style="color: #444;">A csv (Comma Separated Values) file is a text file that differentiates table data using some symbol, usually a comma. In the case of this software, the <b>@</b> symbol is used to separate the data. Here is an example of a proper format for upload:
</p>

<p style="color: #444; padding-left: 70px; line-height: 180%; font-family: Courier New;">
Root@Part_of_Speech@Meaning<br>
lily@noun@A type of plant<br>
pear@noun@A type of fruit<br>
help@verb@To assist another<br>
</p>

<p style="color: #444;">
As you can see, the first row contains the names of the columns, instead of an actual dictionary entry. 
The first cell is named "Root" and @ symbols are used to separate cells from one another. The rows can
be named anything you'd like (so long as the first cell is named Root, and no spaces are present) and you
can make as many columns as your dictionary needs. To convert an existing dictionary spread sheet into
this CSV format using Microsoft Excel, <a href="/documentation.php#dictionary" target="_blank">please watch the video here</a>.<br><br>

You can also make your own CSV file easily using Notepad. Create a spreadsheet in this format in Notepad with your desired information then hit "Save As" in the file menu. For file type select "All Files" and enter a dictionary name ending with the extension <b>.csv</b> (for example <b>dictionary.csv</b>).  Then upload that file onto this page. You will see your dictionary uploaded in the <a href="dictionary_list.php">Dictionary Listings</a> page.
</p>


<br><br>
								                	   	 <a href="backup_structure.php"> <input type="button" class="ytext" name="image" id="image"  value="Download SQL"/></a>
								                	   	 <a href="export2csv.php"> <input type="button" class="ytext" name="image" id="image"  value="Download CSV"/></a>
								                      
								                        </td>
						                    	</tr>
						                    </table>
					                </div>
					              
					                <!-------------------------Form4----------------------->					                
					         		       
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
