<?php 
include 'header1.php';
if(isset($_POST['submit']))
{
	
	if (isset($_POST['check']) && !empty($_POST['check'])) {
     ucfirst_utf8($_POST['check']);
	}
}
function ucfirst_utf8($str) {
	global $db;
    if (mb_check_encoding($str,'UTF-8')) {
    	echo "This is UTF encoding";
		//$ins_data = "insert into tbl_texts1(name) values('$str')";
		echo $ins_data = "INSERT INTO `add_new_entry` (sindarin_text) VALUES ('$str')";
	//	$db->insert_data($ins_data);
    } else {
    	echo "This is Not UTF encoding";
    }
}
?>
<style>	
	td{
		color:black;
	}
.highslide-container
	{
		left:20px !important;
	}
	.main_tr{
		/*overflow-x: scroll;*/
		width:100%;
	}
</style>
<script type="text/javascript" src="js2/highslide/highslide-with-html.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="js2/highslide/highslide.css" />
<script type="text/javascript">
    hs.graphicsDir = 'js2/highslide/graphics/';
    hs.outlineType = 'rounded-white';
	hs.lang.creditsText = '';
	hs.lang.creditsTitle= '';
</script>
<!--<script type="text/javascript" src="js2/add_new_entry_js.js"></script>-->
<script>
function add_row(val,id) // Same function called for Split / Unsplit button and Add More button
{		               
   var no     = id.split('_');
   var idname = no[0]+'_sub_tr_'+no[2]; //syn_split_0 => 0=>syn 1=>sub 2=>0    .... splitted values ....
                 				   // Thus prepare the subtr div id to hide or show it.                    				   	
   if(val == "Split") 
   {   	   
   	document.getElementById(id).value='Unsplit';     	  
   	document.getElementById(idname).style.display='block'; 
   	document.getElementById(idname).setAttribute("style","width:50px")     
       
     /////////////////////// On one row only 1 slit is allowed  (Either Synderin Or English)///////////
     if (no[0]=='syn'){
     	idname1='eng_sub_tr_'+no[2];
     	id1='eng_split_'+no[2]; 
     	
     	 /*var synd_order    =  document.getElementsByName('synd_order[]');
		 for(so=0;so<synd_order.length;so++){
				//	alert('so value'+so)
					synd_order[so].value=so+1;
		 }*/
     }
     if (no[0]=='eng'){
     	idname1='syn_sub_tr_'+no[2];
     	id1='syn_split_'+no[2]; 
     	
		   /*var eng_orders    =  document.getElementsByName('eng_order[]');
		   for(eo=0;eo<eng_orders.length;eo++){
				//	alert('so value'+so)
					eng_orders[eo].value=eo+1;
			}*/
     	
     }
       
 	document.getElementById(id1).value='Split';
   	document.getElementById(idname1).style.display='none';
   	//////////////////////////////Set Null values to split ted text boxes ////////////////////////////
   	var eng_arr  = document.getElementsByName('eng_txt_sub[]');
   	eng_arr[no[2]].value='';    
   	var synd_arr = document.getElementsByName('synd_text_sub[]');
   	synd_arr[no[2]].value='';      
      //////////////////////////////////////////////////////////////////////////////////////////////
   } 
   else 
   {   	
 	document.getElementById(id).value='Split';
   	document.getElementById(idname).style.display='none';    
   }
}//add_row
function set_new_menu(menu_id,curr_seldiv_id,sel_name)
{	
	curr_seldiv_id = '#'+curr_seldiv_id;
	var get_no   = curr_seldiv_id.split('_'); 
	var id_no    = get_no[3];
	var menu_div = document.getElementsByClassName('menu_div');//responce set to respctive select div only
	$.ajax({		
		type:'GET',
		url:'menu_ajax_a.php?menu_id='+menu_id+'&sel_name='+sel_name+'&curr_seldiv_id='+id_no,
		catche:false,
		success:function(menudata){
			//alert(menudata);
         	$(menu_div[id_no]).append(menudata);
		}
	});
}
function reset_this_menu(menu_id,curr_seldiv_id,sel_name)
{
	var get_index      = curr_seldiv_id.split('_');
	var morph_ind  = get_index[2];
	//alert(morph_ind);
//<--------- Delete All cascading select box in clonned row. Only keep main root select menu -------->
	var all_div   = document.getElementsByClassName('menu_div');
    saved = $("#main_select_menu_0").clone().wrap('<div/>').parent().html();//get main select menu in variable
    //alert(saved); 
    all_div[morph_ind].innerHTML=saved;//assign that variable to last row select section
	set_attribute_toclass('id','main_select_menu');//attribute to set , class name
	set_attribute_toclassname('name','main_select_menu');//attribute to set , class name   	    
//<------------------------------------------------------------------------------------------------>//
}

