<?php 
    include('header.php');
	if($_GET['deleteId'])
    {
		$delRec		=	"DELETE FROM `job_address` WHERE  `id` = '".$_GET['deleteId']."' ";
		$resDelRec	=	$db->delete_data($delRec);
	
		$delRec1	=	"DELETE FROM `job_details` WHERE  `address_id` = '".$_GET['deleteId']."' ";
		$resDelRec1	=	$db->delete_data($delRec1);
	
		$msg		=	base64_encode("Record Deleted Successfully..!");
		header('Location:readyforcust_comm.php?msg='.$msg);
   }
#Start Pagination Code By Amol 21-Dec-13/12.20PM
$tbl_name="job_address";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	 * Query cahnged by jyoti to display all those records like tech,abf,civil/aerial pending work once completed these three work, records move to cutover and commission page for other 2 work done.
	*/
 $query       = "SELECT COUNT(*) as num FROM $tbl_name WHERE  `techcomp`='incomplete' OR `civilcomp`='incomplete' OR `abfcomp`='incomplete' ORDER BY `added_date` DESC";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	/* Setup vars for query. */
	$targetpage  = "readyforcust_comm.php"; 	//your file name  (the name of this file)
	$limit       = 10; 								//how many items to show per page
	$page        = $_GET['page'];
	if($page) 
		$start   = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start   = 0;								//if no page var is given, set start to 0
	
	/* Get data. */
 	$sql       = "SELECT * FROM $tbl_name WHERE  `techcomp`='incomplete' OR `civilcomp`='incomplete' OR `abfcomp`='incomplete' ORDER BY `added_date` DESC LIMIT $start, $limit";
	$result    = mysql_query($sql);
	$num_count = mysql_num_rows($result);
	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		//$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage?page=$prev\">previous</a>";
		else
			$pagination.= "<span class=\"disabled\">previous</span>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "<div class='dotdotdot'>...</div>";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "<div class='dotdotdot'>...</div>";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "<div class='dotdotdot'>...</div>";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "<div class='dotdotdot'>...</div>";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
			}
		}		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage?page=$next\">next</a>";
		else
			$pagination.= "<span class=\"disabled\">next</span>";
		//$pagination.= "</div>\n";		
	}
#End Pagination Code
?>
<!-- Thickbox files -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/thickbox.css" media="screen" />
<script language="javascript" type="text/javascript" src="thickbox/javascript/thickbox.js"></script>
<!-- Check Box Validations for This Page In Following File -->
<script language="javascript" type="text/javascript" src="js/readyforcustvaljs.js"></script>
<script>
    function openjobform(custid,openpage,usertype)
    {
    	//alert('custid'+custid+'Page'+openpage+'Usertype'+usertype);
        window.location.href='jobs.php?address_id='+custid+'&retpage='+openpage+'&usertype='+usertype;
    }
  var a=window.innerWidth;
    var b=window.innerHeight;
 
  alert("Width="+a+"Height="+b);
