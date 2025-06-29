<?php
include_once("customexception.php");

Class DBSQL
{
   function DBSQL($DB_NAME)
   {    
	  
	  
	 // echo $DB_NAME; exit;
	  
	 // if(USE_PCONNECT)
		//$conn = mysql_pconnect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD)  or die(mysql_error()."No Connection");
	 // else
	  global $DB_HOST,$DB_USER,$DB_PASS;
	  $conn=mysql_connect($DB_HOST,$DB_USER,$DB_PASS);
	
	  mysql_select_db(DB_NAME,$conn); 

	  $this->CONN = $conn;
	  return true;
   }
   
   function select($sql="")
   {
   
   	
   
	  if (empty($sql)) return false;
      if (empty($this->CONN)) return false; 
	    $conn = $this->CONN; 
	  $results = mysql_query($sql,$conn);
	
		//print_r($results); exit;
	
	  if ((!$results) or (empty($results)))
      { 
		
	   try
	   {
		$sqlError	= $_SERVER['HTTP_HOST']."<br>".mysql_errno() . ": " . mysql_error() ." in ".$sql." on ".basename($_SERVER['PHP_SELF']);
		throw new customException($sqlError);	
	   }
	   catch (customException $e)
		{
		 //display custom message
		 $e->errorMessage();
		}
	  
         return false;
      }
      $count = 0;
      $data = array();
      while ($row =@mysql_fetch_array($results)) {
         $data[$count] = $row;
         $count++;
      }
      $count;
	  @mysql_free_result($results);
      return $data;
   }
 function selectass($sql="")
   {
	  if (empty($sql)) return false;
      if (empty($this->CONN)) return false;
      $conn = $this->CONN;
	  $results = mysql_query($sql,$conn);
	
	  if ((!$results) or (empty($results)))
      { 
		
	   try
	   {
		$sqlError	= $_SERVER['HTTP_HOST']."<br>".mysql_errno() . ": " . mysql_error() ." in ".$sql." on ".basename($_SERVER['PHP_SELF']);
		throw new customException($sqlError);	
	   }
	   catch (customException $e)
		{
		 //display custom message
		 $e->errorMessage();
		}
	  
         return false;
      }
      $count = 0;
      $data = array();
      while ($row = @mysql_fetch_array($results,MYSQL_ASSOC)) {
         $data[$count] = $row;
         $count++;
      }
      $count;
	  @mysql_free_result($results);
      return $data;
   }
   
   function insert($sql="")
   {
      if (empty($sql)) return false;
      if (empty($this->CONN)) return false;

      $conn = $this->CONN;
      $results = mysql_query($sql,$conn);
      if (!$results)
	   {
			try
		   {
			$sqlError	= $_SERVER['HTTP_HOST']."<br>".mysql_errno() . ": " . mysql_error() ." in ".$sql." on ".basename($_SERVER['PHP_SELF']);
			throw new customException($sqlError);	
		   }
		   catch (customException $e)
			{
			 //display custom message
			 $e->errorMessage();
			}

		return false;
	   }
      $results = mysql_insert_id();
      return $results;
   }

   
   function update($sql="")
   {
      if(empty($sql)) return false;
      if(empty($this->CONN)) return false;

      $conn = $this->CONN;
      $result = mysql_query($sql,$conn);
	  if(!$result)
	   {
		   try
		   {
			$sqlError	= $_SERVER['HTTP_HOST']."<br>".mysql_errno() . ": " . mysql_error() ." in ".$sql." on ".basename($_SERVER['PHP_SELF']);
			throw new customException($sqlError);	
		   }
		   catch (customException $e)
			{
			 //display custom message
			 $e->errorMessage();
			}

	  }

      return $result;
   }
   
   

   
   function delete($sql="")
   {
      if(empty($sql)) return false;
      if(empty($this->CONN)) return false;

      $conn = $this->CONN;
      $result = mysql_query($sql,$conn);
	  if(!$result)
	  {
		  try
		   {
			$sqlError	= $_SERVER['HTTP_HOST']."<br>".mysql_errno() . ": " . mysql_error() ." in ".$sql." on ".basename($_SERVER['PHP_SELF']);
			throw new customException($sqlError);	
		   }
		   catch (customException $e)
			{
			 //display custom message
			 $e->errorMessage();
			}

	  }
      return $result;
   }
   
   function sql_fetch_object($sql="")
   {
      if(empty($sql)) return false;
      if(empty($this->CONN)) return false;

      $conn = $this->CONN;
      $result = mysql_query($sql,$conn);
	  if(!$result)
	   {
		   try
		   {
			$sqlError	= $_SERVER['HTTP_HOST']."<br>".mysql_errno() . ": " . mysql_error() ." in ".$sql." on ".basename($_SERVER['PHP_SELF']);
			throw new customException($sqlError);	
		   }
		   catch (customException $e)
			{
			 //display custom message
			 $e->errorMessage();
			}

	  }
		////////////////////////	

      return $result;
   }
   
////////////////////////////////////////////////////////////

function db_fetch_object($set)
{
// Start by getting the usual array 
	if(empty($set)) return false;
    if(empty($this->CONN)) return false;
	
    $conn = $this->CONN;
	$row = mysql_fetch_object($set);
	if ($row === null) return null;
	
	foreach($row as $key => $value)
	{
		$this->$key = $value;
	}
	return $this;
}
///////////////////////////////////////////////////////////
   function createtable($sql="")
   {
      if(empty($sql)) return false;
      if(empty($this->CONN)) return false;

      $conn = $this->CONN;
      $result = mysql_query($sql,$conn);
      return $result;
   }
   
   function droptable($sql="")
   {
      if(empty($sql)) return false;
      if(empty($this->CONN)) return false;

      $conn = $this->CONN;
      $result = mysql_query($sql,$conn);
      return $result;
   }
   
   function createindex($sql="")
   {
      if(empty($sql)) return false;
      if(empty($this->CONN)) return false;

      $conn = $this->CONN;
      $result = mysql_query($sql,$conn);
      return $result;
   }
   
   function dropindex($sql="")
   {
      if(empty($sql)) return false;
      if(empty($this->CONN)) return false;

      $conn = $this->CONN;
      $result = mysql_query($sql,$conn);
      return $result;
   }

}

?>