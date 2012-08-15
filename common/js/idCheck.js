
    var req;

    function check_id(userid) {
	
		if(userid == "") {
			alert("아이디를 입력해 주세요");
			document.form1.HDQT_ID.value = "";
			document.form1.HDQT_ID.focus();
			return;
		}
	
	  var pattern = /(^[a-z0-9]+$)/;
    if(!pattern.test(userid)){
      alert("영어(소문자), 숫자만 입력할 수 있습니다.");
      return;
    }



		
       req = newXMLHttpRequest(); 
		
		
		
        req.onreadystatechange = processReqChange;

       
		
        req.open("POST", "/math/lms/idCheck.php", true); 
        req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
        req.send("userid="+userid+"&userkind=10"); 
    
    } 

function newXMLHttpRequest() { 

  var xmlreq = false; 

  if (window.XMLHttpRequest) { 
    xmlreq = new XMLHttpRequest(); 
  } else if (window.ActiveXObject) { 
    try { 
      
      xmlreq = new ActiveXObject("Msxml2.XMLHTTP"); 
    } catch (e1) { 
   
      try { 
        
        xmlreq = new ActiveXObject("Microsoft.XMLHTTP"); 
      } catch (e2) { 
    
      } 
    } 
  } 
  return xmlreq; 
} 


function processReqChange() { 

   
    if (req.readyState == 4) { 
         
        if (req.status == 200) { 
            printData(); 
        } else { 
            alert("There was a problem retrieving the XML data:\n" + 
                req.statusText); 
        } 
    } 
} 

function printData() { 

	var getResult = req.responseText; 

	if(getResult == 0) {
		document.form1.idCheck.value = 1;
		alert("사용가능한 코드, 아아디입니다.");
	} else {
		document.form1.idCheck.value = "";
		alert("중복된 코드, 아이디입니다.");
	}
	
} 



