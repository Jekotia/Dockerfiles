<?php
include_once('includes/applicationTop.php');

$val 		= $_GET['val'];
$menu_id 	= $_GET['menu_id'];
$get_menu  	= "SELECT * FROM `tbl_menu`  WHERE `id` IN ($menu_id)";
$get_menu_info    = $db->select_data($get_menu);
$get_menu_count = count($get_menu_info);

?>
<style>
	td
	{
		color: black;
	}
	
</style>
<table>

	<tr>
		<td><?php echo ucwords($val);?>
			<?php echo "<hr>";?>
		</td>		
	</tr>
	<?php
for ($i=0; $i < $get_menu_count; $i++) 
{ 
	$menu_title 	= $get_menu_info[$i]['menu_title'];
	$abbrevation 	= $get_menu_info[$i]['abbrevation'];
	$note 			= $get_menu_info[$i]['note'];
	?>
	
	<tr>
		<td><b><?php echo $menu_title;?></b></td>		
	</tr>
	<tr>		
		<td><?php echo $abbrevation;?></td>		
	</tr>
	<tr>		
		<td><?php echo $note;?></td>
	</tr>
	<?php
}

?>
</table>

