<?php

class Pager  
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
	
		   return $ret;  
	       } 
       function getPageingLine($PageURL,$PageNo,$numPages,$class="text"){
		//For MultiLinagual
		

		$strFirst = "First";
		$strNext = "Next";
		$strLast = "Last";
		$strPrevious ="Prev" ;
		
		if ($PageNo == 1) // this is the first page - there is no previous page 
			echo $strFirst . " &nbsp;&nbsp; <&nbsp; ";
		else
			echo "<a href=\"$PageURL&page=1\" class='$class'>".$strFirst."</a> &nbsp;&nbsp; <&nbsp; ";

		if ($PageNo == 1) 
			echo $strPrevious;  
		else             
			echo "<a href=\"$PageURL&page=" . ($PageNo - 1) . "\" class='$class'>".$strPrevious."</a>";  
	
		//echo " --- ".$PageNo." ---".$numPages;

		if ($PageNo == $numPages) 
			echo  $strNext;  
		else            
			echo "<a href=\"$PageURL&page=" . ($PageNo + 1) . "\" class='$class'> ".$strNext."</a>";
	
		if ($PageNo == $numPages) 
			echo "> ". $strLast;  
		else 
			echo " &nbsp;> &nbsp;&nbsp;<a href=\"$PageURL&page=" . $numPages . "\" class='$class'> ".$strLast."</a>";	
       }

 function getPageingLine_Index($PageURL,$PageNo,$numPages,$class="text")
 	{
		//For MultiLinagual
		

		$strNext = "Next";
		$strPrevious ="Prev" ;
		
		echo "<table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"0\"><tr>";
		if ($PageNo == 1) 
			echo "<td align=\"left\">".$strPrevious."</td>";  
		else             
			echo "<td align=\"left\"><a href=\"$PageURL&page=" . ($PageNo - 1) . "\" class='$class'>".$strPrevious."</a></td>";  
	
		echo "<td width=\"150px\">&nbsp;<td>";

		if ($PageNo == $numPages) 
			echo "<td align=\"right\">".$strNext."</td>";  
		else            
			echo "<td align=\"right\"><a href=\"$PageURL&page=" . ($PageNo + 1) . "\" class='$class'> ".$strNext."</a></td>";
			
			echo "</tr></table>";
	
	  }

 function getPageingLine_pagenum($PageURL,$PageNo,$numPages,$rpp,$class="text"){
 
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
//echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

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
			echo "<a href=\"$PageURL&page=1\" class=$class>1</a>....";


		for ($pn=$stpage;$pn<=$edpage && $pn <=$numPages ;$pn++)
			{

			if($pn==$PageNo)
			echo " | <strong><span class=\"smtexto\">			".$pn."</span></strong>";
			else
			echo " | <a href=\"$PageURL&page=" . ($pn) . "\" class=$cls> ".$pn."</a>";
			}
if($numPages>$pn)
			echo ".....<a href=\"$PageURL&page=" . ($numPages) . "\" class=$class>".$numPages."</a>";

			//echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		if ($PageNo == $numPages) 
			echo " | " . $strNext;  
		else            
			echo " | <a href=\"$PageURL&page=" . ($PageNo + 1) . "\" class=$class> ".$strNext."</a>";
	
		if ($PageNo == $numPages) 
			echo " | ". $strLast;  
		else 
			echo " | <a href=\"$PageURL&page=" . $numPages . "\" class=$class> ".$strLast."</a>";	
       }
	


// New Function for Corazon...
function getPaging_pagenum($PageURL,$PageNo,$numPages,$rpp)
{

	 for($i=1;$i<=$numPages;$i++)
	 {
			if($i==$PageNo)
			$pagesRow	.="&nbsp;<span class=\"boxclass_select\"><span class=\"selectedpage\" align=\"center\">".$i."</span></span>&nbsp;";
			else
			$pagesRow	.="&nbsp;<span class=\"boxclass\" style1=\"1px solid #cccc99;\" align=\"center\"><a href=\"$PageURL&page=$i\" class=\"nopage\" style1=\"border:#999999 solid 1px;\">&nbsp;".$i."&nbsp;</a></span>&nbsp;";
	 }
		echo $pagingFormat	= "<span class=\"grey-txt\">Page</span> $pagesRow ";
	   
}

