<?php
include("header.php"); 
include_once("admin_templateclass/user_list_manager.php");
$classObject	 = 	new user_list_class();
$managerObject =	new user_list_manager();

//$res_user	 =	$db->select_data("select * from user_register order by id");
$del_id		 =	$_GET['del_id'];
$user_type   =	$_GET['user_type'];
$active      =	$_GET['active'];
$deactive 	 =	$_GET['deactive'];
 
if($active!="")
{
	$msg = $managerObject->activate_single($active); 
}
if($deactive!="")
{
	$msg = $managerObject->Deactivate_single($deactive);
}
if($del_id!="")
{
	$msg = $managerObject->delete_single($del_id,$user_type);
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
$res_user	=	$managerObject->select_member();

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
 <h3 class="page-title">User Listing </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="index.php">Home</a>
                           <span class="divider">/</span>
                       </li>
                      
                       <li class="active" title="User Listing">
                          
                          User Listing
                       </li>
                   </ul>
                   <!-- END PAGE TITLE & BREADCRUMB-->
               </div>
            </div>
          <!-- BEGIN ADVANCED TABLE widget-->
          
           <!-- <div style="float: left;margin-bottom: 20px;">
                	<a href="add_charset.php" title="Add Charset"><button class="btn btn-info"><i class="icon-plus"></i> Add Charset</button></a>
                </div> -->
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
								/*setTimeout(function () {
								window.location.href= "user_list.php" // the redirect goes here
								},300); // 2 seconds */
						</script>
						<?php } ?>	
                <div style="float: right;margin-bottom: 20px;">
                 <button class="btn btn-small btn-success" name="btn_activate" onclick='javascript: return activate_confirm(this);'><i class="icon-ok icon-white"></i> Activate</button>
                 <button class="btn btn-small btn-info" name="btn_deactivate" onclick='javascript: return deactivate_confirm(this);'><i class="icon-ban-circle icon-white"></i> Deactivate</button> 
                 <button class="btn btn-small btn-danger" name="btn_delete" onclick='javascript: return delete_confirm(this);'><i class="icon-remove icon-white"></i> Delete</button> 
                </div>
                
                
                <div class="widget gray">
                	
                    <div class="widget-title">
                    	 
                        <h4><i class="icon-reorder"></i>User Listing</h4>
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
                                <th class="align_center_t">Name</th>
                                <th class="align_center_t">Email</th>
                                <th class="align_center_t">User Type</th>
                                <th class="align_center_t">Password</th>
                                <th class="align_center_t">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if($res_user) { 
                            		for($i=0;$i<count($res_user);$i++)
									{
										$user_id		=	trim($res_user[$i]['id']);
										$user_name		=	trim($res_user[$i]['name']);	
										$user_email		=	trim($res_user[$i]['display_email']);
										$user_type		=	trim($res_user[$i]['user_type']);
									    	$user_pass		=	base64_decode(trim($res_user[$i]['password']));
										$user_status	=	trim($res_user[$i]['is_active']);
										 
                            ?>
                            <tr class="odd gradeX">
                                <td><input type="checkbox" class="checkboxes" name="chk_act[]" value="<?php echo $user_id?>"/></td>
                                <td class="align_center_t"><?php echo $i+1; ?></td>
                                <td class="align_center_t"><?php echo $user_name; ?></td>
                                <td class="align_center_t"><?php echo $user_email; ?> 
                                </td>
                                <td class="align_center_t"><?php echo $user_type;?></td>
                                <td class="align_center_t"><em>Hidden</em></td>
                                <td class="align_center_t">
                                	
	                                <a style="color: #fff" href="add_user.php?edit_id=<?php echo $user_id; ?>" class="btn btn-primary a_hover" title="Edit"><i class="icon-pencil"></i></a>    
				                    <a style="color: #fff" href="user_list.php?del_id=<?php echo $user_id; ?>&user_type=<?php echo $user_type;?>" class="btn btn-danger a_hover" title="Delete" onclick="javascript:return confirm('Are you sure you wish to delete')"><i class="icon-trash"></i></a>
					                  <?php if($user_status=='Y') 
									 {
								   ?>
								   <a href='user_list.php?deactive=<?php echo $user_id?>' title='Deactive' class="btn btn-success" >
								   	<i class="icon-ok"></i>
							         </a>
							      <?php   }
										else
										{
							      ?>
							       <a href='user_list.php?active=<?php echo $user_id?>' title='Active' class="btn btn-danger">
							       	<i class="icon-ok"></i>
									 </a>
									<?php
										}
									?>
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