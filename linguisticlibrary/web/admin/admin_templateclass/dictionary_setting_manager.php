<?php 
include("dictionary_setting_class.php");
class dictionary_setting_manager
{
	function csv_valid()
	{
	 	$csvfile   = $_FILES["sel_csvfile1"]["name"];		
		$is_csv    = strpos($csvfile, ".csv");
		if ($is_csv===FALSE)
		{
			$error[0] = "Please Upload CSV File";
		}	
		/*else {
				$act_csvfile  = $_FILES["sel_csvfile1"]["tmp_name"];
		        $handle       = fopen($act_csvfile, 'r');
				$data         = fgetcsv($handle, 1000, "@");				
				$expected_columnnames    = "Root,IPA,Part_of_Speech,Meaning,Source";
				$expected_columnnamesarr = explode(",", $expected_columnnames);
				foreach ($data as $cname)
				{
					if (!in_array($cname, $expected_columnnamesarr))
					{
						$error[0]="CSV column names (1st row) must be one from the set $expected_columnnames.<br>Please download sample CSV formats from this page.";
					}
				}
	    }*/
		if (count($error)==0)
		{
		 	   $message	= $this->csv();
		}
		return $error;
	}
	function csv()
	{
		global $db;
		$csvfile     = $_FILES["sel_csvfile1"]["tmp_name"];
		$handle      = fopen($csvfile, 'r');
		 $col_cnt = fgetcsv($handle, 1000, "@");
	  $cnt=count($col_cnt);
//	print_r($col_cnt);
                 $sql="DROP TABLE tbl_dictionary";
			      $qur=mysql_query($sql);
	        $sql1="CREATE TABLE IF NOT EXISTS `tbl_dictionary` (`id` int(11) NOT NULL AUTO_INCREMENT,";
             for($i=0;$i<$cnt;$i++)
			 {
			 	$sql1.="`$col_cnt[$i]` varchar(255)  CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,"; 
			 }	
	         $sql1.="PRIMARY KEY (`id`)) ";
           //echo $sql1 ;
          // die; 		
		  $qur1=mysql_query($sql1); 
		  $get_cols = $db->select_data("SHOW COLUMNS FROM `tbl_dictionary`");
		  $tot_cols = count($get_cols);
		$row=-0;
		//Note : Date Format in csv file is mm/dd/yy
		while (($data = fgetcsv($handle, 1000, "@")) !== FALSE)
		{
				$colnms="";
				$values="";
				$upcolumn="";
			 	$row++;	
				if ($row>0)
				{					
//In below for loop, the $iq=1 is set to skip 1st column `id` which is auto_increment and has no role in insert & update query 
				for ($i1=1; $i1 < $tot_cols; $i1++) 
				  { 
//Insert Query Generation
					 	$colnms.="`".$get_cols[$i1][0]."`";																	
					 	$values.="'".$data[$i1-1]."'";
//Update Query Generation
					 	$upvalue="'".$data[$i1-1]."'";							 						  						  
					 	$upcolumn.="`".$get_cols[$i1][0]."`"."=".$upvalue; 
//Append ,(comma) to query till second last in the insert/update query
					    if ($i1 < $tot_cols-1)
						{
							$colnms.=",";
							$values.=",";
							$upcolumn.=",";
						}//if
		           }//for						 
				   $ins_qury="INSERT INTO `tbl_dictionary`($colnms) VALUES($values)";						 					 							 
				   $db->insert_data($ins_qury);		
				}
		}//while		
	}
}//class
?>