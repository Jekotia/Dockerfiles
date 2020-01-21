<?php
include("includes/applicationTop.php");
 $word=$_GET['word'];

$qrs = "SELECT Root FROM tbl_dictionary WHERE Root = '$word' LIMIT 1";
$res=$db->select_data($qrs);
$num =count($res);
// for($i=0;$i<count($res);$i++)
// {
	// $root=$res[$i]['word'];
  	// if($root==$word)
	// {
?>
 
	<?php	echo $num;
	?>
		
	 

<?php //}
	
//} ?>




