var hs = {
// Language strings
lang : {
	cssDirection: 'ltr',
	loadingText : 'Loading...',
	loadingTitle : 'Click to cancel',
	focusTitle : 'Click to bring to front',
	fullExpandTitle : 'Expand to actual size (f)',
	//creditsText : 'Powered by <i>Highslide JS</i>',
	creditsText : 'Blogs',
	//creditsTitle : 'Go to the Highslide JS homepage',
	creditsTitle : 'Blogs',
	previousText : 'Previous',
	nextText : 'Next', 
	moveText : 'Move',
	closeText : 'Close', 
	closeTitle : 'Close (esc)', 
	resizeTitle : 'Resize',
	playText : 'Play',
	playTitle : 'Play slideshow (spacebar)',
	pauseText : 'Pause',
	pauseTitle : 'Pause slideshow (spacebar)',
	previousTitle : 'Previous (arrow left)',
	nextTitle : 'Next (arrow right)',
	moveTitle : 'Move',
	fullExpandText : 'Full size',
	restoreTitle : 'Click to close image, click and drag to move. Use arrow keys for next and previous.'
},
// See http://highslide.com/ref for examples of settings  
graphicsDir : 'highslide/graphics/',
expandCursor : 'zoomin.cur', // null disables
restoreCursor : 'zoomout.cur', // null disables
expandDuration : 250, // milliseconds
restoreDuration : 250,
marginLeft : 0,
marginRight : 0,
marginTop : 0,
marginBottom : 0,
zIndexCounter : 1001, // adjust to other absolutely positioned elements
loadingOpacity : 0.75,
allowMultipleInstances: true,
numberOfImagesToPreload : 5,
outlineWhileAnimating : 2, // 0 = never, 1 = always, 2 = HTML only 
outlineStartOffset : 3, // ends at 10
fullExpandPosition : 'bottom right',
fullExpandOpacity : 1,
padToMinWidth : false, // pad the popup width to make room for wide caption
showCredits : true, // you can set this to false if you want
//creditsHref : 'http://highslide.com',
creditsHref : '',
enableKeyListener : true,

allowWidthReduction : false,
allowHeightReduction : true,
preserveContent : true, // Preserve changes made to the content and position of HTML popups.
objectLoadTime : 'before', // Load iframes 'before' or 'after' expansion.
cacheAjax : true, // Cache ajax popups for instant display. Can be overridden for each popup.
dragByHeading: true,
minWidth: 200,
minHeight: 200,
allowSizeReduction: true, // allow the image to reduce to fit client size. If false, this overrides minWidth and minHeight
outlineType : 'drop-shadow', // set null to disable outlines
wrapperClassName : 'highslide-wrapper', // for enhanced css-control
skin : {
	contentWrapper:
		'<div class="highslide-header" style="margin:0px 0px 0px 0px; padding: 0px 0px 0px 0px;"><ul>'+
			'<li class="highslide-previous">'+
				'<a href="#" title="{hs1.lang.previousTitle}" onclick="return hs1.previous(this)">'+
				'<span>{hs1.lang.previousText}</span></a>'+
			'</li>'+
			'<li class="highslide-next">'+
				'<a href="#" title="{hs1.lang.nextTitle}" onclick="return hs1.next(this)">'+
				'<span>{hs1.lang.nextText}</span></a>'+
			'</li>'+
			'<li class="highslide-move">'+
				'<a href="#" title="{hs1.lang.moveTitle}" onclick="return false">'+
				'<span>{hs1.lang.moveText}</span></a>'+
			'</li>'+
			'<li class="highslide-close">'+
				'<a href="#" title="{hs1.lang.closeTitle}" onclick="return hs1.refreshparentObject(this)">'+
				'<span>{hs1.lang.closeText}</span></a>'+
			'</li>'+
		'</ul></div>'+
		'<div class="highslide-body" style="margin:0px 0px 0px 0px; padding: 0px 0px 0px 0px;"></div>'+
		'<div class="highslide-footer" style="margin:0px 0px 0px 0px; padding: 0px 0px 0px 0px;"><div>'+
			'<span class="highslide-resize" title="{hs1.lang.resizeTitle}"><span></span></span>'+
		'</div></div>'
},
// END OF YOUR SETTINGS


// declare internal properties
preloadTheseImages : [],
continuePreloading: true,
expanders : [],
overrides : [
	'allowSizeReduction',
	'outlineType',
	'outlineWhileAnimating',
	'captionId',
	'captionText',
	'captionEval',
	'captionOverlay',
	'headingId',
	'headingText',
	'headingEval',
	'headingOverlay',
	'dragByHeading',
	
	'contentId',
	'width',
	'height',
	'allowWidthReduction',
	'allowHeightReduction',
	'preserveContent',
	'maincontentId',
	'maincontentText',
	'maincontentEval',
	'objectType',	
	'cacheAjax',	
	'objectWidth',
	'objectHeight',
	'objectLoadTime',	
	'swfOptions',
	'wrapperClassName',
	'minWidth',
	'minHeight',
	'maxWidth',
	'maxHeight',
	'slideshowGroup',
	'easing',
	'easingClose',
	'fadeInOut',
	'src'
],
overlays : [],
idCounter : 0,
oPos : {
	x: ['leftpanel', 'left', 'center', 'right', 'rightpanel'],
	y: ['above', 'top', 'middle', 'bottom', 'below']
},
mouse: {},
headingOverlay: {},
captionOverlay: {},
swfOptions: { flashvars: {}, params: {}, attributes: {} },
faders : [],

pendingOutlines : {},
sleeping : [],
preloadTheseAjax : [],
cacheBindings : [],
cachedGets : {},
clones : {},
ie : (document.all && !window.opera),
safari : /Safari/.test(navigator.userAgent),
geckoMac : /Macintosh.+rv:1\.[0-8].+Gecko/.test(navigator.userAgent),

$ : function (id) {
	return document.getElementById(id);
},

push : function (arr, val) {
	arr[arr.length] = val;
},

createElement : function (tag, attribs, styles, parent, nopad) {
	var el = document.createElement(tag);
	if (attribs) hs1.setAttribs(el, attribs);
	if (nopad) hs1.setStyles(el, {padding: 0, border: 'none', margin: 0});
	if (styles) hs1.setStyles(el, styles);
	if (parent) parent.appendChild(el);	
	return el;
},

setAttribs : function (el, attribs) {
	for (var x in attribs) el[x] = attribs[x];
},

setStyles : function (el, styles) {
	for (var x in styles) {
		if (hs1.ie && x == 'opacity') {
			if (styles[x] > 0.99) el.style.removeAttribute('filter');
			else el.style.filter = 'alpha(opacity='+ (styles[x] * 100) +')';
		}
		else el.style[x] = styles[x];
	}
},

ieVersion : function () {
	var arr = navigator.appVersion.split("MSIE");
	return arr[1] ? parseFloat(arr[1]) : null;
},

getPageSize : function () {
	var d = document, w = window, iebody = d.compatMode && d.compatMode != 'BackCompat' 
		? d.documentElement : d.body;
	
	var width = hs1.ie ? iebody.clientWidth : 
			(d.documentElement.clientWidth || self.innerWidth),
		height = hs1.ie ? iebody.clientHeight : self.innerHeight;
	
	return {
		width: width,
		height: height,		
		scrollLeft: hs1.ie ? iebody.scrollLeft : pageXOffset,
		scrollTop: hs1.ie ? iebody.scrollTop : pageYOffset
	}
},

getPosition : function(el)	{
	var p = { x: el.offsetLeft, y: el.offsetTop };
	while (el.offsetParent)	{
		el = el.offsetParent;
		p.x += el.offsetLeft;
		p.y += el.offsetTop;
		if (el != document.body && el != document.documentElement) {
			p.x -= el.scrollLeft;
			p.y -= el.scrollTop;
		}
	}
	return p;
},
expand : function(a, params, custom, type) {
	if (!a) a = hs1.createElement('a', null, { display: 'none' }, hs1.container);
	if (typeof a.getParams == 'function') return params;
	if (type == 'html') {
		for (var i = 0; i < hs1.sleeping.length; i++) {
			if (hs1.sleeping[i] && hs1.sleeping[i].a == a) {
				hs1.sleeping[i].awake();
				hs1.sleeping[i] = null;
				return false;
			}
		}
		hs1.hasHtmlExpanders = true;
	}	
	try {	
		new hs1.Expander(a, params, custom, type);
		return false;
	} catch (e) { return true; }
},

htmlExpand : function(a, params, custom) {
	return hs1.expand(a, params, custom, 'html');
},

getSelfRendered : function() {
	return hs1.createElement('div', { 
		className: 'highslide-html-content', 
		innerHTML: hs1.replaceLang(hs1.skin.contentWrapper) 
	});
},
getElementByClass : function (el, tagName, className) {
	var els = el.getElementsByTagName(tagName);
	for (var i = 0; i < els.length; i++) {
    	if ((new RegExp(className)).test(els[i].className)) {
			return els[i];
		}
	}
	return null;
},
replaceLang : function(s) {
	s = s.replace(/\s/g, ' ');
	var re = /{hs\.lang\.([^}]+)\}/g,
		matches = s.match(re),
		lang;
	if (matches) for (var i = 0; i < matches.length; i++) {
		lang = matches[i].replace(re, "$1");
		if (typeof hs1.lang[lang] != 'undefined') s = s.replace(matches[i], hs1.lang[lang]);
	}
	return s;
},


getCacheBinding : function (a) {
	for (var i = 0; i < hs1.cacheBindings.length; i++) {
		if (hs1.cacheBindings[i][0] == a) {
			var c = hs1.cacheBindings[i][1];
			hs1.cacheBindings[i][1] = c.cloneNode(1);
			return c;
		}
	}
	return null;
},

preloadAjax : function (e) {
	var arr = hs1.getAnchors();
	for (var i = 0; i < arr.htmls.length; i++) {
		var a = arr.htmls[i];
		if (hs1.getParam(a, 'objectType') == 'ajax' && hs1.getParam(a, 'cacheAjax'))
			hs1.push(hs1.preloadTheseAjax, a);
	}
	
	hs1.preloadAjaxElement(0);
},

