<?
/*-----------------------------------------------------------------------------------------
---------------------------------------정의된 함수-----------------------------------------
-------------------------------------------------------------------------------------------
isnull($data)	//NULL비교..
strSql($value)	//db injection 예방... 문자열 치환

fileR($path)	//파일 읽어옴(전체)
fileW($path, $contents)	//파일기록
fileUp(&$f, $dir_dest, $size_max)	//파일 업로드 : fileUp(&$_FILES["파일"], 저장될 폴더, 업로드 제한 사이즈)
fileDown($file)	//파일 다운로드 : fileDown(파일path)

dateAdd($interval, $number, $date)		//vbscript dateAdd 함수
dateDiff($interval, $date1, $date2)		//vbscript의 dateDiff와 같은 기능
unix_timestamp($date)	//unix timestamp로 변환 : 예> unix_timestamp('2007-01-01') == 1167577200
redirect($url)	//페이지 이동
nocache()	// 0웹페이지 캐쉬 남지않게 태그 출력
trace($type)	//서버측 모든 환경 변수값 출력 : debug("all"|"server"|"env"|"cookie"|"get"|"post"|"files"|"request"|"globals");

back($msg = "")	 //자바스크립트 history.back()
close($msg = "") //자바스크립트 close
openerrefresh($msg = "") //부모창 새로고침(팝업창에서)
parentrefresh($msg = "") // 부모창 새로고침(iframe 등)
alert($msg = "")	 //자바스크립트 alert
location($url, $msg = "") //자바스크립트 location
writehistory(히스토리 이름, 대상자 아이디, 대상자 이름, 변경자 아이디, 변경자 이름, 대상자 이전 회원종류, 대상자 이전 학원, 대상자 이전 반, 대상자 이전 선생님 이름, 대상자 이후 회원종류, 대상자 이후 학원, 대상자 이후 반, 변경자 회원종류)
writewaitmember($t_woru, $t_id, $t_name, $wm_preinstitut, $wm_preclass, $t_memberkind, $t_status, $t_institut, $t_class)
				종류이름, 아이디, 이름, 이전 학원, 이전 반, 회원 종류, 상태, 학원, 반, 선생님 아이디, 선생님이름)
				
cutting	//한글 자를 때 깨짐현상 방지
rmdir_rf //폴더 삭제				
------------------------------------------------------------------------------------------*/
/* NULL비교.. */

// require_once("/home/institute_ivy/include/php/commphp.php");
//
function cookiealldelete(){
	 // 모든 쿠키 삭제
	if(count($_COOKIE)){ 
		foreach($_COOKIE as $key => $value)
		{ 
		setcookie($key,NULL,0,'/'); 
		} 
	} 
	
}


/* db injection 예방... 문자열 치환 */
function strSql($value){
	return str_replace("'","''",$value);
}

/* 문자열에 한글이 포함되어 있는지 체크 : 한글포함(true), 미포함(false) */
function isKor($value){
	return preg_match("/[\xA1-\xFE][\xA1-\xFE]/", $value);
}

/* 파일 읽어옴(전체) */
function fileR($path){	
	$fo = fopen($path,"r");
		$value = fread($fo,8192);
	fclose($fo);	
	return $value;
}
/* 파일기록 */
function fileW($path, $contents){
     $fo = fopen($path,"w");
     	fwrite($fo,$contents);
     fclose($fo);
}

/* 파일 업로드 : fileUp(&$_FILES["파일"], 저장될 폴더, 업로드 제한 사이즈) */
function fileUp(&$f, $dir_dest, $size_max){
	$file = $f["name"];
	
	if($file != ""){
		/* sql 특수문자 치환 */
		$file = strSql($file);
		$file_name = substr($file,0,strrpos($file,"."));
		$file_type = substr($file,strrpos($file,".")+1);

		$check_type = "cgi, jsp, js, php, asp, htm, html, php1, php2, php3, php4, php5, php6";
		if(strpos($check_type,$file_type)){
			back("서버측 스크립트언어 파일은 업로드 하실 수 없습니다.");
			exit();
		}
		if(	$f["size"] > $size_max){
			back("업로드 제한 용량을 초과하였습니다.");
			exit();
		}
		
		//파일명이 한글이면 영문 파일명으로 변경
		if(isKor($file_name)){
			$file_name = (string)time();
		}
		
		$num = 0;
		$file_temp = $file_name.".".$file_type;
		
		while(file_exists($dir_dest."/".$file_temp)){
			$file_temp = $file_name.$num.".".$file_type;
			$num++;
		}

		$file = $file_temp;
	
		move_uploaded_file($f["tmp_name"], $dir_dest."/".$file);
		$file = $file_temp.",".$file_type.",".$dir_dest.",".$f["size"];
				
	}

	return $file;
}



