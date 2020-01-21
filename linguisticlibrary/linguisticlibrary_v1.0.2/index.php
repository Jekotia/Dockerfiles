<?php
include('includes/applicationTop.php');
include("frontpage_header.php");

$queryt =	"select *from graphics where id=1";
$res	=	$db->select_data($queryt);
$image 	=	$res[0]['frontpage_background'];
 ?>
<html> 
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>Custom PHP Post</title>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<link rel="shortcut icon" href="/favicon.png">
	<link rel="stylesheet" type="text/css" href="css/style_homepage.css">
	
	
	
<script>
function isNumericKey(e)
{
var  val=document.getElementById('search').value;
if (window.event) 
  {
   var charCode = e.keyCode; 
  }
else 
  { 
  var charCode = e.which;
  }
 if(charCode==13)
 {
  $("#lookup").trigger('click');
 }
} 
</script>
	<style>
		 
		body{
		margin: 0;
		font-family: Arial;
		font-size: 14px;
			background:url(admin/upload/<?php  echo $image;?>) no-repeat   top center;
		}
		p{
			margin-left: 20px;
			margin-top: 0px!important;
		}
	.headerbar
	{
		display: none;
	}

	</style>
</head>
<div class="container">
	<div class="main_wrap" style="height:469px;">
	<body>
		<script>
			function search_val()
			{
				var val=	document.getElementById('search').value;
				if(val == "")
				{
					document.getElementById("search").placeholder = "Please Enter value";					
				}
				else
				{
					window.location.href='search_library.php?search_type='+val;
				}
			}
		</script>
		
			<div class="row-fluide">	
			<div class="search_wrapper">
			<div class="sitename"><?php echo $SITE; ?></div>
			<div class="search_item1"><input type="text" name="search" id="search" onkeypress="isNumericKey(event)" placeholder="Search Library" ></div>			
			<a id="lookup"  onclick="return search_val()"><div class="search_item2"><p>LOOKUP</p></div></a>			
			<a id="viewall"  href="library.php"><div class="search_item3"><p>VIEW ALL</p></div></a>
			<a id="recent" href="search_library.php?acc_type=Public&value=recent"><div class="search_item4"><p>RECENT</p></div></a>
			</div>
			</div>
		
		
		</div>
</div>
<?php include("frontpage_footer.php");?>

