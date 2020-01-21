<?php 
include("header.php"); 
include_once("admin_templateclass/add_admin_manager.php");
$adminObject		= 	new add_admin_class();
$adminManager 		=	new add_admin_manager();
$edit_id			=	$_GET['edit_id'];
if(isset($_POST['submit']))
{
	$adminObject->setPostVar($_POST);
	$err	=	$adminManager->chkvalidation($adminObject,$edit_id);
	if(count($err)==0)
	{
		$message	=	$adminManager->adduser($adminObject,$edit_id);?>
		<script type="text/javascript"> 
			setTimeout(function () {
			window.location.href= "admin_listing.php" // the redirect goes here
			},3000); // 3 seconds
		</script> 
	<?php }
}
if($edit_id!="")
{
	$btnsub="Update";
	$sel 	=	"SELECT * FROM `admin` WHERE admin_id='$edit_id'";
	$res	=	$db->select_data($sel);
	
    $username		=	trim($res[0]['admin_name']);
	$email   		=	trim($res[0]['admin_email']);
	$password		=	trim($res[0]['admin_password']);
	$approval_required =trim($res[0]['approval_required']);
	
	
	if($_POST['password']!="")
	{
		$pwd=trim($_POST['password']);
	}
}
else
{
   $btnsub="Submit";
   $username	=	trim($_POST['username']);
   $email		=	trim($_POST['email']);
   $pwd			=	trim($_POST['password']);
   $cpassword	=	trim($_POST['cpassword']);
   $approval_required=$_POST['approval_required'];
}
?>
<script>
	function education_change(str)
 	{
 		if(str=='user')
 		{
 		  document.getElementById('userselection').style.display = "block"; 
 	    }
 	    else
 	    {
 	      document.getElementById('userselection').style.display = "none"; 
 	    }
 	}
</script>
<h3 class="page-title">Add User</h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="index.php">Home</a>
                           <span class="divider">/</span>
                       </li>
                      
                       <li class="active">
                           Add User
                       </li>
                       
                   </ul>
                   <!-- END PAGE TITLE & BREADCRUMB-->
               </div>
            </div>
  <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
                <div class="span12">
                	<?php if($message) { ?>
                        <div class="alert alert-success">
                           <button class="close" data-dismiss="alert">×</button>
                           <strong><?php echo $message; ?></strong>
                        </div>
                    <?php } ?>
                    <!-- BEGIN SAMPLE FORMPORTLET-->
                    <div class="widget gray">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i> Add User</h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            </span>
                        </div>
                        
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                            <form method="post" class="form-horizontal">
                                 <div class="control-group">
			                         <a class="btn btn-info" href="admin_listing.php" style="float: right;">
			                         Back To List <i class="icon-circle-arrow-right"></i>
			                         </a>
			                     </div>
        		            
                                <div <?php if($err[0]!=""){ ?> class="control-group error" <?php } else if($err[0]=="") {?> class="control-group" <?php } ?>>
                                    <label class="control-label">UserName</label>
                                    <div class="controls">
                                        <input type="text" name="username" placeholder="Username" class="input-xlarge" value="<?php echo $username; ?>"/>
                                        <?php if($err[0]!=""){ ?>
                                        <span class="help-inline"><?php echo $err[0]; ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div <?php if($err[1]){ ?> class="control-group error" <?php } else {?> class="control-group" <?php } ?>>
                                <label class="control-label">Email Address</label>
                                <div class="controls">
                                    <div class="input-icon left">
                                        <i class="icon-envelope"></i>
                                        <input type="text" name="email" placeholder="Email Address" class="input-email" value="<?php echo $email; ?>"/>
                                        <?php if($err[1]!=""){ ?>
                                        <span class="help-inline"><?php echo $err[1]; ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                            	</div>

                            	<div <?php if($err[2]){ ?> class="control-group error" <?php } else {?> class="control-group" <?php } ?>>
                                    <label class="control-label"><?php if($edit_id==""){ ?> Password<?php }else { ?>Change Password<?php }?></label>
                                    <div class="controls">
                                        <input type="password" name="password" placeholder="password" class="input-xlarge" value="<?php echo $pwd; ?>"/>
                                        <?php if($err[2]!=""){ ?>
                                        <span class="help-inline"><?php echo $err[2]; ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                               <div <?php if($err[3]){ ?> class="control-group error" <?php } else {?> class="control-group" <?php } ?>>
                                    <label class="control-label">Confirm Password</label>
                                    <div class="controls">
                                        <input type="password" name="cpassword" placeholder="Confirm Password" class="input-xlarge"/>
                                        <?php if($err[3]!=""){ ?>
                                        <span class="help-inline"><?php echo $err[3]; ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                 <div <?php if($err[6]!=""){ ?> class="control-group error" <?php } else if($err[6]=="") {?> class="control-group" <?php } ?>>
                                    <label class="control-label">Approval Required</label>
                                    <div class="controls">
                                        <input type="radio" name="approval_required" value="Y" <?php if ($approval_required=='Y'){ echo 'checked'; } ?> />
             	                    	Yes
             	                    		<input type="radio" name="approval_required" id="no" value="N" <?php if ($approval_required=='N'){ echo 'checked'; } ?> />
             	                    	No
             	                    	 <?php if($err[6]!=""){ ?>
                                        <span class="help-inline"><?php echo $err[6]; ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                               	<div class="form-actions">
                                <button type="submit" name="submit" class="btn btn-info"><?php echo $btnsub; ?></button>
                            	</div>
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                </div>
            </div>
          </div>
        </div>
       </div>
            

<?php include("footer.php"); ?>
