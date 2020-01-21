<?php
include("header.php"); 
include_once("admin_templateclass/dictionary_list_manager.php");
$classObject		= 	new dictionary_list_class();
$managerObject 		=	new dictionary_list_manager();
if(isset($_POST['btn_delete']))
	{
		$classObject->setpostvar($_POST['chk_act']);
		$msg = $managerObject->delete_selected($classObject);
	}
mysql_set_charset("UTF8");

// $userObject	 = 	new user_list_class();
// $userManager =	new user_list_manager();

$res_user	 =	$db->select_data("SELECT * FROM `tbl_dictionary` ORDER BY id DESC");
$del_id		 =	$_GET['del_id'];
$active     =	$_GET['active'];
$deactive 	=	$_GET['deactive'];
 
if($del_id!="")
{
	$query	="DELETE FROM `tbl_dictionary` where id='$del_id';";	 
	$query1	=$db->delete_data($query);
	$msg	="Records Deleted Successfully";
 }

if($active!='')
{
	$sql_active="update `tbl_dictionary` set is_active='Y' where id='$active'";
	$sql_res=$db->update_data($sql_active);
	if(count($sql_res)>0)
	{
		$msg="User Activated Successfully";
	} 
}

if($deactive!='')
{
	$sql_deactive="update `tbl_dictionary` set is_active='N' where id='$deactive'";
	$sql_res1=$db->update_data($sql_deactive);
	if(count($sql_res1>0))
	{
		$msg="User Deactivate Successfully";
	}
}

