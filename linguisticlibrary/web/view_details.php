<?php
//include('includes/applicationTop.php');
include('includes/connectdb.php');
mysql_set_charset("UTF-8");
$sql="select * from charset";
$query=mysql_query($sql); 
$id=$_GET['id'];
?>
<script type="text/javascript">
function f1(val)
{
    var curr_index = '<?php echo $id; ?>';
    parent.document.getElementById('synd_textcls_'+curr_index).value+=val;
    return parent.hs.refreshparentObject(this);	
}
</script> 
<style>
	.sp_sym
	{width:600px;}
	
	.hi_techg {
	width: 50px;
	background-color: #eee;
	border:1px solid #fff;
	padding: 7px;
	float: left;
	}
</style>
 <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<h3><center>Special Symbol</center></h3>
    		<div class="sp_sym">
    		<?php 
    		
    		while($query1=mysql_fetch_array($query))
			{
			   $charname =$query1['char_name'];
			
			   
			 ?>
			<div class="hi_techg">
            <input type="button" value="<?php echo $charname; ?>" onclick="return f1(this.value)" style="width: 48px;cursor:pointer;background-color:#fff;border:1px solid #aaa;float: left;"> 
          </div>
             
          <?php } ?>
        
   
</div>