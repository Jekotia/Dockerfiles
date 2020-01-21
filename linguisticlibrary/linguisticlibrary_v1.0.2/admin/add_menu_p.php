<?php header ('Content-type: text/html; charset=utf-8'); ?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

<?php
//include('../includes/connectdb.php');
include("../includes/applicationTop.php");
$type 	= $_GET['type'];
$sql	="SELECT `id` FROM tbl_menu ORDER BY `id` DESC LIMIT 1";				
$res	=	$db->select_data($sql);
$res_id = $res[0]['id'];
$id_ajax = $res_id + 1;
if(isset($_POST['submit']))
{
  //$submenu = $_POST['is_submenu'];  
  $menu_name1 = $_POST['menu_name'];
  $menu_name  = $menu_name1[0];
  $name_sub   = implode(',', $menu_name1);
  $abbr 	  = trim($_POST['abbr']);
  $note       = addslashes(trim($_POST['note']));
  $is_submenu = $_POST['is_submenu'];
  if($menu_name != "")
  {
 	$sql_sel = "SELECT * FROM `tbl_menu` WHERE menu_title ='$menu_name'";				
  	$res_sel	= $db->select_data($sql_sel);
	
	if(count($res_sel) > 0)
	{
		$msg ="Menu Name is Alredy Exist";
	}
	else
	{
		$sql_insert = "INSERT INTO  tbl_menu(`menu_title`,`parent_id`,`abbrevation`, `note`)VALUES('$menu_name',0,'$abbr','$note')";				
	  	$res_insert	= $db->insert_data($sql_insert);
		$inc_id 	= mysql_insert_id();
		$msg 		= "Menu inserted successfully";
	}
	
	?>
	<script>
	 	//return parent.hs.refreshparentObject(this);	 // close popup		
	 	window.parent.location.reload();
	</script> 
	
	<!-- <script>
	
	 var is_sub = '<?php echo $is_submenu;?>';
	 var in_id  = '<?php echo $inc_id;?>'
	 var s_id   = '<?php echo $id_ajax;?>';
	 var s_name  = '<?php echo $name_sub;?>';
	 // alert('ppppppp==='+s_name);
		if(is_sub == 'Y')
		{
			
		parent.document.getElementById('my_in_id').value = in_id;	
		parent.document.getElementById('my_chek').value = is_sub;	
			 // $.ajax({
			 	 	// type:"POST",
		   			// url:"change_id.php",
		   			// data:"s_id="+s_id+"&s_name="+s_name,
		   			// cache:false,
		   			// success:function(data)
		   			// {
		   				// //alert(data);
		   				// document.getElementById('msg').innerHTML = data;
		   			// }
			 	 // }); 				
			
		}
		else
		if(is_sub == 'N')
		{
			parent.document.getElementById('my_in_id').value = in_id;	
			parent.document.getElementById('my_chek').value = is_sub;
			//parent.document.getElementById('my_id').value='N';
			///parent.document.getElementById('my_id').value=in_id;
			//var is_chek = parent.document.getElementById('my_id').value;
				
			
			 	//$(p_submenu_id).remove();	
			 	//return parent.hs.refreshparentObject(this)	 // close popup		
			
		}
		
	 //return parent.hs.refreshparentObject(this);	 // close popup		
	</script> -->
	
	<?php
	
  }
}

?>
<script>
function add_child() 
{
	//$('#menu_name').clone().appendTo('#clone_td');	
	// var p_clone_td_id = parent.document.getElementById('clone_td');	
	// $('#menu_name').clone().appendTo(p_clone_td_id);
	// document.getElementById('p_clone_td_id').setAttribute("style","width:30px");
}
		
</script>



<form name="menu_form" method="post">
						<!-- <div class="alert alert-success" id="responce">
                           <button class="close" data-dismiss="alert">×</button>
                           <strong id="responce"></strong>
                        </div> -->
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
	         <td style="width:50%">Name</td>
	         <td id="clone_td" style="width: 50%;"><input type="text" name="menu_name[]"  id="menu_name"/></td>
	        </tr>
	        <tr class="gradeX odd">
	         <td style="width:50%">Abbreviation</td>
	         <td  style="width: 50%;"><input type="text" name="abbr"  id="abbr"/></td>
	        </tr>
	        <tr class="gradeX odd">
	         <td style="width:50%">Note</td>
	         <td  style="width: 50%;"><textarea name="note" id="note"></textarea></td>
	        </tr>
	        <!-- <tr><td><lable>Has sub-menu?</lable></td></tr> -->
	        <tr>	        	 
	        	<!-- <td>
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
	        	</td> -->
	        	<td><input type="submit" name="submit" id="submit" value="Okay" /></td>
	        </tr>
	    </tbody>
    
</table>
</form>