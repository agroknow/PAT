
function img(id,name){
     if (document.images){
       if (document.images[id]){document.images[id].src=eval(name+".src");
       } else {
         if (document.layers){ 
           for (i=0; i < document.layers.length; i++) {
             if (document.layers[i].document.images[id]) {
             document.layers[i].document.images[id].src=eval(name+".src");
             break;
             }
           }
         }
       }
     }
   }


function show(id) {
	document.getElementById(id).style.display = "block";
}

function hide(id) {
	document.getElementById(id).style.display = "none";
}

function hideAll() {
	hide('m01');
	hide('m02');
	hide('m03');
	hide('m04');
	hide('m05');
	hide('m06');
	hide('m07');
	hide('m08');	
}
	 
/*
var layerRef="", styleSwitch="";

function show(layerName){
if (navigator.appName == "Netscape") {
var layerRef="document.layers";
var styleSwitch="";
}else{
var layerRef="document.all";
var styleSwitch=".style";
}
eval(layerRef+'["'+layerName+'"]'+styleSwitch+'.visibility="visible"');
}

function hide(layerName){
if (navigator.appName == "Netscape") {
var layerRef="document.layers";
var styleSwitch="";
}else{
var layerRef="document.all";
var styleSwitch=".style";
}
eval(layerRef+'["'+layerName+'"]'+styleSwitch+'.visibility="hidden"');
}
*/

function preload(imgObj,imgSrc) {
	if(document.images) 
		eval(imgObj+' = new Image();');
		eval(imgObj+'.src = "'+imgSrc+'";');
}

function preloadAll() {
preload('do01_off','images/do_comment_off.png');
preload('do01_on','images/do_comment_on.png');
preload('do02_off','images/do_discuss_off.png');
preload('do02_on','images/do_discuss_on.png');
preload('do03_off','images/do_share_off.png');
preload('do03_on','images/do_share_on.png');
preload('do04_off','images/do_ask_off.png');
preload('do04_on','images/do_ask_on.png');
preload('do05_off','images/do_learn_off.png');
preload('do05_on','images/do_learn_on.png');
preload('do06_off','images/do_experiment_off.png');
preload('do06_on','images/do_experiment_on.png');

preload('lang01_off','images/lang_01_off.gif');
preload('lang01_on','images/lang_01_on.gif');
preload('lang02_off','images/lang_02_off.gif');
preload('lang02_on','images/lang_02_on.gif');
preload('lang03_off','images/lang_03_off.gif');
preload('lang03_on','images/lang_03_on.gif');
preload('lang04_off','images/lang_04_off.gif');
preload('lang04_on','images/lang_04_on.gif');
preload('lang05_off','images/lang_05_off.gif');
preload('lang05_on','images/lang_05_on.gif');

preload('icon01_off','images/icon_01_off.gif');
preload('icon01_on','images/icon_01_on.gif');
preload('icon02_off','images/icon_02_off.gif');
preload('icon02_on','images/icon_02_on.gif');
}

/*
window.onload = function(){
	preloadAll();
	hideAll();
	show('m04');
}
*/