<?php
include('includes/connectdb.php');
$sql="select * from tbl_alphabet where is_active='Y'";
$query=mysql_query($sql); 
$id=$_GET['id'];
?>
<script type="text/javascript">
function f1(val,alphaimg)
{  
	// alert(val);
    var curr_index = '<?php echo $id; ?>';
    parent.document.getElementById('alpha_cls_'+curr_index).value+=val;
    parent.document.getElementById('alpha_image_cls_'+curr_index).value+=alphaimg;
    return parent.hs.refreshparentObject(this);	
}
</script> 
 <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<h3><center>Alphabet</center></h3>
<div style="width:600px;">
    		<?php 
    		
    		while($query1=mysql_fetch_array($query))
			 {
			   $charname =$query1['alpha_name'];
			   $img      =$query1['image'];
			   
			 ?>
		   <div style="width: 50px;background-color: #eee;border:1px solid #fff;padding: 7px;float: left;">
           <center><a href="#" onclick="return f1(<?php echo $charname?>)">  
           <img src="admin/upload/<?php echo $img;?>" width="10" height="20"/>
          </a></center>
           <input type="button" value="<?php echo $charname;?>" onclick="return f1(this.value,'<?php echo $img; ?>')"  style="width: 48px; cursor:pointer;background-color:#fff;border:1px solid #aaa;float: left;"> 
           
           </div>
        
        <?php } ?>
</div>
