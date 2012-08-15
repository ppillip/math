<?
class MastFunc extends Mast
{

		function initHeader(){


		}
    
	   

	
	/* db injection 예방... 문자열 치환 */
	function strSql($value){
		return str_replace("'","''",$value);
	}
	
	/* 문자열에 한글이 포함되어 있는지 체크 : 한글포함(true), 미포함(false) */
	function isKor($value){
		return preg_match("/[\xA1-\xFE][\xA1-\xFE]/", $value);
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
	
	function openerSelectBox() {
		print("<script language='javascript'>\n");
		
		print("opener.loadSchool();\n");
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
		
	
		  $i=0;
		  while($_hdqt_list_row = $_hdqt_list->sql_fetch_array($_hdqt_list_result) )
		  {
			  
			  if($i == 0) {
					global $init_hdqt_id;
					$init_hdqt_id = $_hdqt_list_row[HDQT_ID];  
			  }
			  
			
			if($get_hdqt_id == $_hdqt_list_row[HDQT_ID]) {
				$add_string = "selected";	
			} else {
				$add_string = "";
			}
			
			$show_list_html .= "<option value='$_hdqt_list_row[HDQT_ID]'". $add_string.">";
			$show_list_html .= "$_hdqt_list_row[HDQT_NM]";
			$show_list_html .= "</option>";
	
			$i++;
	
		  }
	
	
		  $show_list_html .= "</select>";
			
		  echo $show_list_html;
	      //return $init_hdqt_id;
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

	
	
	
	function get_teacher_list($get_inst_id = '', $get_user_id = '') {
		
		$_brch_list = new MastJson();
	
		$_brch_list_sql = "SELECT
					USER_ID
				,	USER_NM
				FROM MST_USER
				WHERE USER_COMP_ID = '$get_inst_id'
				AND   USER_ROLE_TYPE = 50
				AND   USER_ACCESS_YN = 'Y'
				";
	
				
		$_brch_list_sql .= "		
				ORDER BY USER_NM
		";	
				
		//echo $_brch_list_sql;
		$_brch_list_result = $_brch_list->sql_query($_brch_list_sql); 
	
	
		$show_list_html = "<select name='CLSS_TECH_ID' id='CLSS_TECH_ID' onChange='javascript:send_tech_id(this.value)'>";
		//$show_list_html .= "<option value=''> - 지사</option>";
	
		 // $i=1;
		  while($_brch_list_row = $_brch_list->sql_fetch_array($_brch_list_result) )
		  {
			
			if($get_user_id == $_brch_list_row[USER_ID]) {
				$add_string = "selected";	
			} else {
				$add_string = "";
			}
			
			$show_list_html .= "<option value='$_brch_list_row[USER_ID]'". $add_string.">";
			$show_list_html .= "$_brch_list_row[USER_NM]";
			$show_list_html .= "</option>";
	
	
	
		  }
	
	
		  $show_list_html .= "</select>";
	
		  echo $show_list_html;
	
	$_brch_list = null;	
		
		
		
	}
	
	
	
	
		function get_class_list($get_inst_id = '', $get_class_id = '') {
		
		$_class_list = new MastJson();
	
		$_class_list_sql = "SELECT
					CLSS_ID
				,	CLSS_NM
				FROM LMS_CLSS
				WHERE CLSS_INST_ID = '$get_inst_id'
				AND   CLSS_USE_YN = 'Y'
				";
	
				
		$_class_list_sql .= "		
				ORDER BY CLSS_NM
		";	
				
		
		$_class_list_result = $_class_list->sql_query($_class_list_sql); 
	
	
		$show_list_html = "<select name='CLSS_ID' id='CLSS_ID' onChange='javascript:sendData();'>";
		$show_list_html .= "<option value=''>-반</option>";
		  while($_class_list_row = $_class_list->sql_fetch_array($_class_list_result) )
		  {
			
			if($get_class_id == $_class_list_row[CLSS_ID]) {
				$add_string = "selected";	
			} else {
				$add_string = "";
			}
			
			$show_list_html .= "<option value='$_class_list_row[CLSS_ID]'". $add_string.">";
			$show_list_html .= "$_class_list_row[CLSS_NM]";
			$show_list_html .= "</option>";
	
	
	
		  }
	
	
		  $show_list_html .= "</select>";
	
		  echo $show_list_html;
	
	$_class_list = null;	
		
		
		
	}
	
	
	
	
	
	
	
	function IdCheck($get_id) {
	
	  $match = preg_match("/(^[a-z0-9]+$)/", $get_id);
	  
	  if($match == 0) {
	    MastFunc::back("아이디는 영어(소문자), 숫자만 입력할 수 있습니다.");
	    exit();
	  }
	  
	}
	
	
	
		
	
	function checkAuth($get_auth, $check_auth) {
		
		//echo $get_auth."-".$check_auth;
		
		if(MastUtil::get_session("S_USER_ID") == "") {
			MastFunc::location("/", "로그인 후 이용해 주세요");	
			exit();
		}
		
		
		if($get_auth > $check_auth) {
			MastFunc::back("접근권한이 없습니다.");
			exit();
		}
		
	}	
	
	
	function idStrCheck($get_param) {
    if(!ereg("^[a-z0-9]+$", $get_param)) { 
      MastFunc::back("아이디는 영어(소문자), 숫자만 입력할 수 있습니다."); 
      exit();
    }	  
	}
	
	function nmStrCheck($get_param) {
	  if(!ereg("^[a-zA-Z가-힣]+$", $get_param)) { 
      MastFunc::back("이름은 영어, 한글만 입력할 수 있습니다.");
      
      exit();
    }	
	}
	
	
	
	function g_login_check() {
		
		
/*	
		$_loginDB = new MastJson();
		
		
		if(MastUtil::get_session("S_USER_ID")) {
			
			$login_str = date("Y-m-d H:i:s", strtotime("-5 minutes"));
			$login_date = date("Y-m-d H:i:s");
			   
			   
			$g_login_del = "DELETE FROM MST_LOGNCK WHERE LGCK_DT < '$login_str'
			";
	
			$_loginDB->sql_query($g_login_del);
			
		}
		
		//echo MastUtil::get_session("S_USER_ID");
		//exit();
		
		$g_login_qry = "SELECT * FROM MST_LOGNCK WHERE LGCK_ID = '".MastUtil::get_session("S_USER_ID")."'		
		";
		
		$g_login_result = $_loginDB->sql_query($g_login_qry);
		$g_login_rows = mysql_num_rows($g_login_result);
		
		
		
		
		
		if($g_login_rows == 0) {
		
			$g_login_qry2 = "INSERT INTO MST_LOGNCK (LGCK_ID, LGCK_IP, LGCK_OK, LGCK_DT) VALUES (
												   '".MastUtil::get_session("S_USER_ID")."', '".$_SERVER['REMOTE_ADDR']."', 1, '$login_date')
			
			";
			
			$_loginDB->sql_query($g_login_qry2);
			
			
			
		}  else if($g_login_rows == 1) {
			
			
			$g_login_row = $_loginDB->sql_fetch($g_login_qry);
			

			if($g_login_row[LGCK_IP] == $_SERVER['REMOTE_ADDR']) {
				
				
				$g_login_qry3 = "UPDATE MST_LOGNCK
							SET		LGCK_DT = '$login_date'
							WHERE   LGCK_ID = '".MastUtil::get_session("S_USER_ID")."'				
				";
				
				$_loginDB->sql_query($g_login_qry3);
				
								
			} else {
				
				session_destroy();
				MastFunc::location("/", "다른 ip에 해당 아이디가 중복 로그인 되어있습니다.");
				
				
				
			}
				
		} else if($g_login_rows > 1) {
			
			
			$g_login_del = "DELETE FROM MST_LOGNCK WHERE LG_ID = '".MastUtil::get_session("S_USER_ID")."'
			";
	
			$_loginDB->sql_query($g_login_del);
			session_destroy();
			
			
			MastFunc::location("/","다시 로그인 해 주세요.");
		}
*/			
	}

	
}


?>