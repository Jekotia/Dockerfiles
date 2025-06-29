<?php

class user_list_class
{
	var $postvar;
	function __user_list_class()
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
}//class
?>