<?php
include('includes/connectdb.php');
$getmenu_id = $_GET['menu_id'];


$get_multiroots   = "SELECT * FROM `tbl_menu` WHERE `parent_id`='$getmenu_id'";
$get_multirootres = mysql_query($get_multiroots);
$tot_roots        = mysql_num_rows($get_multirootres);
if ($tot_roots>0){
?>
	<select name="morpho[]" onchange="set_new_menu(this.value,0)">
		<option value="">Select Category</option>
		<?php
	while($info = mysql_fetch_array($get_multirootres))
	{
		$menu_id    = $info['id'];
		$menu_title = $info['menu_title'];
		 ?>
	        		<option value="<?php echo $menu_id; ?>"><?php echo $menu_title; ?></option> 
		 <?php
	}
      ?>
      </select>
      <?php
}//if tot roots
?>
