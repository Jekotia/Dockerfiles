<?php
include("header.php");
include_once("admin_templateclass/add_website_manager.php");
$classObject		= 	new add_website_class();
$managerObject 		=	new add_website_manager();
$edit_id			=	1;

if(isset($_POST['submit']))
{
	$classObject->setPostVar($_POST);
	   $err	= $managerObject->chkvalidation($classObject,$edit_id);
	if(count($err)==0)
	{
		$message	=	$managerObject->register($classObject,$edit_id);
		?>
		<script type="text/javascript"> 
			setTimeout(function () {
			window.location.href= "website_form.php" // the redirect goes here
			},1000); // 3 seconds
		</script>
		<?php 
	}
	
}
  
if($edit_id!="")
{
	$btnsub 	=	"Update";
	$sel 		=	"select * from  graphics where id=1";
	$res		=	$db->select_data($sel);
	
    $image1 =   $res[0]['frontpage_background'];
	$image2 =   $res[0]['banner_background'];
    $image3 =   $res[0]['favicon'];
	$name   =   $res[0]['website_name'];
	$desc1  =   stripslashes(trim($res[0]['footer_html1']));
	$desc2  =   stripslashes(trim($res[0]['footer_html2']));
   	$desc3  =   stripslashes(trim($res[0]['footer_html3']));

	$pages_Query = "SELECT * FROM `navigation_menu`";
	$get_Pages   = $db->select_data($pages_Query);
	$tot_Pages   = count($get_Pages);
	 
	
	
}
else
{
    $btnsub =	"Save Changes";
    //$name	=	trim($_POST['name']);
    //$status	=	trim($_POST['display']);
    //$order	=	trim($_POST['order']);
	
		$image1 =  $_FILES['frontpageimage']['name'];
		$image2	 =	$_FILES['bckimage']['name'];
	    $image3	 =	$_FILES['favicon']['name'];
		 
		
		$desc1  = stripslashes(trim($_POST['desc1']));
		$desc2  = stripslashes(trim($_POST['desc2']));
		$desc3  = stripslashes(trim($_POST['desc3']));
}
	 
 
	?>	
<style>
	.widget-body
	{
		overflow-x: scroll;
		width: 95%;
	}
	.input-xlarge 
	{
		width: 80px;
	}
	
	.form-horizontal .control-group, .control-group 
	{
		margin: 0;
	}
    .monthsty
    {
    	font-size: 12px;
		font-weight: bold;
		text-align: center;
		width: 40px;
	}
    .main_table
    {
    	width: 1700px!important;
    }
    .first_td
    {
    	width :8%;
    }
   textarea.expr {
	width: auto !important;
}
</style>

<style type="text/css">
@-moz-document url-prefix() {
  .widget-body
	{
		overflow-x: scroll;
		width: 95%;
	}
   .input-xlarge 
	{
		width: 62px;
	}
	
	.form-horizontal .control-group, .control-group 
	{
		margin: 0;
	}
	 .main_table
    {
    	width: 1700px!important;
    }
     .monthsty
    {
    	 padding: 0 21px 0 18px;
	}
    .first_td
    {
    	padding-right: 114px;
    }
}
</style>
<script  src="js/service_tax.js" > </script>
<script type="text/javascript">
function f1()
{
	var val=document.getElementById('desc1').value;
    
	if(val!='')
	{
		document.getElementById('desc1').value="";
		return true;
		
	}
	 	
}	
	