?>
<script>
function checkAll(frm_member,act_del,obj_ad)
	{
		var val; 
	    val=obj_ad;
		chkarr = frm_member.elements["chk_act[]"];
		var i=0;
		for( i=0 ; i<chkarr.length ; i++)
		{
			chkarr[i].checked=val;
		} 		
	}
	function delete_confirm(frm_member)
	{
		chkarr=frm_member.form.elements['chk_act[]'];
		 var i=0;
		 var temp=0;
	        for( i=0 ; i<chkarr.length ; i++)
	        {
	        	if (chkarr[i].checked==true)
				{
				temp=1;
				break;
				}
	        } 
			if(temp==0)
			{
				alert("Please Select at least one Record. ");
				return false;
			}
			var act_yes= confirm("Do you want to delete Record?");
			if (act_yes==true)
			{	
				return true;
			}
			else
			{
				$('input:checkbox').attr('checked', false);
				return false;
			}
	}	
	function activate_confirm(frm_member)
	{
		chkarr=frm_member.form.elements['chk_act[]'];
		 var i=0;
		 var temp=0;
	        for( i=0 ; i<chkarr.length ; i++)
	        {
	        	if (chkarr[i].checked==true)
				{
				temp=1;
				break;
				}
	        } 
			if(temp==0)
			{
				alert("Please Select at least one Record. ");
				return false;
			}
			var act_yes= confirm("Do you want to Activate Record?");
			if (act_yes==true)
			{
				return true;
			}
			else
			{
				$('input:checkbox').attr('checked', false);
				return false;
			}
	}
	function deactivate_confirm(frm_member)
	{
		chkarr=frm_member.form.elements['chk_act[]'];
		 var i=0;
		 var temp=0;
	        for( i=0 ; i<chkarr.length ; i++)
	        {
	        	if (chkarr[i].checked==true)
				{
				temp=1;
				break;
				}
	        } 
			if(temp==0)
			{
				alert("Please Select at least one Record. ");
				return false;
			}
			var act_yes= confirm("Do you want to Deactivate Record?");
			if (act_yes==true)
			{
				return true;
			}
			else
			{
				$('input:checkbox').attr('checked', false);	
				return false;
			}
	}
	function delete_single_confirm()
	{
   		var del_yes= confirm("Do you want to Delete Record?");
   		if (del_yes==true)
   		{	
	  		return true;
   		}
   		else
   		{
	  		return false;
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
 <h3 class="page-title">Dictionary Listing </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="index.php">Home</a>
                           <span class="divider">/</span>
                       </li>
                      
                       <li class="active" title="Dictionary Listing">
                          
                          Dictionary Listing
                       </li>
                   </ul>
                   <!-- END PAGE TITLE & BREADCRUMB-->
               </div>
            </div>
          <!-- BEGIN ADVANCED TABLE widget-->
               	  <?php	
							
							$sql_column="SELECT * FROM `tbl_dictionary`";
							$i=0;	
							$ress=mysql_query($sql_column);
						 	$abcd= mysql_num_fields($ress); 
							
							$col_name=array();
						 
							$vari=array();
							?>
				<div style="float: left;"> 
        	         <a href="add_dictionary.php?id=<?php echo $abcd; ?>" title="Add Root"><button class="btn btn-info"><i class="icon-plus"></i> Add Root</button></a>
                </div>  
        
         <form name="frm_member" method="post">
            <div class="row-fluid">
                <div class="span12">
                <!-- BEGIN EXAMPLE TABLE widget-->
               <?php if($msg !="") 
						{ ?>
							<div class="alert alert-success">
						       <button class="close" data-dismiss="alert">×</button>
						       <strong><?php echo $msg; ?></strong>
						    </div>
							<?php 
						 ?>
						 <script type="text/javascript"> 
								setTimeout(function () {
								window.location.href= "dictionary_list.php" // the redirect goes here
								},2000); // 2 seconds
							</script>
						<?php } ?>	
						      
                <div style="float: right;margin-bottom: 20px;">
                <!-- <button class="btn btn-small btn-success" name="btn_activate" onclick='javascript: return activate_confirm(this);'><i class="icon-ok icon-white"></i> Activate</button>
                <button class="btn btn-small btn-info" name="btn_deactivate" onclick='javascript: return deactivate_confirm(this);'><i class="icon-ban-circle icon-white"></i> Deactivate</button> -->
                <button class="btn btn-small btn-danger" name="btn_delete" onclick='javascript: return delete_confirm(this);'><i class="icon-remove icon-white"></i> Delete</button>
                </div>
                
                <div class="widget gray">
                	
                    <div class="widget-title">
                    	 
                        <h4><i class="icon-reorder"></i>Dictionary Listing</h4>
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                            </span>
                    </div>
                   
                    <div class="widget-body">
                        <table class="table table-striped table-bordered" id="sample_1">
                            <thead>
                            <tr>
                                <th style="width:8px;"><input type="checkbox" name="chk_act[]" onClick="checkAll(this.form,this,this.checked)"/></th>
                        
							<?php
					        while ($i<mysql_num_fields($ress))   
					        {  
					          //echo 'Information for column'. $i.':<br>';  
					          $meta = mysql_fetch_field($ress,$i);  
					          echo '<th class="align_center_t">'.$meta->name.'</th>';    
					          $col_name[$i]=$meta->name;
					          $i++; 
					        } 
					        ?>
                                 <th class="align_center_t" style="width: 79px;">Action<?php echo str_replace('&nbsp', 25); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                           $tot_rec=count($res_user);
                            
							$tot_col=count($col_name);
                        //print_r($tot_col);
						     if($res_user) 
                             { 
                            		for($i=0;$i<$tot_rec;$i++)
									{
										for($k=0;$k<$tot_col;$k++)
										{
											$vari[$i][$k]=trim(stripslashes($res_user[$i][$col_name[$k]]));
										}
									}
							 }
							
							for($i=0;$i<$tot_rec;$i++)
							{
							?>
                            <tr class="odd gradeX">
                                <td><input type="checkbox" class="checkboxes" name="chk_act[]" value="<?php print_r($vari[$i][0]); ?>"/></td>
                                <td class="align_center_t"><?php echo $i+1; ?></td>
                                <?php  
                              // printf('')
                              for($k=1;$k<$tot_col;$k++)
								{	
                               echo '<td class="align_center_t">';
                                 // echo  $vari[$i][$k]; 
								  
								  $len=strlen($vari[$i][$k]);
											if($len>10)
											{
												$disp=substr($vari[$i][$k], 0,10);
												echo $disp.'....';?><br>
												<a style="float: right;" class="black_txt" href="view_more.php?id=<?php echo $vari[$i][$k];?>" onClick="return hs.htmlExpand(this, { contentId: 'highslide-html', objectType:   'iframe',height: 'auto',width: '470',height:'300' })" title="View Description">View Details</a>
                                     <?php  }
											else
											{
												echo $vari[$i][$k];
											}
                             
                               echo '</td>';
								}
                               ?>
                               <!-- <?php $len=strlen($vari[$i][$k]);
											if($len>30)
											{
												$disp=substr($vari[$i][$k], 0,30);
												echo $disp.'....';?><br>
												<a style="float: right;" class="black_txt" href="view_cms.php?id=<?php echo $id;?>" onClick="return hs.htmlExpand(this, { contentId: 'highslide-html', objectType:   'iframe',height: 'auto',width: '600',height:'300' })" title="View Description">View Details</a>
									<?php   }
											else
											{
												echo $vari[$i][$k];
											}
									 ?> -->
                                 <td class="align_center_t">
			                         <a style="color: #fff" href="add_dictionary.php?edit_id=<?php print_r($vari[$i][0]);?>&id=<?php echo $abcd; ?>" class="btn btn-primary a_hover" title="Edit"><i class="icon-pencil"></i></a>	
			                         <a style="color: #fff" href="dictionary_list.php?del_id=<?php  print_r($vari[$i][0]);?>" class="btn btn-danger a_hover" title="Delete" onclick="javascript:return confirm('Are you sure you wish to delete')" ><i class="icon-trash"></i></a>
                                 </td>
                            </tr>
                            <?php }  ?>
                            </tbody>
                        </table>
                    </div>
                  
                </div>
                <!-- END EXAMPLE TABLE widget-->
                </div>
            </div>
            <!-- END ADVANCED TABLE widget-->
           </form>
            </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->  
   </div>
   <!-- END CONTAINER -->

<?php include("footer.php") ?>