preloadAjaxElement : function (i) {
	if (!hs1.preloadTheseAjax[i]) return;
	var a = hs1.preloadTheseAjax[i];
	var cache = hs1.getNode(hs1.getParam(a, 'contentId'));
	if (!cache) cache = hs1.getSelfRendered();
	var ajax = new hs1.Ajax(a, cache, 1);	
   	ajax.onError = function () { };
   	ajax.onLoad = function () {
   		hs1.push(hs1.cacheBindings, [a, cache]);
   		hs1.preloadAjaxElement(i + 1);
   	};
   	ajax.run();
},

focusTopmost : function() {
	var topZ = 0, topmostKey = -1;
	for (var i = 0; i < hs1.expanders.length; i++) {
		if (hs1.expanders[i]) {
			if (hs1.expanders[i].wrapper.style.zIndex && hs1.expanders[i].wrapper.style.zIndex > topZ) {
				topZ = hs1.expanders[i].wrapper.style.zIndex;
				
				topmostKey = i;
			}
		}
	}
	if (topmostKey == -1) hs1.focusKey = -1;
	else hs1.expanders[topmostKey].focus();
},

getParam : function (a, param) {
	a.getParams = a.onclick;
	var p = a.getParams ? a.getParams() : null;
	a.getParams = null;
	
	return (p && typeof p[param] != 'undefined') ? p[param] : 
		(typeof hs[param] != 'undefined' ? hs[param] : null);
},

getSrc : function (a) {
	var src = hs1.getParam(a, 'src');
	if (src) return src;
	return a.href;
},

getNode : function (id) {
	var node = hs1.$(id), clone = hs1.clones[id], a = {};
	if (!node && !clone) return null;
	if (!clone) {
		clone = node.cloneNode(true);
		clone.id = '';
		hs1.clones[id] = clone;
		return node;
	} else {
		return clone.cloneNode(true);
	}
},

discardElement : function(d) {
	hs1.garbageBin.appendChild(d);
	hs1.garbageBin.innerHTML = '';
},

previousOrNext : function (el, op) {
	hs1.updateAnchors();
	var exp = hs1.last = hs1.getExpander(el);
	try {
		var adj = hs1.upcoming =  exp.getAdjacentAnchor(op);
		adj.onclick(); 		
	} catch (e){
		hs1.last = hs1.upcoming = null;
	}
	try { exp.close(); } catch (e) {}
	return false;
},

previous : function (el) {
	return hs1.previousOrNext(el, -1);
},

next : function (el) {
	return hs1.previousOrNext(el, 1);	
},
refreshparentObject : function (e1)
{
	
	var topWin	= window.top;
	topWin.location.href	= window.self.location;//'view_picture.php?user_id=MTg=';
	return hs1.close();
},

keyHandler : function(e) {
	if (!e) e = window.event;
	if (!e.target) e.target = e.srcElement; // ie
	if (typeof e.target.form != 'undefined') return true; // form element has focus
	var exp = hs1.getExpander();
	
	var op = null;
	switch (e.keyCode) {
		case 70: // f
			if (exp) exp.doFullExpand();
			return true;
		case 32: // Space
		case 34: // Page Down
		case 39: // Arrow right
		case 40: // Arrow down
			op = 1;
			break;
		case 8:  // Backspace
		case 33: // Page Up
		case 37: // Arrow left
		case 38: // Arrow up
			op = -1;
			break;
		case 27: // Escape
		case 13: // Enter
			op = 0;
	}
	if (op !== null) {hs1.removeEventListener(document, window.opera ? 'keypress' : 'keydown', hs1.keyHandler);
		if (!hs1.enableKeyListener) return true;
		
		if (e.preventDefault) e.preventDefault();
    	else e.returnValue = false;
    	
    	if (exp) {
			if (op == 0) {
				exp.close();
			} else {
				hs1.previousOrNext(exp.key, op);
			}
			return false;
		}
	}
	return true;
},


registerOverlay : function (overlay) {
	hs1.push(hs1.overlays, overlay);
},


getWrapperKey : function (element, expOnly) {
	var el, re = /^highslide-wrapper-([0-9]+)$/;
	// 1. look in open expanders
	el = element;
	while (el.parentNode)	{
		if (el.id && re.test(el.id)) return el.id.replace(re, "$1");
		el = el.parentNode;
	}
	// 2. look in thumbnail
	if (!expOnly) {
		el = element;
		while (el.parentNode)	{
			if (el.tagName && hs1.isHsAnchor(el)) {
				for (var key = 0; key < hs1.expanders.length; key++) {
					var exp = hs1.expanders[key];
					if (exp && exp.a == el) return key;
				}
			}
			el = el.parentNode;
		}
	}
	return null; 
},

getExpander : function (el, expOnly) {
	if (typeof el == 'undefined') return hs1.expanders[hs1.focusKey] || null;
	if (typeof el == 'number') return hs1.expanders[el] || null;
	if (typeof el == 'string') el = hs1.$(el);
	return hs1.expanders[hs1.getWrapperKey(el, expOnly)] || null;
},

isHsAnchor : function (a) {
	return (a.onclick && a.onclick.toString().replace(/\s/g, ' ').match(/hs1.(htmlE|e)xpand/));
},

reOrder : function () {
	for (var i = 0; i < hs1.expanders.length; i++)
		if (hs1.expanders[i] && hs1.expanders[i].isExpanded) hs1.focusTopmost();
},

mouseClickHandler : function(e) 
{	
	if (!e) e = window.event;
	if (e.button > 1) return true;
	if (!e.target) e.target = e.srcElement;
	
	var el = e.target;
	while (el.parentNode
		&& !(/highslide-(image|move|html|resize)/.test(el.className)))
	{
		el = el.parentNode;
	}
	var exp = hs1.getExpander(el);
	if (exp && (exp.isClosing || !exp.isExpanded)) return true;
		
	if (exp && e.type == 'mousedown') {
		if (e.target.form) return true;
		var match = el.className.match(/highslide-(image|move|resize)/);
		if (match) {
			hs1.dragArgs = { exp: exp , type: match[1], left: exp.x.pos, width: exp.x.size, top: exp.y.pos, 
				height: exp.y.size, clickX: e.clientX, clickY: e.clientY };
			
			
			hs1.addEventListener(document, 'mousemove', hs1.dragHandler);
			if (e.preventDefault) e.preventDefault(); // FF
			
			if (/highslide-(image|html)-blur/.test(exp.content.className)) {
				exp.focus();
				hs1.hasFocused = true;
			}
			return false;
		}
		else if (/highslide-html/.test(el.className) && hs1.focusKey != exp.key) {
			exp.focus();
			exp.doShowHide('hidden');
		}
	} else if (e.type == 'mouseup') {
		
		hs1.removeEventListener(document, 'mousemove', hs1.dragHandler);
		
		if (hs1.dragArgs) {
			if (hs1.dragArgs.type == 'image')
				hs1.dragArgs.exp.content.style.cursor = hs1.styleRestoreCursor;
			var hasDragged = hs1.dragArgs.hasDragged;
			
			if (!hasDragged &&!hs1.hasFocused && !/(move|resize)/.test(hs1.dragArgs.type)) {
				exp.close();
			} 
			else if (hasDragged || (!hasDragged && hs1.hasHtmlExpanders)) {
				hs1.dragArgs.exp.doShowHide('hidden');
			}
			
			if (hs1.dragArgs.exp.releaseMask) 
				hs1.dragArgs.exp.releaseMask.style.display = 'none';
			
			hs1.hasFocused = false;
			hs1.dragArgs = null;
		
		} else if (/highslide-image-blur/.test(el.className)) {
			el.style.cursor = hs1.styleRestoreCursor;		
		}
	}
	return false;
},

dragHandler : function(e)
{
	if (!hs1.dragArgs) return true;
	if (!e) e = window.event;
	var a = hs1.dragArgs, exp = a.exp;
	if (exp.iframe) {		
		if (!exp.releaseMask) exp.releaseMask = hs1.createElement('div', null, 
			{ position: 'absolute', width: exp.x.size+'px', height: exp.y.size+'px', 
				left: exp.x.cb+'px', top: exp.y.cb+'px', zIndex: 4,	background: (hs1.ie ? 'white' : 'none'), 
				opacity: .01 }, 
			exp.wrapper, true);
		if (exp.releaseMask.style.display == 'none')
			exp.releaseMask.style.display = '';
	}
	
	a.dX = e.clientX - a.clickX;
	a.dY = e.clientY - a.clickY;	
	
	var distance = Math.sqrt(Math.pow(a.dX, 2) + Math.pow(a.dY, 2));
	if (!a.hasDragged) a.hasDragged = (a.type != 'image' && distance > 0)
		|| (distance > (hs1.dragSensitivity || 5));
	
	if (a.hasDragged && e.clientX > 5 && e.clientY > 5) {
		
		if (a.type == 'resize') exp.resize(a);
		else {
			exp.moveTo(a.left + a.dX, a.top + a.dY);
			if (a.type == 'image') exp.content.style.cursor = 'move';
		}
	}
	return false;
},

wrapperMouseHandler : function (e) {
	try {
		if (!e) e = window.event;
		var over = /mouseover/i.test(e.type); 
		if (!e.target) e.target = e.srcElement; // ie
		if (hs1.ie) e.relatedTarget = 
			over ? e.fromElement : e.toElement; // ie
		var exp = hs1.getExpander(e.target);
		if (!exp.isExpanded) return;
		if (!exp || !e.relatedTarget || hs1.getExpander(e.relatedTarget, true) == exp 
			|| hs1.dragArgs) return;
		for (var i = 0; i < exp.overlays.length; i++) {
			var o = hs1.$('hsId'+ exp.overlays[i]);
			if (o && o.hideOnMouseOut) {
				var from = over ? 0 : o.opacity,
					to = over ? o.opacity : 0;			
				hs1.fade(o, from, to);
			}
		}	
	} catch (e) {}
},

addEventListener : function (el, event, func) {
	try {
		el.addEventListener(event, func, false);
	} catch (e) {
		try {
			el.detachEvent('on'+ event, func);
			el.attachEvent('on'+ event, func);
		} catch (e) {
			el['on'+ event] = func;
		}
	} 
},

