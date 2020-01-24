<?php
class admin_listing_class
{
			var $postVar;
			function __admin_listing_class()
			{
				$this->postVar = array();
			}

		//set & get
			function setpostvar($postVar)
			{
				$this->postVar =$postVar;
			}
			function getpostvar()
			{
				return $this->postVar;
			}
			function setStatus($statusId)
			{
				$this->statusId = $statusId;
			}
			function getStatus()
			{
				return $this->statusId;
			}
}
?>