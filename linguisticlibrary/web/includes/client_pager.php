<?php
class ClientPager  
	   {  
	       function getPagerData($numHits, $limit, $page)  
	       {  
		  	$numHits  = (int) $numHits;  
		  $limit    = max((int) $limit, 1);  
		   $page     = (int) $page;  
		  	$numPages = ceil($numHits / $limit);  
	
		  $page = max($page, 1);  
		  $page = min($page, $numPages);  
	
			if ($page==0)
			   $offset = ($page) * $limit;  
			   else
			 $offset = ($page - 1) * $limit;  
			   
	
		   $ret = new stdClass;  
			
		   $ret->offset   = $offset;  
		   $ret->limit    = $limit;  
		   $ret->numPages = $numPages;  
		   $ret->page     = $page;  
		 /*  echo "<pre>";
			print_r($ret);
			echo "</pre>";*/
		   return $ret;  
	   } 

       function getPageingLine($PageURL,$PageNo,$numPages,$class="text")
	   {
		//For MultiLinagual
		$strFirst = "First";
		$strNext = "Next";
		$strLast = "Last";
		$strPrevious ="Prev" ;
		
		if ($PageNo == 1) // this is the first page - there is no previous page 
			echo $strFirst . " | ";
			
			
		else
			echo "<a href=\"$PageURL&page=1\" class=\"text\">".$strFirst."</a> | ";

		if ($PageNo == 1) 
			echo $strPrevious;  
		else             
			echo "<a href=\"$PageURL&page=" . ($PageNo - 1) . "\" class=\"text\">".$strPrevious."</a>";  
	
		//echo " --- ".$PageNo." ---".$numPages;

		if ($PageNo == $numPages) 
			echo "| " . $strNext;  
		else            
			echo "| <a href=\"$PageURL&page=" . ($PageNo + 1) . "\" class=\"text\"> ".$strNext."</a>";
	
		if ($PageNo == $numPages) 
			echo " | ". $strLast;  
		else 
			echo "| <a href=\"$PageURL&page=" . $numPages . "\" class=\"text\"> ".$strLast."</a>";	
       }



 function getPageingLine_pagenum($PageURL,$PageNo,$numPages,$rpp,$class="link_light_blue")
 {
 		
		//For MultiLinagual
		  $strFirst = "<<";		// first
		  $strNext = ">";		//next
		  $strLast = ">>";		//last
		  $strPrevious ="<" ;	//prev
		//echo $PageURL;
		
		if ($PageNo == 1) // this is the first page - there is no previous page 
		{	
			//echo $strFirst . " | ";
			echo "";
		}	
		else if($PageNo == 0)  
			{            
			echo "".$strFirst." | ";  
			}	
		else
		{
			echo "<a href=\"$PageURL&page=1\" class=\"link_light_blue\">".$strFirst."</a> | ";
		}
		if ($PageNo == 1) 
		{
			//echo $strPrevious."|";  
			echo "";
		}
		else if($PageNo == 0)  
			{            
			echo "".$strPrevious."&nbsp;&nbsp;".$PageNo;  
			}	
			else
			{
				echo "<a href=\"$PageURL&page=" . ($PageNo - 1) . "\" class=\"link_light_blue\">".$strPrevious."</a>";  
			}
		
		//echo "------".$rpp." --- ".$PageNo." ---".$numPages;
echo "&nbsp;&nbsp;&nbsp;";

$stpage=$PageNo-5;


if ($stpage<=1)
$stpage=1;

//if (($stpage%5)+1<=1)
//		$stpage= 1;


$edpage=$stpage + 9;

if ($stpage+10 >= $numPages)
$stpage=$numPages-9;

if ($stpage<=0)
	$stpage=1;

if($stpage>1)
			echo "<a href=\"$PageURL&page=1\" class=\"link_light_blue\">1</a>....";

//echo $numPages;
		for ($pn=$stpage;$pn<=$edpage && $pn <=$numPages ;$pn++)
			{

			if($pn==$PageNo)
			{
				if($pn==1 || $PageNo==1)
				{
					echo "  <strong><span class=\"link_light_blue\">			".$pn."</span></strong>";
				}
				else
				{
					echo " | <strong><span class=\"link_light_blue\">			".$pn."</span></strong>";
				}
			}
			else
			echo " | <a href=\"$PageURL&page=" . ($pn) . "\" class=\"link_light_blue\"> ".$pn."</a>";
			}
if($numPages>$pn)
			echo ".....<a href=\"$PageURL&page=" . ($numPages) . "\" class=\"link_light_blue\">".$numPages."</a>";

			echo "&nbsp;&nbsp;&nbsp;";
		if ($PageNo == $numPages) 
		{
			//echo " | " . $strNext;  
			echo "";
		}
		else            
			echo " | <a href=\"$PageURL&page=" . ($PageNo + 1) . "\" class=\"link_light_blue\"> ".$strNext."</a>";
	
		if ($PageNo == $numPages)
		{ 
			//echo " | ". $strLast;  
			echo "";
		}
		else 
			echo " | <a href=\"$PageURL&page=" . $numPages . "\" class=\"link_light_blue\"> ".$strLast."</a>";	
       }



// New Function for Corazon...
function getPaging_pagenum($PageURL,$PageNo,$numPages,$rpp)
{

	 for($i=1;$i<=$numPages;$i++)
	 {
			if($i==$PageNo)
			$pagesRow	.="&nbsp;<span class=\"text\"><u>".$i."</u></span>&nbsp;";
			else
			$pagesRow	.="&nbsp;<a href=\"$PageURL&page=$i\" class=\"text\" style=\"color:#000000\">".$i."</a>&nbsp;";
	 }
		echo $pagingFormat	= "<span class=\"text\">Page</span> $pagesRow ";
	   
}

//-----22 JUL----------------------------

 function getPageingLine_pagenum_array($PageURL,$PageNo,$numPages,$rpp,$class="text"){
		//For MultiLinagual
		echo "<br>first : ".$strFirst = "First";
		echo "<br>Next : ".$strNext = "Next";
		echo "<br>Last : ".$strLast = "Last";
		echo "<br>Prev : ".$strPrevious ="Prev" ;

		
		if ($PageNo == 1) // this is the first page - there is no previous page 
			echo $strFirst . " | ";
		else
			echo "<a href=\"javascript: fun_search('".$PageURL."&page=1')\" class=\"text\">".$strFirst."</a> | ";

		if ($PageNo == 1) 
			echo $strPrevious;  
		else             
			echo "<a  href=\"javascript: fun_search('".$PageURL."&page="  . ($PageNo - 1) . "')\" class=\"text\">".$strPrevious."</a>";  
	
		//echo "------".$rpp." --- ".$PageNo." ---".$numPages;
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

$stpage=$PageNo-5;


if ($stpage<=1)
$stpage=1;

//if (($stpage%5)+1<=1)
//		$stpage= 1;


$edpage=$stpage + 9;

if ($stpage+10 >= $numPages)
$stpage=$numPages-9;

if ($stpage<=0)
	$stpage=1;

if($stpage>1)
			echo "<a href=\"javascript: fun_search('".$PageURL."&page=1')\" class=\"text\">1</a>....";


		for ($pn=$stpage;$pn<=$edpage && $pn <=$numPages ;$pn++)
			{

			if($pn==$PageNo)
			echo " | <strong><span class=\"text\">			".$pn."</span></strong>";
			else
			echo " | <a  href=\"javascript: fun_search('".$PageURL."&page=" . ($pn)."');\" class=\"text\">".$pn."</a>";
			}
if($numPages>$pn)
			echo ".....<a href=\"javascript: fun_search('".$PageURL."&page=" . ($numPages) . "')\" class=\"text\">".$numPages."</a>";

			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		if ($PageNo == $numPages) 
			echo " | " . $strNext;  
		else            
			echo " | <a href=\"javascript: fun_search('".$PageURL."&page=" . ($PageNo + 1) . "')\" class=\"text\"> ".$strNext."</a>";
	
		if ($PageNo == $numPages) 
			echo " | ". $strLast;  
		else 
			echo " | <a href=\"javascript: fun_search('".$PageURL."&page=" . $numPages . "')\" class=\"text\"> ".$strLast."</a>";	
       }



//-----22 JUL----------------------------



	   }
	   
	   
	   
	   //-----22 JUL----------------------------
 function getPageingLine_pagenum_newsheetal($PageURL,$PageNo,$numPages,$rpp,$class="arial14")
 
 {
		//For MultiLinagual
		$strFirst = "First";
		$strNext = "Next";
		$strLast = "Last";
		$strPrevious ="Prev" ;
		
		
		if ($PageNo == 1) // this is the first page - there is no previous page 
			echo $strFirst . " | ";
		else
			echo "<a href=\"$PageURL&page=1\" class=\"$class\">".$strFirst."</a> | ";

		if ($PageNo == 1) 
			echo $strPrevious;  
		else             
			echo "<a href=\"$PageURL&page=" . ($PageNo - 1) . "\" class=$class>".$strPrevious."</a>";  
	
		//echo "------".$rpp." --- ".$PageNo." ---".$numPages;
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

$stpage=$PageNo-1;


if ($stpage<=1)
$stpage=1;

//if (($stpage%5)+1<=1)
//		$stpage= 1;


$edpage=$stpage + 2;

if ($stpage+2>= $numPages)
$stpage=$numPages-1;

if ($stpage<=0)
	$stpage=1;

if($stpage>1)
       echo "<span onClick=\"pagingdomainauction('$PageURL?page=1');\">1</span>.... ";	


		for ($pn=$stpage;$pn<=$edpage && $pn <=$numPages ;$pn++)
			{

			if($pn==$PageNo)
			echo " | <strong><span class=\"smtexto\">			".$pn."</span></strong>";
			else
			echo " | <a href=\"$PageURL&page=" . ($pn) . "\" class=$cls> ".$pn."</a>";
			}
if($numPages>$pn)
			echo ".....<a href=\"$PageURL&page=" . ($numPages) . "\" class=$class>".$numPages."</a>";

			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		if ($PageNo == $numPages) 
			echo " | " . $strNext;  
		else            
			echo " | <a href=\"$PageURL&page=" . ($PageNo + 1) . "\" class=$class> ".$strNext."</a>";
	
		if ($PageNo == $numPages) 
			echo " | ". $strLast;  
		else 
			echo " | <a href=\"$PageURL&page=" . $numPages . "\" class=$class> ".$strLast."</a>";	
       }

	   
	   $PAGER_INCLUDED=1;
	   ?>