removeEventListener : function (el, event, func) {
	try {
		el.removeEventListener(event, func, false);
	} catch (e) {
		try {
			el.detachEvent('on'+ event, func);
		} catch (e) {
			el['on'+ event] = null;
		}
	}
},

preloadFullImage : function (i) {
	if (hs1.continuePreloading && hs1.preloadTheseImages[i] && hs1.preloadTheseImages[i] != 'undefined') {
		var img = document.createElement('img');
		img.onload = function() { 
			img = null;
			hs1.preloadFullImage(i + 1);
		};
		img.src = hs1.preloadTheseImages[i];
	}
},
preloadImages : function (number) {
	if (number && typeof number != 'object') hs1.numberOfImagesToPreload = number;
	
	var arr = hs1.getAnchors();
	for (var i = 0; i < arr.images.length && i < hs1.numberOfImagesToPreload; i++) {
		hs1.push(hs1.preloadTheseImages, hs1.getSrc(arr.images[i]));
	}
	
	// preload outlines
	if (hs1.outlineType)	new hs1.Outline(hs1.outlineType, function () { hs1.preloadFullImage(0)} );
	else
	
	hs1.preloadFullImage(0);
	
	// preload cursor
	var cur = hs1.createElement('img', { src: hs1.graphicsDir + hs1.restoreCursor });
},


init : function () {
	if (!hs1.container) {
		hs1.container = hs1.createElement('div', {
				className: 'highslide-container'
			}, {
				position: 'absolute', 
				left: 0, 
				top: 0, 
				width: '100%', 
				zIndex: hs1.zIndexCounter,
				direction: 'ltr'
			}, 
			document.body,
			true
		);
		hs1.loading = hs1.createElement('a', {
				className: 'highslide-loading',
				title: hs1.lang.loadingTitle,
				innerHTML: hs1.lang.loadingText,
				href: 'javascript:;'
			}, {
				position: 'absolute',
				top: '-9999px',
				opacity: hs1.loadingOpacity,
				zIndex: 1
			}, hs1.container
		);
		hs1.garbageBin = hs1.createElement('div', null, { display: 'none' }, hs1.container);
		hs1.clearing = hs1.createElement('div', null, 
			{ clear: 'both', paddingTop: '1px' }, null, true);
		
		// http://www.robertpenner.com/easing/ 
		Math.linearTween = function (t, b, c, d) {
			return c*t/d + b;
		};
		Math.easeInQuad = function (t, b, c, d) {
			return c*(t/=d)*t + b;
		};
		for (var x in hs1.langDefaults) {
			if (typeof hs[x] != 'undefined') hs1.lang[x] = hs[x];
			else if (typeof hs1.lang[x] == 'undefined' && typeof hs1.langDefaults[x] != 'undefined') 
				hs1.lang[x] = hs1.langDefaults[x];
		}
		hs1.ie6SSL = (hs1.ie && hs1.ieVersion() <= 6 && location.protocol == 'https:');
		
		hs1.hideSelects = (hs1.ie && hs1.ieVersion() < 7);
		hs1.hideIframes = ((window.opera && navigator.appVersion < 9) || navigator.vendor == 'KDE' 
			|| (hs1.ie && hs1.ieVersion() < 5.5));
	}
},
domReady : function() {
	hs1.isDomReady = true;
	if (hs1.onDomReady) hs1.onDomReady();
},

updateAnchors : function() {
	var els = document.all || document.getElementsByTagName('*'), all = [], images = [], htmls = [],groups = {}, re;
	
	for (var i = 0; i < els.length; i++) {
		re = hs1.isHsAnchor(els[i]);
		if (re) {
			hs1.push(all, els[i]);
			if (re[0] == 'hs1.expand') hs1.push(images, els[i]);
			else if (re[0] == 'hs1.htmlExpand') hs1.push(htmls, els[i]);
			var g = hs1.getParam(els[i], 'slideshowGroup') || 'none';
			if (!groups[g]) groups[g] = [];
			hs1.push(groups[g], els[i]);
		}
	}
	hs1.anchors = { all: all, groups: groups, images: images, htmls: htmls };
	
	return hs1.anchors;
},

getAnchors : function() {
	return hs1.anchors || hs1.updateAnchors();
},


fade : function (el, o, oFinal, dur, fn, i, dir) {
	if (typeof i == 'undefined') { // new fader
		if (typeof dur != 'number') dur = 250;
		if (dur < 25) { // instant
			hs1.setStyles( el, { opacity: oFinal	});
			if (fn) fn();
			return;
		}
		i = hs1.faders.length;
		dir = oFinal > o ? 1 : -1;
		var step = (25 / (dur - dur % 25)) * Math.abs(o - oFinal);
	}
	o = parseFloat(o);
	var skip = (el.fade === 0 || el.fade === false || (el.fade == 2 && hs1.ie));
	el.style.visibility = ((skip ? oFinal : o) <= 0) ? 'hidden' : 'visible';
	if (skip || o < 0 || (dir == 1 && o > oFinal)) { 
		if (fn) fn();
		return;
	}
	if (el.fading && el.fading.i != i) {
		clearTimeout(hs1.faders[el.fading.i]);
		o = el.fading.o;
	}
	el.fading = {i: i, o: o, step: (step || el.fading.step)};
	el.style.visibility = (o <= 0) ? 'hidden' : 'visible';
	hs1.setStyles(el, { opacity: o });
	hs1.faders[i] = setTimeout(function() {
		hs1.fade(el, o + el.fading.step * dir, oFinal, null, fn, i, dir);
	}, 25);
},

close : function(el) {
	var exp = hs1.getExpander(el);
	if (exp) exp.close();
	return false;
}
}; // end hs object


hs1.Outline =  function (outlineType, onLoad) {
	this.onLoad = onLoad;
	this.outlineType = outlineType;
	var v = hs1.ieVersion(), tr;
	
	this.hasAlphaImageLoader = hs1.ie && v >= 5.5 && v < 7;
	if (!outlineType) {
		if (onLoad) onLoad();
		return;
	}
	
	hs1.init();
	this.table = hs1.createElement(
		'table', { 
			cellSpacing: 0 
		}, {
			visibility: 'hidden',
			position: 'absolute',
			borderCollapse: 'collapse',
			width: 0
		},
		hs1.container,
		true
	);
	var tbody = hs1.createElement('tbody', null, null, this.table, 1);
	
	this.td = [];
	for (var i = 0; i <= 8; i++) {
		if (i % 3 == 0) tr = hs1.createElement('tr', null, { height: 'auto' }, tbody, true);
		this.td[i] = hs1.createElement('td', null, null, tr, true);
		var style = i != 4 ? { lineHeight: 0, fontSize: 0} : { position : 'relative' };
		hs1.setStyles(this.td[i], style);
	}
	this.td[4].className = outlineType +' highslide-outline';
	
	this.preloadGraphic(); 
};

hs1.Outline.prototype = {
preloadGraphic : function () {
	var src = hs1.graphicsDir + (hs1.outlinesDir || "outlines/")+ this.outlineType +".png";
				
	var appendTo = hs1.safari ? hs1.container : null;
	this.graphic = hs1.createElement('img', null, { position: 'absolute', 
		top: '-9999px' }, appendTo, true); // for onload trigger
	
	var pThis = this;
	this.graphic.onload = function() { pThis.onGraphicLoad(); };
	
	this.graphic.src = src;
},

onGraphicLoad : function () {
	var o = this.offset = this.graphic.width / 4,
		pos = [[0,0],[0,-4],[-2,0],[0,-8],0,[-2,-8],[0,-2],[0,-6],[-2,-2]],
		dim = { height: (2*o) +'px', width: (2*o) +'px' };
	for (var i = 0; i <= 8; i++) {
		if (pos[i]) {
			if (this.hasAlphaImageLoader) {
				var w = (i == 1 || i == 7) ? '100%' : this.graphic.width +'px';
				var div = hs1.createElement('div', null, { width: '100%', height: '100%', position: 'relative', overflow: 'hidden'}, this.td[i], true);
				hs1.createElement ('div', null, { 
						filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale, src='"+ this.graphic.src + "')", 
						position: 'absolute',
						width: w, 
						height: this.graphic.height +'px',
						left: (pos[i][0]*o)+'px',
						top: (pos[i][1]*o)+'px'
					}, 
				div,
				true);
			} else {
				hs1.setStyles(this.td[i], { background: 'url('+ this.graphic.src +') '+ (pos[i][0]*o)+'px '+(pos[i][1]*o)+'px'});
			}
			
			if (window.opera && (i == 3 || i ==5)) 
				hs1.createElement('div', null, dim, this.td[i], true);
			
			hs1.setStyles (this.td[i], dim);
		}
	}
	this.graphic = null;
	if (hs1.pendingOutlines[this.outlineType]) hs1.pendingOutlines[this.outlineType].destroy();
	hs1.pendingOutlines[this.outlineType] = this;
	if (this.onLoad) this.onLoad();
},
	
setPosition : function (exp, pos, vis) {
	pos = pos || {
		x: exp.x.pos,
		y: exp.y.pos,
		w: exp.x.size + exp.x.p1 + exp.x.p2,
		h: exp.y.size + exp.y.p1 + exp.y.p2
	};
	if (vis) this.table.style.visibility = (pos.h >= 4 * this.offset) 
		? 'visible' : 'hidden';
	hs1.setStyles(this.table, {
		left: (pos.x - this.offset) +'px',
		top: (pos.y - this.offset) +'px',
		width: (pos.w + 2 * (exp.x.cb + this.offset)) +'px'
	});
	
	pos.w += 2 * (exp.x.cb - this.offset);
	pos.h += + 2 * (exp.y.cb - this.offset);
	hs1.setStyles (this.td[4], {
		width: pos.w >= 0 ? pos.w +'px' : 0,
		height: pos.h >= 0 ? pos.h +'px' : 0
	});
	if (this.hasAlphaImageLoader) this.td[3].style.height 
		= this.td[5].style.height = this.td[4].style.height;
},
	
destroy : function(hide) {
	if (hide) this.table.style.visibility = 'hidden';
	else hs1.discardElement(this.table);
}
};

