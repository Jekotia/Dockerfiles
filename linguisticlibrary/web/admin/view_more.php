<?php
$root="../";
include($root."includes/applicationTop.php");

 $id=$_GET['id']; 
 $sql="SELECT * FROM `tbl_dictionary` where id='$id'";
$query=$db->select_data($sql);
 
  $word =$query[0]['word'];
  $ipa =$query[0]['ipa'];
  $part =$query[0]['part_of_speech'];
  $meaning =$query[0]['meaning'];
  $source =$query[0]['source'];
  $sound =$query[0]['sound'];
	
?>
 <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<table class="table table-striped table-bordered dataTable" id="sample_1" aria-describedby="sample_1_info">
    <thead>
       <tr role="row">
       	  <th class="align_center_t sorting_disabled" role="columnheader" rowspan="1" colspan="6" aria-label="description" style="text-align: center;">Details</th>
       </tr>
    </thead>
    <tbody role="alert" aria-live="polite" aria-relevant="all">
    	<tr class="gradeX odd">
          <td><?php echo $id; ?></td>
          
        </tr>
    </tbody>
</table>