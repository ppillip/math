//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 롤오버및 오브젝트숨김
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}


function MM_showHideLayers() { //v3.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v='hide')?'hidden':v; }
    obj.visibility=v; }
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 대메뉴 보이고숨기기 스크립트
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function displaySub(id) {
	var imgName;
	var re;
	for(i=1 ; i<=6 ; i++) {
		document.getElementById("subnav_list"+i).style.display="none";
		imgName = document.getElementById("subMenuImg_"+i).src;
		re = /over\./g;
		document.getElementById("subMenuImg_"+i).src = imgName.replace(re,"out.");		
	}
	if(document.getElementById("subnav_list"+id)){
		document.getElementById("subnav_list"+id).style.display="block";
		imgName = document.getElementById("subMenuImg_"+id).src;
		re = /out\./g;
		document.getElementById("subMenuImg_"+id).src = imgName.replace(re,"over.");	
	}

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  팝업
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//스크롤 있을때---팝업!!
function open_Y_TN(theURL,winName,myWidth, myHeight, isCenter) { //v3.0
  if(window.screen)if(isCenter)if(isCenter=="true"){
    var myLeft = (screen.width-myWidth)/2;
    var myTop = (screen.height-myHeight)/2;

    style= "'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0, width=" + myWidth + ",height=" + myHeight + ",top=" + myTop +",left=" + myLeft + "'";

  }
  www=window.open(theURL,winName,style);
  www.focus();
}

//스크롤 없을때---팝업!!
function open_N_TN(theURL,winName,myWidth, myHeight, isCenter) { //v3.0
  if(window.screen)if(isCenter)if(isCenter=="true"){
    var myLeft = (screen.width-myWidth)/2;
    var myTop = (screen.height-myHeight)/2;

    style= "'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=0, width=" + myWidth + ",height=" + myHeight + ",top=" + myTop +",left=" + myLeft + "'";

  }
  www=window.open(theURL,winName,style);
  www.focus();
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  점프메뉴
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function newpages(sel)
{
var index = sel.selectedIndex;
if (index<1) return false;
var wi = window.open('','_blank','');
if (sel.options[index].value != '') {
wi.location.href = sel.options[index].value;
}
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  메시지 팝업창띄우기
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function MM_popupMsg(msg) { //v1.0
  alert(msg);
}


var initBody;
function beforePrint(){ 
initBody = document.body.innerHTML; 
document.body.innerHTML = idPrint.innerHTML;
} 
function afterPrint(){ 
document.body.innerHTML = initBody;
} 
function printArea() { 
window.print(); 
} 
window.onbeforeprint = beforePrint; 
window.onafterprint = afterPrint;
////////////////////////////////////레이어띄우기1///////////////////////////////
var on_off="off";
function show_sub(){
 if(on_off=="off"){
  sublayer.style.visibility="visible";
  on_off="on";
 }
 else{
  sublayer.style.visibility="hidden";
  on_off="off";
 }
}
function show_help(){
 window.open("");
}
////////////////////////////////////레이어띄우기2///////////////////////////////
var on_off="off";
function show_sub2(){
 if(on_off=="off"){
  sublayer2.style.visibility="visible";
  on_off="on";
 }
 else{
  sublayer2.style.visibility="hidden";
  on_off="off";
 }
}
function show_help(){
 window.open("");
}
//////////////////////////////테이블접었다펴기////////////////////////////////
var old_menu = '';
var old_cell = '';

function menuclick( submenu ,cellbar){

if( old_menu != submenu ) {
 if( old_menu !='' ) {
 old_menu.style.display = 'none';
 }
 submenu.style.display = 'block';
 old_menu = submenu;
 old_cell = cellbar;
 } 
else {
 submenu.style.display = 'none';
 old_menu = '';
 old_cell = '';
 }
}




//////////////////////////////png 파일 투명하게 보이기////////////////////////////////
function setPng24(obj) {
        obj.width=obj.height=1;
        obj.className=obj.className.replace(/\bpng24\b/i,'');

        obj.style.filter =

        "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+ obj.src +"',sizingMethod='image');"
        obj.src=''; 
        return '';
    }



