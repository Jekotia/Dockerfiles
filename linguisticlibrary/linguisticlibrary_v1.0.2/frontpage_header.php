<?php
header ('Content-type: text/html; charset=utf-8');
ob_start();
session_start();
include_once('includes/applicationTop.php'); 
 
 
	  $queryt = "select *from graphics where id=1";
	  $res	  = $db->select_data($queryt);
	  $img	  = $res[0]['banner_background']; 
	  $fevicon= $res[0]['favicon'];
	  $image  = $res[0]['frontpage_background'];	
	?>
	<?php 
      $id      =$_GET['id'];
	  $postname=$_GET['postname'];
		 
        ?>
<html><head>
<!--<meta http-equiv="content-type" content="text/html; charset=windows-1252">-->
<!--<meta http-equiv="content-type" content="text/html; charset=UTF-8">-->
<title> <?php echo $SITE; ?></title>
<link rel="shortcut icon" href="/favicon.png">
<link rel="stylesheet" type="text/css" href="css/style_1.css">
<link rel="stylesheet" type="text/css" href="css/style_2column.css">
<link rel="stylesheet" href="css/style.css" />
<!-- <link rel="stylesheet" href="css/bootstrap/bootstrap.css" />
<link rel="stylesheet" href="css/bootstrap/bootstrap-responsive.css" /> -->
<link rel="shortcut icon" href="admin/upload/<?php echo $fevicon;?>" type="image/x-icon">
<link rel="icon" href="admin/upload/<?php echo $fevicon;?>" type="image/x-icon">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<link rel="stylesheet" type="text/css" href="css/style_homepage.css">



<style>
.headerbar {
float: left;
width: 100%;
height: 130px;
background-color: #606262;
background-image: url(admin/upload/<?php echo $img;?>);
background-repeat: no-repeat;
background-position: top left;
}
	
	body{
	margin: 0;
	font-family: Arial;
	font-size: 14px;
	background:url(admin/upload/<?php  echo $image;?>) no-repeat   center;
	}
	.navbar-nav {
	background-color: black;
	padding: 10px 20px 10px 10px;
	border-radius: 5px;
}
	</style>

<script type="text/javascript">
	function bookmark()
	{
		 
		var val ='<?php echo $id; ?>';
		var val1='<?php echo $postname;?>';
		 
		 
	}
	
</script>
	
</head>

<body>

<div class="main_wrap">
	<div class="headerbar">
		<?php
							 $sql="SELECT `website_name` FROM `graphics` where id=1";
							 $res =$db->select_data($sql);
							 			 	 
							  $name =$res[0]['website_name'];	
							 ?>
		<div class="website_name"><font color="white"><?php echo $name; ?></font></div>
		<?php
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
        
       <div class="nav" style="float: right;margin-right: 24px;">
        <ul class="nav navbar-nav">
          
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
   	   	 Profile:    
		 <li class="active"><div><a href="profile_update.php" style="color:#907ED1;"><?php echo  $user_id." ";?></a> | 
		 <a href="logout.php" class="log" id="log"><font color="white">Logout</font></a></div></li>
		  	<?php } 
		  	else
		  	{
		  		  //header("location:login.php");
				   ?><a href="login.php">Login</a><?php 
			}   ?></li>          
     </ul></div> 
     <?php
		//$query="select *from navigation_menu order by page_order";
		$query="select *from navigation_menu where is_page_display='Y' order by page_order";
		$query1=$db->select_data($query);
	
		?>
		<div class="menu_m">
		<?php 
	    for($i=0;$i<count($query1);$i++)
		{	
		?>	
		<a class="menubtn" href="<?php echo $query1[$i]['url']?>"><?php echo $query1[$i]['page_name'];?></a>&nbsp;
		<?php } ?>	
			
		</div>
	</div>
	</div>