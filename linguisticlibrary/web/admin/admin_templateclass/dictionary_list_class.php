<?php
	class dictionary_list_class
		{
			var $postVar;
			function __dictionary_list_class()
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
			function setDeleteId($delId)
			{
				$this->delId = $delId;				
			}
			function getDeleteId()
			{
				return $this->delId;				
			}
		}
?>