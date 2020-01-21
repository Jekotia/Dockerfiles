<?php
include('includes/connectdb.php');
$getmenu_id     = $_GET['menu_id'];
$sel_name       = $_GET['sel_name']; 
$curr_seldiv_id = $_GET['curr_seldiv_id'];
$sel_id = "main_select_menu_".$curr_seldiv_id;
$get_multiroots   = "SELECT * FROM `tbl_menu` WHERE `parent_id`='$getmenu_id'";
 
$get_multirootres = mysql_query($get_multiroots);
$tot_roots        = mysql_num_rows($get_multirootres);
if ($tot_roots>0){
?>
	<select name="<?php echo $sel_name; ?>" id="<?php echo $sel_id; ?>" onchange="set_new_menu(this.value,'<?php echo $sel_id;  ?>',this.name)">
		<option value="">Select Category</option>
		<?php
	while($info = mysql_fetch_array($get_multirootres))
	{
		echo $menu_id    = $info['id'];
		echo $menu_title = $info['menu_title'];
		 ?>
	        		<option value="<?php echo $menu_id; ?>"><?php echo $menu_title; ?></option> 
		 <?php
	}
      ?>
      </select>
      <?php
}//if tot roots
?>
