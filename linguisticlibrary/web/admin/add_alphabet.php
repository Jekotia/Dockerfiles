<?php 
include("header.php"); 
include_once("admin_templateclass/add_alphabet_manager.php");
$classObject		= 	new add_alphabet_class();
$managerObject 		=	new add_alphabet_manager();
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
			 window.location.href= "alphabet_listing.php" // the redirect goes here
			 },100); // 3 seconds
		 </script>
	 <?php 
	 }
 }
if($edit_id!="")
{
	 $btnsub	  =	"Update";
	 $sel 		  =	"select * from tbl_alphabet where id='$edit_id'";
	 $res		  =	$db->select_data($sel);
	 $name        =	$res[0]['alpha_name'];
	 $image       = $res[0]['image'];
	 $is_active	  =	$res[0]['is_active'];
	 $is_tehta	  =	$res[0]['is_tehta'];
	   
}
else
{
     $btnsub	  = "Submit";
     $name	      = $_POST['alpha_name'];
	 $image       = $_FILES['image']['name'];
	 $is_active	  = $_POST['is_active'];
	 $is_tehta	  = $_POST['is_tehta'];
}
?>
<style>
	.err{
		color:red;
	}
</style> 
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
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
function isNumericKey(e)
{
	//alert("dkjgdfag");
    if (window.event) { var charCode = window.event.keyCode; }
    else if (e) { var charCode = e.which; }
    else { return true; }
    if (charCode > 31 && (charCode < 48 || charCode > 57)) { return false; }
    return true;
} 
</script>
<h3 class="page-title">Add Alphabet Symbols </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="index.php">Home</a>
                           <span class="divider">/</span>
                       </li>
                      
                       <li class="active">
                          Add Alphabet Symbols
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
                            <h4><i class="icon-reorder"></i> Add Alphabet Symbol </h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            </span>
                        </div>
                        
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                            <form method="post" class="form-horizontal" name="frm_member" enctype="multipart/form-data">
                                 <div class="control-group">
			                         <a class="btn btn-info" href="alphabet_listing.php" style="float: right;">
			                         Back To Listing <i class="icon-circle-arrow-right"></i>
			                         </a> 
			                     </div>
                                 <div <?php if($err[0]!=""){ ?> class="control-group error" <?php } else if($err[0]=="") {?> class="control-group" <?php } ?>>
                                    <label class="control-label">Symbol Name <span class="err">*</span></label>
                                    <div class="controls">
                                        <input type="text" name="alpha_name"  class="input-xlarge" value="<?php echo $name; ?>"  />
                                        <?php if($err[0]!=""){ ?> 
                                       <span class="help-inline"><?php echo $err[0]; ?></span>
                                        <?php } ?>  
                                    </div>
                                 </div>
                                 <div <?php if($err[1]!=""){ ?> class="control-group error" <?php } else if($err[1]=="") {?> class="control-group" <?php } ?>>
                                    <label class="control-label">Image</label>
                                    <div class="controls">
                                        <input type="file" name="image" class="input-xlarge"/>
                                        <?php 
										if($edit_id!="") { ?>
                                        	<span><img src="upload/<?php echo $image; ?>" style="height:40px;width: 20px;"/></span>
                                        <?php } ?>
                                       
                                        <?php if($err[1]!=""){ ?>
                                        <span class="help-inline"  style="margin-left: 2%;"><?php echo $err[1]; ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                 <div <?php if($err[2]!=""){ ?> class="control-group error" <?php } else if($err[2]=="") {?> class="control-group" <?php } ?>>
                                    <label class="control-label">Active</label>
                                    <div class="controls">
                                        <label class="radio">
                                            <input type="radio" name="is_active" value="Y" checked="checked" <?php if($is_active=='Y'){ echo 'checked';} ?>/>
                                             Yes
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="is_active" value="N" <?php if($is_active=='N'){ echo 'checked';} ?>/>
                                             No
                                        </label>
                                       
                                        <?php if($err[2]!=""){ ?>
                                        <span class="help-inline" style="margin-left: 151px;"><?php echo $err[2]; ?></span>
                                        <?php } ?>
                                     </div>
                                  </div>
                                 <div <?php if($err[3]!=""){ ?> class="control-group error" <?php } else if($err[3]=="") {?> class="control-group" <?php } ?>>
                                    <label class="control-label">Type</label>
                                    <div class="controls">
                                        <label class="radio">
                                            <input type="radio" name="is_tehta" value="Y" checked="checked" <?php if($is_tehta=='Y'){ echo 'checked';} ?>/>
                                             Regular
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="is_tehta" value="N" <?php if($is_tehta=='N'){ echo 'checked';} ?>/>
                                             Diacritic
                                        </label>
                                       
                                        <?php if($err[3]!=""){ ?>
                                        <span class="help-inline" style="margin-left: 151px;"><?php echo $err[3]; ?></span>
                                        <?php } ?>
                                     </div>
                                  </div>
                                
		               			<div class="form-actions">
                                <button type="submit" name="submit" class="btn btn-info" style="margin-left: 14px;"><?php echo $btnsub; ?></button>
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
