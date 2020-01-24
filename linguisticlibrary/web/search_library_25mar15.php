<?php
include 'header.php';
//mysql_set_charset("UTF8");
include('includes/applicationTop.php');
$admin_id    =$_SESSION['ADMIN_ID'];
$author_id   =$_SESSION['author_id'];
$reader_id   =$_SESSION['reader_id'];
$acc_type 	 = $_GET['acc_type'];
$recent_value= $_GET['value'];
$search_type = trim($_GET['search_type']);



if($recent_value !="" )
{
	$query	  = "select * from add_post where `accessibility`='$acc_type' ORDER BY added_date DESC";		
}
else if($acc_type != "")
{
	if($acc_type!='Private'&& $acc_type!='Unlisted' )	
	$query	  = "select * from add_post where `accessibility`='$acc_type' ORDER BY post_name ASC";
}
else
if($search_type != "")
{
	//++++++++++ SEARCH BY root_word +++++++++++++
	$query_sel1	  = "SELECT post_id FROM add_new_entry  WHERE root_word='$search_type'";	
	$res_sel1 	  = $db->select_data($query_sel1);
	$new_entry_post_id = $res_sel1[0]['post_id'];
	for ($ro=0; $ro < count($res_sel1) ; $ro++)
	{ 
		$new_entry_post_id1 = $res_sel1[$ro]['post_id'];
		$new_entry_post    .= $new_entry_post_id1.',';
	}
	$count1		  = count($res_sel1);
	
	//++++++++++ SEARCH BY AUTHOR NAME +++++++++++
	$query_sel2	  = "SELECT  `id` FROM `user_register` WHERE name='$search_type'";	
	$res_sel2 	  = $db->select_data($query_sel2);
	$user_post_id = $res_sel2[0]['id'];
	$count2		  = count($res_sel2);
	
	
	//+++++++++++ SEARCH BY POST Name ++++++++++
	$query_sel3	  = "SELECT  `id` FROM `add_post` WHERE post_name='$search_type' AND `accessibility`!='Unlisted' AND `accessibility` !='Private' ";	
	$res_sel3 	  = $db->select_data($query_sel3);
	$post_id 	  = $res_sel3[0]['id'];
	$count3		  = count($res_sel3);

	$query_sel4 = "SELECT * FROM `add_post` WHERE `search_tags`='$search_type' AND `accessibility`!='Unlisted' AND `accessibility` !='Private'  OR"; 
	$res_sel4 	  = $db->select_data($query_sel4);
	$user_post_id1 = $res_sel4[0]['id'];
	$count4		  = count($res_sel4);
	
	if($count1 > 0)
	{
		  if($admin_id!=''||$reader_id!=''||$author_id!='')	
		     $query	  = "SELECT * FROM `add_post` WHERE `id`='$new_entry_post_id'  OR";
		  else
		     $query	  = "SELECT * FROM `add_post` WHERE `id`='$new_entry_post_id'  AND `accessibility`!='Private' OR";		  
	}
    else if($count2 > 0)
	{
		/*$queryt="SELECT `accessibility` FROM `add_post` WHERE `user_id`='$user_post_id'";
		$resultt=$db->select_data($queryt);
		$access =$resultt[0]['accessibility'];*/
		
		$query        = "SELECT * FROM `add_post` WHERE";
		for($b=0;$b<$count2;$b++)
		{
		  $user_post_id   = $res_sel2[$b]['id'];
		// if($access=='Private' &&($admin_id==$user_post_id||$author_id==$user_post_id||$reader_id==$user_post_id))	
 		  $query .=" `user_id`='$user_post_id' ";
		 if($b<$count2-1)
		 {
		 	$query .= " OR";
		 } 
		}
		
	  if($admin_id!=''||$reader_id!=''||$author_id!='')
	  $query .=" OR";
      else
      $query .= " AND `accessibility`!='Private' OR";

	 
	}	
	else if($count3 > 0)//
	{
		$query	  = "SELECT * FROM `add_post` WHERE `id`='$post_id' OR ";	
	}	
    else if($count4>0)//Follow tags
    {
    	$query        = $query_sel4;
	}
	else
	{	
	 	$query	  = " SELECT * FROM `add_post` WHERE  ";
	}
	
	//echo "<br>".$query;
  $query .="(`accessibility`='Unlisted' AND `accessibility`!='Private' AND `search_tags`='$search_type') ";
	
		
}
  
