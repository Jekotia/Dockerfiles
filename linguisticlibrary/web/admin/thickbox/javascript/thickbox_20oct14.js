/*
 * Thickbox 3 - One Box To Rule Them All.
 * By Cody Lindley (http://www.codylindley.com)
 * Copyright (c) 2007 cody lindley
 * Licensed under the MIT License: http://www.opensource.org/licenses/mit-license.php
*/
		  
var tb_pathToImage = "thickbox/files/thickbox/loadingAnimation.gif"; /*files/thickbox/loadingAnimation.gif*/

/*!!!!!!!!!!!!!!!!! edit below this line at your own risk !!!!!!!!!!!!!!!!!!!!!!!*/

//on page load call tb_init
$(document).ready(function(){   
	tb_init('a.thickbox, area.thickbox, input.thickbox');//pass where to apply thickbox
	imgLoader = new Image();// preload image
	imgLoader.src = tb_pathToImage;
});

//add thickbox to href & area elements that have a class of .thickbox
var used=0;
function tb_init(domChunk)
{
	$(domChunk).click(function()
	{
		var t = this.title || this.name || null;
		var a = this.href || this.alt;
		var g = this.rel || false;
		tb_show(t,a,g);
		this.blur();
		return false;
	});
}

function tb_show(caption, url, imageGroup) 
{//function called when the user clicks on a thickbox link

	try 
	{
		if (typeof document.body.style.maxHeight === "undefined") 
		{//if IE 6
			$("body","html").css({height: "100%", width: "100%"});
			$("html").css("overflow","hidden");
			if (document.getElementById("TB_HideSelect") === null) 
			{//iframe to hide select elements in ie6
				$("body").append("<iframe id='TB_HideSelect'></iframe><div id='TB_overlay'></div><div id='TB_window'></div>");
				$("#TB_overlay").click(tb_remove);
			}
		}
		else
		{//all others
			if(document.getElementById("TB_overlay") === null)
			{
				$("body").append("<div id='TB_overlay'></div><div id='TB_window'>");
				$("#TB_overlay").click(tb_remove);
			}
		}
		
		if(caption===null)
		{
			caption="";
		}
		$("body").append("<div id='TB_load'><img src='"+imgLoader.src+"' /></div>");//add loader to the page
		$('#TB_load').show();//show loader
		
		var baseURL;
	   if(url.indexOf("?")!==-1) //ff there is a query string involved
	   { 
			baseURL = url.substr(0, url.indexOf("?"));
	   }
	   else
	   { 
	   		baseURL = url;
	   }
	   
		
			var queryString = url.replace(/^[^\?]+\??/,'');
			var params = tb_parseQuery( queryString );

			TB_WIDTH = (params['width']*1) + 30 || 630; //defaults to 630 if no paramaters were added to URL
			TB_HEIGHT = (params['height']*1) + 40 || 440; //defaults to 440 if no paramaters were added to URL
			ajaxContentW = TB_WIDTH - 30;
			ajaxContentH = TB_HEIGHT - 45;
			
			if(url.indexOf('TB_iframe') != -1 && used==0)
			{				
					urlNoQuery = url.split('TB_');		
					$("#TB_window").append("<div id='TB_title'><div id='TB_ajaxWindowTitle'>"+caption+"</div><div id='TB_closeAjaxWindow'><a href='#' id='TB_closeWindowButton' title='Close'> Close </a> </div></div><iframe frameborder='0' hspace='0' src='"+urlNoQuery[0]+"' id='TB_iframeContent' name='TB_iframeContent' style='width:"+(ajaxContentW + 29)+"px;height:"+(ajaxContentH + 17)+"px;' onload='tb_showIframe()'> </iframe>");					
					used++;
					//alert('used'+used);
			}
				/*else
				{
					if($("#TB_window").css("display") != "block"){
						if(params['modal'] != "true"){
						$("#TB_window").append("<div id='TB_title'><div id='TB_ajaxWindowTitle'>"+caption+"</div><div id='TB_closeAjaxWindow'><a href='#' id='TB_closeWindowButton'>Close </a> </div></div><div id='TB_ajaxContent' style='width:"+ajaxContentW+"px;height:"+ajaxContentH+"px'></div>");
						}else{
						$("#TB_overlay").unbind();
						$("#TB_window").append("<div id='TB_ajaxContent' class='TB_modal' style='width:"+ajaxContentW+"px;height:"+ajaxContentH+"px;'></div>");	
						}
					}else{
						$("#TB_ajaxContent")[0].style.width = ajaxContentW +"px";
						$("#TB_ajaxContent")[0].style.height = ajaxContentH +"px";
						$("#TB_ajaxContent")[0].scrollTop = 0;
						$("#TB_ajaxWindowTitle").html(caption);
					}
			}*/
					
			$("#TB_closeWindowButton").click(tb_remove);
			
				if(url.indexOf('TB_inline') != -1)
				{	
					$("#TB_ajaxContent").html($('#' + params['inlineId']).html());
					tb_position();
					$("#TB_load").remove();
					$("#TB_window").css({display:"block"}); 
				}
				else 
				if(url.indexOf('TB_iframe') != -1)
				{
					tb_position();
					/*if(frames['TB_iframeContent'] === undefined){//be nice to safari
						$("#TB_load").remove();
						$("#TB_window").css({display:"block"});
						$(document).keyup( function(e)
						{ 
							var key = e.keyCode; 
							if(key == 27)
							{
								tb_remove();
							}});
					}*/
				}else{
					$("#TB_ajaxContent").load(url += "&random=" + (new Date().getTime()),function(){//to do a post change this load method
						tb_position();
						$("#TB_load").remove();
						tb_init("#TB_ajaxContent a.thickbox");
						$("#TB_window").css({display:"block"});
					});
				}
			
	

		if(!params['modal']){
			document.onkeyup = function(e){ 	
				if (e == null) { // ie
					keycode = event.keyCode;
				} else { // mozilla
					keycode = e.which;
				}
				if(keycode == 27){ // close
					tb_remove();
				}	
			};
		}
		
	} 
	catch(e) 
	{
		//nothing here
	}
}//main function tb_show

