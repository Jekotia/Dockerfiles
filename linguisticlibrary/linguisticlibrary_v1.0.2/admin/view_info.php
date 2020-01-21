<?php
	 //define('N','NO');
	 //define('Y','YES');
	$root="../";
	include($root."includes/applicationTop.php");
	 
	$id		=	$_GET['id'];
	 
	$sql						=	"select * from `auto_insurance_data` where `vehicle_id`='$id'";
	$res_cms					=	$db->select_data($sql);
	
	// $vehicle_year				=	$res_cms[0]['vehicle_year'];
	// $make   					=	$res_cms[0]['make'];
	// $sql_make					= 	"SELECT * FROM `addon_makes` WHERE `makes_id`='$make'";
	// $res_make					=	$db->select_data($sql_make);
 	// $make1 						=   $res_make[0]['makes_name']; 
	// $model	    				=	$res_cms[0]['model'];
	// $sql_model					= 	"SELECT * FROM `addon_models` WHERE `models_id`='$model'";
	// $res_model					=	$db->select_data($sql_model);
 	// $model1 					=   $res_model[0]['models_name']; 
	// $ownership	 	   			=	$res_cms[0]['ownership'];
	// $night_parking	    		=	$res_cms[0]['night_parking'];
	// $primary_use				=	$res_cms[0]['primary_use'];
	// $annual_mileage				=	$res_cms[0]['annual_mileage'];
	// $zip_code					=	$res_cms[0]['zip_code'];
	
	//$is_confirm 				= ($is_confirm1=='N') ? "NO" : "YES";
 	// if($is_confirm1=='N')
	// {
		// $is_confirm = 'NO';
	// }
	// elseif($is_confirm1=='Y')
	// {
		// $is_confirm='YES';
	//}

?>
<!-- <script>
	function print(
		window.print();
	)
</script> -->
<style>
	
	.gradeX
	{
		font-size: 15px;
	}
	/*.tr
	{
		width: 40%;
	}*/
</style>
 <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
 <h3 align="center">Driver's Information</h3>
