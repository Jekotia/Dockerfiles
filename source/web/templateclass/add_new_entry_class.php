<?php
  
 class addnewentry
 {
 	
	var $postvar;
	function __addnewentry_class()
	{
		$this->postvar = array();
	}
	function setPostVar($postvar)
	{
		$this->postvar = $postvar;
	}
	function getPostVar()
	{
		return $this->postvar;
	}
	
	
 }   
    
    
?>