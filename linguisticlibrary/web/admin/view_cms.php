<?php
$root="../";
include($root."includes/applicationTop.php");

$id=$_GET['id'];
$sql="select * from manage_cms where id=$id";
$query=$db->select_data($sql);
 
$message =$query[0]['cms_desc'];
	
?>
 <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<table class="table table-striped table-bordered dataTable" id="sample_1" aria-describedby="sample_1_info">
    <thead>
       <tr role="row">
       	  <th class="align_center_t sorting_disabled" role="columnheader" rowspan="1" colspan="1" aria-label="description" style="text-align: center;">Description</th>
       </tr>
    </thead>
    <tbody role="alert" aria-live="polite" aria-relevant="all">
    	<tr class="gradeX odd">
          <td><?php echo $message; ?> </td>
        </tr>
    </tbody>
</table>