/* 파일 다운로드 : fileDown(파일path) */
function fileDown($file){

	if(!file_exists($file)){
		return false;
	}
	
	$name = substr($file,strrpos($file,"/")+1);

   if(eregi("(MSIE 5.0|MSIE 5.1|MSIE 5.5|MSIE 6.0)", $_SERVER["HTTP_USER_AGENT"]) && !eregi("(Opera|Netscape)", $_SERVER["HTTP_USER_AGENT"])) {
      Header("Content-type: application/octet-stream");
      Header("Content-Length: ".(string)(filesize($file)) );
      Header("Content-Disposition: attachment; filename=".$name);
      Header("Cache-Control: cache, must-revalidate");
      Header("Content-Transfer-Encoding: binary");
      Header("Pragma: no-cache");
      Header("Expires: 0");
   } else {
      Header("Content-type: file/unknown");
      Header("Content-Length: ".(string)(filesize($file)));
      Header("Content-Disposition: attachment; filename=".$name);
      Header("Content-Description: PHP5 Generated Data");
      Header("Content-Transfer-Encoding: binary");
      Header("Pragma: no-cache");
      Header("Expires: 0");
   }

	$fo = fopen($file, "rb");	//rb 읽기전용 바이너리

	if (!fpassthru($fo))
	fclose ($fo);
	flush(); //출력 버퍼비우기 함수.. 

	return true;

}

/* vbscript dateAdd 함수 */

function dateAdd($interval, $number, $date){

	$timeArr = getdate($date);
	$hs = $timeArr["hours"];
	$ns = $timeArr["minutes"];
	$ss = $timeArr["seconds"];
	$m = $timeArr["mon"];
	$d = $timeArr["mday"];
	$y = $timeArr["year"];
	
	switch($interval){
		case "yyyy" :
			$y += $number;
			break;
		case "q" :
			$y += ( $number * 3 );
			break;
		case "m" :
			$m += $number;
			break;
		case "y" :
		case "d" :
		case "w" :
			$d += $number;
			break;
		case "ww" :
			$d += ( $number * 7 );
			break;
		case "h" :
			$hs += $number;
			break;
		case "n" :
			$ms+=$number;
			break;
		case "s" :
			$ss+=$number;
			break;
	}
	
	//return unix timestamp
	return mktime($hs ,$ms, $ss, $m, $d, $y);
	
}
/* vbscript의 dateDiff와 같은 기능 */
function dateDiff($interval, $date1, $date2){
		
	$timediff = $date1 - $date2;
		
	switch($interval){
		case "w":
			$ret = bcdiv($timediff,604800);
			break;
		case "d":
			$ret = bcdiv($timediff,86400);
			break;
		case "h":
			$ret = bcdiv($timediff,3600);
			break;
		case "n":
			$ret = bcdiv($timediff,60);
			break;
		case "s":
			$ret = $timediff;
			break;
	}
	
	return $ret;
	
}
/* unix timestamp로 변환 : 예> unix_timestamp('2007-01-01') == 1167577200 */
function unix_timestamp($date){
	
	if(strstr($date,"-")){
		$dateArr = explode("-" ,$date);
	} else {
		$dateArr = explode("-" ,$date);
	}
		
	return mktime(0, 0, 0, $dateArr[2], $dateArr[1], $dateArr[0]);
	
}

/* 페이지 이동 */
function redirect($url){
	Header("Location:".$url);
	exit(0);
}

/* 웹페이지 캐쉬 남지않게 태그 출력 */
function nocache(){
	header("Cache-Control:no-cache"); 
	header("Expires:0" ); 
	header("Pragma:no-cache"); 
}

/*---------------------------------클라이언트 스크립트 관련------------------------------------*/
function back($msg = ""){

	print("<script language='javascript'>\n");
	
	if($msg != "")
		print("alert(\"".$msg."\");\n");
		
	print("history.back();\n");
    print("</script>\n");
	
}
function close($msg = ""){	
	print("<script language='javascript'>\n");
	
	if($msg != "")
		print("alert(\"".$msg."\");\n");
		
	print("self.close();\n");
    print("</script>\n");
}

function openerrefresh($msg = "") {
	print("<script language='javascript'>\n");
	
	if($msg != "")
		print("alert(\"".$msg."\");\n");
		
	print("window.opener.document.location.href = window.opener.document.URL;\n");
	print("</script>\n");
	
}

function parentrefresh($msg = "") {
	print("<script language='javascript'>\n");
	
	if($msg != "")
		print("alert(\"".$msg."\");\n");
		
	print("parent.document.location.href = parent.document.URL;\n");
	print("</script>\n");
}	

