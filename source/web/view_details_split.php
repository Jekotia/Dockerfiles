<?php
include('includes/applicationTop.php');
$sql="select * from charset";
$query=$db->select_data($sql); 
$id=$_GET['id'];
?>
<script type="text/javascript">
function f1(val)
{
    var curr_index = '<?php echo $id; ?>';
    parent.document.getElementById('syn_cls_'+curr_index).value+=val;
    return parent.hs.refreshparentObject(this);	
}
</script> 
 <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<table class="table table-striped table-bordered dataTable" id="sample_1" aria-describedby="sample_1_info">
    <thead>
       <tr role="row">
       	  <th class="align_center_t sorting_disabled" role="columnheader" rowspan="1" colspan="1" aria-label="description" style="text-align: center;">Special Characters</th>
       </tr>
    </thead>
    <tbody role="alert" aria-live="polite" aria-relevant="all">
    	
    		<?php 
    		
    		for($name=0;$name<count($query);$name++)
			 {
			   $charname =$query[$name]['char_name'];
			   
			 ?>
			 <tr class="gradeX odd">
             <td><input type="button" value="<?php echo $charname; ?>" onclick="return f1(this.value)"> </td>
          
             </tr>
          <?php } ?>
        
    </tbody>
</table>
