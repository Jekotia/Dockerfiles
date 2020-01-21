<?php
include 'header.php';
include('includes/applicationTop.php');
 $follow_tag = $_GET['follow'];
 $follow_tag = explode(",", $follow_tag);
  $follow_tag = implode(",", $follow_tag);

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
 $search_tags1= explode(",",$follow_tag);
 $query3 ="SELECT * FROM `add_post` WHERE";
 
 for($i=0;$i<count($search_tags1);$i++)
 {
     $val =$search_tags1[$i];
     $query3 .= " `search_tags` LIKE '%$val%'";
	if($i<count($search_tags1)-1)
	{
		$query3 .=" OR";
	} 
 }
  
// echo $query3; 
 $res	    = $db->select_data($query3);

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
	.main_wrap
	{
		height:469px;
	}
</style>
 
</head>
<div class="container">
	<div class="main_wrap">
	<body>
	<div id="titles">
		<div class="article_library">Library Index</div>		
	</div>

	<div class="entry_form">
		<table width="100%">
			<tr>
				<td class="library_td_top">Script Title</td>
				<td class="library_td_top">Tag Name</td>
				<td class="library_td_top">Author(s)</td>
				
				</td>
		    <?php if($res)
			{
				for($i=0;$i<count($res);$i++)
				{
					$id		  	 = $res[$i]['id'];
					$user_id	 = $res[$i]['user_id'];
					$postname	 = $res[$i]['post_name'];
					$tagname	 = $res[$i]['search_tags'];
					$is_approve  = $res[$i]['is_approve'];
				    $user_type   = $res[$i]['user_type']; 
		 
		            if($user_type=='author')
		           {
		             $queryf    ="select *from user_register where id='$user_id'";
		             $resf      =$db->select_data($queryf);
		             $name      =$resf[0]['name'];
		           }
		 
		           if($user_type=='admin')
		          { 
		            $queryf    ="select *from admin where admin_id='$user_id'";
		            $resf      =$db->select_data($queryf);
		            $name      =$resf[0]['admin_name'];
		          } 
		
		   
				 if($tagname!='')
				 { 
				?>
					 
				?>			 
			     <tr>			     	
			     	<td class="library_td"> <a href="entry.php?link_page=library&id=<?php echo $id;?>&postname=<?php echo $postname;?>"><?php echo $postname;?></a> </td>
			     	<td class="library_td"><?php echo $tagname;?> </td>	
			     	<td class="library_td"><?php echo $name;?> </td>
			    	
			    	
			     </tr>
							
				<?php	
				 }
				}				
			}
			?>
			
			 </table>
	</div>
 </body>
</div>
</div>
<?php include('footer.php');?>