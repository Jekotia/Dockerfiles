<?php include("header.php"); 
include_once("admin_templateclass/admin_listing_manager.php"); 
$adminObject		= 	new admin_listing_class();
$adminManager 		=	new admin_listing_manager();
$res_admin	=	$adminManager->select_admin();
$del_id				=	$_GET['del_id'];
$status_id=$_GET['active'];
$deactive=$_GET['deactive'];

$user_id= $_SESSION["ADMIN_ID"];
if($del_id!="")
{
	$msg = $adminManager->delete_single($del_id);
}
if($status_id!='')
{
	$msg=$adminManager->active_single($status_id);
} 
if($deactive!='')
{
	$msg=$adminManager->deactive_single($deactive);
}
?>
<script language="JavaScript">
	function deactive_single()
	{
	   var del_yes= confirm("Do you want to deactivate Record?");
	   if (del_yes==true)
	   {
		  return true;
	   }
	   else
	   {
	   	  
		  return false;
	   }
	 } 
	function active_single()
	{
	   var del_yes= confirm("Do you want to activate Record?");
	   alert(del_yes);
	   if (del_yes==true)
	   {
		  return true;
	   }
	   else
	   {
	   
		  return false;
	   }
	} 
	function delete_single()
	{
	   var del_yes= confirm("Do you want to delete Record?");
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
 <h3 class="page-title">Users List</h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="index.php">Home</a>
                           <span class="divider">/</span>
                       </li>
                      
                       <li class="active" title="Users">
                          Users
                       </li>
                   </ul>
                   <!-- END PAGE TITLE & BREADCRUMB-->
               </div>
            </div>
          <!-- BEGIN ADVANCED TABLE widget-->
            <div class="row-fluid">
                <div class="span12">
                <!-- BEGIN EXAMPLE TABLE widget-->
                <div style="float: left;margin-bottom: 20px;">
                	<a href="add_admin.php" title="Add User"><button class="btn btn-info"><i class="icon-plus"></i> Add User</button></a>
                </div>
                <!-- <div style="float: right;margin-bottom: 20px;">
                <button class="btn btn-small btn-success"><i class="icon-ok icon-white"></i> Activate</button>
                <button class="btn btn-small btn-info"><i class="icon-ban-circle icon-white"></i> Deactivate</button>
                <button class="btn btn-small btn-danger"><i class="icon-remove icon-white"></i> Delete</button>
                </div> -->
                
                <div class="widget gray">
                	
                    <div class="widget-title">
                    	 
                        <h4><i class="icon-reorder"></i>Users List</h4>
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                            </span>
                    </div>
                    <div class="widget-body">
                    	<?php if($msg !="") 
						{ 
							?>
							<div class="alert alert-success">
						       <button class="close" data-dismiss="alert">×</button>
						       <strong><?php echo $msg; ?></strong>
						    </div>
						    <script type="text/javascript"> 
								setTimeout(function () {
								window.location.href= "admin_listing.php" // the redirect goes here
								},2000); // 2 seconds
							</script>	
							<?php 
						}
						 ?>
						
						
                        <table class="table table-striped table-bordered" id="sample_1">
                        	
                            <thead>
                            <tr>
                                <th class="align_center_t">Sr. No.</th>
                                <th class="align_center_t">Name</th>
                                <th class="align_center_t">Email</th>
                              <!--  <th class="align_center_t">Last Connection</th> -->
                                <th class="align_center_t">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if($res_admin) { 
                            		for($i=0;$i<count($res_admin);$i++)
									{
										$admin_id		=	trim($res_admin[$i]['admin_id']);
										$admin_name		=	trim($res_admin[$i]['admin_name']);	
										$admin_email	=	trim($res_admin[$i]['admin_email']);
										$status			=	trim($res_admin[$i]['is_active']);
										$login			=	$res_admin[$i]['login_time'];
									 	$sql_lltime		=	"select DATE_FORMAT('$login', '%m-%d-%Y  %r')";
  	     							 	$res_ll			=	$db->select_data($sql_lltime);
	   	    						 	$disp_time		=	$res_ll[0][0];
								     	if($login=="")
									   		$login_time="00-00-0000  00:00";
								     	else
									   	$login_time=$disp_time;
									 	 $cnt++; 	
                            ?>
                            <tr class="odd gradeX">
                               
                                <td class="align_center_t"><?php echo $i+1; ?></td>
                                <td class="align_center_t"><?php echo $admin_name; ?></td>
                                <td class="align_center_t"><a href="mailto:<?php echo $admin_email ?>"><?php echo $admin_email; ?></a>
                                </td>
                               
                                <!-- <td class="align_center_t"><?php echo $login_time; ?></td> -->
                                <td class="align_center_t">
                                	
                                    <a style="color: #fff" href="add_admin.php?edit_id=<?php echo $admin_id; ?>" class="btn btn-primary a_hover" title="Edit"><i class="icon-pencil"></i></a>
                
					                 <?php if($admin_id!="1"){?>
					                <a style="color: #fff" href="admin_listing.php?del_id=<?php echo $admin_id; ?>" class="btn btn-danger a_hover" title="Delete" onclick="javascript:return confirm('Are you sure you wish to delete')"><i class="icon-trash"></i></a>
					                <?php if($status=='Y') 
									 {
								   ?>
								   <a href='admin_listing.php?deactive=<?php echo $admin_id?>' title='Deactive' class="btn btn-success" >
								   	<i class="icon-ok"></i>
							         </a>
							      <?php   }
										else
										{
							      ?>
							       <a href='admin_listing.php?active=<?php echo $admin_id?>' title='Active' class="btn btn-danger">
							       	<i class="icon-ok"></i>
									 </a>
									<?php
										}
									?>      <?php } ?>
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
            </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->  
   </div>
   <!-- END CONTAINER -->

<?php include("footer.php") ?>