hs1.Dimension = function(exp, dim) {
	this.exp = exp;
	this.dim = dim;
	this.ucwh = dim == 'x' ? 'Width' : 'Height';
	this.wh = this.ucwh.toLowerCase();
	this.uclt = dim == 'x' ? 'Left' : 'Top';
	this.lt = this.uclt.toLowerCase();
	this.ucrb = dim == 'x' ? 'Right' : 'Bottom';
	this.rb = this.ucrb.toLowerCase();
};
hs1.Dimension.prototype = {
get : function(key) {
	switch (key) {
		case 'loadingPos':
			return this.tpos + this.tb + (this.t - hs1.loading['offset'+ this.ucwh]) / 2;
		case 'wsize':
			return this.size + 2 * this.cb + this.p1 + this.p2;
		case 'fitsize':
			return this.clientSize - this.marginMin - this.marginMax;
		case 'opos':
			return this.pos - (this.exp.outline ? this.exp.outline.offset : 0);
		case 'osize':
			return this.get('wsize') + (this.exp.outline ? 2*this.exp.outline.offset : 0);
		case 'imgPad':
			return this.imgSize ? Math.round((this.size - this.imgSize) / 2) : 0;
		
	}
},
calcBorders: function() {
	// correct for borders
	this.cb = (this.exp.content['offset'+ this.ucwh] - this.t) / 2;
	this.marginMax = hs['margin'+ this.ucrb] + 2 * this.cb;
},
calcThumb: function() {
	this.t = this.exp.el[this.wh] ? parseInt(this.exp.el[this.wh]) : 
		this.exp.el['offset'+ this.ucwh];
	this.tpos = this.exp.tpos[this.dim];
	this.tb = (this.exp.el['offset'+ this.ucwh] - this.t) / 2;
	this.p1 = this.p2 = 0;
	if (this.tpos == 0) {
		this.tpos = (hs1.page[this.wh] / 2) + hs1.page['scroll'+ this.uclt];		
	};
},
calcExpanded: function() {
	this.justify = 'auto';
	
	
	// size and position
	this.pos = this.tpos - this.cb + this.tb;
	this.size = Math.min(this.full, this.exp['max'+ this.ucwh] || this.full);
	this.minSize = this.exp.allowSizeReduction ? 
		Math.min(this.exp['min'+ this.ucwh], this.full) : this.full;
	if (hs1.padToMinWidth && this.dim == 'x') this.minSize = this.exp.minWidth;
	this.marginMin = hs['margin'+ this.uclt];
	this.scroll = hs1.page['scroll'+ this.uclt];
	this.clientSize = hs1.page[this.wh];
},
setSize: function(i) {
	this.size = i;
	this.exp.content.style[this.wh] = i +'px';
	this.exp.wrapper.style[this.wh] = this.get('wsize') +'px';
	if (this.exp.outline) this.exp.outline.setPosition(this.exp);
	if (this.exp.releaseMask) this.exp.releaseMask.style[this.wh] = i +'px';
	if (this.exp.isHtml) {
		var d = this.exp.scrollerDiv;
		if (!this.sizeDiff)	
			this.sizeDiff = this.exp.innerContent['offset'+ this.ucwh] - d['offset'+ this.ucwh];
		d.style[this.wh] = (this.size - this.sizeDiff) +'px';
	
		if (this.dim == 'x') this.exp.mediumContent.style.width = 'auto';
		if (this.exp.body) this.exp.body.style[this.wh] = 'auto';
	
	}
	if (this.dim == 'x' && this.exp.overlayBox) this.exp.sizeOverlayBox(true);
},
setPos: function(i) {
	this.pos = i;
	this.exp.wrapper.style[this.lt] = i +'px';	
	
	if (this.exp.outline) this.exp.outline.setPosition(this.exp);
	
}
};

hs1.Expander = function(a, params, custom, contentType) {
	if (document.readyState && hs1.ie && !hs1.isDomReady) {
		hs1.onDomReady = function() {
			new hs1.Expander(a, params, custom, contentType);
		};
		return;
	} 
	this.a = a;
	this.custom = custom;
	this.contentType = contentType || 'image';
	this.isHtml = (contentType == 'html');
	this.isImage = !this.isHtml;
	
	hs1.continuePreloading = false;
	this.overlays = [];
	hs1.init();
	var key = this.key = hs1.expanders.length;
	// override inline parameters
	for (var i = 0; i < hs1.overrides.length; i++) {
		var name = hs1.overrides[i];
		this[name] = params && typeof params[name] != 'undefined' ?
			params[name] : hs[name];
	}
	if (!this.src) this.src = a.href;
	// get thumb
	var el = (params && params.thumbnailId) ? hs1.$(params.thumbnailId) : a;
	el = this.thumb = el.getElementsByTagName('img')[0] || el;
	this.thumbsUserSetId = el.id || a.id;
	
	// check if already open
	for (var i = 0; i < hs1.expanders.length; i++) {
		if (hs1.expanders[i] && hs1.expanders[i].a == a) {
			hs1.expanders[i].focus();
			return false;
		}
	}	
	// cancel other
	for (var i = 0; i < hs1.expanders.length; i++) {
		if (hs1.expanders[i] && hs1.expanders[i].thumb != el && !hs1.expanders[i].onLoadStarted) {
			hs1.expanders[i].cancelLoading();
		}
	}
	hs1.expanders[this.key] = this;
	if (!hs1.allowMultipleInstances) {
		if (hs1.expanders[key-1]) hs1.expanders[key-1].close();
		if (typeof hs1.focusKey != 'undefined' && hs1.expanders[hs1.focusKey])
			hs1.expanders[hs1.focusKey].close();
	}
	
	
	// initiate metrics
	this.el = el;
	this.tpos = hs1.getPosition(el);
	hs1.page = hs1.getPageSize();
	var x = this.x = new hs1.Dimension(this, 'x');
	x.calcThumb();
	var y = this.y = new hs1.Dimension(this, 'y');
	y.calcThumb();
	
	// instanciate the wrapper
	this.wrapper = hs1.createElement(
		'div', {
			id: 'highslide-wrapper-'+ this.key,
			className: this.wrapperClassName
		}, {
			visibility: 'hidden',
			position: 'absolute',
			zIndex: hs1.zIndexCounter++
		}, null, true );
	
	this.wrapper.onmouseover = this.wrapper.onmouseout = hs1.wrapperMouseHandler;
	if (this.contentType == 'image' && this.outlineWhileAnimating == 2)
		this.outlineWhileAnimating = 0;
	
	// get the outline
	if (!this.outlineType) {
		this[this.contentType +'Create']();
	
	} else if (hs1.pendingOutlines[this.outlineType]) {
		this.connectOutline();
		this[this.contentType +'Create']();
	
	} else {
		this.showLoading();
		var exp = this;
		new hs1.Outline(this.outlineType, 
			function () {
				exp.connectOutline();
				exp[exp.contentType +'Create']();
			} 
		);
	}
	return true;
};

