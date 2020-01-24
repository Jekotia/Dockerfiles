<?php
include('../includes/applicationTop.php');

 date_default_timezone_set('UTC'); 
$query="SHOW CREATE TABLE `tbl_menu`";
$result=$db->select_data($query);
 //$cnt=count($result);
  
    $headers   =$result[0]['Create Table'];
    $headers  .=";";
    $starttime = microtime(true);
	$headers  .= "-- MySql Data Dump\n\n";
	$headers  .= "-- Database : Custom PHP Post \n\n";
	$headers  .= "-- Dumping started at : ". date("Y-m-d-h-i-s") .  "\n\n";
     

	//for($t=0;$t<count($tables);$t++){
	//	$outputdata .= "\n\n-- Dumping data for table : $tables[$t]\n\n";
		$sql = "SELECT * FROM `tbl_menu`";
		$result = mysql_query($sql);
		while($row = mysql_fetch_assoc($result)){
			 $nor = count($row);
			 $datas = array();
			
			//$nor=count($result);
			foreach($row as $r){
				$datas[] = $r;
			}
			$lines .= "INSERT INTO `tbl_menu` VALUES (";
			for($i=0;$i<$nor;$i++){
				//echo $datas[$i];
				if($datas[$i]===NULL){
					$lines .= "NULL";
				}else if((string)$datas[$i] == "0"){
					$lines .= "0";
				}else if(filter_var($datas[$i],FILTER_VALIDATE_INT) || filter_var($datas[$i],FILTER_VALIDATE_FLOAT)){
					$lines .= $datas[$i];
				}else{
					$lines .= "'" . str_replace("\n","\\n",$datas[$i]) . "'";
				}
				if($i==$nor-1){
					$lines .= ");\n";
				}else{
					$lines .= ",";
				}
			}
		    $outputdata .= $lines;
			$lines = "";
		  }
//	}
	$headers .= "-- Dumping finished at : ". date("Y-m-d-h-i-s") .  "\n\n";
	$endtime = microtime(true);
	$diff = $endtime - $starttime;
	$headers .= "-- Dumping data of custom_php_post took : ". $diff .  " Sec\n\n";
	$headers .= "-- --------------------------------------------------------";
	 echo $datadump = $headers . $outputdata;

	//$file = fopen("tbl_dictionary.sql","w");
	//$len = fwrite($file,$datadump);
	 header('Content-type: text/plain');

     header('Content-Disposition: attachment; filename="'."tbl"."_"."menu_".date('YmdHis').'.sql"');
	 
	//fclose($file);
	//if($len != 0){
	//	return true;
	//}else{
	//	return false;
	//}
//      
?>