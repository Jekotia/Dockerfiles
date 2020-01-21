<?php

class add_website_class
{
	var $postvar;
	function __add_website_class()
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