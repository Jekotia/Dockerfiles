<?php
include_once('header.php'); 
//include_once('includes/applicationTop.php');
/*
 Project        : Custom PHP Post
 Developer Name : Atul Bharambe  
 Section        : Add New Entry to the Post
 Start Date     : 17-1-2015
 End Date       : 3-2-2015 
  */
include('templateclass/add_new_entry_manageredit.php');
$add_new_entryobj=new addnew();
$add_new_enryclass=new addnewentry();
$editid=$_GET['edit_id'];
if(isset($_POST['submit']))
{
	$postname=$_POST['txt1']; 
	$add_new_enryclass->setPostVar($_POST);
	$msg=$add_new_entryobj->add_entry($add_new_enryclass,$editid);	 
	if($msg)
	{
		/* echo "<b><font color='black'>".$msg."</font></b>"; */
	?>
	<script type="text/javascript">
		setTimeout(function(){
		window.location.href="entry.php?link_page=library&id=<?php echo $editid;?>&postname=<?php echo $postname;?>"	
		},400);
	</script>
<?php	
	}
}
 
if($editid!='')
{
    $btnsub="Update";	
    $query_sql="select *from add_new_entry where post_id='$editid' ORDER BY sindarin_order,english_order";
	$query_res=$db->select_data($query_sql);
	//echo "Total Words=".$tot_word = count($query_res);
	$tot_word = count($query_res);
	if ($tot_word<6)
	   $show_entries = 6-$tot_word;
	
	$query_sql_p="select *from add_post where  id='$editid'";
	$query_res_p=$db->select_data($query_sql_p);
	
	$postname=$query_res_p[0]['post_name'];
	$access=$query_res_p[0]['accessibility'];
	$search_tag=$query_res_p[0]['search_tags'];    
 	$cnt=count($query_res);
}
else 
{
    $btnsub="Add";
	
}
?>
<style>	
	td{
		color:black;
	}
#highslide-container
	{

        margin: -36px;
        
	}
	.main_tr{
		/*overflow-x: scroll;*/
		width:100%;
	}
	
	#entry_td3{
	   min-width: 124px;
    }
	a.view_morpho:link, a.view_morpho:visited {
		font-size: 11px;
		font-style: italic;
		color: black;
	}
	.disclaimer {
		color: #444;
		padding: 20px;
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
         	set_attribute_toclass('id','main_select_menu');//attribute to set , class name
		}
	});
}
function reset_this_menu(menu_id,curr_seldiv_id,sel_name)
{
	var get_index      = curr_seldiv_id.split('_');
	var morph_ind  = get_index[2];
	//alert(get_index);
	//alert(morph_ind);
//<--------- Delete All cascading select box in clonned row. Only keep main root select menu -------->
	var all_div   = document.getElementsByClassName('reset_div');
	
	$("#setit").show();
	
	var all_new_div   = document.getElementsByClassName('new_menu_div');
	var tot_new       = all_new_div.length;
	all_div[morph_ind].innerHTML='';
	for (nm=0;nm<tot_new;nm++){
		saved=$("#new_menu_div_"+nm).clone().wrap('<div/>').parent().html();//get main select menu in variable
	    all_div[morph_ind].innerHTML+=saved;
	    document.getElementById("new_menu_div_"+nm).className = "menu_div";
	}
	$("#setit").hide();
	
    //saved[] = $("#new_menu_div_0").clone().wrap('<div/>').parent().html();//get main select menu in variable
    //alert(saved);
   // all_div[morph_ind].innerHTML=saved;//assign that variable to last row select section
    //$("#new_menu_div_0").className='menu_div'; 
   //document.getElementById("new_menu_div_0").className = "menu_div";  
   set_attribute_toclass('id','menu_div');

 
	set_attribute_toclass('id','main_select_menu');//attribute to set , class name
	set_attribute_toclassname('name','main_select_menu');//attribute to set , class name
//	set_attribute_toclassname('name','setitsel');//attribute to set , class name
	//setitsel
	
	
	set_attribute_toclass('id','reset_div');//attribute to set , class name   	    
//<------------------------------------------------------------------------------------------------>//
}

