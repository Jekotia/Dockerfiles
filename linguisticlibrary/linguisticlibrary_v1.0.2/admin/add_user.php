<?php 
include("header.php"); 
include_once("admin_templateclass/add_user_manager.php");
$adminObject		= 	new add_user_class();
$adminManager 		=	new add_user_manager();
$edit_id			=	$_GET['edit_id'];
if(isset($_POST['submit']))
{
	$adminObject->setPostVar($_POST);
	$err	=	$adminManager->chkvalidation($adminObject,$edit_id);
	//print_r($err);
	
	if(count($err)==0)
	{
		
		$message	=	$adminManager->register($adminObject,$edit_id);
		?>
		<script type="text/javascript"> 
			setTimeout(function () {
			window.location.href= "user_list.php" // the redirect goes here
			},3000); // 3 seconds
		</script> 
	<?php }
}
if($edit_id!="")
{
	$btnsub="Update";
	$sel 	=	"SELECT * FROM `user_register` WHERE id='$edit_id'";
	$res	=	$db->select_data($sel);
	
	$user_type	=	trim($res[0]['user_type']);
 	$name		=	trim($res[0]['name']);
	$email		=	trim($res[0]['display_email']);
	//$password	=	trim($res[0]['password']);
	$approval_required =trim($res[0]['approval_required']);
	$status		=	trim($res[0]['is_active']);
	
	if($_POST['password']!="")
	{
		$password=trim($_POST['password']);
	}
}
else
{
   	$btnsub="Submit";
   
 	$user_type	=	trim($_POST['user_type']);
 	$name		=	trim($_POST['name']);
	$email		=	trim($_POST['email']);
	$password	=	trim($_POST['password']);
	$cpassword	=	trim($_POST['cpassword']);
	$approval_required=trim($_POST['approval_required']);
	$status		=	trim($_POST['is_active']);
   
   
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
			                         <a class="btn btn-info" href="user_list.php" style="float: right;">
			                         Back To List <i class="icon-circle-arrow-right"></i>
			                         </a>
			                     </div>
        		            
                                <div <?php if($err[0]!=""){ ?> class="control-group error" <?php } else if($err[0]=="") {?> class="control-group" <?php } ?>>
                                    <label class="control-label">User Type</label>
                                    <div class="controls">
                                      
             	                    		<input type="radio" name="user_type" value="author" <?php if ($user_type=='author'){ echo 'checked'; } ?> />
             	                    	Author
             	                    		<input type="radio" name="user_type"  value="reader" <?php if ($user_type=='reader'){ echo 'checked'; } ?> />
             	                    	Reader
             	                    	<input type="radio" name="user_type" value="admin" <?php if ($user_type=='admin'){ echo 'checked'; } ?> />
             	                    	Admin
             	                    	
                                        <?php if($err[0]!=""){ ?>
                                        <span class="help-inline"><?php echo $err[0]; ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                 <div <?php if($err[1]!=""){ ?> class="control-group error" <?php } else if($err[1]=="") {?> class="control-group" <?php } ?>>
                                    <label class="control-label">Status</label>
                                    <div class="controls">
                                        <input type="radio" name="is_active" value="Y" <?php if ($status=='Y'){ echo 'checked'; } ?> />
             	                    	Active
             	                    		<input type="radio" name="is_active" id="no" value="N" <?php if ($status=='N'){ echo 'checked'; } ?> />
             	                    	Deactive
             	                    	 <?php if($err[1]!=""){ ?>
                                        <span class="help-inline"><?php echo $err[1]; ?></span>
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
                               <div <?php if($err[2]!=""){ ?> class="control-group error" <?php } else if($err[2]=="") {?> class="control-group" <?php } ?>>
                                <label class="control-label">Display Name</label>
                                <div class="controls">
                                        <input type="text" name="name" placeholder="Name" class="input-xlarge" value="<?php echo $name; ?>"/>
                                        <?php if($err[2]!=""){ ?>
                                        <span class="help-inline"><?php echo $err[2]; ?></span>
                                        <?php } ?>
                                    </div>
                               
                            	</div>
								<div <?php if($err[3]!=""){ ?> class="control-group error" <?php } else if($err[3]=="") {?> class="control-group" <?php } ?>>
                                    <label class="control-label">Email</label>                                  
                                    
                                     <div class="controls">
                                    <div class="input-icon left">
                                        <i class="icon-envelope"></i>
                                        <input type="text" name="email" placeholder="Email" class="input-email" value="<?php echo $email; ?>"/>
                                        <?php if($err[3]!=""){ ?>
                                        <span class="help-inline"><?php echo $err[3]; ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                </div>
                            	<div <?php if($err[4]){ ?> class="control-group error" <?php } else {?> class="control-group" <?php } ?>>
                                    <label class="control-label"><?php if($edit_id==""){ ?> Password<?php }else { ?>Change Password<?php }?></label>
                                    <div class="controls">
                                        <input type="password" name="password" placeholder="password" class="input-xlarge" value="<?php echo $password; ?>"/>
                                        <?php if($err[4]!=""){ ?>
                                        <span class="help-inline"><?php echo $err[4]; ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                               <div <?php if($err[5]){ ?> class="control-group error" <?php } else {?> class="control-group" <?php } ?>>
                                    <label class="control-label">Confirm Password</label>
                                    <div class="controls">
                                        <input type="password" name="cpassword" placeholder="Confirm Password" class="input-xlarge"/>
                                        <?php if($err[5]!=""){ ?>
                                        <span class="help-inline"><?php echo $err[5]; ?></span>
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
