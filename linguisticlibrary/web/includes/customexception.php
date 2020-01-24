<?php
class customException extends Exception
 {
	 public function errorMessage()
	  {
	  //error message
	  $errorMsg = 'ERROR in mysql : <b>'.$this->getMessage().'</b>';
	  $headers  = "MIME-Version: 1.0\r\n"; 
	  $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
	  //$headers .= "From: <mail@mindsgroup.org>\r\n"; 
	 
	  return $errorMsg;
	  }
 }


?>