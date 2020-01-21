<?php
include 'header.php';
include('includes/applicationTop.php');

$approve     =	$_GET['approve'];
$disapprove  =	$_GET['disapprove'];

if($approve!='')
{
	$sql_active="update `add_post` set is_approve='Y' where id='$approve'";
	$sql_res=$db->update_data($sql_active);
	if(count($sql_res)>0)
	{
		$msg="User Approved Successfully";
	} 
}

if($disapprove!='')
{
	$sql_deactive="update `add_post` set is_approve='N' where id='$disapprove'";
	$sql_res1=$db->update_data($sql_deactive);
	if(count($sql_res1>0))
	{
		$msg="User Disapproved Successfully";
	}
}

if($msg !="") 
{ ?>
	<!-- <div class="alert alert-success">
       <button class="close" data-dismiss="alert">×</button>
       <strong><?php echo $msg; ?></strong>
    </div> -->
	<?php 
 ?>
 <script type="text/javascript"> 
		setTimeout(function () {
		window.location.href= "aprove_post.php" // the redirect goes here
		},1000); // 2 seconds
	</script>
<?php } 	

//$query="select * from add_post where user_id='$id'";
$query	="SELECT * FROM `add_post` ORDER BY id DESC";
$res	=$db->select_data($query);


?>
<?php
 $sql_query	 =	"select * from graphics where id=1";
 $res_sql  	 =	$db->select_data($sql_query);
 $image 	 =	$res_sql[0]['frontpage_background'];
?>
<html>
<head>
<style>
	 
	body{
	margin: 0;
	font-family: Arial;
	font-size: 14px;
	background:url(admin/upload/<?php  echo $image;?>) no-repeat   center;
	}
</style>
 
</head>
<div class="container">
	<div class="main_wrap" style="height:469px;">
	<body>
	<div id="titles">
		<div class="article_library">Library Index</div>		
	</div>

	<div class="entry_form">
		<table width="100%">
			<tr>
				<td class="library_td_top">Script Title</td>
				<td class="library_td_top">Author(s)</td>
				<td class="library_td_top">Approve/Disapprove</td>
				</td>
		    <?php if($res)
			{
				for($i=0;$i<count($res);$i++)
				{
					$id		  	 = $res[$i]['id'];
					$user_id	 = $res[$i]['user_id'];
					$postname	 = $res[$i]['post_name'];
					$is_approve  =	$res[$i]['is_approve'];
					$sql_qry	 =	"SELECT * FROM `user_register` WHERE `id`='$user_id'";
					$res_sel  	 =	$db->select_data($sql_qry);
					$user_name   =	$res_sel[0]['name'];
				
					 
				?>			 
			     <tr>			     	
			     	<td class="library_td"> <a href="entry.php?link_page=library&id=<?php echo $id;?>&postname=<?php echo $postname;?>"><?php echo $postname;?></a> </td>
			     	<td class="library_td"><?php echo $user_name;?> </td>
			    	<td class="library_td">
			    	<?php 
			    	if($is_approve=='Y') 
					 {
				   ?>
				   <a href='aprove_post.php?disapprove=<?php echo $id?>' title='Disapprove'  >
				   	<input type="button" value="Disapprove">
			         </a>
			       <?php   
					 }
					 else
					 {
			       ?>
			        <a href='aprove_post.php?approve=<?php echo $id?>' title='Approve'>
			        <input type="button" value="Approve">
					 </a>
					<?php
						}
					?>
			    	
			    	</td>
			    	
			     </tr>
							
				<?php	
				}
				
			}
			?>
			
			 </table>
	</div>
 </body>
</div>
</div>
<?php include('footer.php');?>