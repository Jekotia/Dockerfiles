<?php
class add_admin_class
{
		var $fldPostVar;
		var $fldUsername;
		var $fldPassword;
		var $fldConPassword;
		var $fldmail;
		function __add_admin_class()
		{
			$this->fldPostVar	=	array();
			$this->fldUsername	=	"";
			$this->fldPassword	=	"";
			$this->fldConPassword	=	"";
			$this->fldmail	=	"";
		}
		//set
		function setPostVar($fldPostVar)		{			$this->fldPostVar	=	$fldPostVar;			}
		function setUserName($fldUsername)		{			$this->fldUsername	=	$fldUsername;			}
		function setMail($fldmail)		{			$this->fldmail	=	$fldmail;			}
		function setPassword($fldPassword)		{			$this->fldPassword	=	$fldPassword;			}
		function setConfirmPassword($fldConPassword)		{			$this->fldConPassword	=	$fldConPassword;			}		function setConfirmPh($fldConPh)		{			$this->fldConPh	=	$fldConPh;			}
		function setimg($fldimg)		{			$this->fldimg	=	$fldimg;			}
		//get
		function getPostVar()		{			return $this->fldPostVar;			}
		function getUserName()		{			return  $this->fldUsername;			}
		function getMail()		{			return $this->fldmail;			}
		function getPassword()		{			return $this->fldPassword;			}		function getConfirmPassword()		{			return $this->fldConPassword;			}		function getConfirmPh()		{			return $this->fldConPh;			}		function getimg()		{			return $this->fldimg;			}	}
?>