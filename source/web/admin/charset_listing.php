<?php 
include("header.php"); 
include_once("admin_templateclass/charset_listing_manager.php"); 
$classObject		= 	new charset_listing_class();
$managerObject 		=	new charset_listing_manager();




$active				=	trim($_GET['active']);
$deactive			=	trim($_GET['deactive']);
$delete_id			=	trim($_GET['delete_id']);


if($active!="")
	{
		$msg = $managerObject->activate_single($active); ?>
	<?php }
	if($deactive!="")
	{
		$msg = $managerObject->Deactivate_single($deactive);?>
	<?php }
	if($delete_id!="")
	{
		$msg = $managerObject->delete_single($delete_id);
	}
	if(isset($_POST['btn_delete']))
	{
		$classObject->setpostvar($_POST['chk_act']);
		$msg = $managerObject->delete_selected($classObject);
	}
	if(isset($_POST['btn_activate']))
	{
		$classObject->setpostvar($_POST['chk_act']);
		$msg = $managerObject->activate_selected($classObject);
	}
	if(isset($_POST['btn_deactivate']))
	{
		$classObject->setpostvar($_POST['chk_act']);
		$msg = $managerObject->deactivate_selected($classObject);
	}




$memberlist		=	$managerObject->select_member();
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
 <h3 class="page-title">Charset Listing </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="index.php">Home</a>
                           <span class="divider">/</span>
                       </li>
                      
                       <li class="active" title="Contact Listing">
                          Charset Listing
                       </li>
                   </ul>
                   <!-- END PAGE TITLE & BREADCRUMB-->
               </div>
            </div>
          <!-- BEGIN ADVANCED TABLE widget-->
          
           <div style="float: left;margin-bottom: 20px;">
                	<a href="add_charset.php" title="Add Charset"><button class="btn btn-info"><i class="icon-plus"></i> Add Charset</button></a>
                </div>
         <form name="frm_member" method="post">
            <div class="row-fluid">
                <div class="span12">
                <!-- BEGIN EXAMPLE TABLE widget-->
                <?php if($msg!="") { ?>
                     <div class="alert alert-success">
                        <button class="close" data-dismiss="alert">×</button>
                        <strong><?php echo $msg; ?></strong>
                     </div>
                     <script type="text/javascript"> 
						setTimeout(function () {
						window.location.href= "charset_listing.php" // the redirect goes here
						},1000); // 3 seconds
					</script>	
                <?php } ?>
                <div style="float: right;margin-bottom: 20px;">
                <button class="btn btn-small btn-success" name="btn_activate" onclick='javascript: return activate_confirm(this);'><i class="icon-ok icon-white"></i> Activate</button>
                <button class="btn btn-small btn-info" name="btn_deactivate" onclick='javascript: return deactivate_confirm(this);'><i class="icon-ban-circle icon-white"></i> Deactivate</button>
                <button class="btn btn-small btn-danger" name="btn_delete" onclick='javascript: return delete_confirm(this);'><i class="icon-remove icon-white"></i> Delete</button>
                </div>
                
                <div class="widget gray">
                	
                    <div class="widget-title">
                    	 
                        <h4><i class="icon-reorder"></i>Charset Listing</h4>
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                            </span>
                    </div>
                   
                    <div class="widget-body">
                        <table class="table table-striped table-bordered" id="sample_1">
                            <thead>
                            <tr>
                                <th style="width:8px;"><input type="checkbox" name="chk_act[]" onClick="checkAll(this.form,this,this.checked)"/></th>
                              	<th class="align_center_t">Sr. No.</th> 
                            	<th sclass="align_center_t">Charset Name</th>                           
                           		<th class="align_center_t">Action</th>
                                
                            </tr>
                            </thead>
                            <tbody>
                            <?php if($memberlist) {
                            		for($i=0;$i<count($memberlist);$i++)
									{
										$id		=	trim($memberlist[$i]['id']);
										$name	=	$memberlist[$i]['char_name'];	
										$status =   trim($memberlist[$i]['is_active']);

                            ?>
                            <tr class="odd gradeX">
                                <td><input type="checkbox" class="checkboxes" name="chk_act[]" value="<?php echo $id?>"/></td>
                                <td class="align_center_t"><?php echo $i+1; ?></td>
                                <td>
                                	 <?php echo $name; ?>
                                </td>
                                <td class="align_center_t">
                                 
                                  <a style="color: #fff" href="add_charset.php?edit_id=<?php echo $id; ?>" class="btn btn-primary a_hover" title="Edit"><i class="icon-pencil"></i></a>
                                 <?php if($status=="N") { ?>
                                  	<a href="charset_listing.php?active=<?php echo $id; ?>" title="Deactive" class="btn btn-danger" onclick='javascript: return activate_single(this);'><i class="icon-ban-circle"></i></a>	
                                 <?php } else { ?>
                                 	<a href="charset_listing.php?deactive=<?php echo $id; ?>" title="Active" class="btn btn-success" onclick='javascript: return deactivate_single(this);'><i class="icon-ok"></i></a>
                                 <?php } ?> 
                               <a style="color: #fff" href="charset_listing.php?delete_id=<?php echo $id; ?>" title="Delete" class="btn btn-danger a_hover" onclick='javascript: return delete_single_confirm(this);'><i class="icon-trash"></i></a>
                                </td>
                            </tr>
                            <?php } } ?>
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