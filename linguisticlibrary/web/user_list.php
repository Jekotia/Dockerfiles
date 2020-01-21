<?php
include("header.php"); 

include_once("admin_templateclass/user_list_manager.php");

$userObject	 = 	new user_list_class();
$userManager =	new user_list_manager();
$res_user	 =	$db->select_data("select * from user_register order by id");
$del_id		 =	$_GET['del_id'];
$active     =$_GET['active'];
$deactive 	=$_GET['deactive'];
 
if($del_id!="")
{
	 $query="delete from user_register where id='$del_id';";
	 $query1=$db->delete_data($query);
	 $msg="Deleted Successfully";
	 
	  ?>
	
	
<?php }
?>

<?php 
if($active!='')
{
	$sql_active="update user_register set is_active='Y' where id='$active'";
	$sql_res=$db->update_data($sql_active);
	if(count($sql_res)>0)
	{
		$msg="User Activated Successfully";
	} 
	
	
 
}

if($deactive!='')
{
	$sql_deactive="update user_register set is_active='N' where id='$deactive'";
	$sql_res1=$db->update_data($sql_deactive);
	if(count($sql_res1>0))
	{
		$msg="User Deactivate Successfully";
	}
}
?>
 
 <h3 class="page-title">User List</h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="index.php">Home</a>
                           <span class="divider">/</span>
                       </li>
                      
                       <li class="active" title="Users">
                          User
                       </li>
                   </ul>
                   <!-- END PAGE TITLE & BREADCRUMB-->
               </div>
            </div>
          <!-- BEGIN ADVANCED TABLE widget-->
            <div class="row-fluid">
                <div class="span12">
                <!-- BEGIN EXAMPLE TABLE widget-->
                 
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
 <?php
 if($msg!='')
 {
 	echo $msg; 
 ?>
 <script type="text/javascript"> 
		setTimeout(function () {
		window.location.href= "user_list.php" // the redirect goes here
		},2000); // 2 seconds
	</script>
<?php } ?>	
                    <div class="widget-body">
                        <table class="table table-striped table-bordered" id="sample_1">
                            <thead>
                            <tr>
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
										$user_id=trim($res_user[$i]['id']);
										$user_name=trim($res_user[$i]['name']);	
										$user_email=trim($res_user[$i]['display_email']);
										$user_type=trim($res_user[$i]['user_type']);
									    $user_pass=base64_decode(trim($res_user[$i]['password']));
										$user_status=trim($res_user[$i]['is_active']);
										 
                            ?>
                            <tr class="odd gradeX">
                               
                                <td class="align_center_t"><?php echo $i+1; ?></td>
                                <td class="align_center_t"><?php echo $user_name; ?></td>
                                <td class="align_center_t"><?php echo $user_email; ?> 
                                </td>
                                <td class="align_center_t"><?php echo $user_type;?></td>
                                <td class="align_center_t"><?php echo $user_pass; ?></td>
                                <td class="align_center_t">
                                	
                                    
                                    <a style="color: #fff" href="user_list.php?del_id=<?php echo $user_id; ?>" class="btn btn-danger a_hover" title="Delete"><i class="icon-trash"></i></a>
                  <?php if($user_status=='Y') 
				 {
			   ?>
			   <a href='user_list.php?deactive=<?php echo $user_id?>' class="btn btn-success" >
			   	<i class="icon-ok"></i>
		         </a>
		      <?php   }
					else
					{
		      ?>
		       <a href='user_list.php?active=<?php echo $user_id?>' class="btn btn-danger">
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
            </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->  
   </div>
   <!-- END CONTAINER -->

<?php include("footer.php") ?>