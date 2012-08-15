
/*	글자확대축소 */	
var currentFontSize = 1;

function zoomUtil(state, e){
	var idx;
	var arrFontSize = new Array();
	
	/*arrFontSize[0] = "xx-small";
	arrFontSize[1] = "x-small";
	arrFontSize[2] = "small";
	arrFontSize[3] = "medium";
	arrFontSize[4] = "large";
	arrFontSize[5] = "x-large";
	arrFontSize[6] = "xx-large";
	*/

	arrFontSize[0] = "65%";
	arrFontSize[1] = "75%";
	arrFontSize[2] = "85%";
	arrFontSize[3] = "100%";
	arrFontSize[4] = "110%";
	arrFontSize[5] = "120%";
	arrFontSize[6] = "130%";
	
	if (isAccess(e)) {
		if (state == "plus") {		
						
			if (currentFontSize < 6 ) {
				idx = currentFontSize + 1;
				currentFontSize = idx;
			}else{
				idx = 6;
				currentFontSize = idx;
			}			
		
		} else if (state == "default") {
			idx = 1;
			currentFontSize = idx;
		
		} else if (state == "minus") {			
			
			if ( currentFontSize >= 1) {
				idx = currentFontSize - 1;
				currentFontSize = idx;
			}else{
				idx = 0;
				currentFontSize = idx;
			}
			
		}		
	}
	
	document.body.style.fontSize = arrFontSize[idx];
	
	return false;	
}

/*----------------------------------------------------------------------------------------
* 	isAccess(e)
*	example : 
*	if (isAccess(event)) {
*	}
*	return : true | false
*	date : 2007.5.1

*	descript : 
	마우스클릭이나 키보드로 선택된 상태인지 판단

	탭키로 해당 영역에 포커스가 간후 다시 탭으로 넘어갈 경우 onkeypress 이벤트가 발생하여 원하는 이벤트 처리가 안된다.
	마우스나 엔터키가 눌러진 경우 keycode = 1)만 이벤트가 발생하게 처리한다.
	Netscape/Firefox/Opera 의 경우 e.which 1로 체크, Safari 의 경우 window.event 0 으로 체크
	IE의 경우 event.button 이나 keycode 13(엔터키)로 체크
----------------------------------------------------------------------------------------*/
function isAccess(e) {
	
	var keynum;
	var ismouseClick = 1;
	
	if (window.event) {		//IE & Safari
		keynum = e.keyCode;
		
		//Safari의 경우 마우스클릭은 keynum 0 이 넘어옴
		if (event.button == 0 || keynum == 0){
			ismouseClick = 0;
		}		
		
	} else if ( e.which ){		// Netscape/Firefox/Opera
		keynum = e.which;
		
		if (keynum == 1) {
			ismouseClick = 0;
		}		
		
	}
	
	//마우스 클릭이거나 엔터키를 누른경우 true값 반환
	if ( ismouseClick == 0 || keynum == 13 ) {
		return true;
	} else {
		return false;
	}
}