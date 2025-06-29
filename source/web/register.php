<?php
include('header.php');
include('templateclass/reg_manager.php');     
$class_obj	=	new reg_class();
$reg_obj	=	new reg_manager();
$msg='';
 if($_POST['submit'])
 {
 	$class_obj->setPostVar($_POST);
	$err=$reg_obj->validation($class_obj);
	if(count($err)==0)
	{
		$msg=$reg_obj->register($class_obj);
		$msg = "You Are Registered Successfully";
	}
 }  
 $user_type	=	$_POST['user_type'];
 $name		=	$_POST['disp_name'];

 $email		=	$_POST['email'];
 $password	=	$_POST['password'];
 $confirm_password=$_POST['cpass'];
 $status	=	$_POST['status'];
 
 $queryt	=	"select *from graphics where id=1";
 $res  		=	$db->select_data($queryt);
 $image 	=	$res[0]['frontpage_background'];	
?>
<link rel="stylesheet" type="text/css" href="css/style_homepage.css">
<style>
	 
	body{
	margin: 0;
	font-family: Arial;
	font-size: 14px;
	background-color: #fff !important;
	}
	.pro_login {
	color: #333;
	padding-top: 40px;
	}
	.reg_div
	{
		color:green;
		text-align:center;
	}
</style>
</head>
<div class="container">
<div class="main_wrap" style="height:469px;">
<div class="profile_title">Register</div>
		<div class="reg_div"><?php echo $msg; ?></div>
		<form method="post" name="login" id="login" >
			<table class="pro_login" align="center">
			<tr>
		 		<td><b>User Type</b></td>
		 		<td>
		 			 <input type="radio" id="user_type" name="user_type" value="author"/>Author  
			 		 <input type="radio" id="user_type" name="user_type" value="reader"/>Reader
			 		<b>  
			 		 <?php 
			 		 if($err[6])
					 {
					 	echo $err[6];
					 }
			 		 ?>
			 		 </b>
		 		 </td>
		 	</tr>
		 	<tr>
		 		<td><b>Status</b></td>
		 		<td>
		 			<input type="radio" id="status" name="status" value="Y"/>Active
                     <input type="radio" id="status" name="status" value="N"/>Deactive
                     <b>
                  	<?php 
                    if($err[7])
					 {
					 	echo $err[7];
					 }
					?>
					</b>
		 		</td>
		 	</tr>
		 	<tr>
		 		<td><b>Display Name</b></td>
		 		<td><input type="text" id="disp_name" name="disp_name" placeholder="Display Name" >
			 		<span>
			 		<b>	
			 		<?php if($err[0])
					{
						echo $err[0];
					}
					?>
					</b>
					</span>
		 		</td>
		 	</tr>
		 	<tr>
		 		<td><b>Email</b></td>
		 		<td><input type="text" id="email" name="email" placeholder="Email">
			 		<span>
			 		<b>	
			 		<?php if($err[1])
					{
					    echo $err[1];	
					}
					?>
					</b>
					</span>
		 		</td>
		 	</tr>
		 	<tr>
		 		<td><b>Password</b></td>
		 		<td>
		 			<input type="password" name="password" id="password" placeholder="Password"/>
			 		<span><b>
			 			<?php 
			 			if($err[2])
						{
							echo $err[2];
						}
			 			?>
			 			</b>
			 		</span>
		 		</td>
		 	</tr>
		 	
		 	<tr>
		 		<td><b>Confirm Password</b></td>
		 		<td>
		 			<input type="password" name="cpass" id="cpass"  placeholder="Confirm Password"/>
			 		<span><b>
			 		<?php
			 		 if($err[3])
					 {
					 	echo $err[3];
					 }
			 		?>
		 		</b>
		 	</span>	
		 	</td></tr>
		 	
		 	<tr><td colspan="2"><input type="submit"   name="submit" value="Register" style="margin-left: 311px;"/>  <input type="reset" value="Clear"/></td></tr>				
			</table>
		</form>

</div>
</div>	

<?php 
include('footer.php');
?>