hs1.Expander.prototype = {

connectOutline : function() {
	var o = this.outline = hs1.pendingOutlines[this.outlineType];
	o.table.style.zIndex = this.wrapper.style.zIndex;
	hs1.pendingOutlines[this.outlineType] = null;
},

showLoading : function() {
	if (this.onLoadStarted || this.loading) return;
	
	this.loading = hs1.loading;
	var exp = this;
	this.loading.onclick = function() {
		exp.cancelLoading();
	};
	var exp = this, 
		l = this.x.get('loadingPos') +'px',
		t = this.y.get('loadingPos') +'px';
	setTimeout(function () { 
		if (exp.loading) hs1.setStyles(exp.loading, { left: l, top: t, zIndex: hs1.zIndexCounter++ })}
	, 100);
},

imageCreate : function() {
	var exp = this;
	
	var img = document.createElement('img');
    this.content = img;
    img.onload = function () {
    	if (hs1.expanders[exp.key]) exp.contentLoaded(); 
	};
    if (hs1.blockRightClick) img.oncontextmenu = function() { return false; };
    img.className = 'highslide-image';
    hs1.setStyles(img, {
    	visibility: 'hidden',
    	display: 'block',
    	position: 'absolute',
		maxWidth: '9999px',
		zIndex: 3
	});
    img.title = hs1.lang.restoreTitle;
    if (hs1.safari) hs1.container.appendChild(img);
    if (hs1.ie && hs1.flushImgSize) img.src = null;
	img.src = this.src;
	
	this.showLoading();
},

htmlCreate : function () {
	
	this.content = hs1.getCacheBinding(this.a);
	if (!this.content) 
		this.content = hs1.getNode(this.contentId);
	if (!this.content) 
		this.content = hs1.getSelfRendered();
	this.getInline(['maincontent']);
	if (this.maincontent) {
		var body = hs1.getElementByClass(this.content, 'div', 'highslide-body');
		if (body) body.appendChild(this.maincontent);
		this.maincontent.style.display = 'block';
	}
	
	this.innerContent = this.content;
	
	if (/(swf|iframe)/.test(this.objectType)) this.setObjContainerSize(this.innerContent);
	
	// the content tree
	hs1.container.appendChild(this.wrapper);
	hs1.setStyles( this.wrapper, { 
		position: 'static',
		padding: '0 '+ hs1.marginRight +'px 0 '+ hs1.marginLeft +'px'
	});
	this.content = hs1.createElement(
    	'div', {
    		className: 'highslide-html' 
    	}, {
			position: 'relative',
			zIndex: 3,
			overflow: 'hidden'
		},
		this.wrapper
	);
	this.mediumContent = hs1.createElement('div', null, null, this.content, 1);
	this.mediumContent.appendChild(this.innerContent);
	
	hs1.setStyles (this.innerContent, { 
		position: 'relative',
		display: 'block',
		direction: hs1.lang.cssDirection || ''
	});
	if (this.width) this.innerContent.style.width = this.width+'px';
	if (this.height) this.innerContent.style.height = this.height+'px';
	if (this.innerContent.offsetWidth < this.minWidth)
		this.innerContent.style.width = this.minWidth +'px';
	
    
	if (this.objectType == 'ajax' && !hs1.getCacheBinding(this.a)) {
		this.showLoading();
    	var ajax = new hs1.Ajax(this.a, this.innerContent);
    	var exp = this;
    	ajax.onLoad = function () {	if (hs1.expanders[exp.key]) exp.contentLoaded(); };
    	ajax.onError = function () { location.href = exp.src; };
    	ajax.run();
	}
    else
    
    if (this.objectType == 'iframe' && this.objectLoadTime == 'before') {
		this.writeExtendedContent();
	}
    else
    	this.contentLoaded();
},

contentLoaded : function() {
	try {	
		if (!this.content) return;
		this.content.onload = null;
		if (this.onLoadStarted) return;
		else this.onLoadStarted = true;
		
		var x = this.x, y = this.y;
		
		if (this.loading) {
			hs1.setStyles(this.loading, { top: '-9999px' });
			this.loading = null;
		}
		//this.marginBottom = hs1.marginBottom;
		if (this.isImage) {	
			x.full = this.content.width;
			y.full = this.content.height;
			
			hs1.setStyles(this.content, {
				width: this.x.t +'px',
				height: this.y.t +'px'
			});
		} else if (this.htmlGetSize) this.htmlGetSize();
		
		this.wrapper.appendChild(this.content);
		hs1.setStyles (this.wrapper, {
			left: this.x.tpos +'px',
			top: this.y.tpos +'px'
		});
		hs1.container.appendChild(this.wrapper);
		
		x.calcBorders();
		y.calcBorders();
		this.getOverlays();
		
		var ratio = x.full / y.full;
		
		x.calcExpanded();
		this.justify(x);
		
		y.calcExpanded();
		this.justify(y);
		if (this.isHtml) this.htmlSizeOperations();
		if (this.overlayBox) this.sizeOverlayBox(0, 1);
		
		if (this.allowSizeReduction) {
			if (this.isImage)
				this.correctRatio(ratio);
			else this.fitOverlayBox();		
			
			if (this.isImage && this.x.full > this.x.size) {
				this.createFullExpand();
				if (this.overlays.length == 1) this.sizeOverlayBox();	
			}
		}
		this.show();
		
	} catch (e) {
		window.location.href = this.src;
	}
},


setObjContainerSize : function(parent, auto) {
	var c = hs1.getElementByClass(parent, 'DIV', 'highslide-body');
	if (/(iframe|swf)/.test(this.objectType)) {
		if (this.objectWidth) c.style.width = this.objectWidth +'px';
		if (this.objectHeight) c.style.height = this.objectHeight +'px';
	}
},

writeExtendedContent : function () {
	if (this.hasExtendedContent) return;
	var exp = this;
	this.body = hs1.getElementByClass(this.innerContent, 'DIV', 'highslide-body');
	if (this.objectType == 'iframe') {
		this.showLoading();
		var ruler = hs1.clearing.cloneNode(1);
		this.body.appendChild(ruler);
		this.newWidth = this.innerContent.offsetWidth;
		if (!this.objectWidth) this.objectWidth = ruler.offsetWidth;
		var hDiff = this.innerContent.offsetHeight - this.body.offsetHeight,
			h = this.objectHeight || (hs1.getPageSize()).height - hDiff - hs1.marginTop - hs1.marginBottom,
			onload = this.objectLoadTime == 'before' ? 
				' onload="if (hs1.expanders['+ this.key +']) hs1.expanders['+ this.key +'].contentLoaded()" ' : '';
		
		this.body.innerHTML += '<iframe name="hs'+ (new Date()).getTime() +'" frameborder="0" key="'+ this.key +'" '
			+' allowtransparency="true" style="width:'+ this.objectWidth +'px; height:'+ h +'px" '
			+ onload +' src="'+ this.src +'"></iframe>';
		this.ruler = this.body.getElementsByTagName('div')[0];
		this.iframe = this.body.getElementsByTagName('iframe')[0];
		
		if (this.objectLoadTime == 'after') this.correctIframeSize();
		
	}
	if (this.objectType == 'swf') {
		this.body.id = this.body.id || 'hs-flash-id-' + this.key;
		var a = this.swfOptions;
		if (typeof a.params.wmode == 'undefined') a.params.wmode = 'transparent';
		if (swfobject) swfobject.embedSWF(this.src, this.body.id, this.objectWidth, this.objectHeight, 
			a.version || '7', a.expressInstallSwfurl, a.flashvars, a.params, a.attributes);
	}
	this.hasExtendedContent = true;
},
htmlGetSize : function() {
	if (this.iframe && !this.objectHeight) { // loadtime before		
		this.iframe.style.height = this.body.style.height = this.getIframePageHeight() +'px';
	}
	this.innerContent.appendChild(hs1.clearing);
	if (!this.x.full) this.x.full = this.innerContent.offsetWidth;
    this.y.full = this.innerContent.offsetHeight;
    this.innerContent.removeChild(hs1.clearing);
    if (hs1.ie && this.newHeight > parseInt(this.innerContent.currentStyle.height)) { // ie css bug
		this.newHeight = parseInt(this.innerContent.currentStyle.height);
	}
	hs1.setStyles( this.wrapper, { position: 'absolute',	padding: '0'});
	hs1.setStyles( this.content, { width: this.x.t +'px',	height: this.y.t +'px'});
},

getIframePageHeight : function() {
	var h;
	try {
		var doc = this.iframe.contentDocument || this.iframe.contentWindow.document;
		var clearing = doc.createElement('div');
		clearing.style.clear = 'both';
		doc.body.appendChild(clearing);
		h = clearing.offsetTop;
		if (hs1.ie) h += parseInt(doc.body.currentStyle.marginTop) 
			+ parseInt(doc.body.currentStyle.marginBottom) - 1;
	} catch (e) { // other domain
		h = 300;
	}
	return h;
},
correctIframeSize : function () {
	var wDiff = this.innerContent.offsetWidth - this.ruler.offsetWidth;
	if (wDiff < 0) wDiff = 0;
	
	var hDiff = this.innerContent.offsetHeight - this.body.offsetHeight;
	
    hs1.setStyles(this.iframe, { width: (this.x.size - wDiff) +'px', 
		height: (this.y.size - hDiff) +'px' });
    hs1.setStyles(this.body, { width: this.iframe.style.width, 
    	height: this.iframe.style.height });
    	
    this.scrollingContent = this.iframe;
    this.scrollerDiv = this.scrollingContent;
},
htmlSizeOperations : function () {
	
	this.setObjContainerSize(this.innerContent);
	
	
	if (this.objectType == 'swf' && this.objectLoadTime == 'before') this.writeExtendedContent();	
	
    // handle minimum size
    if (this.x.size < this.x.full && !this.allowWidthReduction) this.x.size = this.x.full;
    if (this.y.size < this.y.full && !this.allowHeightReduction) this.y.size = this.y.full;
    this.scrollerDiv = this.innerContent;
    hs1.setStyles(this.mediumContent, { 
		width: this.x.size +'px',
		position: 'relative',
		left: (this.x.pos - this.x.tpos) +'px',
		top: (this.y.pos - this.y.tpos) +'px'
	});
    hs1.setStyles(this.innerContent, { 
    	border: 'none', 
    	width: 'auto', 
    	height: 'auto'
    });
	var node = hs1.getElementByClass(this.innerContent, 'DIV', 'highslide-body');
    if (node && !/(iframe|swf)/.test(this.objectType)) {
    	var cNode = node; // wrap to get true size
    	node = hs1.createElement(cNode.nodeName, null, {overflow: 'hidden'}, null, true);
    	cNode.parentNode.insertBefore(node, cNode);
    	node.appendChild(hs1.clearing); // IE6
    	node.appendChild(cNode);
    	
    	var wDiff = this.innerContent.offsetWidth - node.offsetWidth;
    	var hDiff = this.innerContent.offsetHeight - node.offsetHeight;
    	node.removeChild(hs1.clearing);
    	
    	var kdeBugCorr = hs1.safari || navigator.vendor == 'KDE' ? 1 : 0; // KDE repainting bug
    	hs1.setStyles(node, { 
    			width: (this.x.size - wDiff - kdeBugCorr) +'px', 
    			height: (this.y.size - hDiff) +'px',
    			overflow: 'auto', 
    			position: 'relative' 
    		} 
    	);
		if (kdeBugCorr && cNode.offsetHeight > node.offsetHeight)	{
    		node.style.width = (parseInt(node.style.width) + kdeBugCorr) + 'px';
		}
    	this.scrollingContent = node;
    	this.scrollerDiv = this.scrollingContent;
	}
    if (this.iframe && this.objectLoadTime == 'before') this.correctIframeSize();
    if (!this.scrollingContent && this.y.size < this.mediumContent.offsetHeight) this.scrollerDiv = this.content;
	
	if (this.scrollerDiv == this.content && !this.allowWidthReduction && !/(iframe|swf)/.test(this.objectType)) {
		this.x.size += 17; // room for scrollbars
	}
	if (this.scrollerDiv && this.scrollerDiv.offsetHeight > this.scrollerDiv.parentNode.offsetHeight) {
		setTimeout("try { hs1.expanders["+ this.key +"].scrollerDiv.style.overflow = 'auto'; } catch(e) {}",
			 hs1.expandDuration);
	}
},

justify : function (p, moveOnly) {
	var tgtArr, tgt = p.target, dim = p == this.x ? 'x' : 'y';
	
		var hasMovedMin = false;
		
		var allowReduce = hs1.allowSizeReduction;
			p.pos = Math.round(p.pos - ((p.get('wsize') - p.t) / 2));
		if (p.pos < p.scroll + p.marginMin) {
			p.pos = p.scroll + p.marginMin;
			hasMovedMin = true;		
		}
		if (!moveOnly && p.size < p.minSize) {
			p.size = p.minSize;
			allowReduce = false;
		}
		if (p.pos + p.get('wsize') > p.scroll + p.clientSize - p.marginMax) {
			if (!moveOnly && hasMovedMin && allowReduce) {
				p.size = p.get('fitsize'); // can't expand more
			} else if (p.get('wsize') < p.get('fitsize')) {
				p.pos = p.scroll + p.clientSize - p.marginMax - p.get('wsize');
			} else { // image larger than viewport
				p.pos = p.scroll + p.marginMin;
				if (!moveOnly && allowReduce) p.size = p.get('fitsize');
			}			
		}
		
		if (!moveOnly && p.size < p.minSize) {
			p.size = p.minSize;
			allowReduce = false;
		}
		
	
		
	if (p.pos < p.marginMin) {
		var tmpMin = p.pos;
		p.pos = p.marginMin; 
		
		if (allowReduce && !moveOnly) p.size = p.size - (p.pos - tmpMin);
		
	}
},

correctRatio : function(ratio) {
	var x = this.x, y = this.y;
	var changed = false;
	if (x.size / y.size > ratio) { // width greater
		x.size = y.size * ratio;
		if (x.size < x.minSize) { // below minWidth
			if (hs1.padToMinWidth) x.imgSize = x.size;			
			x.size = x.minSize;
			if (!x.imgSize)
			y.size = x.size / ratio;
		}
		changed = true;
	
	} else if (x.size / y.size < ratio) { // height greater
		var tmpHeight = y.size;
		y.size = x.size / ratio;
		changed = true;
	}
	this.fitOverlayBox(ratio);
	
	if (changed) {
		x.pos = x.tpos - x.cb + x.tb;
		x.minSize = x.size;
		this.justify(x, true);
	
		y.pos = y.tpos - y.cb + y.tb;
		y.minSize = y.size;
		this.justify(y, true);
		if (this.overlayBox) this.sizeOverlayBox();
	}
},
fitOverlayBox : function(ratio) {
	var x = this.x, y = this.y;
	if (this.overlayBox) {
		while (y.size > this.minHeight && x.size > this.minWidth 
				&&  y.get('wsize')  > y.get('fitsize')) {
			y.size -= 10;
			if (ratio) x.size = y.size * ratio;
			this.sizeOverlayBox(0, 1);
		}
	}
},

show : function () {
	this.doShowHide('hidden');
	// Apply size change
	this.changeSize(
		1,
		{ 
			xpos: this.x.tpos + this.x.tb - this.x.cb,
			ypos: this.y.tpos + this.y.tb - this.y.cb,
			xsize: this.x.t,
			ysize: this.y.t,
			xp1: 0,
			xp2: 0,
			yp1: 0,
			yp2: 0,
			ximgSize: this.x.t,
			ximgPad: 0,
			o: hs1.outlineStartOffset
		},
		{
			xpos: this.x.pos,
			ypos: this.y.pos,
			xsize: this.x.size,
			ysize: this.y.size,
			xp1: this.x.p1,
			yp1: this.y.p1,
			xp2: this.x.p2,
			yp2: this.y.p2,
			ximgSize: this.x.imgSize,
			ximgPad: this.x.get('imgPad'),
			o: this.outline ? this.outline.offset : 0
		},
		hs1.expandDuration
	);
},

changeSize : function(up, from, to, dur) {
	
	if (this.outline && !this.outlineWhileAnimating) {
		if (up) this.outline.setPosition(this);
		else this.outline.destroy(
				(this.isHtml && this.preserveContent));
	}
	
	
	if (!up && this.overlayBox) {
		if (this.isHtml && this.preserveContent) {
			this.overlayBox.style.top = '-9999px';
			hs1.container.appendChild(this.overlayBox);
		} else
		hs1.discardElement(this.overlayBox);
	}
	if (this.fadeInOut) {
		from.op = up ? 0 : 1;
		to.op = up;
	}
	var t,
		exp = this,
		easing = Math[this.easing] || Math.easeInQuad,
		steps = (up ? hs1.expandSteps : hs1.restoreSteps) || parseInt(dur / 25) || 1;
	if (!up) easing = Math[this.easingClose] || easing;
	for (var i = 1; i <= steps ; i++) {
		t = Math.round(i * (dur / steps));
		
		(function(){
			var pI = i, size = {};
			
			for (var x in from) {
				size[x] = easing(t, from[x], to[x] - from[x], dur);
				if (isNaN(size[x])) size[x] = to[x];
				if (!/^op$/.test(x)) size[x] = Math.round(size[x]);
			}
			setTimeout ( function() {
				if (up && pI == 1) {
					exp.content.style.visibility = 'visible';
					exp.a.className += ' highslide-active-anchor';
				}
				exp.setSize(size);
			}, t);				
		})();
	}
	
	if (up) { 
			
		setTimeout(function() {
			if (exp.outline) exp.outline.table.style.visibility = "visible";
		}, t);
		setTimeout(function() {
			exp.afterExpand();
		}, t + 50);
	}
	else setTimeout(function() { exp.afterClose(); }, t);
},

setSize : function (to) {
	try {		
		if (to.op) hs1.setStyles(this.wrapper, { opacity: to.op });
		hs1.setStyles ( this.wrapper, {
			width : (to.xsize +to.xp1 + to.xp2 +
				2 * this.x.cb) +'px',
			height : (to.ysize +to.yp1 + to.yp2 +
				2 * this.y.cb) +'px',
			left: to.xpos +'px',
			top: to.ypos +'px'
		});
		hs1.setStyles(this.content, {
			top: to.yp1 +'px',
			left: (to.xp1 + to.ximgPad) +'px',
			width: (to.ximgSize ||to.xsize) +'px',
			height: to.ysize +'px'
		});
		if (this.isHtml) {
			hs1.setStyles(this.mediumContent, { 
				left: (this.x.pos - to.xpos 
					+ this.x.p1 - to.xp1) +'px',
				top: (this.y.pos - to.ypos 
					+ this.y.p1 - to.yp1) +'px' 
			});			
			this.innerContent.style.visibility = 'visible';
		}
		
		if (this.outline && this.outlineWhileAnimating) {
			var o = this.outline.offset - to.o;
			this.outline.setPosition(this, {
				x: to.xpos + o, 
				y: to.ypos + o, 
				w: to.xsize + to.xp1 + to.xp2 + - 2 * o, 
				h: to.ysize + to.yp1 + to.yp2 + - 2 * o
			}, 1);
		}
			
		this.wrapper.style.visibility = 'visible';
		
	} catch (e) {
		window.location.href = this.src;	
	}
},


afterExpand : function() {
	this.isExpanded = true;	
	this.focus();
	
	if (this.isHtml && this.objectLoadTime == 'after') this.writeExtendedContent();
	
	if (this.isHtml) {
		if (this.iframe) {
			try {
				var exp = this,
					doc = this.iframe.contentDocument || this.iframe.contentWindow.document;
				hs1.addEventListener(doc, 'mousedown', function () {
					if (hs1.focusKey != exp.key) exp.focus();
				});
			} catch(e) {}
			if (hs1.ie && typeof this.isClosing != 'boolean') // first open 
				this.iframe.style.width = (this.objectWidth - 1) +'px'; // hasLayout
		}
	}
	this.prepareNextOutline();
	
	
	var p = hs1.page, mX = hs1.mouse.x + p.scrollLeft, mY = hs1.mouse.y + p.scrollTop;
	this.mouseIsOver = this.x.pos < mX && mX < this.x.pos + this.x.get('wsize')
		&& this.y.pos < mY && mY < this.y.pos + this.y.get('wsize');
	
	if (this.overlayBox) this.showOverlays();
	
},


prepareNextOutline : function() {
	var key = this.key;
	var outlineType = this.outlineType;
	new hs1.Outline(outlineType, 
		function () { try { hs1.expanders[key].preloadNext(); } catch (e) {} });
},


preloadNext : function() {
	var next = this.getAdjacentAnchor(1);
	if (next && next.onclick.toString().match(/hs\.expand/)) 
		var img = hs1.createElement('img', { src: hs1.getSrc(next) });
},


getAdjacentAnchor : function(op) {
	var current = this.getAnchorIndex(), as = hs1.anchors.groups[this.slideshowGroup || 'none'];
	
	/*< ? if ($cfg->slideshow) : ?>s*/
	if (!as[current + op] && this.slideshow && this.slideshow.repeat) {
		if (op == 1) return as[0];
		else if (op == -1) return as[as.length-1];
	}
	/*< ? endif ?>s*/
	return as[current + op] || null;
},

getAnchorIndex : function() {
	var arr = hs1.anchors.groups[this.slideshowGroup || 'none'];
	for (var i = 0; i < arr.length; i++) {
		if (arr[i] == this.a) return i; 
	}
	return null;
},


cancelLoading : function() {	
	hs1.expanders[this.key] = null;
	if (this.loading) hs1.loading.style.left = '-9999px';
},

writeCredits : function () {
	this.credits = hs1.createElement('a', {
		href: hs1.creditsHref,
		className: 'highslide-credits',
		innerHTML: hs1.lang.creditsText,
		title: hs1.lang.creditsTitle
	});
	this.createOverlay({ 
		overlayId: this.credits, 
		position: 'top left' 
	});
},

getInline : function(types, addOverlay) {
	for (var i = 0; i < types.length; i++) {
		var type = types[i], s = null;
		if (!this[type +'Id'] && this.thumbsUserSetId)  
			this[type +'Id'] = type +'-for-'+ this.thumbsUserSetId;
		if (this[type +'Id']) this[type] = hs1.getNode(this[type +'Id']);
		if (!this[type] && !this[type +'Text'] && this[type +'Eval']) try {
			s = eval(this[type +'Eval']);
		} catch (e) {}
		if (!this[type] && this[type +'Text']) {
			s = this[type +'Text'];
		}
		if (!this[type] && !s) {
			var next = this.a.nextSibling;
			while (next && !hs1.isHsAnchor(next)) {
				if ((new RegExp('highslide-'+ type)).test(next.className || null)) {
					this[type] = next.cloneNode(1);
					break;
				}
				next = next.nextSibling;
			}
		}
		
		if (!this[type] && s) this[type] = hs1.createElement('div', 
				{ className: 'highslide-'+ type, innerHTML: s } );
		
		if (addOverlay && this[type]) {
			var o = { position: (type == 'heading') ? 'above' : 'below' };
			for (var x in this[type+'Overlay']) o[x] = this[type+'Overlay'][x];
			o.overlayId = this[type];
			this.createOverlay(o);
		}
	}
},


// on end move and resize
doShowHide : function(visibility) {
	if (hs1.hideSelects) this.showHideElements('SELECT', visibility);
	if (hs1.hideIframes) this.showHideElements('IFRAME', visibility);
	if (hs1.geckoMac) this.showHideElements('*', visibility);
},
showHideElements : function (tagName, visibility) {
	var els = document.getElementsByTagName(tagName);
	var prop = tagName == '*' ? 'overflow' : 'visibility';
	for (var i = 0; i < els.length; i++) {
		if (prop == 'visibility' || (document.defaultView.getComputedStyle(
				els[i], "").getPropertyValue('overflow') == 'auto'
				|| els[i].getAttribute('hidden-by') != null)) {
			var hiddenBy = els[i].getAttribute('hidden-by');
			if (visibility == 'visible' && hiddenBy) {
				hiddenBy = hiddenBy.replace('['+ this.key +']', '');
				els[i].setAttribute('hidden-by', hiddenBy);
				if (!hiddenBy) els[i].style[prop] = els[i].origProp;
			} else if (visibility == 'hidden') { // hide if behind
				var elPos = hs1.getPosition(els[i]);
				elPos.w = els[i].offsetWidth;
				elPos.h = els[i].offsetHeight;
			
				
					var clearsX = (elPos.x + elPos.w < this.x.get('opos') 
						|| elPos.x > this.x.get('opos') + this.x.get('osize'));
					var clearsY = (elPos.y + elPos.h < this.y.get('opos') 
						|| elPos.y > this.y.get('opos') + this.y.get('osize'));
				var wrapperKey = hs1.getWrapperKey(els[i]);
				if (!clearsX && !clearsY && wrapperKey != this.key) { // element falls behind image
					if (!hiddenBy) {
						els[i].setAttribute('hidden-by', '['+ this.key +']');
						els[i].origProp = els[i].style[prop];
						els[i].style[prop] = 'hidden';
					} else if (!hiddenBy.match('['+ this.key +']')) {
						els[i].setAttribute('hidden-by', hiddenBy + '['+ this.key +']');
					}
				} else if ((hiddenBy == '['+ this.key +']' || hs1.focusKey == wrapperKey)
						&& wrapperKey != this.key) { // on move
					els[i].setAttribute('hidden-by', '');
					els[i].style[prop] = els[i].origProp || '';
				} else if (hiddenBy && hiddenBy.match('['+ this.key +']')) {
					els[i].setAttribute('hidden-by', hiddenBy.replace('['+ this.key +']', ''));
				}
						
			}
		}
	}
},

focus : function() {
	this.wrapper.style.zIndex = hs1.zIndexCounter++;
	// blur others
	for (var i = 0; i < hs1.expanders.length; i++) {
		if (hs1.expanders[i] && i == hs1.focusKey) {
			var blurExp = hs1.expanders[i];
			blurExp.content.className += ' highslide-'+ blurExp.contentType +'-blur';
			if (blurExp.isImage) {
				blurExp.content.style.cursor = hs1.ie ? 'hand' : 'pointer';
				blurExp.content.title = hs1.lang.focusTitle;	
			}
		}
	}
	
	// focus this
	if (this.outline) this.outline.table.style.zIndex 
		= this.wrapper.style.zIndex;
	this.content.className = 'highslide-'+ this.contentType;
	if (this.isImage) {
		this.content.title = hs1.lang.restoreTitle;
		
		if (hs1.restoreCursor) {
			hs1.styleRestoreCursor = window.opera ? 'pointer' : 'url('+ hs1.graphicsDir + hs1.restoreCursor +'), pointer';
			if (hs1.ie && hs1.ieVersion() < 6) hs1.styleRestoreCursor = 'hand';
			this.content.style.cursor = hs1.styleRestoreCursor;
		}
	}
	hs1.focusKey = this.key;	
	hs1.addEventListener(document, window.opera ? 'keypress' : 'keydown', hs1.keyHandler);	
},

moveTo: function(x, y) {
	this.x.setPos(x);
	this.y.setPos(y);
},
resize : function (e) {
	var w, h, r = e.width / e.height;
	w = Math.max(e.width + e.dX, Math.min(this.minWidth, this.x.full));
	if (this.isImage && Math.abs(w - this.x.full) < 12) w = this.x.full;
	h = this.isHtml ? e.height + e.dY : w / r;
	if (h < Math.min(this.minHeight, this.y.full)) {
		h = Math.min(this.minHeight, this.y.full);
		if (this.isImage) w = h * r;
	}
	this.resizeTo(w, h);
},
resizeTo: function(w, h) {
	this.y.setSize(h);
	this.x.setSize(w);
},

close : function() {
	if (this.isClosing || !this.isExpanded
		) return;
	this.isClosing = true;
	
	hs1.removeEventListener(document, window.opera ? 'keypress' : 'keydown', hs1.keyHandler);
	
	try {
		if (this.isHtml) this.htmlPrepareClose();
		this.content.style.cursor = 'default';
		this.changeSize(
			0, {
				xpos: this.x.pos,
				ypos: this.y.pos,
				xsize: this.x.size,
				ysize: this.y.size,
				xp1: this.x.p1,
				yp1: this.y.p1,
				xp2: this.x.p2,
				yp2: this.y.p2,
				ximgSize: this.x.imgSize,
				ximgPad: this.x.get('imgPad'),
				o: this.outline ? this.outline.offset : 0
			}, {
				xpos: this.x.tpos - this.x.cb + this.x.tb,
				ypos: this.y.tpos - this.y.cb + this.y.tb,
				xsize: this.x.t,
				ysize: this.y.t,
				xp1: 0,
				yp1: 0,
				xp2: 0,
				yp2: 0,
				ximgSize: this.x.imgSize ? this.x.t : null,
				ximgPad: 0,
				o: hs1.outlineStartOffset
			},
			hs1.restoreDuration
		);
		
	} catch (e) { this.afterClose(); } 
},

htmlPrepareClose : function() {
	if (hs1.geckoMac) { // bad redraws
		if (!hs1.mask) hs1.mask = hs1.createElement('div', null, 
			{ position: 'absolute' }, hs1.container);
		hs1.setStyles(hs1.mask, { width: this.x.size +'px', height: this.y.size +'px', 
			left: this.x.pos +'px', top: this.y.pos +'px', display: 'block' });			
	}
	if (this.objectType == 'swf') try { hs1.$(this.body.id).StopPlay(); } catch (e) {}
	
	if (this.objectLoadTime == 'after' && !this.preserveContent) this.destroyObject();		
	if (this.scrollerDiv && this.scrollerDiv != this.scrollingContent) 
		this.scrollerDiv.style.overflow = 'hidden';
},

destroyObject : function () {
	if (hs1.ie && this.iframe)
		try { this.iframe.contentWindow.document.body.innerHTML = ''; } catch (e) {}
	if (this.objectType == 'swf') swfobject.removeSWF(this.body.id);
	this.body.innerHTML = '';
},

sleep : function() {
	if (this.outline) this.outline.table.style.display = 'none';
	this.releaseMask = null;
	this.wrapper.style.display = 'none';
	hs1.push(hs1.sleeping, this);
},

awake : function() {
	hs1.expanders[this.key] = this;
	
	if (!hs1.allowMultipleInstances &&hs1.focusKey != this.key) {	
		try { hs1.expanders[hs1.focusKey].close(); } catch (e){}
	}
	
	var z = hs1.zIndexCounter++, stl = { display: '', zIndex: z };
	hs1.setStyles (this.wrapper, stl);
	this.isClosing = false;
	
	var o = this.outline || 0;
	if (o) {
		if (!this.outlineWhileAnimating) stl.visibility = 'hidden';
		hs1.setStyles (o.table, stl);		
	}
	this.show();
},

createOverlay : function (o) {
	var el = o.overlayId;
	if (typeof el == 'string') el = hs1.getNode(el);
	if (!el || typeof el == 'string') return;
	el.style.display = 'block';
	this.genOverlayBox();
	var width = o.width && /^[0-9]+(px|%)$/.test(o.width) ? o.width : 'auto';
	if (/^(left|right)panel$/.test(o.position) && !/^[0-9]+px$/.test(o.width)) width = '200px';
	
	var overlay = hs1.createElement(
		'div', { 
			id: 'hsId'+ hs1.idCounter++, hsId: o.hsId
		}, {
			position: 'absolute',
			visibility: 'hidden',
			width: width,
			direction: hs1.lang.cssDirection || ''
		},
		this.overlayBox,
		true
	);
	
	overlay.appendChild(el);
	hs1.setAttribs(overlay, {
		hideOnMouseOut: o.hideOnMouseOut,
		opacity: o.opacity || 1,
		hsPos: o.position,
		fade: o.fade
	});
	
	if (this.gotOverlays) {
		this.positionOverlay(overlay);
		if (!overlay.hideOnMouseOut || this.mouseIsOver) hs1.fade(overlay, 0, overlay.opacity);
	}
	hs1.push(this.overlays, hs1.idCounter - 1);
},
positionOverlay : function(overlay) {
	var p = overlay.hsPos || 'middle center';
	if (/left$/.test(p)) overlay.style.left = 0; 
	if (/center$/.test(p))	hs1.setStyles (overlay, { 
		left: '50%',
		marginLeft: '-'+ Math.round(overlay.offsetWidth / 2) +'px'
	});	
	if (/right$/.test(p))	overlay.style.right = 0;
	
	if (/^leftpanel$/.test(p)) { 
		hs1.setStyles(overlay, {
			right: '100%',
			marginRight: this.x.cb +'px',
			top: - this.y.cb +'px',
			bottom: - this.y.cb +'px',
			overflow: 'auto'
		});		 
		this.x.p1 = overlay.offsetWidth;
	
	} else if (/^rightpanel$/.test(p)) {
		hs1.setStyles(overlay, {
			left: '100%',
			marginLeft: this.x.cb +'px',
			top: - this.y.cb +'px',
			bottom: - this.y.cb +'px',
			overflow: 'auto'
		});
		this.x.p2 = overlay.offsetWidth;
	}
	if (/^top/.test(p)) overlay.style.top = 0; 
	if (/^middle/.test(p))	hs1.setStyles (overlay, { 
		top: '50%', 
		marginTop: '-'+ Math.round(overlay.offsetHeight / 2) +'px'
	});	
	if (/^bottom/.test(p)) overlay.style.bottom = 0;
	if (/^above$/.test(p)) {
		hs1.setStyles(overlay, {
			left: (- this.x.p1 - this.x.cb) +'px',
			right: (- this.x.p2 - this.x.cb) +'px',
			bottom: '100%',
			marginBottom: this.y.cb +'px',
			width: 'auto'
		});
		this.y.p1 = overlay.offsetHeight;
	
	} else if (/^below$/.test(p)) {
		hs1.setStyles(overlay, {
			position: 'relative',
			left: (- this.x.p1 - this.x.cb) +'px',
			right: (- this.x.p2 - this.x.cb) +'px',
			top: '100%',
			marginTop: this.y.cb +'px',
			width: 'auto'
		});
		this.y.p2 = overlay.offsetHeight;
		overlay.style.position = 'absolute';
	}
},

getOverlays : function() {	
	this.getInline(['heading', 'caption'], true);
	if (this.heading && this.dragByHeading) this.heading.className += ' highslide-move';
	if (hs1.showCredits) this.writeCredits();
	for (var i = 0; i < hs1.overlays.length; i++) {
		var o = hs1.overlays[i], tId = o.thumbnailId, sg = o.slideshowGroup;
		if ((!tId && !sg) || (tId && tId == this.thumbsUserSetId)
				|| (sg && sg === this.slideshowGroup)) {
			if (this.isImage || (this.isHtml && o.useOnHtml))
			this.createOverlay(o);
		}
	}
	var os = [];
	for (var i = 0; i < this.overlays.length; i++) {
		var o = hs1.$('hsId'+ this.overlays[i]);
		if (/panel$/.test(o.hsPos)) this.positionOverlay(o);
		else hs1.push(os, o);
	}
	/*
	var curW = this.x.p1 + this.x.full + this.x.p2;
	if (hs1.padToMinWidth && curW < hs1.minWidth) {
		this.x.p1 += (hs1.minWidth - curW) / 2;
		this.x.p2 += (hs1.minWidth - curW) / 2;
	}
	*/
	for (var i = 0; i < os.length; i++) this.positionOverlay(os[i]);
	this.gotOverlays = true;
},
genOverlayBox : function() {
	if (!this.overlayBox) this.overlayBox = hs1.createElement (
		'div', {
			className: this.wrapperClassName
		}, {
			position : 'absolute',
			width: this.x.size ? this.x.size +'px' : this.x.full +'px',
			height: 0,
			visibility : 'hidden',
			overflow : 'hidden',
			zIndex : hs1.ie ? 4 : null
		},
		hs1.container,
		true
	);
},
sizeOverlayBox : function(doWrapper, doPanels) {
	hs1.setStyles( this.overlayBox, {
		width: this.x.size +'px', 
		height: this.y.size +'px'
	});
	if (doWrapper || doPanels) {
		for (var i = 0; i < this.overlays.length; i++) {
			var o = hs1.$('hsId'+ this.overlays[i]);
			if (o && /^(above|below)$/.test(o.hsPos)) {
				if (hs1.ie && (hs1.ieVersion() <= 6 || document.compatMode == 'BackCompat')) {
					o.style.width = (this.overlayBox.offsetWidth + 2 * this.x.cb
						+ this.x.p1 + this.x.p2) +'px';
				}
				this.y[o.hsPos == 'above' ? 'p1' : 'p2'] = o.offsetHeight;
			}
		}
	}
	if (doWrapper) {
		hs1.setStyles(this.content, {
			top: this.y.p1 +'px'
		});
		hs1.setStyles(this.overlayBox, {
			top: (this.y.p1 + this.y.cb) +'px'
		});
	}
},

showOverlays : function() {
	var b = this.overlayBox;
	b.className = '';
	hs1.setStyles(b, {
		top: (this.y.p1 + this.y.cb) +'px',
		left: (this.x.p1 + this.x.cb) +'px',
		overflow : 'visible'
	});
	if (hs1.safari) b.style.visibility = 'visible';
	this.wrapper.appendChild (b);
	for (var i = 0; i < this.overlays.length; i++) {
		var o = hs1.$('hsId'+ this.overlays[i]);
		o.style.zIndex = 4;
		if (!o.hideOnMouseOut || this.mouseIsOver) hs1.fade(o, 0, o.opacity);
	}
},



createFullExpand : function () {
	this.fullExpandLabel = hs1.createElement(
		'a', {
			href: 'javascript:hs1.expanders['+ this.key +'].doFullExpand();',
			title: hs1.lang.fullExpandTitle,
			className: 'highslide-full-expand'
		}
	);
	
	this.createOverlay({ 
		overlayId: this.fullExpandLabel, 
		position: hs1.fullExpandPosition, 
		hideOnMouseOut: true, 
		opacity: hs1.fullExpandOpacity
	});
},

doFullExpand : function () {
	try {
		if (this.fullExpandLabel) hs1.discardElement(this.fullExpandLabel);
		
		this.focus();
		
		var xpos = this.x.pos - (this.x.full - this.x.size) / 2;
		if (xpos < hs1.marginLeft) xpos = hs1.marginLeft;
		
		this.moveTo(xpos, this.y.pos);
		this.resizeTo(this.x.full, this.y.full);
		this.doShowHide('hidden');
	
	} catch (e) {
		window.location.href = this.content.src;
	}
},


afterClose : function () {
	this.a.className = this.a.className.replace('highslide-active-anchor', '');
	
	this.doShowHide('visible');	
	
	if (this.isHtml && this.preserveContent) this.sleep();
	else {
		if (this.outline && this.outlineWhileAnimating) this.outline.destroy();
	
		hs1.discardElement(this.wrapper);
	}
	if (hs1.mask) hs1.mask.style.display = 'none';
	hs1.expanders[this.key] = null;		
	hs1.reOrder();
}

};