$res = $db->select_data($query);
$query1 = "select *from add_post where `post_name` ='$search_type'";
$result1= $db->select_data($query1);
$accessibility=$result1[0]['accessibility'];

 if(count($res)==0 && $accessibility!='Unlisted')
 {
 	$query .= " OR (`accessibility`='Private' AND `accessibility`!='Unlisted' AND `user_id` IN('$author_id','$reader_id','$admin_id') AND `post_name`='$search_type' )";
    $res = $db->select_data($query);
    
 }
if($recent_value==''&&$acc_type=='')
   $query      .= "ORDER BY `id` DESC";
$sql_query	 =	"select * from graphics where id=1";
$res_sql  	 =	$db->select_data($sql_query);
$image 	 	 =	$res_sql[0]['frontpage_background'];
?>
<html>	
<head>
	<style>		 
		body{
		margin: 0;
		font-family: Arial;
		font-size: 14px;
		}
	td
	{
		font-family: Arial!important;
		font-size: 12pt!important;
	}

	.mainwrapsty
	{
	 height:469px;
	}
	.h3sty
	{
	 margin-bottom: -16px;
	}
	</style>
</head>
<div class="container">
	<div class="main_wrap">
		<body>
			<div id="titles">
				<!-- <div class="article_library">Library Index</div> -->
				<div class="article_library">
				<?php if($search_type !=""){?>
				Search : <?php echo $search_type;?>
				<?php }else{ ?>					
				Search : All
				<?php } ?>
				</div>
			</div>
				<div class="entry_form">
					<div class="err">
						<?php
						 
						$count  =count($res);
						if($acc_type=='Public'|| count($res)>0) 
						{
						?>
					<table width="100%">
						<tr>
								<?php 
								
								if(count($res)>0){?>
								<td class="library_td_top" width="40%">Script Title</td>
								<td class="library_td_top" width="20%">Author(s)</td>
								<td class="library_td_top" width="20%">Date Created</td>
				                <td class="library_td_top" width="20%">Last Modify</td>
				                <td class="library_td_top" width="20%">Tags</td>
				
								<?php }?>
						</tr>	 
							
						
						<?php if($res)
							 {
								for($i=0;$i<count($res);$i++)
								{
									$id		  	 = $res[$i]['id'];								
									$postname 	 = $res[$i]['post_name'];	
									$uid 	  	 = $res[$i]['user_id'];		
									$user_type   = $res[$i]['user_type']; 
									$modify_date   = $res[$i]['modify_date'];
		                            $tags          = $res[$i]['search_tags'];
									$date          = $res[$i]['added_date'];
									if($date!='0000-00-00')
				                    $date_e        = date("d F Y",strtotime($date));
									if($modify_date!='0000-00-00')
								    $date_m        = date("d F Y",strtotime($modify_date));
									
					 
		                             if($user_type=='author')
		                              {
		                               $queryf    ="select *from user_register where id='$uid'";
		                               $resf      =$db->select_data($queryf);
		                               $name      =$resf[0]['name'];
		                              }
		 
		                             if($user_type=='admin')
		                            { 
		                              $queryf    ="select *from admin where admin_id='$uid'";
		                              $resf      =$db->select_data($queryf);
		                              $name      =$resf[0]['admin_name'];
		                            } 					
									 
								?>						 
							     <tr>
							     	<td class="library_td" width="40%"> <a href="entry.php?link_page=search_library&id=<?php echo $id;?>&postname=<?php echo $postname;?>&acc_type=<?php echo $acc_type?>&recent_value=<?php echo $recent_value;?>&search_type=<?php echo $search_type; ?>"><?php echo $postname;?></a></td>
							        <td class="library_td" width="20%"><?php echo  $name;?> </td>
							        <td class="library_td" width="20%"><?php echo  $date_e; ?> </td>
			                        <td class="library_td" width="20%"><?php echo  $date_m; ?> </td>
			                        <td class="library_td" width="20%"><?php echo  $tags; ?> </td>
							     </tr>
								<?php	
								}							
							}
							?>
						</table>
						<?php } ?>
						<table width="100%" cellspacing="6">
						<?php
						//Make dynamic code here as per existing dictioanry columns
						// ++++++++++++++ SEARCH BY tbl_dictionary ++++++++++
						    $get_cols = "SHOW COLUMNS FROM tbl_dictionary";
							$cols_res = $db->select_data($get_cols);
							$tot_cols = count($cols_res);
							$r=0;
							 
		                for ($iq=1; $iq < $tot_cols; $iq++)      //dynamic searching from databse
		                { 
					     $colnms.="`".$cols_res[$iq][0]."` ='$search_type'";																	
					 	 $values.="'".$data[$iq-1]."'";
						 if ($iq < $tot_cols-1)
						 {
							$colnms.=" OR ";
						 }
				        } 
						$query_sel6   = "SELECT * FROM `tbl_dictionary` WHERE $colnms";
					    $res_sel6 	  = $db->select_data($query_sel6);						
						$count6	      = count($res_sel6);	 
							
							 //for
				  		if($count6>0)
						{
								?>
							 
							<div>
							  <?php 
							  
							  if($acc_type!='Public')         //dynamic listing from database
							    {  
							         for ($cnt=0; $cnt < $count6; $cnt++) 
								     {
								  		
							    	?>	
								<div class="div_dictionary">
									<?php 
									   for ($iq=1; $iq < $tot_cols; $iq++)  
			                           { 
						                $colnmsw=$cols_res[$iq][0];																	
						                $values =$res_sel6[$cnt][$colnmsw];
										if($colnmsw!='Source')
									    {
									    echo "<p class='div_dictionary_text'>".$values;
									    
									    ?><p>
									  <?php  
										} 
										else
									    echo "Source:".$values;
									    ?> 
									 <?php
									   }
									  ?>
									
								</div>
							<?php	}
								  }
								?>
							</div>
								 
								<?php
						   }  
					//++++++++++ SEARCH BY sindarin_text +++++++++++++						
    $query_sel4   = "SELECT DISTINCT(`post_id`) FROM `add_new_entry` WHERE `sindarin_text`='$search_type'";
						
  //echo   $query_sel4   = "SELECT DISTINCT(`post_id`) FROM `add_new_entry` WHERE `sindarin_text`='$search_type' AND (post_id IN (SELECT `post_id` FROM `add_post` WHERE `accessibility`!='Private') )";

						$res_sel4 	  = $db->select_data($query_sel4);						
						$count4		  = count($res_sel4);	
								
						  if($count4 > 0){
						   
						  ?>							
					 			<?php					 			
					 			for($i=0;$i<$count4;$i++)
								 {
									  $id 		 = $res_sel4[$i]['post_id'];
									  $que_sel	 = "SELECT * FROM `add_post` WHERE id='$id'";
									if($admin_id!=''||$reader_id!=''||$author_id!='')
									{
									 $result    = $db->select_data($que_sel);
									 $user_id   = $result[0]['user_id'];  	
									 if($user_id==$admin_id||$user_id==$author_id||$user_id==$reader_id)	
									 $que_sel .=" OR (`accessibility`='Private' AND `user_id`='$user_id')  ";
                                     else
                                     $que_sel .= "  OR `accessibility`='Public'";
									  
									}
									else 
									{
									 $que_sel	 = "SELECT * FROM `add_post` WHERE id='$id' AND `accessibility`='Public'";	
									}
								 
									$res_que_sel = $db->select_data($que_sel);	
									$uid		 = $res_que_sel[0]['user_id'];
								    $postname    = $res_que_sel[0]['post_name'];
									
										
									if($postname!='')
									{   
									echo "<tr><td  class='library_td' colspan='2'>";								
									$query_fins  = "SELECT * FROM `add_new_entry` WHERE `post_id`='$id' GROUP BY sindarin_order";
									$res_fins  	 = $db->select_data($query_fins);	
									
									
									$qry_user_id = "SELECT name FROM `user_register` WHERE id='$uid'";
									$res_user	 = $db->select_data($qry_user_id);
								    $user 		 = $res_user[0]['name'];
									
						            
									echo "<a href='entry.php?link_page=search_library&id=$id&postname=$postname'>".($i+1).". ".ucwords($postname)." by ".$user."</a><br>";	
									 						
									 for($k=0;$k< count($res_fins);$k++)
									 {
									    $sindarin_text =trim($res_fins[$k]['sindarin_text']);	
									    echo "&nbsp;";
										if($sindarin_text==$search_type)
										{
											echo "<b>".$sindarin_text."</b>";
										}
										else
										{										  
											echo  $sindarin_text;
										}		
									 }
									}	
									echo "</td></tr>";
									 						
								 }							
								
								?>
							   					 	
							
						 <?php } ?>
						 <?php
						 //++++++++++ SEARCH BY english_text +++++++++++++
							 $query_sel5	 = "SELECT DISTINCT(`post_id`) FROM `add_new_entry` WHERE `english_text`='$search_type'";	
						//	$query_sel5   = "SELECT DISTINCT(`post_id`) FROM `add_new_entry` WHERE `english_text`='$search_type' AND (post_id NOT IN (SELECT `post_id` FROM `add_post` WHERE `accessibility`='Private') )";
							
							$res_sel5	  = $db->select_data($query_sel5);						
							$count5	  	  = count($res_sel5);
						    
						  if($count5 > 0){
						   
						  ?>		
								 		<?php
											for($i=0;$i< $count5;$i++)
											{
												
												$id 	     = $res_sel5[$i]['post_id'];
												$que_sel	 = "SELECT * FROM `add_post` WHERE id='$id'";	
									           
												if($admin_id!=''||$reader_id!=''||$author_id!='')
									            {
									              $que_sel	 = "SELECT * FROM `add_post` WHERE id='$id' ";	
												   $result    = $db->select_data($que_sel);
									               $user_id   = $result[0]['user_id'];  	
												   if($user_id==$admin_id||$user_id==$author_id||$user_id==$reader_id)	
									               $que_sel .=" OR (`accessibility`='Private' AND `user_id`='$user_id') ";
                                                   else
                                                   $que_sel .= " OR `accessibility`='Public'";
									  
									            }
									            else 
									            {
									              $que_sel	 = "SELECT * FROM `add_post` WHERE id='$id' AND `accessibility`='Public'";	
									            }
												$res_que_sel = $db->select_data($que_sel);	
									            $uid		 = $res_que_sel[0]['user_id'];
								                $postname    = $res_que_sel[0]['post_name'];
									           
											   if($postname!='')
											   {
												echo "<tr><td colspan='2' class='library_td'>";
												$query       = "select * from add_post where id='$id'";	
												$res_query   = $db->select_data($query);
												$postname    = $res_query[0]['post_name'];
												 								    
												$query_fine	 = "SELECT * FROM `add_new_entry` WHERE `post_id`='$id'  GROUP BY english_order";	
												$res_fine 	 = $db->select_data($query_fine);	
																				
												
												$qry_user_id = "SELECT name FROM `user_register` WHERE id='$uid'";
												$res_user	 = $db->select_data($qry_user_id);
												$user 		 = $res_user[0]['name'];
												
												echo "<a href='entry.php?link_page=search_library&id=$id&postname=$postname'>".($i+1).". ".ucwords($postname)." by ".$user."</a><br><br>";	
												
												for($l=0;$l < count($res_fine);$l++)
												{	
													$english_text =	$res_fine[$l]['english_text'];													
													echo "&nbsp;";
													if($english_text==$search_type)
													{
														echo "<b>".$english_text."</b>";
													}
													else
													{										  
														echo $english_text;
													}			
												}
												echo "</td></tr>";
												}	 
											}
										?>										   
								     
							
							<?php } ?>
				   </table>					 
			   </div>
			  </div>
		 </body>
	</div>
</div>
<?php include('footer.php');?>