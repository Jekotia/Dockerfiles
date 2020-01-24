<?php include("header.php"); 
include_once("admin_templateclass/add_cms_manager.php");
$classObject		= 	new add_cms_class();
$managerObject 		=	new add_cms_manager();
$edit_id			=	$_GET['edit_id'];
if(isset($_POST['submit']))
{
	$classObject->setPostVar($_POST);
	$err	=	$managerObject->chkvalidation($classObject,$edit_id);
	if(count($err)==0)
	{
		$message	=	$managerObject->register($classObject,$edit_id);?>
		<script type="text/javascript"> 
			setTimeout(function () {
			window.location.href= "cms_listing.php" // the redirect goes here
			},3000); // 3 seconds
		</script>
	<?php }
}
if($edit_id!="")
{
	$btnsub="Update";
	$sel 	=	"select * from manage_cms where id='$edit_id'";
	$res	=	$db->select_data($sel);
	
    $title		=	$res[0]['cms_title'];
	$desc   	=	$res[0]['cms_desc'];
	$status		=	$res[0]['is_active'];
	//$file       =   $res[0]['file'];  
}
else
{
    $btnsub="Submit";
    $title		=	trim($_POST['title']);
    $desc		=	trim($_POST['desc']);
    $status		=	trim($_POST['is_active']);
	//$file       =   $_FILES['file']['name'];  
}
?>

<h3 class="page-title">Add CMS</h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="index.php">Home</a>
                           <span class="divider">/</span>
                       </li>
                      
                       <li class="active">
                           Add CMS
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
                            <h4><i class="icon-reorder"></i> Add CMS</h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            </span>
                        </div>
                        
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                            <form method="post" class="form-horizontal" enctype="multipart/form-data">
                                 <div class="control-group">
			                         <a class="btn btn-info" href="cms_listing.php" style="float: right;">
			                         Back To Listing <i class="icon-circle-arrow-right"></i>
			                         </a>
			                     </div>
                                <div <?php if($err[0]!=""){ ?> class="control-group error" <?php } else if($err[0]=="") {?> class="control-group" <?php } ?>>
                                    <label class="control-label">Page Title</label>
                                    <div class="controls">
                                        <input type="text" name="title" placeholder="Title" class="input-xlarge" value="<?php echo $title; ?>"/>
                                        <?php if($err[0]!=""){ ?>
                                        <span class="help-inline"><?php echo $err[0]; ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                               
		                        <div <?php if($err[1]!=""){ ?> class="control-group error" <?php } else if($err[1]=="") {?> class="control-group" <?php } ?>>
		                           <label class="control-label">Page Description</label>
		                            <div class="controls">
		                                <textarea name="desc" class="span12 wysihtmleditor5" rows="5" placeholder="Description"><?php echo $desc; ?></textarea>
		                                <?php if($err[1]!=""){ ?>
                                        <span class="help-inline"><?php echo $err[1]; ?></span>
                                        <?php } ?>
		                            </div>
		                         </div>
		                          <!-- <div <?php if($err[3]!=""){ ?> class="control-group error" <?php } else if($err[3]=="") {?> class="control-group" <?php } ?>>
                                    <label class="control-label">Upload Image</label>
                                    <div class="controls">
                                        <input type="file" name="file" class="input-xlarge" value="<?php echo $file; ?>"/>
                                        <?php if($err[3]!=""){ ?>
                                        <span class="help-inline"><?php echo $err[3]; ?></span>
                                        <?php } ?>
                                    </div>
                                </div> -->
		                         <div <?php if($err[2]!=""){ ?> class="control-group error" <?php } else if($err[2]=="") {?> class="control-group" <?php } ?>>
                                    <label class="control-label">Status</label>
                                    <div class="controls">
                                        <label class="radio">
                                            <input type="radio" name="is_active" value="Y" <?php if($status=='Y'){ echo 'checked';} ?>/>
                                             Yes
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="is_active" value="N" <?php if($status=='N'){ echo 'checked';} ?>/>
                                             No
                                        </label>
                                        <?php if($err[2]!=""){ ?>
                                        <span class="help-inline" style="margin-top: -45px;"><?php echo $err[2]; ?></span>
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
