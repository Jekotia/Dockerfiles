<?php
   include('includes/applicationTop.php');
   $id=$_GET['id'];
   $query="select *from add_new_entry where  id='$id'";
   $res_query=$db->select_data($query);
   
    $menuid=$res_query[0]['menu_id'];  
?>

 
	<table border="2">
   	<tr><td><b>----------Menu--------</b></td></tr>
	<?php 
	$menuid_e=explode(',',$menuid);
	for($i=0;$i<count($menuid_e);$i++)
	{
	 $qwe="select *from tbl_menu where id='$menuid_e[$i]'";
	 $res=$db->select_data($qwe);
   ?>
   <tr>
   		<td><?php echo $menu_title=$res[0]['menu_title'];?></td>

 	</tr>
<?php	
	
	}
	?>
   </table>	
 

 