</script>
<style>
    .rdbutton_example
    {
			text-decoration:none;
			color: #FFF;
			font-size: 1.10em;
			text-transform: uppercase;
			text-align: center;
			border-radius: 5px;
			background: #2B8FC4;
			display: inline-block;
			box-shadow: inset 1px 1px 1px #B5E5FF;
			text-shadow: 0px -1px 0px #024D74;				
			width:60px;
			padding:6px 1.5px;			
	}
	
	.allpagediv
	{
		padding: 5px; 
	} 
	.respmaindiv
	{
		width: inherit;
		/*margin-left:10%;*/
	}
	.subdiv1
	{
		/*float:left;
		width:inherit;
		margin-left: 20%;*/
		width:88%;
		margin: 0 auto;
	}
	.subdiv2
	{
	  width:800px;
	}
	.adminsubdiv1
	{
		/*float:left;*/
		width:88%;
		margin: 0 auto;
	}
	.adminsubdiv2
	{
	  /*float:left;*/	
	  width:800px;
	  margin-left: 0 auto;
	}
	.normaluser
	{
		float: left;
	}
	.adminuser
	{
		float: left;margin-left: 5%;
	}
	.bottomdiv
	{
		height: 80px;
	}
	#mstresptbl
	{
		width: 855px;
	}

	
	/* For resolution 768px */
	@media (max-width: 768px) {

		    #mstresptbl
		    {
		    	width:616px;
		    }

	  	  .adminuser
		  {
				float: left;margin-left: 12%;
		  }			
		  	.subdiv1
			{
				float:left;
				width:100%;
				margin-left: 0%;
			}
		  	.subdiv2
			{
				float:left;
				width:100%;
				margin-left: 8%;
			}
			.adminsubdiv1
			{
				float:left;
				width:100%;
				margin-left: 0%;
			}	
            .normaluser
            {
               float: left;
               padding-top:2%;
            }	
            .newaddr
            {
            	float: left;
				width: 12%;
				margin-left: 10%;
				margin-bottom: 10px;
				padding-top: 1%;
            }
            .adminuser
            {
            	float: left;
				margin-left: 12%;
				padding-top: 1%;
            }
	}
	/* End For resolution 768px */

	/* For Resolution 600px; */
	@media (max-width: 600px)  {

		    #mstresptbl
		    {
		    	width:515px;
		    }
	  	  .adminuser
		  {
				float: left;margin-left: 18%;
		  }		
		.subdiv1
		{
			float:left;
			width:100%;
			margin-left: 0%;
		}
		.adminsubdiv1
		{
			float:left;
			width:100%;
			margin-left: 0%;
		}

		  .subdiv2
	      {
				  float:left;	
				  width:80%;
				  margin-left: 20%;
				  padding-top:2%;
          }
		  .adminsubdiv2
	      {
				  float:left;	
				  width:80%;
				  margin-left: 20%;
				  padding-top:2%;
          }
 	  	  .pagiDiv
	      {
		     float: left;margin-bottom: 10px;padding-top:8%;margin-left:-44%;
	      }
 	  	  .pagiDiv1
	      {
		     float: left;margin-bottom: 10px;
	      }   	
	}
	/* end For Resolution 600px */

	/* For Resolution 568px;  */
	@media (max-width: 568px)  {
		
		
		    #mstresptbl
		    {
		    	width:515px;
		    }
			.subdiv1
			{
				float:left;
				width:100%;
				margin-left: 0%;
			}
			.adminsubdiv1
			{
				float:left;
				width:100%;
				margin-left: 0%;
			}

		  .subdiv2
	      {
				  float:left;	
				  width:80%;
				 /* margin-left: 20%;*/
				  padding-top:2%;
          }
		  .adminsubdiv2
	      {
				  float:left;	
				  width:80%;
				  margin-left: 20%;
				  padding-top:2%;
          }
	  	  .adminuser
		  {
				float: left;margin-left: 21%;
		  }
 	  	  .pagiDiv
	      {
		     float: left;margin-bottom: 10px;padding-top:8%;margin-left:-47%;	      
		  }
 	  	  .pagiDiv1
	      {
		     float: left;margin-bottom: 10px;
	      }
	}
	/* end For Resolution 568px; */

	@media (max-width: 480px) 
	{
		.adminuser
		{
			float: left;margin-left: 26%;
		}	
		.normaluser
		{
			float: left;
			padding-bottom:1%;
		}
		.pagiDiv
		{
			float: left;margin-bottom: 10px;padding-top:2%;margin-left:-8%;padding-top:4%;
		}
		.pagiDiv1
		{
			float: left;margin-bottom: 10px;padding-top:1%;margin-left:3%;
		}
		.subdiv1
		{
			float:left;
			width:100%;
			margin-left: 0%;
		}
		.adminsubdiv1
		{
			float:left;
			width:100%;
			margin-left: 0%;
		}
   }

    @media (max-width: 384px) 
    {
		.adminuser
		{
			float: left;margin-left: 37%;
		}
		.subdiv1
  	    {
			float:left;
			width:100%;
 	    }	
       	.adminsubdiv1
		{
			float:left;
			width:inherit;
			margin-left: 0%;
			width:100%;
		}	 
	}


	@media (max-width: 320px) {
		.subdiv1
  	    {
			float:left;
			width:100%;
 	    }
       	.adminsubdiv1
		{
			float:left;
			width:inherit;
			margin-left: 0%;
			width:100%;
		}

		.adminuser
		{
			float: left;margin-left: 47%;
		}	
		.normaluser
		{
			float: left;
			padding-bottom:1%;
		}
		.pagiDiv
		{
			float: left;margin-bottom: 10px;padding-bottom:2%;
		}
		.pagiDiv1
		{
			float: left;margin-bottom: 10px;
		}
    }

	@media (max-width: 240px) {
		.subdiv1
  	    {
			float:left;
			width:100%;
 	    }

		.newaddr
		{
			float: left;
			width: 12%;
			margin-left:auto;
			margin-bottom: 10px;
		}	

		.adminuser
		{
			float: left;margin-left: 52%;
		}	
		.normaluser
		{
			float: left;
			padding-bottom:1%;
		}
		.pagiDiv
		{
			float: left;margin-bottom: 10px;
		}
		.pagiDiv1
		{
			float: left;margin-bottom: 10px;
		}
		.subdiv2
		{
		  float:left;	
		  width:100%;
		  margin-left: 2%;
		}
		.adminsubdiv2
		{
		  float:left;	
		  width:100%;
		  margin-left: 2%;
		}
    }

