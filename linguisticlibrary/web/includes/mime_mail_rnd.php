<?php
class mime_mail_rnd extends PicSQL
{ 
var $parts; 
var $to; 
var $from; 
var $headers; 
var $subject; 
var $body; 

function mime_mail_rnd($DBName = "")
{ 
	$this->parts = array(); 
	$this->to =  ""; 
	$this->from =  ""; 
	$this->reply =  ""; 
	$this->from =  ""; 

	$this->subject =  ""; 
	$this->body =  ""; 
	$this->headers =  ""; 
    $this->PicSQL($DBName);
} 

function mime_mail_blank()
{ 
	$this->parts = array(); 
	$this->to =  ""; 
	$this->from =  ""; 
	$this->reply =  ""; 
	$this->from =  "";
 
	$this->subject =  ""; 
	$this->body =  ""; 
	$this->headers =  ""; 
} 


function add_attachment($message, $name =  "", $ctype =  "application/octet-stream") 
{ 
	$this->parts[] = array ( "ctype" => $ctype, "message" => $message, "encode" => $encode, "name" => $name ); 
} 

function build_message($part) 
{ 
	$message = $part["message"]; 
	$message = chunk_split(base64_encode($message)); 
	$encoding =  "base64"; 
	return  "Content-Type: ".$part[ "ctype"].($part[ "name"]? "; name = \"".$part[ "name"]. "\"" :  "").   "\nContent-Transfer-Encoding: $encoding\n\n$message\n"; 
} 

function build_multipart() 
{ 
	$boundary =  "b".md5(uniqid(time())); 
	$multipart =  "Content-Type: multipart/mixed; boundary = $boundary\n\nThis is a MIME encoded message.\n\n--$boundary"; 
	
	for($i = sizeof($this->parts)-1; $i >= 0; $i--) 
    { 
		$multipart .=  "\n".$this->build_message($this->parts[$i]). "--$boundary"; 
    } 
	return $multipart.=  "--\n"; 
} 

function send($body_val) 
{ 
    $mime .=  "MIME-Version: 1.0\n";
	$mime .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
	$mime .="From: ".SITENAME." <".$this->from.">\r\n"; 
	//echo $mime;
	@mail($this->to, $this->subject, $body_val, $mime); 	
} 


function getMailDetails($mailid)
{
	global $db;
	$sql_mail="SELECT * FROM  mail WHERE  mail_name='".$mailid."'";
	$res_mail=$db->select_data($sql_mail);

	return $res_mail;

} // end of function getMailDetails

/*function getMailHeaders()
{
	$mHeaders .= "MIME-Version: 1.0\r\n";
	$mHeaders = "From: ".SITE_NAME."<webminds.team@gmail.com>\r\n";
	$mHeaders .= "Content-Type: text/html; charset=iso-8859-1\r\n"; 

	return $mHeaders;

} */// end of fucntion getMailHeaders

};  //--------end of class 

?>