function parentrefresh2($msg = "") {
	print("<script language='javascript'>\n");
	
	if($msg != "")
		print("alert(\"".$msg."\");\n");
		
	print("parent.document.location.reload();");
	print("</script>\n");
}	

function historyback($msg = "") {
	print("<script language='javascript'>\n");
	
	if($msg != "")
		print("alert(\"".$msg."\");\n");
		
	print("history.back();\n");
	print("</script>\n");
}	



function alert($msg = ""){	
	print("<script language='javascript'>\n");
	
	if($msg != "")
		print("alert(\"".$msg."\");\n");
		
    print("</script>\n");
}
function location($url, $msg = ""){
	
	print("<script language='javascript'>\n");
	
	if($msg != "")
		print("alert(\"".$msg."\");\n");
		
	print("location.href='".$url."';\n");
    print("</script>\n");
	
}
/*---------------------------------------------------------------------------------------------*/



/*---------------------------------디버깅 관련 스크립트 관련-----------------------------------*/
/* 서버측 모든 환경 변수값 출력 : trace("all"|"server"|"env"|"cookie"|"get"|"post"|"files"|"request"|"globals"); */
function trace($type = "all"){

	if($type=="server" || $type=="all"){
		print"<br><br>------------------------\$_SERVER or \$HTTP_SERVER_VARS-------------------------<br>";
		foreach($_SERVER as $key => $value){
			print"\$_SERVER[{$key}]={$value}\n<br>";
		}
	}
	
	if($type=="env" || $type=="all"){
		print"<br><br>------------------------\$_ENV or \$HTTP_ENV_VARS-------------------------<br>";
		foreach($_ENV as $key => $value){
			print"\$_ENV[{$key}]={$value}\n<br>";
		}
	}
	
	if($type=="cookie" || $type=="all"){
		print"<br><br>------------------------\$_COOKIE or \$HTTP_COOKIE_VARS-------------------------<br>";
		foreach($_COOKIE as $key => $value){
			print"\$_COOKIE[{$key}]={$value}\n<br>";
		}
	}
	
	if($type=="get" || $type=="all"){
		print"<br><br>------------------------\$_GET or \$HTTP_GET_VARS-------------------------<br>";
		foreach($_GET as $key => $value){
			print"\$_GET[{$key}]={$value}\n<br>";
		}
	}
	
	if($type=="post" || $type=="all"){
		print"<br><br>------------------------\$_POST or \$HTTP_POST_VARS-------------------------<br>";
		foreach($_POST as $key => $value){
			print"\$_POST[{$key}]={$value}\n<br>";
		}
	}
	
	if($type=="files" || $type=="all"){
		print"<br><br>------------------------\$_FILES or \$HTTP_FILES_VARS-------------------------<br>";
		foreach($_FILES as $key => $value){
			print"\$_FILES[{$key}]={$value}\n<br>";
		}
	}
	
	if($type=="request" || $type=="all"){
		print"<br><br>------------------------\$_REQUEST or \$HTTP_REQUEST_VARS-------------------------<br>";
		foreach($_REQUEST as $key => $value){
			print"\$_REQUEST[{$key}]={$value}\n<br>";
		}
	}
	
	if($type=="globals" || $type=="all"){
		print"<br><br>------------------------\$GLOBALS-------------------------<br>";
		foreach($GLOBALS as $key => $value){
			print"\$GLOBALS[{$key}]={$value}\n<br>";
		}
	}

	exit(0);
}

//한글 자를 때 깨짐현상 방지
function cutting($cut_word, $cut_length){ 
if(strlen($cut_word) > $cut_length){ 
$pre_str = substr($cut_word, 0, $cut_length); 
preg_match('/^([\x00-\x7e]|.{2})*/', $pre_str,$post_str); 
return $post_str[0].' ...'; 
} else{ 
return $cut_word; 

} 
} 


//폴더 삭제 
function rmdir_rf($dirname) {
    if ($dirHandle = opendir($dirname)) {
        chdir($dirname);
        while ($file = readdir($dirHandle)) {
            if ($file == '.' || $file == '..') continue;
            if (is_dir($file)) rmdir_rf($file);
            else unlink($file);
        }
        chdir('..');
        rmdir($dirname);
        closedir($dirHandle);
    }
}