<table class="table table-striped table-bordered dataTable" id="sample_1" aria-describedby="sample_1_info">
	  <tbody role="alert" aria-live="polite" aria-relevant="all">
      	
      		<!-- <tr class="gradeX odd">      		
      		<th>Vehicle Year</th><td><?php echo $vehicle_year; ?> </td>   
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>make</th><td><?php echo $make1; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Model No</th><td><?php echo $model1; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Owner</th><td><?php echo $ownership; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Parking</th><td><?php echo $night_parking; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Primary Use</th><td><?php echo $primary_use; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Annual Mileage</th><td><?php echo $annual_mileage; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Zip Code</th><td><?php echo $zip_code; ?> </td>
      		</tr> -->
      		
  <?php
  		$tot_dri                    = count($res_cms);
   	for ($sd=0; $sd < $tot_dri; $sd++) 
   	{ 
	 
	$amount_coverage			=	$res_cms[$sd]['amount_coverage'];
	$is_past_insurance1			=	$res_cms[$sd]['is_past_insurance'];
	$is_past_insurance	 		= ($is_past_insurance1=='N') ? "NO" : "YES";
	$curr_insurance_company		=	$res_cms[$sd]['curr_insurance_company'];
	$insurance_exp_mon1			=	$res_cms[$sd]['insurance_exp_mon'];
 	$insurance_exp_mon			= 	date('F',strtotime($insurance_exp_mon1));
	$insurance_exp_year			=	$res_cms[$sd]['insurance_exp_year'];
	$years_insured				=	$res_cms[$sd]['years_insured'];
	$curr_bodily_injury_liability_limits	=	$res_cms[$sd]['curr_bodily_injury_liability_limits'];
	$first_name					=	$res_cms[$sd]['first_name'];
	$last_name					=	$res_cms[$sd]['last_name'];
	$gender						=	$res_cms[$sd]['gender'];
	$marital_status				=	$res_cms[$sd]['marital_status'];
	$email						=	$res_cms[$sd]['email'];
	$occupation					=	$res_cms[$sd]['occupation'];
	$education_level			=	$res_cms[$sd]['education_level'];
	$residence					=	$res_cms[$sd]['residence'];
	$credit_evaluation			=	$res_cms[$sd]['credit_evaluation'];
	$age_first_licensed			=	$res_cms[$sd]['age_first_licensed'];
	$date_of_birth1				=	$res_cms[$sd]['date_of_birth'];
	$date_of_birth 				=   date("d M,Y",strtotime($date_of_birth1));
	$driver_license_number		=	$res_cms[$sd]['driver_license_number'];
	$is_driver_suspended1		=	$res_cms[$sd]['is_driver_suspended'];
	$is_driver_suspended 		= ($is_driver_suspended1=='N') ? "NO" : "YES";
	$frf_form_needed1			=	$res_cms[$sd]['frf_form_needed'];
	$frf_form_needed 			= ($frf_form_needed1=='N') ? "NO" : "YES";
	$is_recent_insurance1		=	$res_cms[$sd]['is_recent_insurance'];
	$is_recent_insurance 		= ($is_recent_insurance1=='N') ? "NO" : "YES";
	$curr_company				=	$res_cms[$sd]['curr_company'];
	$curr_paying_amout			=	$res_cms[$sd]['curr_paying_amout'];
	$curr_years_insured			=	$res_cms[$sd]['curr_years_insured'];
	$curr_exp_month1			=	$res_cms[$sd]['curr_exp_month'];
	$curr_exp_month				= 	date('F',strtotime($curr_exp_month1));
	$curr_exp_year				=	$res_cms[$sd]['curr_exp_year'];
	$curr_limits				=	$res_cms[$sd]['curr_limits'];
	$your_list					=	$res_cms[$sd]['your_list'];
	$deductible					=	$res_cms[$sd]['deductible'];
	$speeding_tickets1			=	$res_cms[$sd]['speeding_tickets'];
	$speeding_tickets 			= ($speeding_tickets1=='N') ? "NO" : "YES";
	$is_dwi_dui1				=	$res_cms[$sd]['is_dwi_dui'];
 	$is_dwi_dui 				= ($is_dwi_dui1=='N') ? "NO" : "YES";
 	$is_confirm					=	$res_cms[$sd]['is_confirm'];
  
  ?>    		
      		<tr>
               <th style="background-color: pink" colspan="2">Auto Coverage</th>
            </tr>
            <tr class="gradeX odd"> 
      		<th>Desired Amount of Coverage</th><td><?php echo $amount_coverage; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Have you had inssurance past 50 days?</th><td><?php echo $is_past_insurance; ?> </td>
      		</tr>
      		<?php 
      		if($is_past_insurance =='YES')
			{
			?>
      		<tr class="gradeX odd"> 
      		<th>Current Inssurance Company</th><td><?php echo $curr_insurance_company; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Insurance Expairation Date</th><td><?php echo $insurance_exp_mon.' '.$insurance_exp_year; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Years Insuered</th><td><?php echo $years_insured; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Currently bodily injury liability limits</th><td><?php echo $curr_bodily_injury_liability_limits; ?> </td>
      		</tr>
      		<?php }  ?>
      		<tr bgcolor="pink">
               <th style="width:100%;background-color: pink" colspan="2">PRIMARY DRIVER DETAILS</th>
            </tr>
      		 
      		<tr class="gradeX odd"> 
      		<th>Name</th><td><?php echo $first_name." ".$last_name; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Gender</th><td><?php echo $gender; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Marital Status</th><td><?php echo $marital_status; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Email Id</th><td><?php echo $email; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Occupation</th><td><?php echo $occupation; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Educational Level</th><td><?php echo $education_level; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Residence</th><td><?php echo $residence; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Credit Evaluation</th><td><?php echo $credit_evaluation; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Age First Licensed</th><td><?php echo $age_first_licensed; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Date OF Birth</th><td><?php echo $date_of_birth; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Driver License Number</th><td><?php echo $driver_license_number; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Has Driver license been suspended/revoked in the last 3 years?</th><td><?php echo $is_driver_suspended; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Does this Driver needs Financial responsibility Form(SR/22)</th><td><?php echo $frf_form_needed; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Do you currently have insurance?</th><td><?php echo $is_recent_insurance; ?> </td>
      		</tr>
      		<?php
      		if($is_recent_insurance=='YES')
			{
      		?>
      		<tr class="gradeX odd"> 
      		<th>Current company? (Optional)</th><td><?php echo $curr_company; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>How much are you paying? (Optional)</th><td><?php echo $curr_paying_amout; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Years Insured?</th><td><?php echo $curr_years_insured; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Expiration Date?</th><td><?php echo $curr_exp_month.' '.$curr_exp_year; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Current limits</th><td><?php echo $curr_limits; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>(Your lists)</th><td><?php echo $your_list; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Deductible</th><td><?php echo $deductible; ?> </td>
      		</tr>
      		<?php  } ?>
      		<tr class="gradeX odd"> 
      		<th>Any speeding tickets within 3 years?</th><td><?php echo $speeding_tickets; ?> </td>
      		</tr>
      		<tr class="gradeX odd"> 
      		<th>Any DUI/DWI in the past 3 years?</th><td><?php echo $is_dwi_dui; ?> </td>
      		</tr>
      		<!-- <tr class="gradeX odd"> 
      		<th>Add another driver?</th><td><?php echo $is_confirm; ?> </td>
      		</tr> -->
      	</tr>
      	<?php 
      	} ?>
      	
      	</tbody>
      	<!-- <button class="btn btn-small btn-info" style="float: right;margin-top: -28px;" name="btn_deactivate" onclick='javascript: return print(this);'><i class="icon-ban-circle icon-white"></i> Print</button> -->
   
</table>