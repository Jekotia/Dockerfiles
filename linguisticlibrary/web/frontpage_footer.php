<?php 
					global $db;
					$query="select *from graphics";
					$query1=$db->select_data($query);
					$footer_html1=stripslashes(trim($query1[0]['footer_html1']));
					$footer_html2=stripslashes(trim($query1[0]['footer_html2']));
					$footer_html3=stripslashes(trim($query1[0]['footer_html3']));
				
					
if(isset($_SESSION['reader']))
{
$user_id=$_SESSION['reader'];
$readerid=$_SESSION['reader_id'];
}
if(isset($_SESSION['author']))
{
	  $user_id=$_SESSION['author'];
}
if(isset($_SESSION['ADMIN_NAME'])&&isset($_SESSION['ADMIN_ID']))
{
	$user_id=$_SESSION['ADMIN_NAME'];
	$user   =$_SESSION['ADMIN_ID'];
}					
					
?>

<div class="body_3">
<div class="footer_wrapper">
<div class="footer_column1"><p class="footer_text_1"><?php	echo $footer_html1; ?></p></div>
<div class="footer_column2"><p class="footer_text2"><?php	echo $footer_html2; ?></p></div>
<div class="footer_column3" style="width:200px;"><p class="footer_text3">
	<ul class="nav navbar" style="margin-left: -50px;">
          
		  <li <?php if($page_nm=="register"){?>class="active"<?php } ?>><?php if($user_id==""){?><a href="register.php">Sign Up</a><?php } ?></li>
		  <li <?php if($page_nm=="login"){?>class="active"<?php } ?>> 
		   
		  		<?php   if($user_id!=""||$user!=""){
		  	?>
		  
		  	<?php 
		  	$name= basename($_SERVER['PHP_SELF']);
		  	if($name=="entry.php")
		  	{
		  	?>   
		  	<a href="bookmark.php?id=<?php echo $id?>&postname=<?php echo $postname;?>" onclick="return bookmark()">Bookmark |</a>
           <?php } ?>	
   	   	 My Profile:   
		 <li class="active"><div><a href="profile_update.php" style="color:#907ED1;"><?php echo  $user_id." ";?></a> | 
		 <a href="logout.php" class="log" id="log"><font color="white">Logout</font></a></div></li>
		  	<?php } 
		  	else
		  	{
		  		  //header("location:login.php");
				   ?><a href="login.php">Login</a><?php 
			}   ?></li>          
     </ul>
	
	<?php	echo $footer_html3; ?></p></div>
</div>

</div>
	