var cnt=0;
$(document).ready(function(){
	
   // set_order('synd_order[]');
   // set_order('eng_order[]');
    //remove_this('head_title');
    //remove_this('head_order');
    
    var heads_arr = document.getElementsByClassName('head_title');
    // var curr_id_arr=document.getElementsByName('curr_id[]');
     // var val=curr_id_arr.length-1;
     // var r='synd_textcls_'+val;
    // alert(r);
	 
	   
   
    var tot_heads = heads_arr.length;
    for (mk=0;mk<tot_heads;mk++){    	
    	$('#main_tr_'+mk).clone().appendTo('#clone_tr');
   	  
    }

	set_attribute_toclass('id','main_tr');
	for (mk=0;mk<tot_heads;mk++){
		$('#main_tr_'+mk).remove();
	}	
	set_attribute_toclass('id','main_tr');

	set_attribute_toclass('id','head_title');//attribute to set , class name
	set_attribute_toclass('id','head_order');//attribute to set , class name

	for (mk=1;mk<tot_heads;mk++){
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
	set_attribute_toclass('id','disp1');//attribute to set , class name
	set_attribute_toclass('id','disp');//attribute to set , class name
   	set_attribute_toclass('id','codex');//attribute to set , class name
	set_attribute_toclass('id','codex_3');//attribute to set , class name
	set_attribute_toclass('id','codex_2');//attribute to set , class name
	set_attribute_toclass('id','codex_1');//attribute to set , class name
	set_attribute_toclass('id','codex_sub');//attribute to set , class name
	set_attribute_toclass('id','codex_sub_a');//attribute to set , class name
	set_attribute_toclass('id','curr_id');
	set_attribute_toclass('id','menu_div');
	set_attribute_toclass('id','reset_div');//attribute to set , class name
       
   	set_attribute_toclass('id','sel_reset');

});
function remove_this(classname){
   var all_tblhead  = document.getElementsByClassName(classname);
   var tot_head     = all_tblhead.length;
   for(tbl=1;tbl<tot_head;tbl++){
   	  all_tblhead[tbl].remove();
   } 		
}
function remove_this1(classname){
   var all_tblhead  = document.getElementsByClassName(classname);
   var tot_head     = all_tblhead.length;
   	  all_tblhead[tot_head-1].remove();
}
function validation()
{
	var synd_order      =  document.getElementsByName('synd_order[]');
    var synd_text       =  document.getElementsByName('synd_text[]');
    var eng_order       =  document.getElementsByName('eng_order[]');
    var eng_txt         =  document.getElementsByName('eng_txt[]');
    var alpha           =  document.getElementsByName('alpha[]');
    var annotation      =  document.getElementsByName('anno[]');
    var root_word       =  document.getElementsByName('root_sty[]');
    var filesound_length=  document.getElementsByName('file_sound[]');
    var postname        =  document.getElementById('txt1');
    var searchtag       =  document.getElementById('searchtag');
    var letter          = '/^[0-9]+$/';
       
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
    
  
   for(i=0;i<alpha.length;i++)
  {
  	 
    if(alpha[i].value.length>80)
    {
			alert("Please do not exceed 80 characters in the Alphabetic column."); 
			return false;
    }
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
var cnt_v=0;
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
    var curr_id_arr   =  document.getElementsByName('curr_id[]');
    cnt_v++;
    
     
        var letter        = '/^[0-9]+$/';       
        if(postname.value.trim()=='')
        {
        	alert("Please fill Post Name");
        	return false;
        }
        
	    $('#main_tr_0').clone().appendTo('#clone_tr');        
	    remove_this('head_title');
	    remove_this('head_order');
        remove_this1('curr_id');
   /*var all_curr     = document.getElementsByClassName('curr_id');
   var tot_curr     = all_curr.length;*/
    /*all_curr[tot_curr].remove();*/
	    //remove_this('curr_id');
	     
		   synd_order[synd_order.length-1].value=curr_id_arr.length+cnt_v;
		   eng_order[eng_order.length-1].value=curr_id_arr.length+cnt_v;
		    
		 
       // 
	
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
	/*var all_div   = document.getElementsByClassName('menu_div');
	var last_div  = all_div.length-1;   
    saved = $("#main_select_menu_0").clone().wrap('<div/>').parent().html();//get main select menu in variable 
    all_div[last_div].innerHTML=saved;//assign that variable to last row select section*/
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
	set_attribute_toclass('id','codex_3');//attribute to set , class name
	set_attribute_toclass('id','codex_2');//attribute to set , class name
	set_attribute_toclass('id','codex_1');//attribute to set , class name
	set_attribute_toclass('id','codex_sub');//attribute to set , class name
	set_attribute_toclass('id','codex_sub_a');//attribute to set , class name
	set_attribute_toclassname('name','main_select_menu');
	set_attribute_toclass('id','sel_reset');
	set_attribute_toclass('id','reset_div');//attribute to set , class name
	set_attribute_toclass('id','main_tr');
	set_attribute_toclass('id','curr_id');
	set_attribute_toclass('id','menu_div');
	
    
//trigger reset event for last record
	var doc_class1   = document.getElementsByClassName('sel_reset');
	var totclassele1 = doc_class1.length;
	var act_reset_id = totclassele1-1;
	$("#sel_reset_"+act_reset_id).trigger('click');
	 
	
   set_null_value('synd_text[]');
    set_null_value('eng_txt[]');
    set_null_value('root_sty[]');    
    set_null_value('alpha[]');
    set_null_value('anno[]'); 
    	
    
}
function add_more_paragraph(is_valid) 
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
    var curr_id_arr   =  document.getElementsByName('curr_id[]');
    var breaker       =  "[br]";
    cnt_v++;
    
     
        var letter        = '/^[0-9]+$/';       
        if(postname.value.trim()=='')
        {
        	alert("Please fill Post Name");
        	return false;
        }
        
	    $('#main_tr_0').clone().appendTo('#clone_tr');        
	    remove_this('head_title');
	    remove_this('head_order');
        remove_this1('curr_id');
   /*var all_curr     = document.getElementsByClassName('curr_id');
   var tot_curr     = all_curr.length;*/
    /*all_curr[tot_curr].remove();*/
	    //remove_this('curr_id');
	     
		   synd_order[synd_order.length-1].value=curr_id_arr.length+cnt_v;
		   eng_order[eng_order.length-1].value=curr_id_arr.length+cnt_v;
		    
		 
       // 
	
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
	/*var all_div   = document.getElementsByClassName('menu_div');
	var last_div  = all_div.length-1;   
    saved = $("#main_select_menu_0").clone().wrap('<div/>').parent().html();//get main select menu in variable 
    all_div[last_div].innerHTML=saved;//assign that variable to last row select section*/
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
	set_attribute_toclass('id','codex_3');//attribute to set , class name
	set_attribute_toclass('id','codex_2');//attribute to set , class name
	set_attribute_toclass('id','codex_1');//attribute to set , class name
	set_attribute_toclass('id','codex_sub');//attribute to set , class name
	set_attribute_toclass('id','codex_sub_a');//attribute to set , class name
	set_attribute_toclassname('name','main_select_menu');
	set_attribute_toclass('id','sel_reset');
	set_attribute_toclass('id','reset_div');//attribute to set , class name
	set_attribute_toclass('id','main_tr');
	set_attribute_toclass('id','curr_id');
	set_attribute_toclass('id','menu_div');
	
    
//trigger reset event for last record
	var doc_class1   = document.getElementsByClassName('sel_reset');
	var totclassele1 = doc_class1.length;
	var act_reset_id = totclassele1-1;
	$("#sel_reset_"+act_reset_id).trigger('click');
	 
	
   set_null_value('synd_text[]');
    set_null_value('eng_txt[]');
    set_null_value('root_sty[]');    
    set_null_value('alpha[]');
    set_null_value('anno[]'); 
    	
    	synd_text[synd_order.length-1].value=breaker;
	eng_txt[eng_order.length-1].value=breaker;
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
	if(classname=='codex_3')
	{
		for (sp=0;sp<totsplits;sp++){		
			splits[sp].setAttribute('href',"view_details_c.php?id="+sp);
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
	//alert(arr);
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
<?php
if(isset($_SESSION['author'])||isset($_SESSION['reader'])||isset($_SESSION['ADMIN_NAME']))
{
?>
     <!--<form name="add_entry" method="post" enctype="multipart/form-data" onsubmit="return validation();" accept-charset="utf8">-->
<form name="add_entry" method="post" onsubmit="return validation();">   

<div class="profile_title">Post Name: <input type="text" id="txt1" name="txt1" value="<?php echo $postname;?>"></div>
<div class="main_wrap">
<div class="entry_form">
											 
					<?php					 
					  for($i=0;$i<$tot_word;$i++)
					  {
					  	$curr_id   =$query_res[$i]['id'];
					  	$synorder  =$query_res[$i]['sindarin_order'];
					  	$syntext   =$query_res[$i]['sindarin_text'];
						$engorder  =$query_res[$i]['english_order'];
						$engtext   =$query_res[$i]['english_text'];
						$rootword  =$query_res[$i]['root_word'];
						 
						$alphabetic=$query_res[$i]['alphabetic'];
						$alphabetic_image=$query_res[$i]['alphabetic_image'];
						$menuid    =$query_res[$i]['menu_id'];
						$annotation=$query_res[$i]['annotation'];
						 ?>	
			    <div id="main_tr_<?php echo $i; ?>" class="main_tr">				
					<table>
					<thead>	
				<tr class="head_title">
					<?php
						$query	   = "select page_name from visibility";
						$res_query = $db->select_data($query);
						
						$sindarin	=	$res_query[0]['page_name'];
						$english	=	$res_query[1]['page_name'];
					?>
					<td class="entry_td_top" colspan="3"><?php echo $sindarin;?></td>
					<td class="entry_td_top" colspan="3"><?php echo $english; ?></td>
					<td class="entry_td_top">Root Word</td>
					 
					<td class="entry_td_top">Alphabetic</td>
					<td class="entry_td_top" colspan="2">Grammar</td>
				</tr>
				<tr class="head_order">
					<td class="entry_td2">Order</td>
					<td class="entry_td2" id="entry_td3">Text</td>
					<td class="entry_td2"> &nbsp; </td>
					<td class="entry_td2">Order</td>
					<td class="entry_td2" id="entry_td3">Text</td>
					<td class="entry_td2"> &nbsp; </td>
					<td class="entry_td2"> &nbsp; </td>
					<td class="entry_td2" id="entry_td3"> &nbsp; </td>
					 
					<td class="entry_td2">Morphology</td>
					<td class="entry_td2">Note</td>
				</tr>				
				</thead>
				<tbody>		
						 
				 <input type="hidden" name="curr_id[]" value="<?php echo $curr_id; ?>" class="curr_id"/>
					<tr>	
					<td class="entry_td"><input type="text" size="3" name="synd_order[]" value="<?php echo $synorder;?>" ></td>
					<td class="entry_td" id="entry_td3"><input type="text" size="10" name="synd_text[]" class="synd_textcls" value="<?php echo $syntext;  ?>" > 
					
					<a class='codex' href="#" onclick="return hs.htmlExpand(this, { contentId: 'highslide-html', objectType:'iframe',height:'300',width:'500'})">&phi;</a>	
					</td>
					<td class="entry_td">
						<input type="button" name="syn_split" id="split" class="syn_split" value="Split" onclick="return add_row(this.value,this.id);" />
						
					</td>
					<td class="entry_td"><input type="text" size="3" name="eng_order[]"  value="<?php echo $engorder; ?>"></td>
					<td class="entry_td" id="entry_td3"><input type="text" size="10" name="eng_txt[]" class="eng_textcls" value="<?php echo $engtext;?>" > 
					<a class="codex_2" href="#" onClick="return hs.htmlExpand(this, { contentId: 'highslide-html', objectType: 'iframe',height:'300',width:'500'})" >&phi;</a>
					</td>
					<td class="entry_td">
						<input type="button" name="eng_split" id="split" class="eng_split" value="Split" onclick="return add_row(this.value,this.id);" />
					</td>
					<td class="entry_td">
						<a class='codex_3' href="#" onclick="return hs.htmlExpand(this, { contentId: 'highslide-html', objectType:'iframe',height:'400',width:'620'})">&phi;</a>
						<input type="text" size="10" name="root_sty[]" class="root" onkeyup="return username_check(this.value,this.id);" value="<?php echo $rootword;?>">
						<img id="tick" src="images/tick.png" width="16" height="16"/>
    				                <img id="cross" src="images/cross.png" class="cross" width="16" height="16" style="display:none "/>	
						
					  <div class="disp">
  						<a href="add_root.php" class="linkj" id="linka" onClick="return hs.htmlExpand(this, { contentId: 'highslide-html', objectType: 'iframe',height:'300',width:'500'})"></a>
						 
				      </div>	
				   </td>
						
					<!-- <td class="entry_td"><input type="file"  value="Upload" name="file_sound[]" > 
					   </td> -->
					<td class="entry_td" id="entry_td3"><input type="text" size="10" name="alpha[]" class="alpha_cls" value="<?php echo $alphabetic;  ?>" >
						<input type="hidden" name="alpha_image[]" class="alpha_image_cls" value="<?php echo $alphabetic_image;  ?>" >
				<a class="codex_1" href="#"   onClick="return hs.htmlExpand(this, { contentId: 'highslide-html', objectType:'iframe',height:'300',width:'500'})"  >&phi;</a>
						 </td>
					<td class="entry_td">
						<div class="reset_div"> 
						<?php
				         	$get_multiroots   = "SELECT * FROM `tbl_menu` WHERE `parent_id`=0";
							$get_multirootres = $db->select_data($get_multiroots);
							$tot_roots        = count($get_multirootres);
				          	
				          	 ?>
				          	 
							<?php
							 for ($so=0; $so < $tot_roots; $so++) 
							 {
?>
				         <div style="float: left; width: 130px;" id="menu_div" class="menu_div">
				          	<select name="morpho[]" onchange="set_new_menu(this.value,this.id,this.name)" class="main_select_menu">
							     <option value="">Select Category</option>

<?php
							 	$menu_id    = $get_multirootres[$so]['id'];
							 	$menu_title = $get_multirootres[$so]['menu_title']; 
								?>
						        <option value="<?php echo $menu_id; ?>"><?php echo $menu_title; ?></option> 
								
						</select><br>																		
					</div><br>						
								<?php
							 }
							 ?>		
					     </div>		
						<input type="button" value="Reset"  name="reset_sel" class="sel_reset" onclick="reset_this_menu(this.value,this.id,this.name)">				
						<br/>
						<a href="view_morpho.php?id=<?php echo $curr_id;?>" class="view_morpho" name="view_morpho[]" onClick="return hs.htmlExpand(this, { contentId: 'highslide-html', objectType:'iframe',height:'300',width:'300'})">View Morphology</a>
					
						 
					</td>
					<td class="entry_td"><input type="text" size="20" name="anno[]"  value="<?php echo $annotation; ?>" ></td>
				</tr>
				
				
			 <!-- </div> -->
			 <!-- <div class="sub_tr" id="sub_tr" style="display: none;"> -->
					<tr class="syn_sub_tr" style="display: none;">
						<td class="entry_td"><input type="text" size="3" name="synd_order_sub[]" ></td>
						<td class="entry_td"><input type="text" size="10" name="synd_text_sub[]" class="syn_cls"> 
						 <a class="codex_sub"   href="#" onClick="return hs.htmlExpand(this, { contentId: 'highslide-html', objectType:'iframe',height:'300',width:'500'})">&phi;</a>
						</td>							
					</tr>
					<tr class="eng_sub_tr" style="display: none;">
							<td class="entry_td"></td>
							<td class="entry_td"></td>
							<td class="entry_td"></td>
							<td class="entry_td"><input type="text" size="3" name="eng_order_sub[]" ></td>
							<td class="entry_td">
								<input type="text" size="10" name="eng_txt_sub[]" class="eng_cls"> 
								<a class="codex_sub_a" href="#"  onClick="return hs.htmlExpand(this, { contentId: 'highslide-html', objectType:'iframe',height:'300',width:'500'})">&phi;</a>
							</td>														
					</tr>

				</tbody>	
				 </table>	
			  </div> 					
		<?php } ?>
 
			 <div id="clone_tr" style="width: 100%;overflow-x: scroll;">
			 </div>
			 <table class="main_tr">			
				 <tr>
					<td class="entry_more" colspan="11">
						<!-- Add More Fields -->
						<input type="button" id="add_more" name="add_more" onclick="return add_more_row(0);" value="Add Another Word"> &nbsp; 
						<input type="button" id="add_more" name="add_more" onclick="return add_more_paragraph(0);" value="Add New Paragraph">
					</td>
					
				 </tr>
				 <tr>
					<td class="entry_options" colspan="4">
						Public <input type="radio" id="rd1" value="public" 
						<?php 
						if($access=='Public')
						echo "checked";
						?>
						name="rd1"> 
						Unlisted <input type="radio" id="rd1" value="unlisted" 
						<?php 
						if($access=='Unlisted')
						echo "checked";
						?>
						name="rd1"> 
						Private <input type="radio" id="rd1" value="private" 
						<?php 
						if($access=='Private')
						echo "checked";
						?>
						name="rd1"></td>
					<td class="entry_options" colspan="7">Tags (separate with commas): <input type="text" size="40" id="searchtag" name="searchtag" value="<?php echo $search_tag?>"></td>
				 </tr>
 <div id="setit" style="display: none">
<?php

							 for ($so=0; $so < $tot_roots; $so++) 
							 {
							 ?>
							 <div id="new_menu_div_<?php echo $so; ?>" class="new_menu_div">
				          	<select onchange="set_new_menu(this.value,this.id,this.name)" class="main_select_menu">
							     <option value="">Select Category</option>
<?php
							 	$menu_id    = $get_multirootres[$so]['id'];
							 	$menu_title = $get_multirootres[$so]['menu_title']; 
								?>
						        <option value="<?php echo $menu_id; ?>"><?php echo $menu_title; ?></option> 
						    </select>
						    </div>
								<?php
							 }
							 ?>	
				</div>		 		

			</table>

<p class="disclaimer">
By submitting this document, I hereby declare that I have the permission, consent, and authority to make publically available this document.
</p>

		<p align="left"><input type="submit" name="submit"  class="btn" value="<?php echo $btnsub;?>"  /></p>
	</form>
</div>	
</div>
<?php }
else 
{
	header("location:login.php");
}
 ?>
<?php include("footer.php");?>