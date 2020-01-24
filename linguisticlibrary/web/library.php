<?php
include 'header.php';
//mysql_set_charset("UTF-8");
date_default_timezone_set('UTC'); 
 
 
if(isset($_SESSION['author_id']))
{
$id=$_SESSION['author_id'];
}  


$value = $_GET['value'];
if($value=='recent')
{
	if($id!='')
	{
		$query ="SELECT * FROM `add_post` ORDER BY id DESC";
	}
	else 
	{
		$query ="SELECT * FROM `add_post` WHERE `accessibility`!='Private' AND `accessibility`!='Unlisted' ORDER BY id DESC";
	} 
	$res=$db->select_data($query);
} 
else 
{
//$query="select * from add_post WHERE `accessibility`!='Private'";
    if($id!='')
	{
		$query ="SELECT * FROM `add_post` ";
	}
	else 
	{
		$query ="SELECT * FROM `add_post` WHERE `accessibility`!='Private' AND `accessibility`!='Unlisted'";
	} 
$res=$db->select_data($query);
//$is_approve = $res[0]['is_approve'];
}
?>
<?php
 $sql_query	 =	"select *from graphics where id=1";
 $res_sql  	 =	$db->select_data($sql_query);
 $image 	=	$res_sql[0]['frontpage_background'];
?>
<style>
	 
	body{
	margin: 0;
	font-family: Arial;
	font-size: 14px;
	}
	.main_wrap
	{height:469px;}
</style>
<div class="container">
	<div class="main_wrap2">

	<div id="titles">
		<div class="article_library">Library Index</div>		
	</div>

	<div class="entry_form">
		<table width="100%">
			<tr><td class="library_td_top" width="40%">Name</td>
				<td class="library_td_top" width="20%">Author</td>
				<td class="library_td_top" width="20%">Date Created</td>
				<td class="library_td_top" width="20%">Last Modify</td>
				<td class="library_td_top" width="20%">Tags</td>
				
			</tr>
			 
		    <?php 
				$tot_res = count($res);
				for($i=0;$i<$tot_res;$i++)
				{
					$postname      = $res[$i]['post_name'];
					$date          = $res[$i]['added_date'];
				    $date_e        = date("d F Y",strtotime($date));
					 
					$tags          = $res[$i]['search_tags'];
					$get_user_type = $res[$i]['user_type'];
					$get_userid    = $res[$i]['user_id'];
					$is_approve    = $res[$i]['is_approve'];
					$modify_date   = $res[$i]['modify_date'];
					if($modify_date!='0000-00-00')
					$date_m        = date("d F Y",strtotime($modify_date));
					$id            = $res[$i]['id'];	
					$authorstr     = 'author';		
					$adminstr      = 'admin';	
				
		
		$sel_qry   = "SELECT * FROM `add_post` WHERE `is_approve`='Y' ORDER BY id DESC";
		
        if ($get_user_type=="author")
		   $chk_approve = "SELECT `approval_required` FROM `user_register` WHERE `id`='$get_userid'";
        else
        if ($get_user_type=="admin")
		   $chk_approve = "SELECT `approval_required` FROM `admin` WHERE `admin_id`='$get_userid'";	
	
		$approve_res = $db->select_data($chk_approve);
		$approve_req = $approve_res[0]['approval_required'];
		//echo "Approval Required= $approve_req Is Approve = $is_approve";
	    if($approve_req=='N' || $is_approve=="Y")
		{
			$is_approve_name = $db->select_data($sel_qry);
			$show_name       = $is_approve_name[0]['post_name'];
		
	    $auth_qry  = "SELECT name FROM user_register WHERE id='$get_userid'";
		$admin_qry = "SELECT admin_name FROM admin WHERE admin_id='$get_userid'";
		if ($get_user_type=="author")
		{		
		   $authuser_name    = $db->select_data($auth_qry);
		   $show_name        = $authuser_name[0]['name'];			
		}
		else		
		if ($get_user_type=="admin") 
		{
			$adminuser_name    = $db->select_data($admin_qry);
			$show_name         = $adminuser_name[0]['admin_name'];
		}			
													
	?>			 
			     <tr>
			     <td class="library_td" width="40%"> <a href="entry.php?link_page=library&id=<?php echo $id;?>&postname=<?php echo $postname;?>"><?php echo $postname;?></a> </td> 
			     <td class="library_td" width="20%"><?php echo  urldecode($show_name); ?> </td>
			     <td class="library_td" width="20%"><?php echo  $date_e; ?> </td>
			     <td class="library_td" width="20%"><?php echo  $date_m; ?> </td>
			     <td class="library_td" width="20%"><?php echo  $tags; ?> </td>
			     </tr>
							
				<?php	
				}
		}
			
			?>
			
			 </table>
	</div>
 
</div>
</div>
<?php  include('footer.php'); ?>