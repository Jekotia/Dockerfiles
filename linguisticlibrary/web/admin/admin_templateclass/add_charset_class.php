<?php

class add_charset_class
{
	var $postvar;
	function __add_charset_class()
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