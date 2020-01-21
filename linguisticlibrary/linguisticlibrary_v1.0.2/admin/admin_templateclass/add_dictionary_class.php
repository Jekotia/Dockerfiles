<?php

class add_dictionary_class
{
	var $postvar;
	function __add_dictionary_class()
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