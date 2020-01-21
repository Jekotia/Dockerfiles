<?php include("header.php"); 
include_once("admin_templateclass/cms_listing_manager.php"); 
$adminObject		= 	new cms_listing_class();
$adminManager 		=	new cms_listing_manager();
$res_cms			=   $adminManager->select_cms();
$active				=	trim($_GET['active']);
$deactive			=	trim($_GET['deactive']);
if($active!="")
{
	$msg = $adminManager->activate_single($active); 
	?>
	
<?php }
if($deactive!="")
{
	$msg = $adminManager->Deactivate_single($deactive);
?>
    
<?php }
?>
<script>
	function activate_single()
{
   var del_yes= confirm("Do you want to Activate Record?");
   if (del_yes==true)
   {
	  return true;
   }
   else
   {
	  return false;
   }
 }
function deactivate_single()
{
   var del_yes= confirm("Do you want to Deactivate Record?");
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
 <h3 class="page-title">CMS Listing </h3>
         <ul class="breadcrumb">
             <li>
                <a href="index.php" title="Home">Home</a>
                <span class="divider">/</span>
             </li>
             <li class="active" title="CMS Listing">
                CMS Listing
             </li>
          </ul>
                   <!-- END PAGE TITLE & BREADCRUMB-->
  </div>
</div>
    <form action="" method="post">
          <!-- BEGIN ADVANCED TABLE widget-->
            <div class="row-fluid">
                <div class="span12">
                <?php if($msg!="") { ?>
                     <div class="alert alert-success">
                        <button class="close" data-dismiss="alert">×</button>
                        <strong><?php echo $msg; ?></strong>
                     </div>
                     <script type="text/javascript"> 
						setTimeout(function () {
						window.location.href= "cms_listing.php" // the redirect goes here
						},1000); // 3 seconds
					</script>	
                <?php } ?>
                <!-- BEGIN EXAMPLE TABLE widget-->
                <div style="float: left;margin-bottom: 20px;">
                	<a href="add_cms.php" title="Add CMS" class="btn btn-info"><i class="icon-plus"></i> Add CMS</a>
                </div>
                <div class="widget gray">
                    <div class="widget-title">
                        <h4><i class="icon-reorder"></i>CMS Listing</h4>
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                            </span>
                    </div>
                    <div class="widget-body">
                        <table class="table table-striped table-bordered" id="sample_1">
                            <thead>
                            <tr>
                                <th class="align_center_t">Sr. No.</th>
                                <th class="align_center_t">Title</th>
                                <!-- <th class="align_center_t">Image</th> -->
                                <th class="align_center_t">Page Description</th>
                                <th class="align_center_t">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(count($res_cms)!=0) { 
                            		for($i=0;$i<count($res_cms);$i++)
									{
										$id		=	trim($res_cms[$i]['id']);
										$title	=	trim($res_cms[$i]['cms_title']);	
										$desc	=	trim($res_cms[$i]['cms_desc']);
										$status	=	trim($res_cms[$i]['is_active']);
										// $file   =   trim($res_cms[$i]['file']); 
                            ?>
                            <tr class="odd gradeX">
                            	<td class="align_center_t"><?php echo $i+1; ?></td>
                                <td><?php echo ucwords($title); ?></td>
                                <!-- <td><?php if($file!=""){ ?><img src="upload/cms/<?php echo $file; ?>" width="70" height="70"><?php }else{ echo "--"; } ?></td> -->
                                <td>
                                	<?php $len=strlen($desc);
											if($len>30)
											{
												$disp=substr($desc, 0,30);
												echo $disp.'....';?><br>
												<a style="float: right;" class="black_txt" href="view_cms.php?id=<?php echo $id;?>" onClick="return hs.htmlExpand(this, { contentId: 'highslide-html', objectType:   'iframe',height: 'auto',width: '700' })" title="View Description">View Details</a>
									<?php   }
											else
											{
												echo $desc; 
											}
									 ?>
                                </td>
                               
                                <td class="align_center_t">
                                    <a style="color: #fff" href="add_cms.php?edit_id=<?php echo $id; ?>" class="btn btn-primary a_hover" title="Edit"><i class="icon-pencil"></i></a>
                                 <?php if($status=="N") { ?>
                                  	<a href="cms_listing.php?active=<?php echo $id; ?>" title="Deactive" class="btn btn-danger" onclick='javascript: return activate_single(this);'><i class="icon-ban-circle"></i></a>	
                                 <?php } else { ?>
                                 	<a href="cms_listing.php?deactive=<?php echo $id; ?>" title="Active" class="btn btn-success" onclick='javascript: return deactivate_single(this);'><i class="icon-ok"></i></a>
                                 <?php } ?> 
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
  </form>
<?php include("footer.php") ?>