</style>
  <!-- End Combine and Compress These CSS Files -->
  <link rel="stylesheet" href="css/globals.css">
	<link rel="stylesheet" href="css/responsive-tables.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/responsive-tables.js"></script>
<style>
	body {
				margin-top: 2em;
				margin-bottom: 4em;
				padding: 0em;
				background: #101214 url(images/main-bg.png) repeat;
				font-family: 'Open Sans', sans-serif;
				font-size: 9.5pt;
				color: #686868;
	}	
</style>   
<input type="hidden" />    
			<div id="wrapper" class="5grid-layout 5grid"><hr>
				<div class="row">
					<div class="12u">
						<section>
						<div class="allpagediv">
           <div  class="respmaindiv" align="center">
           	<?php if ($_SESSION['USERID']==1){ $subdivcls1="adminsubdiv1"; }else { $subdivcls1="subdiv1";} ?>
           	<div class="<?php echo $subdivcls1;?>" align="center"> 
			 <table class="responsive" id="mstresptbl">	
			  <tr>
				  <th>ADDRESS:</th>			  
				  <th></th><!--UPDATE -->			  
				  <th>TECH</th><!--TECH -->			  
				  <th> CIVIL/AERIAL</th>
				  <th>ABF</font></th>			 
				  <th>RFS</th>
				  <?php  if (($_SESSION['USERID'])==1) {?>
				  <th>Action</th> <?php }?>
			  </tr>                
	  <?php
	     for ($i=0;$i<$num_count;$i++)   //Address List
		 {
				 	$custid      = mysql_result($result,$i,'id');
				 	$address     = mysql_result($result,$i,'address');
					$techdone    = mysql_result($result,$i,'techdone');
					$civilarial  = mysql_result($result,$i,'civilareal');  
					$abf         = mysql_result($result,$i,'abf');
					/*$spliced     = mysql_result($result,$i,'spliced');*/
					$rfs         = mysql_result($result,$i,'rfs');	
				    $workstatusr = mysql_result($result,$i,'work_status');
					$workstatusr1= explode("_", $workstatusr);
					$workstatus  = $workstatusr1[0];//uderwork
				    $workuser    = $workstatusr1[1];//userid
				    
			   	    $jqry = "SELECT job_status_complete FROM job_details WHERE address_id='$custid'";
			   	    $getjobdata       = $db->select_data($jqry);
			   		$jobstat		  = $getjobdata[0][0];
					$jobstatr         = explode(",",$jobstat);
					if (in_array("TECHNICAL", $jobstatr))
					   $techsta='Y';
					if (in_array("CIVIL", $jobstatr))
					   $civilsta='Y';	   
					if (in_array("ABF", $jobstatr))
					   $abfsta='Y';
					if (in_array("SPLICE", $jobstatr))
					   $splsta='Y';
			    
			  ?>
			  <tr>
			     <td title="<?php echo $address; ?>">
			    	<?php 
			    	       $adrlen = strlen($address);
			    	       if ($adrlen>19)
						   {
						   	  $address1 = substr($address, 0,19);
							  echo ucfirst($address1)."..";
						   }						    
                           else 
			    	         echo ucfirst($address);
			    	?>
			     </td>
			 	    <form name="ready_<?php echo $custid; ?>" method="post" action="jobs.php?address_id=<?php echo base64_encode($custid); ?>&retpage=rfcm">
                    <td>
			 	   	<?php
			 	   	      if (($_SESSION['USERID'])==1)
						  {
						  	?>
			 	   	 		<input type="submit" class="button_example" name="updatecust" value="UPDATE">
	 	   	 	<?php     }
						  else  //Under Working Logic	
						  if(isset($_SESSION['USERID']) && $workstatus=="underwork" && $workuser!=$_SESSION['USERID'])						  	
						  { ?>						  	
			            	<a href="jobs.php?viewaddress_id=<?php echo  base64_encode($custid);?>&retpage=rfcm"><input type="button" class="button_example" name="updatecust" value="   VIEW  "></a>
		<?php	     	  }	
						  else
						  if(isset($_SESSION['USERID']))
						  {	 	?>					  						  
			 	   	 		<input type="submit" class="button_example" name="updatecust" value="UPDATE">                  						  
				<?php	  }
						  else 
						  { ?>
		                  <input type="button" class="button_example" name="updatecust" value="UPDATE" disabled="disabled">							  
				<?php	  }
						  		?>						  
			        </td><!--UPDATE -->
			  <?php 
		       if ($_SESSION['USERID']==1)//Admin User can access all users
			   {
			   			 	   ?>
						  <td align="center">
   
						       <input type="checkbox" name="techdonenm"  id="techdonenm_<?php echo $custid;?>" <?php if ($techdone=='Y') { echo checked; } ?>>
						  </td><!--TECH done -->
						  <td  align="center">
						    	<input type="checkbox" name="civilnm" id="civilnm_<?php echo $custid;?>" <?php if ($civilarial=='Y') { echo checked; } ?>>
						  </td>
						  <td align="center">
						        <input type="checkbox" name="abfnm" id="abfnm_<?php echo $custid;?>" <?php if ($abf=='Y') { echo checked; } ?>>
						  </td>
						  <td align="center">
						        <input type="checkbox" name="rfsnm" id="rfsnm_<?php echo $custid;?>" <?php if ($rfs=='Y') { echo checked; } ?>>
						  </td>
						  <td align="center">
			                <a  href="readyforcust_comm.php?deleteId=<?php echo $custid; ?>">
							    <img src="images/cross_circle1.png" />
							</a>
			              </td>
  	<?php      }//if Admin
			   else 
			   if ($_SESSION['USERID']!=1)					 	
			   { ?>
					  <td align="center" style="margin-left: 10px;">
					  	<?php if ($_SESSION['USERID']==7 && ($workstatus=="underwork" || $workstatus=="")){ ?>
					       <input type="checkbox" name="techdonenm" id="techdonenm_<?php echo $custid;?>" value="<?php echo $postadr; ?>" <?php if ($techdone=='Y') { echo checked; } ?>>
					       <?php }
							    else 
								if ($_SESSION['USERID']==7 && $workstatusr=="empty")
								{
									if ($techdone=='Y')
									{  ?>
										<input type="checkbox" name="techdonenm" disabled="disabled" id="techdonenm_<?php echo $custid;?>" value="<?php echo $postadr; ?>" <?php if ($techdone=='Y') { echo checked; } ?>>
							  <?php	}
									else
									 { ?>
										<input type="checkbox" name="techdonenm" id="techdonenm_<?php echo $custid;?>" value="<?php echo $postadr; ?>" <?php if ($techdone=='Y') { echo checked; } ?>>
   						  <?php      }
							    }									
							 else 
							 { ?>
					              	    <input type="checkbox" disabled="disabled" name="techdone" value="<?php echo $postadr; ?>" <?php if ($techdone=='Y') { echo checked; } ?>>	 
					<?php	 }    ?>
					  </td><!--TECH done -->
					  <td align="center"> <!--CIVIL -->
					  	<?php if (($_SESSION['USERID']==2 ||$_SESSION['USERID']==3) && ($workstatus=="underwork" || $workstatus=="")){ ?>
					              <input type="checkbox" name="civilnm" id="civilnm_<?php echo $custid;?>" <?php if ($civilarial=='Y') { echo checked; } ?>>
						  <?php }
							    else 
								if (($_SESSION['USERID']==2 ||$_SESSION['USERID']==3) && $workstatusr=="empty")
								{
									if ($civilarial=='Y')
									{  ?>
										<input type="checkbox" disabled="disabled" name="civilnm" id="civilnm_<?php echo $custid;?>" <?php if ($civilarial=='Y') { echo checked; } ?>>
							  <?php	}
									else
									 { ?>
										<input type="checkbox" name="civilnm" id="civilnm_<?php echo $custid;?>" <?php if ($civilarial=='Y') { echo checked; } ?>>
   						  <?php      }
							    }									
							    else 
							    { ?>
  								  <input type="checkbox" disabled="disabled" name="civilnm" id="civilnm_<?php echo $custid;?>" <?php if ($civilarial=='Y') { echo checked; } ?>>	
					   <?php    }    ?>
					  </td>
					  <td align="center"> <!-- ABF -->
					  	<?php if ($_SESSION['USERID']==4 && ($workstatus=="underwork" || $workstatus=="")){ ?>
					        <input type="checkbox" name="abfnm" id="abfnm_<?php echo $custid;?>" <?php if ($abf=='Y') { echo checked; } ?>>
					    <?php }
						      else 
							  if ($_SESSION['USERID']==4 && $workstatusr=="empty")
							  {
									if ($abf=='Y')
									{  ?>
						<input type="checkbox" name="abfnm" disabled="disabled" id="abfnm_<?php echo $custid;?>" <?php if ($abf=='Y') { echo checked; } ?>>
							  <?php	}
									else
									{ ?>
                        <input type="checkbox" name="abfnm" id="abfnm_<?php echo $custid;?>" <?php if ($abf=='Y') { echo checked; } ?>>										
						     <?php  }
							  }        
						      else 
							  { ?>
					            <input type="checkbox" disabled="disabled" name="<?php echo $abfnm; ?>" <?php if ($abf=='Y') { echo checked; } ?>>
					<?php	  } ?>
					  </td>

					  <td align="center" > <!-- RFS -->
					  	<?php if ($_SESSION['USERID']==6 && ($workstatus=="underwork" || $workstatus=="")){ ?>
					  <input type="checkbox" name="rfsnm" id="rfsnm_<?php echo $custid;?>" <?php if ($rfs=='Y') { echo checked; } ?>>
					       <?php }
						      else 
							  if ($_SESSION['USERID']==6 && $workstatusr=="empty")
							  {
									if ($rfs=='Y')
									{  ?>
                                       <input type="checkbox" name="rfsnm" disabled="disabled" id="rfsnm_<?php echo $custid;?>" <?php if ($rfs=='Y') { echo checked; } ?>>
							  <?php	}
									else
									{ ?>
									  <input type="checkbox" name="rfsnm" id="rfsnm_<?php echo $custid;?>" <?php if ($rfs=='Y') { echo checked; } ?>>										
						     <?php  }
							  }        						
							 else 
							 { ?>
					                  <input type="checkbox" disabled="disabled" <?php if ($rfs=='Y') { echo checked; } ?>>
 			     	<?php	 }  ?>
					  </td>
										 
		 <?php }//if other users	  ?>
		 
		
                 </form>    
                </tr>     
     <?php }//for address list ?>
             </table>        
			</div> <!-- subdiv1 or adminsubdiv1 -->
			
			
	       <?php if ($_SESSION['USERID']==1){ $subdivcls2="adminsubdiv2"; }else { $subdivcls2="subdiv2";} ?>
        <div class="<?php echo $subdivcls2; ?>" align="center">
        <?php
        if($_SESSION['USERID'] == 1) //only admin can add address
						{	?>	
         <div class="newaddr">
		           <?php  	
		                $selectUserName 	=	"SELECT * FROM `user` WHERE  `id` ='".$_SESSION['USERID']."'"; 
						$resUserName		=	$db->select_data($selectUserName);
						$user_name  		=	$resUserName[0]['user_name'];
						?>
							 <a id="newadrid" style="padding: 6px;margin-left:0%;" href="address.php?&KeepThis=true&TB_iframe=true&height=300&width=300"  class="thickbox">
				                 New Address
		            	     </a>
		 </div>		 				            	     
				<?php   
				           $backbtnstyle="adminuser";
				        }
						else
						   $backbtnstyle="normaluser";  
				?>				       
				
			<div class="<?php echo $backbtnstyle; ?>">
				<a href="page.php" class="rdbutton_example">BACK</a>
			</div> 			
			<?php if ($_SESSION['USERID']==1){ $pagicls="pagiDiv"; }else { $pagicls="pagiDiv1";} ?>
			<div class="<?php echo $pagicls;?>">
				<div class="dark-theme  float-right">
      					  <?php echo $pagination; ?>
    	        </div>	   
            </div>
         </div> <!-- subdiv2 -->
         
         
     </div>      
			                </div> <!-- All pagediv padding -->
						    </section>
			              </div>      <!-- div class="12u"  -->
					</div>     <!-- div class="row"  -->
				</div>
				<div  style="height: 80px;"></div>
			</div>	  <!--Div closed from header.php i.e. header-wrapper & 5grid-layout -->		
		</div>
<?php include('footer.php'); ?>