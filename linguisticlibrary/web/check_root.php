<?php
include("includes/applicationTop.php");
$qrs="select *from tbl_dictionary";
$res=$db->select_data($qrs);
$rootname=$_GET['val'];
for($i=0;$i<count($res);$i++)
{
	$root=$res[$i]['word'];
  	if($root==$rootname)
	{
?>
 
		Already exists!!!!!!
		
	 

<?php }
	
} ?>