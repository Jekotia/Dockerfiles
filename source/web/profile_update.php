<?php 
include("header.php"); 
include_once("templateclass/update_manager.php");

$updateObject		= 	new update_class();
$updateManager 		=	new update_manager();
      if (isset($_SESSION['reader']))
      $edit_id=$_SESSION['reader_id'];
	  if (isset($_SESSION['author_id']))
	  $edit_id=$_SESSION['author_id'];
	  if (isset($_SESSION['ADMIN_ID']))
	  $edit_id1=$_SESSION['ADMIN_ID'];
 
      if($edit_id)
	  {
        $sel 	    =	"SELECT * FROM `user_register` WHERE  id='$edit_id'";
	    $res	    =	$db->select_data($sel);
	
        $name		=	trim($res[0]['name']);
		$follow_tags = trim($res[0]['follow_tags']);
	    $id         =   trim($res[0]['id']);
	  }
	  
	  if($edit_id1)
	  {
	  	$sel_user    = "SELECT * FROM `admin` WHERE  admin_id='$edit_id1'";
		$res_user    = $db->select_data($sel_user);
		
		$name        =trim($res_user[0]['admin_name']);
		$follow_tags = trim($res_user[0]['follow_tags']);
		$id          =trim($res_user[0]['admin_id']);
		
	  }
	  
if(isset($_POST['submit']))
{
	$display_name    =$_POST['disp_name'];
	$change_password =$_POST['change_password'];
	$confirm_password=$_POST['confirm_password'];
	$follow_tags     =$_POST['follow_tags'];
	
		
	$updateObject->setPostVar($_POST);
	$err	=	$updateManager->validation($updateObject);
	 
	if(count($err)==0)
	{
		$message	=	$updateManager->update($updateObject, $id); 
		if($message!=' ')
		{
			/* echo $message; */
	    }
		?>
		 
		<script type="text/javascript"> 
			setTimeout(function () {
			window.location.href= "profile_update.php" // the redirect goes here
			},100); // 
		</script> 
	<?php }
}
 
	 
	 
	 
	$open_admin_page = ADMIN_PATH;//Macro is set in config file in the includes folder 
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
<link rel="stylesheet" type="text/css" href="css/style_homepage.css">
<style>
	 
	body{
	margin: 0;
	font-family: Arial;
	font-size: 14px;
	}
	.main_wrap {
	height:469px;
	background-color: #fff;
}
	
	.profile_button1
	{height:50px;
	width: 360px;
	padding: 3px 61px;}
	
	.profile_button5
	{height:70px;
	width: 90px;}
	
	.profile_button7
	{height:70px;
	width: 90px;}
	
	.blk{
		color: black;
	}
	
	
</style>
<?php
   if(isset($_SESSION['author'])||isset($_SESSION['reader'])||isset($_SESSION['ADMIN_NAME']))
  {
	  
	?>
	
<div class="container">
<div class="main_wrap">
<body>
		<div class="profile_title"><?php echo urldecode($name);?>'s Profile</div>		

                            <!-- BEGIN FORM-->
                             
                            <form method="post" name="update">
                             <table class="pro_table" id="tbl1" align="center">
                             	<tr><td class="blk">Display Name</td><td><input type="text" id="disp_name" name="disp_name" placeholder="Display Name" value="<?php echo urldecode($name);?>">
                             	<b>	
                             		<?php 
                             		if($err[0])
									{
										echo $err[0];
									}
                             		
                             		?>
                             	</b>	
                             	</td></tr>
                             	 <tr><td class="blk">Change Password</td><td><input type="password" placeholder="Change Password" name="change_password">
                             	 <b>	
                             	 	
                             	 </b>	
                             	 </td></tr>
                             	 <tr><td class="blk">Confirm Password</td><td><input type="password" placeholder="Confirm Password"  name="confirm_password"/>
                             	 <b>	
                             	 	
                             	 </b>
                             	 </b>	
                             	 </td></tr>
                             	 <tr><td class="blk">Follow these Tags:</td><td><input type="text" placeholder="Tags Name" id="follow_tags" name="follow_tags" value="<?php echo $follow_tags;?>"/>
                             	 <b>	
                             	 	
                             	 </b>
                             	 </td></tr>
                             		
        		                 <tr colspan="2">
        		                 	<td colspan="2"><a href="view_tags.php?follow=<?php echo $follow_tags; ?>"> <input type="button" name="view_tags" value="View Followed Tags" class="profile_button1"/> </a> 
                                        <a href="bookmark.php"> <input type="button" name="view_list" value="View Reading List" class="profile_button1" /> </a>
                                    </td>
                                 </tr>
                                 <?php if(isset($_SESSION['author'])||$_SESSION['ADMIN_ID'])
								 {
								 	?>
								 <tr>
								 	<td colspan="2"><a href="add_new_entry.php"> <input type="button" name="create_entry" value="Create New Entry" class="profile_button1"/> </a> 
                                    <a href="mylibrary.php"> <input type="button" name="view_entry" value="View Your Entries" class="profile_button1"/> </a></td></tr>
                                
                                 <?php } ?> 
                                 <?php if(isset($_SESSION['ADMIN_ID']))
								 {
								 ?>
                                <tr><td colspan="2"><a href="<?php echo $open_admin_page; ?>"> <input type="button" name="adminpanel" value="Enter Admin Panel" class="profile_button5"/> </a> 
                                 <a href="aprove_post.php"> <input type="button" name="approve_post" value="Approve New Posts" class="profile_button5"/> </a></td></tr>
                               
                                <?php  
                                 }
								  ?>
                                <tr><td colspan="2"><input type="submit" name="submit" value="Update" class="profile_button5"> 
                                	 <input type="reset" value="Clear" class="profile_button5" /></td>
                                </tr>
                                </table> 
                             
                            </form>
                            <!-- END FORM-->

</body>
</div>
</div>	
 <?php } 
  
 else 
 {
 	
	header("location:login.php");
     
 }
 ?>
<?php include("footer.php"); ?>
