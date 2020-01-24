<?php
include('includes/applicationTop.php');
include('header.php');
if(isset($_SESSION['reader_id']))
{
$id=$_SESSION['reader_id'];
}     
 if(isset($_SESSION['author_id']))
 {
 	$id=$_SESSION['author_id'];
 }

 if(isset($_SESSION['ADMIN_ID']))
 {
 	$id=$_SESSION['ADMIN_ID'];
 } 
 
$query="select * from add_post where user_id='$id'";
$res=$db->select_data($query);

?>

<html>
<head>
	
</head>	
<body>
<table border="4">
	<th>Sr.No</th>
	<th>POST</th>
	<?php if($res)
	{
		for($i=0;$i<count($res);$i++)
		{
			$postname=$res[$i]['post_name'];
			  $id=$res[$i]['id'];
		?>	
	<tr><td><b><?php echo $i+1;?></b> </td><td><b><?php echo $postname;?></td></b></tr>	
	<tr><td><a href="entry_demo.php?id=<?php echo $id;?>" target="_blank">  ENTRY DEMO</a></td></tr>
			
	<?php	
		}
		
	}
	?>
	
</table>
	
</body>	
</html>