<?php header ('Content-type: text/html; charset=utf-8'); ?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

<?php
//include('../includes/connectdb.php');
include("../includes/applicationTop.php");
$id			  = $_GET['id'];
$edit_id 	  = $_GET['edit_id'];
$curent_id1   = $_GET['curent_id'];
$current_menu = $_GET['current_menu'];
if($current_menu == 'submenu')
{
	$curent_id = $curent_id1;
}else
if($current_menu == 'menu')
{
	$curent_id = $id;
}
if($edit_id !="")
{
	
	$qry1 ="SELECT * FROM `tbl_menu` WHERE id='$edit_id'";
	$sel = $db ->select_data($qry1);
	$sub_menu_name 	= $sel[0]['menu_title'];
 	//$cnt_sub_name 	= trim(count($sub_menu_name));
  	 $abbr 	  		= $sel[0]['abbrevation'];
     $note       	= $sel[0]['note'];
}
else {
	$sub_menu_name 	= $_POST['sub_menu_name'];
 	$cnt_sub_name 	= trim(count($sub_menu_name));
 	$abbr 	  		= trim($_POST['abbr']);
    $note       	= addslashes(trim($_POST['note']));
}
if(isset($_POST['submit']))
{
  //$submenu = $_POST['is_submenu'];  
	$sub_menu_name 	= $_POST['sub_menu_name'];
 	$cnt_sub_name 	= trim(count($sub_menu_name));
    $abbr 	  		= trim($_POST['abbr']);
    $note       	= addslashes(trim($_POST['note']));
  
 	$is_submenu 	= $_POST['is_submenu'];
   if($sub_menu_name != "")
   {       
     for($k=0;$k < $cnt_sub_name;$k++)
	 {	     
				if($edit_id!="")
				{
				 $sql_update =	"UPDATE `tbl_menu` SET `menu_title`='$sub_menu_name[$k]',`parent_id`='$curent_id',`abbrevation`='$abbr',`note`='$note' WHERE id='$edit_id'";
					
				//$sql_update = "INSERT INTO  tbl_menu(`menu_title`,`parent_id`,`abbrevation`, `note`)VALUES('$sub_menu_name[$k]','$curent_id','$abbr','$note')";				
			  	$res_update	= $db->update_data($sql_update);				
				$msg 		= "Menu updated successfully";
				}
				else
				{
					$sql_insert = "INSERT INTO  tbl_menu(`menu_title`,`parent_id`,`abbrevation`, `note`)VALUES('$sub_menu_name[$k]','$curent_id','$abbr','$note')";				
				  	$res_insert	= $db->insert_data($sql_insert);
					$inc_id 	= mysql_insert_id();
					$msg 		= "Menu inserted successfully";									
				}				
      }     
	?>	
	<script>
	 	//return parent.hs.refreshparentObject(this);	 // close popup		
	 	window.parent.location.reload();
	</script> 	
	<?php	
  }
}
?>
<script>
function add_child() 
{	
	//$('#sub_menu_name').clone().appendTo('#clone_td');	
}		
</script>
<form name="menu_form" method="post">				
					<?php if($msg) 
                	{ ?><div class="alert alert-success">
                           <button class="close" data-dismiss="alert">×</button>
                           <strong id="msg"><?php echo $msg; ?></strong>
                        </div>
                    	
                    	<?php 
					} ?>
<table class="table table-striped table-bordered dataTable" id="sample_1" aria-describedby="sample_1_info">
   
	    <tbody role="alert" aria-live="polite" aria-relevant="all">
	    	<tr class="gradeX odd">
	         <td style="width:50%">Sub Menu</td>
	         <td id="clone_td" style="width: 50%;"><input type="text" name="sub_menu_name[]"  id="sub_menu_name" value="<?php echo $sub_menu_name;?>"/></td>
	        </tr>
	         <tr class="gradeX odd">
	         <td style="width:50%">Abbreviation</td>
	         <td  style="width: 50%;"><input type="text" name="abbr"  id="abbr" value="<?php echo $abbr;?>"/></td>
	        </tr>
	        <tr class="gradeX odd">
	         <td style="width:50%">Note</td>
	         <td  style="width: 50%;"><textarea name="note" id="note"><?php echo $note;?></textarea></td>
	        </tr>
	        <!-- <tr><td><lable>Has sub-menu?</lable></td></tr> -->
	        <!-- <tr>	        	 
	        	<td>
	        		<input type="radio" name="is_submenu" id="is_submenu" value="Y" onclick="add_child()" <?php
	                  if($submenu=='Y'){ echo 'checked';} 
                      ?> >
                      Yes &nbsp;&nbsp;
	                 <input type="radio" name="is_submenu" value="N" <?php
                     if($submenu=='N'){ echo 'checked';} 
                     ?> >
                     No &nbsp; &nbsp;
                     <?php
                      if($err[3]){
                      	?><span class="notification-input ni-error"><?php
                      	 echo $err[3];
                  	  ?></span><?php
                  	  } 
                  	  ?>
	        	</td>-->
	        	<td><input type="submit" name="submit" id="submit" value="Okay" /></td>
	        </tr> 
	    </tbody>
    
</table>
</form>