var cnt=0;
$(document).ready(function(){
	
   // set_order('synd_order[]');
   // set_order('eng_order[]');
    remove_this('head_title');
    remove_this('head_order');
    
    for (mk=0;mk<6;mk++){    	
    	$('#main_tr').clone().appendTo('#clone_tr');
   	     $('#root_'+mk).keyup(username_check);
   	    //remove_this('head_title');
    	//remove_this('head_order');
    }

	set_attribute_toclass('id','main_tr');
	$('#main_tr_0').remove();
	set_attribute_toclass('id','main_tr');

	set_attribute_toclass('id','head_title');//attribute to set , class name
	set_attribute_toclass('id','head_order');//attribute to set , class name

	for (mk=1;mk<6;mk++){
			$('#head_title_'+mk).remove();			
			$('#head_order_'+mk).remove();
    }	
	set_attribute_toclass('id','syn_sub_tr');//attribute to set , class name
	set_attribute_toclass('id','eng_sub_tr');//attribute to set , class name
	set_attribute_toclass('id','syn_split');//attribute to set , class name
	set_attribute_toclass('id','eng_split');//attribute to set , class name
	set_attribute_toclass('id','main_select_menu');//attribute to set , class name
	set_attribute_toclass('id','synd_textcls');//attribute to set , class name
	set_attribute_toclass('id','eng_textcls');//attribute to set , class name
	set_attribute_toclass('id','alpha_cls');//attribute to set , class name
	set_attribute_toclass('id','alpha_image_cls');//attribute to set , class name
	set_attribute_toclass('id','syn_cls');//attribute to set , class name
	set_attribute_toclass('id','eng_cls');//attribute to set , class name
	set_attribute_toclass('id','root');//attribute to set , class name
	set_attribute_toclassname('name','main_select_menu');//attribute to set , class name
	set_attribute_toclass('id','linkj');
	set_attribute_toclass('id','cross');
	set_attribute_toclass('name','reset_form');//attribute to set , class name
	//set_attribute_toclassname('name','sel_reset');
	set_attribute_toclass('id','disp1');//attribute to set , class name
	set_attribute_toclass('id','disp');//attribute to set , class name
   	set_attribute_toclass('id','codex');//attribute to set , class name
	set_attribute_toclass('id','codex_2');//attribute to set , class name
	set_attribute_toclass('id','codex_1');//attribute to set , class name
    set_attribute_toclass('id','codex_sub');//attribute to set , class name
    set_attribute_toclass('id','codex_sub_a');//attribute to set , class name


    var synd_order    =  document.getElementsByName('synd_order[]');
	for(so=0;so<synd_order.length;so++){
	//	alert('so value'+so)
		synd_order[so].value=so+1;
	}
    var synd_order    =  document.getElementsByName('eng_order[]');
	for(so=0;so<synd_order.length;so++){
	//	alert('so value'+so)
		synd_order[so].value=so+1;
	}
    
    /*$('#add_more').trigger('click');
    $('#add_more').trigger('click');
    $('#add_more').trigger('click');
    $('#add_more').trigger('click');
    $('#add_more').trigger('click');*/
    /*add_more_row(1);
    add_more_row(1);
    add_more_row(1);
    add_more_row(1);
    add_more_row(1);*/
   	set_attribute_toclass('id','sel_reset');
	var doc_class1   = document.getElementsByClassName('sel_reset');
	var totclassele1 = doc_class1.length;	
	
	for (sp=0;sp<totclassele1;sp++){		
		doc_class[sp].setAttribute('name',"sel_reset_"+sp+"[]");		
	}

   
   
   

});
function remove_this(classname){
   var all_tblhead  = document.getElementsByClassName(classname);
   var tot_head     = all_tblhead.length;
   for(tbl=1;tbl<tot_head;tbl++){
   	  all_tblhead[tbl].remove();
   } 		
}
function validation()
{
	var synd_order    =  document.getElementsByName('synd_order[]');
    var synd_text     =  document.getElementsByName('synd_text[]');
    var eng_order     =  document.getElementsByName('eng_order[]');
    var eng_txt       =  document.getElementsByName('eng_txt[]');
    var alpha         =  document.getElementsByName('alpha[]');
    var annotation    =  document.getElementsByName('anno[]');
    var root_word     =  document.getElementsByName('root_sty[]');
    var filesound_length=document.getElementsByName('file_sound[]');
    var postname      =  document.getElementById('txt1');
    var searchtag     =  document.getElementById('searchtag');
    var letter        = '/^[0-9]+$/';
       
    if(postname.value.trim()=='')
    {
      	alert("Please fill Post Name");
       	return false;
    }
    if(synd_order[0].value.trim()==''|| synd_text[0].value.trim()==''||eng_order[0].value.trim()==''||eng_txt[0].value.trim()=='')//||root_word[0].value.trim()==''
    {
     		alert("Please Fill First Row");
     		return false;
    }
    
  
   
  for(i=0;i<filesound_length.length;i++)
  {
  	var filesound_name=filesound_length[i].value;
  	var file_Size=filesound_length[i].files[0].size;
  	var file_type=filesound_length[i].files[0].type;
  	 
  	  
  	if(file_type!='audio/mp3'&& file_type!='video/mp4'&& file_type!='audio/mp4' && file_type!='audio/wav'&& file_type!='audio/flv'&& file_type!='audio/aiff'&& file_type!='audio/amr'&& file_type!='audio/wma'&& file_type!='audio/3gp')
  	{
  		alert("Please Select MP3/MP4/WAVE/FLV/3GP/AIFF/AMR/WMA Sound File");
  		return false;
  	}
  	// if(file_Size>1000000)
    // {
    	// alert("Please Select sound file less than 1MB");
    	// return false;
    // }  	
    
  	
  }	
}
function add_more_row(is_valid) 
{
    var synd_order    =  document.getElementsByName('synd_order[]');
    var synd_text     =  document.getElementsByName('synd_text[]');
    var eng_order     =  document.getElementsByName('eng_order[]');
    var eng_txt       =  document.getElementsByName('eng_txt[]');
    var alpha         =  document.getElementsByName('alpha[]');
    var annotation    =  document.getElementsByName('anno[]');
    var root_word     =  document.getElementsByName('root_sty[]');
    var sound_file    =  document.getElementsByName('file_sound[]');
    var postname      =  document.getElementById('txt1');
    var searchtag     =  document.getElementById('searchtag');
       var letter        = '/^[0-9]+$/';       
        if(postname.value.trim()=='')
        {
        	alert("Please fill Post Name");
        	return false;
        }
        
	    $('#main_tr_0').clone().appendTo('#clone_tr');        
	    remove_this('head_title');
	    remove_this('head_order');

		synd_order[synd_order.length-1].value=synd_order.length;
		eng_order[eng_order.length-1].value=eng_order.length;
    
	
//<-------- On making clone if above div has sub tr then for clonned div hide the sub tr ------------->
	var sub_trs    = document.getElementsByClassName('syn_sub_tr');
	var totsubtrs  = sub_trs.length;
	sub_trs[totsubtrs-1].setAttribute('style','display:none'); 

	var sub_trs    = document.getElementsByClassName('eng_sub_tr');
	var totsubtrs  = sub_trs.length;
	sub_trs[totsubtrs-1].setAttribute('style','display:none');
//<---------------------------------------------------------------------------------------------------->	
	
//<----------------- Setting the Default Value Split to added clone row split button ------------------>
	var splitbtn   = document.getElementsByClassName('eng_split');
	var totsplits  = splitbtn.length;
	splitbtn[totsplits-1].setAttribute('value','Split');

	var splitbtn   = document.getElementsByClassName('syn_split');
	var totsplits  = splitbtn.length;
	splitbtn[totsplits-1].setAttribute('value','Split');
//<------------------------------------------------------------------------------------------------>//

//<--------- Delete All cascading select box in clonned row. Only keep main root select menu -------->
	var all_div   = document.getElementsByClassName('menu_div');
	var last_div  = all_div.length-1;   
    saved = $("#main_select_menu_0").clone().wrap('<div/>').parent().html();//get main select menu in variable 
    all_div[last_div].innerHTML=saved;//assign that variable to last row select section
//<------------------------------------------------------------------------------------------------>//
	set_attribute_toclass('id','syn_sub_tr');//attribute to set , class name
	set_attribute_toclass('id','eng_sub_tr');//attribute to set , class name
	set_attribute_toclass('id','syn_split');//attribute to set , class name
	set_attribute_toclass('id','eng_split');//attribute to set , class name
	set_attribute_toclass('id','main_select_menu');//attribute to set , class name
	set_attribute_toclass('id','synd_textcls');//attribute to set , class name
	set_attribute_toclass('id','eng_textcls');//attribute to set , class name
	set_attribute_toclass('id','alpha_cls');//attribute to set , class name
	set_attribute_toclass('id','alpha_image_cls');//attribute to set , class name
	set_attribute_toclass('id','syn_cls');//attribute to set , class name
	set_attribute_toclass('id','eng_cls');//attribute to set , class name
	set_attribute_toclass('id','root');//attribute to set , class name
	set_attribute_toclass('id','codex');//attribute to set , class name
	set_attribute_toclass('name','reset_form');//attribute to set , class name
	set_attribute_toclass('id','linkj');
	set_attribute_toclass('id','cross');
	set_attribute_toclass('id','disp1');//attribute to set , class name
	set_attribute_toclass('id','disp');//attribute to set , class name
	set_attribute_toclass('id','codex_2');//attribute to set , class name
    set_attribute_toclass('id','codex_1');//attribute to set , class name
	set_attribute_toclass('id','codex_sub');//attribute to set , class name
	set_attribute_toclass('id','codex_sub_a');//attribute to set , class name
	set_attribute_toclassname('name','main_select_menu');
	set_attribute_toclass('id','sel_reset');
	set_attribute_toclass('id','main_tr');
  //  set_order('synd_order[]');
   // set_order('eng_order[]');
 
    set_null_value('synd_text[]');
   // set_null_value('synd_order[]');
    //set_null_value('eng_order[]');
    set_null_value('eng_txt[]');
    set_null_value('root_sty[]');
    
    set_null_value('alpha[]');
    set_null_value('anno[]'); 
    set_null_value('morpho[]');
    var doc_class1   = document.getElementsByClassName('sel_reset');
	var totclassele1 = doc_class1.length;	
	
	for (sp=0;sp<totclassele1;sp++){		
		doc_class[sp].setAttribute('name',"sel_reset_"+sp+"[]");		
	}
 
    
}
function set_attribute_toclass(setid,classname)
{
	var splits    = document.getElementsByClassName(classname);
	var totsplits = splits.length;
	if (classname=='codex'){
		//alert(totsplits);
		for (sp=0;sp<totsplits;sp++){		
			splits[sp].setAttribute('href',"view_details.php?id="+sp);
		}
	}
	if(classname=='codex_2')
	{
		for (sp=0;sp<totsplits;sp++){		
			splits[sp].setAttribute('href',"view_details_a.php?id="+sp);
		}
	}
	if(classname=='codex_1')
	{
		for (sp=0;sp<totsplits;sp++){		
			splits[sp].setAttribute('href',"view_details_b.php?id="+sp);
		}
	}
	if(classname=='codex_sub')
	{
		for (sp=0;sp<totsplits;sp++){		
			splits[sp].setAttribute('href',"view_details_split_new.php?id="+sp);
		}
	}
	if(classname=='codex_sub_a')
	{
		for (sp=0;sp<totsplits;sp++){		
			splits[sp].setAttribute('href',"view_details_split_a_new.php?id="+sp);
		}
	}
	for (sp=0;sp<totsplits;sp++){		
		splits[sp].setAttribute(setid,classname+"_"+sp);
	}
}
function set_attribute_toclassname(set_attr,class_name){
	var doc_class   = document.getElementsByClassName(class_name);
	var totclassele = doc_class.length;	
	
	for (sp=0;sp<totclassele;sp++){		
		doc_class[sp].setAttribute(set_attr,"morpho_"+sp+"[]");
		
	}
}
function set_null_value(arr_name)
{
	var arr     = document.getElementsByName(arr_name);
	var totele  = arr.length-1;		
	/*if (arr_name=='morpho[]')
	alert('Array Name='+arr_name+'Total Lengh='+totele);	*/
	arr[totele].value='';
}
function set_order(order_name)
{
	var orders    = document.getElementsByName(order_name);
	var totorders = orders.length;	
	for (or=0;or<totorders;or++){
		orders[or].value=or+1;;
	}	
}
function username_check(val,val1){	
 
 var get_no   = val1.split('_'); 
// alert(val);
 var id_no      = get_no[1];	
 var r          ="disp_"+id_no;
 var r1         ="disp1_"+id_no;
 var r2         ="cross_"+id_no;
var image       = document.createElement("img");
var imageParent = document.getElementById(r1);
image.id        = "1";
image.className = "s1";
image.src       = "images/tick.png";
image.width     ="10";
image.height    ="10";

//alert(username);
if(val == "" || val.length < 1){
 $('#root').css();
 $('#tick').hide();
 $("#"+r).show();
 $('#'+r2).hide();
}else{

$.ajax({
   type: "GET",
   url: "check.php",
   data: 'word='+ val,
   cache: false,
   success: function(response){
      //alert(response);
if(response == 1){
	 
	//alert(response);
	$('#tick').hide();
	$('#'+r2).fadeIn();
	$("#"+r).hide();
	
	}else
	{
	 //$('#root').css();
	 $('#'+r2).hide();
	 $("#"+r).show();
	//$('#tick').fadeIn();
	document.getElementById('linkj_'+id_no).style.color='blue'; 
	$('a#linkj_'+id_no).text("+");
	}

}
});
}



}
function check(val,val1)
{
 //alert(val1);	
 
 var get_no   = val1.split('_'); 
 var id_no    = get_no[1];	
 var r        ="disp_"+id_no;
 var r1       ="disp1_"+id_no;
 
var image       = document.createElement("img");
var imageParent = document.getElementById(r1);
image.id        = "1";
image.className = "s1";
image.src       = "images/tick.png";
image.width     ="10";
image.height    ="10";

 //document.getElementById('linka').label="+";
if(val=='')
{
 
	$('#'+r).show();
	$('#'+r1).hide();
	return false;
}
else
{
$.ajax({		
		type:'GET',
		url:'check.php?word='+val,
		catche:false,
		success:function(menudata){
			 
			 if(menudata==1)
			 {
			 	 
			 	  imageParent.appendChild(image);
			 	  $('#'+r).hide();
			 } 
			 else
			 {
			 	 
			 	document.getElementById('linkj_'+id_no).style.color='blue'; 
			 	$('a#linkj_'+id_no).text("+");
			 }
			 
		}
	});	
}
} 
</script>
<style>
#root{
	
}

#tick{display:none}
#cross{display:none}
	

</style>
<div class="main_wrap">
<div class="entry_form">
<form method="post" enctype="multipart/form-data" onsubmit="return validation();">
	<table>
    		<tr><td class="entry_td_top">Post Name:<input type="text" id="txt1" name="txt1"></td></tr>
    	</table>
		<?php
		//http://stackoverflow.com/questions/3624681/utf-8-not-working-in-html-forms
		
						$query	   = "select page_name from visibility";
						$res_query = $db->select_data($query);
						
						$sindarin	=	$res_query[0]['page_name'];
						$english	=	$res_query[1]['page_name'];
					?>
					<td class="entry_td_top" colspan="3"><?php echo $sindarin;?></td>
					<td class="entry_td_top" colspan="3"><?php echo $english; ?></td>
    <input type="text" name="check" />
    <input type="submit" name="submit" value="Test Char"/>
</form>