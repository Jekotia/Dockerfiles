<?php
  include('header.php');
  mysql_set_charset("UTF-8");
  $id1          =$_GET['id'];
  $postname     =$_GET['postname'];
  if(isset($_SESSION['reader_id']))
  $reader       = $_SESSION['reader_id'];
  if(isset($_SESSION['ADMIN_ID']))
  $reader       = $_SESSION['ADMIN_ID'];
  if(isset($_SESSION['author_id']))
  $reader       = $_SESSION['author_id'];
  
   $del_id	    = trim($_GET['del_id']);
   if($del_id!="")
 {
  	
     $sql_delete="DELETE FROM `bookmark` WHERE `id`='$del_id'";
	   $res_delete=$db->delete_data($sql_delete);
		   $msg="Record Deleted Successfully";	
 }
   
  if(isset($_SESSION['reader'])||isset($_SESSION['author']))
  {
   $query        = "select *from user_register where id='$reader'";
   $resquery     = $db->select_data($query);
   $user_id      = $resquery[0]['id'];
  }
  
  if(isset($_SESSION['ADMIN_NAME']))
  {
   $queryt       = "select *from admin where admin_id='$reader'";
   $resqueryt    = $db->select_data($queryt);
   $user_id      = $resqueryt[0]['admin_id'];
  }
  $actual_link  = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];	
  $href         = "$actual_link?link_page=library&id=$id&postname=$postname";
  
  if($postname!='')
  {
   $query       ="insert into bookmark(user_id,post_id,bookmark_url) values('$user_id','$id','$href')";
   $resquery    =$db->insert_data($query);  
  }
 
 ?>

 
<div class="container">
	<div class="main_wrap" style="height:469px;"> 
	<div id="titles">
		
		<div class="article_library">Bookmark Index</div>		
	</div>

	<div class="entry_form">
		 <?php if($msg !="") { ?>
 	
 <span style="color:red"><?php echo $msg; ?></span>
 
 <?php } ?>
<table>
	
	<tr>
	<td class="library_td_top" width="60%">Name</td>
	<td class="library_td_top" width="20%">Author</td>
	<td class="library_td_top" width="20%">Delete</td>
	<!-- <td class="library_td_top" width="20%">Tags</td> -->
 
	</tr>
	
	  <?php  
	  
	  	
     	$querse="select *from bookmark where user_id='$reader' order by id DESC";
		$res   =$db->select_data($querse);
	    
	
		
		for($i=0;$i<count($res);$i++)
		{
		$post        =$res[$i]['bookmark_url'];
		
		$del_id     =$res[$i]['id'];
	    $id          =$res[$i]['post_id'];
		$query       ="select *from add_post where id='$id'";
		$res_query   =$db->select_data($query);
		$postname_k  =$res_query[0]['post_name'];
		$user_id     =$res_query[0]['user_id'];
	    $user_type   =$res_query[0]['user_type']; 
		 
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
		 
	  ?> 
	  <tr>  	
	  
	  <td class="library_td" width="60%"><a href="entry.php?link_page=library&id=<?php echo $id;?>&postname=<?php echo $postname_k;?>"><?php echo   $postname_k;?> </a> </td>
	  <td class="library_td" width="20%"><?php echo  $name; ?> </td>
       <td class="library_td" width="20%"><a href="bookmark.php?del_id=<?php echo $del_id; ?>"><input type="submit" name="delete" value="Delete" /></a></td>
	 <!-- <td class="library_td" width="20%"><?php echo  $tags; ?> </td> -->
 
	</tr>
	 <? }  ?>
</table>
</div>
</div>
</div>
<?php include('footer.php'); ?>
