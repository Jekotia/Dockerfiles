<?php
include("includes/applicationTop.php");
mysql_set_charset("UTF8");
include_once("admin/admin_templateclass/add_dictionary_manager.php");
$classObject		= 	new add_dictionary_class();
$managerObject 		=	new add_dictionary_manager();
$get_cols    = "SHOW COLUMNS FROM tbl_dictionary";
$get_colsres = $db->select_data($get_cols);
$tot_col = count($get_colsres);
if(isset($_POST['submit']))
{
	$classObject->setPostVar($_POST);
	$err	=	$managerObject->chkvalidation($classObject,$edit_id,"");
	
	if(count($err)==0)
	{
		$message	=	$managerObject->register($classObject,$edit_id,"");
		if($message!='')
		{
			echo $message;
		}
		?>
		 
		<?php 
	}
}
?>
 

<script>
function valid_sound()
	{
		var filesound_length= document.getElementById('sound');
		var file_type       = filesound_length.files[0].type;
	   
	    if(file_type!='audio/mp3'&& file_type!='video/mp4'&& file_type!='audio/mp4' && file_type!='audio/wav'&& file_type!='audio/flv'&& file_type!='audio/aiff'&& file_type!='audio/amr'&& file_type!='audio/wma'&& file_type!='audio/3gp')
  	   {
  	 	alert("Please Select MP3/MP4/WAVE/FLV/3GP/AIFF/AMR/WMA Sound File");
  		return false;
  	   }
		
	}
</script>
<form name="lang_setting" method="post" class="form-horizontal" enctype="multipart/form-data" onsubmit="return valid_sound();">
		                       
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
                            <input type="submit" name="submit" class="btn btn-info" value="Submit">
                        	</div>
       					</form>