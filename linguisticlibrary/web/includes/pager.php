<?php
class Pager  
	   {  
	      static  function getPagerData($numHits, $limit, $page)  
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
  static function getPageingLine_pagenum($PageURL,$PageNo,$numPages,$rpp,$class="text"){
 
		//For MultiLinagual
		$strFirst = "First";
		$strNext = " Next";
		$strLast = " Last";
		$strPrevious ="Prev" ;
		if ($PageNo==1) // this is the first page - there is no previous page 
			echo "<a class='button'><span><img width='12' height='9' alt='First' src='images/arrow-stop-180-small.gif'> ".$strFirst."</span></a>" ;
		else
			echo "<a class='button' href=\"$PageURL&page=1\" ><span><img width='12' height='9' alt='First' src='images/arrow-stop-180-small.gif'> ".$strFirst."</span></a>";

		if ($PageNo==1) 
			echo "<a class='button'><span><img width='12' height='9' alt='Prev' src='images/arrow-180-small.gif'>".$strPrevious."</span></a>";  
		else             
			echo "<a href=\"$PageURL&page=" . ($PageNo - 1) . "\" class='button'><span><img width='12' height='9' alt='Prev' src='images/arrow-180-small.gif'> ".$strPrevious."</span></a>";  
	
        echo "<div class='numbers'>";
$stpage=$PageNo-5;
if ($stpage<=1)
$stpage=1;
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
           echo "</div>";
			//echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			if ($PageNo == $numPages) 
			echo "<a class='button' style='float: right;'><span><img width='12' height='9' alt='Last' src='images/arrow-stop-000-small.gif'> ".$strLast."</span></a>";  
		else 
			echo "<a href=\"$PageURL&page=" . $numPages . "\" class='button' style='float: right;'><span><img width='12' height='9' alt='Last' src='images/arrow-stop-000-small.gif'> ".$strLast."</span></a>";	
		if ($PageNo == $numPages) 
			echo "<a class='button' style='float: right;'><span><img width='12' height='9' alt='Next' src='images/arrow-000-small.gif'> ".$strNext."</span></a>";  
		else            
			echo "<a class='button' style='float: right;' href=\"$PageURL&page=" . ($PageNo + 1) . "\" ><span><img width='12' height='9' alt='Next' src='images/arrow-000-small.gif'> ".$strNext."</span></a>";
       }
static function getPageingLine_pagenum_client($PageURL,$PageNo,$numPages,$rpp,$class="text"){
 
		//For MultiLinagual
		$strFirst = "First";
		$strNext = " Next";
		$strLast = " Last";
		$strPrevious ="Prev" ;
		if ($PageNo==1) // this is the first page - there is no previous page 
			echo "<a class=''><span><font color='#C7C5C7'>".$strFirst."</font></span></a>" ;
		else
			echo "<a class='' href=\"$PageURL&page=1\" ><span> ".$strFirst."</span></a>";

		if ($PageNo==1) 
			echo "<a class=''><span><font color='#C7C5C7'>".$strPrevious."</font></span></a>";  
		else             
			echo "<a href=\"$PageURL&page=" . ($PageNo - 1) . "\" class='button'><span> ".$strPrevious."</span></a>";  
	
        echo "<div class=''>";
$stpage=$PageNo-5;
if ($stpage<=1)
$stpage=1;
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
			echo "<strong><span class=\"\">			".$pn."</span></strong>";
			else
			echo "<a href=\"$PageURL&page=" . ($pn) . "\" class=$cls> ".$pn."</a>";
			}
if($numPages>$pn)
			echo ".....<a href=\"$PageURL&page=" . ($numPages) . "\" class=$class>".$numPages."</a>";
           echo "</div>";
			//echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		if ($PageNo == $numPages) 
			echo "<a class='' ><span><font color='#C7C5C7'>".$strNext."</font></span></a>";  
		else            
			echo "<a class='' href=\"$PageURL&page=" . ($PageNo + 1) . "\" ><span> ".$strNext."</span></a>";
		if ($PageNo == $numPages) 
			echo "<a class='' ><span><font color='#C7C5C7'>".$strLast."</font></span></a>";  
		else 
			echo "<a href=\"$PageURL&page=" . $numPages . "\" class='button' ><span> ".$strLast."</span></a>";
       }


static function getPageingLine_pagenum_client1($PageURL,$PageNo,$numPages,$rpp,$class="text"){
	
	
	$strNext = " Next";
	$strPrevious ="Previous" ;
	if ($PageNo==1) 
		echo "<a class='btn btn-mini btn-primary m_r8'>".$strPrevious."</a>";  
	else             
		echo "<a href=\"$PageURL&page=" . ($PageNo - 1) . "\" class='btn btn-mini btn-primary m_r8'> ".$strPrevious."</a>";  
	       
	$stpage=$PageNo-5;
	if ($stpage<=1)
		$stpage=1;
		$edpage=$stpage + 3;
	if ($stpage+4 >= $numPages)
		$stpage=$numPages-3;
	if ($stpage<=0)
		$stpage=1;
	if($stpage>1)
		echo "<a href=\"$PageURL&page=1\" class=\"btn btn-mini btn-inverse m_r8\" > 1 </a>....";
		for ($pn=$stpage;$pn<=$edpage && $pn <=$numPages ;$pn++)
		{
			if($pn==$PageNo)
			echo "<span class=\"btn btn-mini btn-inverse m_r8\"> ".$pn." </span>";
			else
			echo " <a href=\"$PageURL&page=" . ($pn) . "\" class=\"btn btn-mini btn-primary m_r8\"> ".$pn."</a>";
		}
	if($numPages>$pn)
			echo ".....<a href=\"$PageURL&page=" . ($numPages) . "\" class=\"btn btn-mini btn-primary m_r8\">".$numPages."</a>";
	if ($PageNo == $numPages) 
		echo "<a class='btn btn-mini btn-primary m_r8'>".$strNext."</a>";  
	else            
		echo "<a class='btn btn-mini btn-primary m_r8'  href=\"$PageURL&page=" . ($PageNo + 1) . "\" >".$strNext."</a>";
	 }
}
	   $PAGER_INCLUDED=1;
?>