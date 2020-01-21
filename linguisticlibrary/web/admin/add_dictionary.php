<?php
include("header.php");
mysql_set_charset("UTF8");
include_once("admin_templateclass/add_dictionary_manager.php");
$classObject		= 	new add_dictionary_class();
$managerObject 		=	new add_dictionary_manager();
$edit_id			=	$_GET['edit_id'];
$count			=	$_GET['id'];

$get_cols    = "SHOW COLUMNS FROM tbl_dictionary";
$get_colsres = $db->select_data($get_cols);
$tot_col = count($get_colsres);

if(isset($_POST['submit']))
{
	$classObject->setPostVar($_POST);
	$err	=	$managerObject->chkvalidation($classObject,$edit_id,$count);
	
	if(count($err)==0)
	{
		$message	=	$managerObject->register($classObject,$edit_id,$count);
		?>
		<script type="text/javascript"> 
			setTimeout(function () {
			window.location.href= "dictionary_list.php" // the redirect goes here
			},2000); // 3 seconds
		</script>
		<?php 
	}
}
if($edit_id!="")
{
	 $btnsub    	=  "Update";
	 $sel 	    	=	"SELECT * FROM `tbl_dictionary` WHERE id='$edit_id'";
	 $dic_res   	= mysql_query($sel);
	 $col_names     = array();
	 $i=0;
	 while ($i<mysql_num_fields($dic_res))   
     {  
					          //echo 'Information for column'. $i.':<br>';  
					          $meta = mysql_fetch_field($dic_res,$i);  
					          $col_name[$i]=$meta->name;
					          $i++; 
     } 
	 $tot = count($col_name);
	 for ($sv=1; $sv < $tot; $sv++) { 
		 $$col_name[$sv]=mysql_result($dic_res,0,$col_name[$sv]);
	 }
	 //echo "<br>Variable of variable=".$Root;
	 //echo "<br>Variable of variable=".$Meaning;
	 
	 $cnt=0;
 	
     //$menu_title		=	trim($res[0]['menu_title']);
	
	$root 		= 	$res[0]['word'];
    $part_of_speech = $res[0]['part_of_speech'];
    $meaning 	= 	stripslashes($res[0]['meaning']);
    $ipa 		= 	$res[0]['ipa'];
    $source 	= 	$res[0]['source'];
 	$sound		=	$res[0]['sound'];

}
else
{
   $btnsub 		= 	"Submit";
   $root 		= 	trim($_POST['word']);
   $part_of_speech = trim($_POST['part_of_speech']);
   $meaning 	= 	stripslashes(trim($_POST['meaning']));
   $ipa 		= 	trim($_POST['ipa']);
   $source 		= 	trim($_POST['source']);
   $sound		=	$_FILES['sound']['name'];
 
}

?>	

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>  <!-- Js for Clone -->
<style>
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
	/*.wysihtml5-sandbox
    {
    	width :476!important;
    }*/
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
		if (csvfile.trim()=="")
		{
			document.getElementById('csvfileval').innerHTML='Please Select The CSV File';
			return false;
		}		   
		else
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
	
	function valid_sound()
	{
		var filesound_length= document.getElementById('sound');
		var file_type       = filesound_length.files[0].type;
	   
	    if(file_type!='audio/mp3'&& file_type!='video/mp4'&& file_type!='audio/mp4' && file_type!='audio/wav'&& file_type!='audio/flv'&& file_type!='audio/aiff'&& file_type!='audio/amr'&& file_type!='audio/wma'&& file_type!='audio/3gp')
  	   {
  	 	alert("Please Select MP3/MP4/WAVE/FLV/3GP/AIFF/AMR/WMA Sound File");
  	//	return false;
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
<h3 class="page-title">Add Root</h3>
	<ul class="breadcrumb">
		<li>
        	<a href="index.php">Home</a>
            <span class="divider">/</span>
        </li>
                      
        <li class="active">
        	Add Root
        </li>
    </ul>
  
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
                        <h4><i class="icon-reorder"></i> Add Root</h4>
                        <span class="tools">
                        <a href="javascript:;" class="icon-chevron-down"></a>
                        </span>
                    </div>
                    
                    
                    <div class="widget-body" >
                        <!-- BEGIN FORM-->
                        
                        <form name="lang_setting" method="post" class="form-horizontal" enctype="multipart/form-data" onsubmit="return valid_sound();">
		                       <div class="control-group">
		                         <a class="btn btn-info" href="dictionary_list.php" style="float: right;">
		                         Back To List <i class="icon-circle-arrow-right"></i>
		                         </a>
		                      </div>
				               <!-------------------------Form4----------------------->					                
				                <label class="control-label"><b>Add New Root</b></label>
			                <div class="controls" style="margin-top:12px;">
				               
				                <table style="border : none;">
				                	<tr rowspan="2"></tr>
		                	<?php
		                	for ($cr=1; $cr < $tot_col; $cr++) { 
								
		                	?>				                	 
				                	<tr>
				                		<td><?php echo $get_colsres[$cr][0]; ?></td>
				                	    <td>
				                	    <?php
				                	    if ($get_colsres[$cr][0]=="Meaning"){
				                	    	?>
                 <textarea name="<?php echo $get_colsres[$cr][0]; ?>" class="span12 wysihtmleditor5" rows="6"><?php echo $$col_name[$cr];?></textarea>				                	    	
				                	    	<?php
				                	    }
										else {
?>
				               <input type="text" name="<?php echo $get_colsres[$cr][0]; ?>" class="input-x" value="<?php echo $$col_name[$cr];?>"/>
<?php											
										}
				                	   	if($err[$cr-1]!=""){ ?>
                                    <span class="help-inline"><?php echo $err[$cr-1]; ?></span>
                                    <?php } ?>
				                        </td>
				                    </tr>
<?php
							}//for	
?>				                    
				                </table>
			                </div>
				            
				            <div class="form-actions">
                            <input type="submit" name="submit" class="btn btn-info" value="<?php echo $btnsub; ?>">
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