function get_hdqt_list($get_hdqt_id = '') {
	$_hdqt_list = new MastJson();

	$_hdqt_list_sql = "SELECT
				HDQT_ID
			,	HDQT_NM
			FROM LMS_HDQT
			ORDER BY HDQT_NM
	";	
			
	//echo $_hdqt_list_sql;
	$_hdqt_list_result = $_hdqt_list->sql_query($_hdqt_list_sql); 


	$show_list_html = "<select name='HDQT_ID'>";
	

     // $i=1;
      while($_hdqt_list_row = $_hdqt_list->sql_fetch_array($_hdqt_list_result) )
      {
		
		if($get_hdqt_id == $_hdqt_list_row[HDQT_ID]) {
			$add_string = "selected";	
		} else {
			$add_string = "";
		}
		
		$show_list_html .= "<option value='$_hdqt_list_row[HDQT_ID]'". $add_string.">";
		$show_list_html .= "$_hdqt_list_row[HDQT_NM]";
		$show_list_html .= "</option>";



	  }


	  $show_list_html .= "</select>";

	  echo $show_list_html;

$_hdqt_list = null;




}




function get_hdqt_list2($get_hdqt_id = '') {
	$_hdqt_list = new MastJson();

	$_hdqt_list_sql = "SELECT
				HDQT_ID
			,	HDQT_NM
			FROM LMS_HDQT
			ORDER BY HDQT_NM
	";	
			
	//echo $_hdqt_list_sql;
	$_hdqt_list_result = $_hdqt_list->sql_query($_hdqt_list_sql); 


	$show_list_html = "<select name='HDQT_ID' onChange='javascript:send_hdqt_id(this.value);'>";
	$show_list_html .= "<option value=''>- 본부</option>";

     // $i=1;
      while($_hdqt_list_row = $_hdqt_list->sql_fetch_array($_hdqt_list_result) )
      {
		
		if($get_hdqt_id == $_hdqt_list_row[HDQT_ID]) {
			$add_string = "selected";	
		} else {
			$add_string = "";
		}
		
		$show_list_html .= "<option value='$_hdqt_list_row[HDQT_ID]'". $add_string.">";
		$show_list_html .= "$_hdqt_list_row[HDQT_NM]";
		$show_list_html .= "</option>";



	  }


	  $show_list_html .= "</select>";

	  echo $show_list_html;

$_hdqt_list = null;




}



function get_brch_list($get_brch_id = '', $get_hdqt_id = '') {
	$_brch_list = new MastJson();

	$_brch_list_sql = "SELECT
				BRCH_ID
			,	BRCH_NM
			FROM LMS_BRCH";
	
	
	if($get_hdqt_id != "") {
		$_brch_list_sql .= "
			WHERE BRCH_HDQT_ID = '$get_hdqt_id'
		";	
	}
	
	
	$_brch_list_sql .= "
			ORDER BY BRCH_NM
	";	
	
	
	
			
	//echo $_brch_list_sql;
	$_brch_list_result = $_brch_list->sql_query($_brch_list_sql); 


	$show_list_html = "<select name='BRCH_ID'>";
	

     // $i=1;
      while($_brch_list_row = $_brch_list->sql_fetch_array($_brch_list_result) )
      {
		
		if($get_brch_id == $_brch_list_row[BRCH_ID]) {
			$add_string = "selected";	
		} else {
			$add_string = "";
		}
		
		$show_list_html .= "<option value='$_brch_list_row[BRCH_ID]'". $add_string.">";
		$show_list_html .= "$_brch_list_row[BRCH_NM]";
		$show_list_html .= "</option>";



	  }


	  $show_list_html .= "</select>";

	  echo $show_list_html;

$_brch_list = null;




}


function get_brch_list2($get_brch_id = '', $get_hdqt_id = '') {
	$_brch_list = new MastJson();

	$_brch_list_sql = "SELECT
				BRCH_ID
			,	BRCH_NM
			FROM LMS_BRCH";
			
	if($get_hdqt_id != "") {
		$_brch_list_sql .= "
			WHERE BRCH_HDQT_ID = '$get_hdqt_id'
		";	
	}		
			
	$_brch_list_sql .= "		
			ORDER BY BRCH_NM
	";	
			
	//echo $_brch_list_sql;
	$_brch_list_result = $_brch_list->sql_query($_brch_list_sql); 


	$show_list_html = "<select name='BRCH_ID' onChange='javascript:send_brch_id(this.value)'>";
	$show_list_html .= "<option value=''> - 지사</option>";

     // $i=1;
      while($_brch_list_row = $_brch_list->sql_fetch_array($_brch_list_result) )
      {
		
		if($get_brch_id == $_brch_list_row[BRCH_ID]) {
			$add_string = "selected";	
		} else {
			$add_string = "";
		}
		
		$show_list_html .= "<option value='$_brch_list_row[BRCH_ID]'". $add_string.">";
		$show_list_html .= "$_brch_list_row[BRCH_NM]";
		$show_list_html .= "</option>";



	  }


	  $show_list_html .= "</select>";

	  echo $show_list_html;

$_brch_list = null;




}








?>