// function for paging when htaccess

function getPageingLine_pagenumber($PageURL,$PageNo,$numPages,$rpp,$class="text"){
		//For MultiLinagual
		$strFirst = "First";
		$strNext = "Next";
		$strLast = "Last";
		$strPrevious ="Prev" ;

		
		if ($PageNo == 1) // this is the first page - there is no previous page 
			echo $strFirst . " | ";
		else
			echo "<a href=\"$PageURL"."1/\" class=$class>".$strFirst."</a> | ";

		if ($PageNo == 1) 
			echo $strPrevious;  
		else             
			echo "<a href=\"$PageURL" . ($PageNo - 1) . "/\" class=$class>".$strPrevious."</a>";  
	
		//echo "------".$rpp." --- ".$PageNo." ---".$numPages;
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

$stpage=$PageNo-2;


if ($stpage<=1)
$stpage=1;

//if (($stpage%5)+1<=1)
//		$stpage= 1;


$edpage=$stpage + 3;

if ($stpage+3>= $numPages)
$stpage=$numPages-2;

if ($stpage<=0)
	$stpage=1;

if($stpage>1)
			echo "<a href=\"$PageURL\" class=$class>1</a>....";


		for ($pn=$stpage;$pn<=$edpage && $pn <=$numPages ;$pn++)
			{

			if($pn==$PageNo)
			echo " | <strong><span >".$pn."</span></strong>";
			else
			echo " | <a href=\"$PageURL" . ($pn) . "/\" class=$class> ".$pn."</a>";
			}
if($numPages>$pn)
			echo ".....<a href=\"$PageURL" . ($numPages) . "/\" class=$class>".$numPages."</a>";

			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		if ($PageNo == $numPages) 
			echo " | " . $strNext;  
		else            
			echo " | <a href=\"$PageURL" . ($PageNo + 1) . "/\" class=$class> ".$strNext."</a>";
	
		if ($PageNo == $numPages) 
			echo " | ". $strLast;  
		else 
			echo " | <a href=\"$PageURL" . $numPages . "/\" class=$class> ".$strLast."</a>";	
       }



//-----22 JUL----------------------------

 function getPageingLine_pagenum_array($PageURL,$PageNo,$numPages,$rpp,$class="text"){
		//For MultiLinagual
		$strFirst = "First";
		$strNext = "Next";
		$strLast = "Last";
		$strPrevious ="Prev" ;

		
		if ($PageNo == 1) // this is the first page - there is no previous page 
			echo $strFirst . " | ";
		else
			echo "<a href=\"javascript: fun_search('".$PageURL."&page=1')\" class=$class>".$strFirst."</a> | ";

		if ($PageNo == 1) 
			echo $strPrevious;  
		else             
			echo "<a  href=\"javascript: fun_search('".$PageURL."&page="  . ($PageNo - 1) . "')\" class=$class>".$strPrevious."</a>";  
	
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
			echo "<a href=\"javascript: fun_search('".$PageURL."&page=1')\" class=$class>1</a>....";


		for ($pn=$stpage;$pn<=$edpage && $pn <=$numPages ;$pn++)
			{

			if($pn==$PageNo)
			echo " | <strong><span class=\"smtexto\">			".$pn."</span></strong>";
			else
			echo " | <a  href=\"javascript: fun_search('".$PageURL."&page=" . ($pn)."');\" class=$cls> ".$pn."</a>";
			}
if($numPages>$pn)
			echo ".....<a href=\"javascript: fun_search('".$PageURL."&page=" . ($numPages) . "')\" class=$class>".$numPages."</a>";

			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		if ($PageNo == $numPages) 
			echo " | " . $strNext;  
		else            
			echo " | <a href=\"javascript: fun_search('".$PageURL."&page=" . ($PageNo + 1) . "')\" class=$class> ".$strNext."</a>";
	
		if ($PageNo == $numPages) 
			echo " | ". $strLast;  
		else 
			echo " | <a href=\"javascript: fun_search('".$PageURL."&page=" . $numPages . "')\" class=$class> ".$strLast."</a>";	
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


	   }
	   
	   $PAGER_INCLUDED=1;
	   ?>