//helper functions below
function tb_showIframe(){
	$("#TB_load").remove();
	$("#TB_window").css({display:"block"});
}

function tb_remove() {
 	$("#TB_imageOff").unbind("click");
	$("#TB_overlay").unbind("click");
	$("#TB_closeWindowButton").unbind("click");
	$("#TB_window").fadeOut("fast",function(){$('#TB_window,#TB_overlay,#TB_HideSelect').remove();});
	$("#TB_load").remove();
	/*if (typeof document.body.style.maxHeight == "undefined") {//if IE 6
		$("body","html").css({height: "auto", width: "auto"});
		$("html").css("overflow","");
	}*/
	document.onkeydown = "";
	used=0;
	return false;
}

function tb_position() {
$("#TB_window").css({marginLeft: '-' + parseInt((TB_WIDTH / 2),10) + 'px', width: TB_WIDTH + 'px'});
	if ( !(jQuery.browser.msie && typeof XMLHttpRequest == 'function')) { // take away IE6
		$("#TB_window").css({marginTop: '-' + parseInt((TB_HEIGHT / 2),10) + 'px'});
	}
}

function tb_parseQuery ( query ) 
{
   var Params = {};
   if ( ! query ) 
   {
   	return Params;
   }// return empty object
   var Pairs = query.split(/[;&]/);
   for ( var i = 0; i < Pairs.length; i++ ) 
   {
      var KeyVal = Pairs[i].split('=');
      if ( ! KeyVal || KeyVal.length != 2 ) 
      {
      	continue;
      }
      var key = unescape( KeyVal[0] );
      var val = unescape( KeyVal[1] );
      val = val.replace(/\+/g, ' ');
      Params[key] = val;
   }
   return Params;
}

function tb_getPageSize(){
	var de = document.documentElement;
	var w = window.innerWidth || self.innerWidth || (de&&de.clientWidth) || document.body.clientWidth;
	var h = window.innerHeight || self.innerHeight || (de&&de.clientHeight) || document.body.clientHeight;
	arrayPageSize = [w,h];
	return arrayPageSize;
}
