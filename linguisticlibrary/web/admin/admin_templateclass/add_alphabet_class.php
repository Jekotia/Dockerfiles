<?php

class add_alphabet_class
{
	var $postvar;
	function __add_alphabet_class()
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