// hs1.Ajax object prototype
hs1.Ajax = function (a, content, pre) {
	this.a = a;
	this.content = content;
	this.pre = pre;
};

hs1.Ajax.prototype = {
run : function () {
	if (!this.src) this.src = hs1.getSrc(this.a);
	if (this.src.match('#')) {
		var arr = this.src.split('#');
		this.src = arr[0];
		this.id = arr[1];
	}
	if (hs1.cachedGets[this.src]) {
		this.cachedGet = hs1.cachedGets[this.src];
		if (this.id) this.getElementContent();
		else this.loadHTML();
		return;
	}
	try { this.xmlHttp = new XMLHttpRequest(); }
	catch (e) {
		try { this.xmlHttp = new ActiveXObject("Msxml2.XMLHTTP"); }
		catch (e) {
			try { this.xmlHttp = new ActiveXObject("Microsoft.XMLHTTP"); }
			catch (e) { this.onError(); }
		}
	}
	var pThis = this; 
	this.xmlHttp.onreadystatechange = function() {
		if(pThis.xmlHttp.readyState == 4) {
			if (pThis.id) pThis.getElementContent();
			else pThis.loadHTML();
		}
	};
	this.xmlHttp.open("GET", this.src, true);
	this.xmlHttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	this.xmlHttp.send(null);
},

getElementContent : function() {
	hs1.init();
	var attribs = window.opera || hs1.ie6SSL ? { src: 'about:blank' } : null;
	
	this.iframe = hs1.createElement('iframe', attribs, 
		{ position: 'absolute', top: '-9999px' }, hs1.container);
		
	this.loadHTML();
},

loadHTML : function() {
	var s = this.cachedGet || this.xmlHttp.responseText;
	if (this.pre) hs1.cachedGets[this.src] = s;
	if (!hs1.ie || hs1.ieVersion() >= 5.5) {
		s = s.replace(/\s/g, ' ').replace(
			new RegExp('<link[^>]*>', 'gi'), '').replace(
			new RegExp('<script[^>]*>.*?</script>', 'gi'), '');

		if (this.iframe) {
			var doc = this.iframe.contentDocument;
			if (!doc && this.iframe.contentWindow) doc = this.iframe.contentWindow.document;
			if (!doc) { // Opera
				var pThis = this;
				setTimeout(function() {	pThis.loadHTML(); }, 25);
				return;
			}
			doc.open();
			doc.write(s);
			doc.close();
			try { s = doc.getElementById(this.id).innerHTML; } catch (e) {
				try { s = this.iframe.document.getElementById(this.id).innerHTML; } catch (e) {} // opera
			}
		} else {
			s = s.replace(new RegExp('^.*?<body[^>]*>(.*?)</body>.*?$', 'i'), '$1');
		}
	}
	hs1.getElementByClass(this.content, 'DIV', 'highslide-body').innerHTML = s;
	this.onLoad();
	for (var x in this) this[x] = null;
}
};
if (document.readyState && hs1.ie) {
	(function () {
		try {
			document.documentElement.doScroll('left');
		} catch (e) {
			setTimeout(arguments.callee, 50);
			return;			
		}
		hs1.domReady();		
	})();
}
hs1.langDefaults = hs1.lang;
// history
var HsExpander = hs1.Expander;

// set handlers
hs1.addEventListener(window, 'load', function() {
	var sel = '.highslide img', 
		dec = 'cursor: url('+ hs1.graphicsDir + hs1.expandCursor +'), pointer !important;';
		
	var style = hs1.createElement('style', { type: 'text/css' }, null, 
		document.getElementsByTagName('HEAD')[0]);

	if (!hs1.ie) {
		style.appendChild(document.createTextNode(sel + " {" + dec + "}"));
	} else {
		var last = document.styleSheets[document.styleSheets.length - 1];
		if (typeof(last.addRule) == "object") last.addRule(sel, dec);
	}
});
hs1.addEventListener(document, 'mousemove', function(e) {
	hs1.mouse = { x: e.clientX, y: e.clientY	};
});
hs1.addEventListener(document, 'mousedown', hs1.mouseClickHandler);
hs1.addEventListener(document, 'mouseup', hs1.mouseClickHandler);
hs1.addEventListener(window, 'load', hs1.preloadImages);
hs1.addEventListener(window, 'load', hs1.preloadAjax);