function f2()
{
	var val=document.getElementById('desc2').value;
     
	if(val!='')
	{
		document.getElementById('desc2').value="";
		return true;
		
	}	
}	
function f3()
{
	 
    var val=document.getElementById('desc3').value;
     
	 
	if(val!='')
	{
		document.getElementById('desc3').value="";
		return true;
		
	}
	 
	
	
	
	
	
}	
</script>
<h3 class="page-title">Add Website</h3>
	<ul class="breadcrumb">
		<li>
        	<a href="index.php">Home</a>
            <span class="divider">/</span>
        </li>
                      
        <li class="active">
        	Add Website
        </li>
    </ul>
                   <!-- END PAGE TITLE & BREADCRUMB-->
               </div>
            </div>
  <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
                <div class="span12">
                	<?php if($message) 
                	{ ?>
                    	<div class="alert alert-success">
                           <button class="close" data-dismiss="alert">×</button>
                           <strong><?php echo $message; ?></strong>
                        </div>
                    	<?php 
					} ?>
                    <!-- BEGIN SAMPLE FORMPORTLET-->
                    <div class="widget gray">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i> Add Website</h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            </span>
                        </div>
                        
                        
                        <div class="widget-body" >
                            <!-- BEGIN FORM-->
                            
                            <form method="post" class="form-horizontal" enctype="multipart/form-data">
                                <div class="control-group"> 
			                         <a class="btn btn-info" href="#" style="float: right;">
			                         Back To Listing <i class="icon-circle-arrow-right"></i></a> 
			                    </div> 
			                     <div <?php if($err[4]!=''){?> class="control-group error"   <?php  } else {?>  class="control-group"<?php } ?>  > 
					               <label class="control-label"><b>Navigation Menu:</b></label>	
					                <div class="controls">
								  <!-- <table border="0" class="main_table"> -->
								     <table style="border : none;">
                                	 <tr></tr>
                                	 <tr>
                                	<th colspan="2">Name</th>
                                	 <th colspan="2">Display?</th>
                                	 <th>Order</th>
                                	 <th>URL</th>
                                	 </tr>
                                	 <?php
                                	  for ($pg=0; $pg < $tot_Pages; $pg++) 
                                	  {
                                	  	 $val=$get_Pages[$pg]['page_name']; 
										 
										  ?>
                                	 <tr>
                                		<td style="border-right:none;">
             	                    	<?php echo $get_Pages[$pg]['page_desc']; ?>
             	                       </td>
             	                       <td><input type="text" name="name1[]" class="input-x" value="<?php echo $val; ?>"/></td>
             	                    	<td style="border-right : none;">
             	                    	<input type="radio" name="display<?php echo $pg; ?>" value="Y" <?php if ($get_Pages[$pg]['is_page_display']=='Y'){ echo 'checked'; } ?> />
             	                    	Yes
             	                    	</td>
             	                    	<td style="border-right : none;">
             	                    		<input type="radio" name="display<?php echo $pg; ?>" id="no" value="N" <?php if ($get_Pages[$pg]['is_page_display']=='N'){ echo 'checked'; } ?> />
             	                    	No
             	                    	</td>
             	                    	<td style="border-right:none;">
             	                        <input type="text" name="order[]" style="width:45px" value="<?php echo $get_Pages[$pg]['page_order']; ?>"/>
             	                        </td>
             	                        <td style="border-right:none;">
             	                        <input type="text" name="url[]" style="width:150px" value="<?php echo $get_Pages[$pg]['url']; ?>"/>
             	                        </td>
             	                     </tr>
										  <?php
									  }
                                	  ?>                                	              	                     
             	                    </table>
             	                   </div>
             	                  </div>
                          	 
                           <?php if($err[4]){ ?><span class="help-inline" style="margin-left: 189px;"> <?php echo $err[4];  ?></span> <?php } ?>     	                    
                        
                          <!--------------------------------------Form2 ------------------------------------>
                                <div>
                                    <label class="control-label"><b>Graphics:</b></label>
                                    <div class="controls">
                                    	<div class="input-left">
                                    	 <label class="control-label">Frontpage Background</label>
                                         <input class="text" name="frontpageimage" id="image" type="file"  style="width: 213px;vertical-align: top;" accept="image/*"/>
                                    
                                         <?php 
										if($edit_id!="") { ?>
                                        	<span><img src="upload/<?php echo $image1; ?>" style="height:100px;width: 100px;"/></span>
                                        <?php } ?>
                                       
                                        <?php if($err[0]!=""){ ?>
                                        <span class="help-inline"  style="margin-left: 2%;"><?php echo $err[0]; ?></span>
                                        <?php } ?>
										 
									   </div>
									<div class="input-left">
										  <label class="control-label">Banner Background </label>
										 <input class="text" name="bckimage" id="image1" type="file" style="width: 213px;vertical-align: top;" accept="image/*"/>
                                       
                                         <?php 
										if($edit_id!="") { ?>
                                        	<span><img src="upload/<?php echo $image2; ?>" style="height:30px;width: 100px;"/></span>
                                        <?php } ?>
                                       
                                        <?php if($err[1]!=""){ ?>
                                        <span class="help-inline"  style="margin-left: 2%;"><?php echo $err[1]; ?></span>
                                        <?php } ?>
                                    </div>
                                   <div class="input-left">
										  <label class="control-label">Favicon</label>
										 <input class="text" name="favicon" id="image2" type="file" style="width: 213px;vertical-align: top;" accept="image/*"/>
                                     
                                         <?php 
										if($edit_id!=="") { ?>
                                        	<span><img src="upload/<?php echo $image3; ?>" style="height:16px;width: 16px;"/></span>
                                        <?php } ?>
                                       
                                        <?php if($err[2]!="")
                                        { ?>
                                        <span class="help-inline"  style="margin-left: 2%;"><?php echo $err[2]; ?></span>
                                        <?php } ?>
                                    </div>
                                    </div>
                                </div>
                                <!---------------------------Form 2-------------------------------->
                                <div> 
					                <label class="control-label"><b>Website:</b></label>
					                <div class="controls" style="margin-top:12px;">
					               
					                <table style="border : none;">
					                     <tr>
					                			<td>Name:</td>
					                	    <td>
					                	   	 <input type="text" name="name" class="input-x" value="<?php echo $name;?>"/>
					                        </td>
					                     </tr><br/>
					                     <tr></tr>
					                    
					                    <tr>
					                		<td>Homepage HTML 1:</td>
					                	    <td>
					                	   	 <textarea class="expr" name="desc1" id="desc1" placeholder="Description" rows="4" cols="75"><?php echo $desc1; ?></textarea>                       
					                        </td>
					                    </tr>
					                     <tr></tr>
					                      <tr><td><input type="button" id="res" name="res" onclick="f1()" value="Reset"/> </td></tr>
					                    <tr>
					                		<td>Homepage HTML 2:</td>
					                	    <td>
					                	   	 <textarea class="expr" name="desc2" id="desc2" placeholder="Description" rows="4" cols="75"><?php echo $desc2; ?></textarea>                       
					                        </td>
					                    </tr>
					                     <tr><td><input type="button" id="res1" name="res1" onclick="f2()" value="Reset"/> </td></tr>
					                   
					                    <tr>
					                		<td>Homepage HTML 3:</td>
					                	    <td>
					                	   	 <textarea class="expr" name="desc3" id="desc3" placeholder="Description" rows="4" cols="75"><?php echo $desc3; ?></textarea>                       
					                        </td>
					                    </tr>
					                     <tr><td><input type="button" id="res2" name="res2" onclick="f3()" value="Reset"/> </td></tr>
					                   
					                              
					                    </table>
					                </div>
					                </div>
                            
                               	<div class="form-actions">
                                <input type="submit" name="submit" value="<?php echo $btnsub; ?>" class="btn btn-info" />
                            	</div>
                            </form>
                          
                            <!-- END FORM-->
                        </div>
                        
                          <!-- <div style="border:0!important;" >
                    		<img style="border:0!important;"  src="forex_bar.php">
                               </div> -->
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                </div>
            </div>
          </div>
        </div>
       </div>
       
<?php
				include ("footer.php");
 ?>
