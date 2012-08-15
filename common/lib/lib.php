<?
//-------------------------------------------
// SESSION 설정
//-------------------------------------------
//ini_set("session.use_trans_sid", 0);    // PHPSESSID를 자동으로 넘기지 않음
//ini_set("url_rewriter.tags",""); // 링크에 PHPSESSID가 따라다니는것을 무력화함 (해뜰녘님께서 알려주셨습니다.)
//
//session_save_path("{$g4['path']}/data/session");
//
//if (isset($SESSION_CACHE_LIMITER)) 
//    @session_cache_limiter($SESSION_CACHE_LIMITER);
//else 
//    @session_cache_limiter("no-cache, must-revalidate");

//==============================================================================
// 공용 변수
//==============================================================================
// 기본환경설정
// 기본적으로 사용하는 필드만 얻은 후 상황에 따라 필드를 추가로 얻음
//$config = sql_fetch(" select * from $g4[config_table] ");
//
//ini_set("session.cache_expire", 180); // 세션 캐쉬 보관시간 (분)
//ini_set("session.gc_maxlifetime", 10800); // session data의 gabage collection 존재 기간을 지정 (초)
//
//session_set_cookie_params(0, "/");
//ini_set("session.cookie_domain", $g4['cookie_domain']); 

@session_start();

@extract($_GET);
@extract($_POST);
@extract($_SERVER); 


function consoleLog($msg)
{
  return; 
	$access = date("Y.m.d");
	$file_pointer = fopen($_SERVER['DOCUMENT_ROOT']."/logs/debug".$access.".log", "a"); 
	$text = chr(10).date("Y/m/d H:i:s").":::::::::>"."\n"; 
	foreach (debug_backtrace() as $k => $v) {$text = $text.$v['file'].":line(".$v['line'].")\n";}
	$text = $text.$msg;
	fwrite($file_pointer, $text); 
	fclose($file_pointer); 
}


/*
	set_error_handler("PHPErrorHandler"); 사용시에 적어 놓는것
*/
function PHPErrorHandler($errno, $errstr)
{ 
 	$access = date("Y.m.d");
	$file_pointer = fopen($_SERVER['DOCUMENT_ROOT']."/logs/debug".$access.".log", "a"); 
	$text = "\n\n################################################################################################";
	$text = $text."\n# !!!!!!!!!!!!!!PHP ERROR !!!!!!!!!!!! ".date("Y/m/d H:i:s"); 
	foreach (debug_backtrace() as $k => $v) {
		$text = $text."\n# ".$v['file'].":line(".$v['line'].")";
	}
	$text = $text."\n# [$errno] : $errstr";
	$text = $text."\n################################################################################################\n\n" ; 
	$text = str_replace("# :line()\n","",$text);  //--> 에러나면 :line()  이거 한줄이 들어가서 짜증 지대로 난다.
	fwrite($file_pointer, $text); 
	fclose($file_pointer); 
}



/*************************************************************************
**
**  일반 함수 모음
**
*************************************************************************/

// 마이크로 타임을 얻어 계산 형식으로 만듦
function get_microtime()
{
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
}


// 현재페이지, 총페이지수, 한페이지에 보여줄 행, URL
function get_paging($write_pages, $cur_page, $total_page, $url, $add="")
{
    $str = "";
    if ($cur_page > 1) {
        $str .= "<a href='" . $url . "1{$add}'>처음</a>";
    }

    $start_page = ( ( (int)( ($cur_page - 1 ) / $write_pages ) ) * $write_pages ) + 1;
    $end_page = $start_page + $write_pages - 1;

    if ($end_page >= $total_page) $end_page = $total_page;

    if ($start_page > 1) $str .= " &nbsp;<a href='" . $url . ($start_page-1) . "{$add}'>이전</a>";

    if ($total_page > 1) {
        for ($k=$start_page;$k<=$end_page;$k++) {
            if ($cur_page != $k)
                $str .= " &nbsp;<a href='$url$k{$add}'><span>$k</span></a>";
            else
                $str .= " &nbsp;<b>$k</b> ";
        }
    }

    if ($total_page > $end_page) $str .= " &nbsp;<a href='" . $url . ($end_page+1) . "{$add}'>다음</a>";

    if ($cur_page < $total_page) {
        //$str .= "[<a href='$url" . ($cur_page+1) . "'>다음</a>]";
        $str .= " &nbsp;<a href='$url$total_page{$add}'>맨끝</a>";
    }
    $str .= "";

    return $str;
}


// 변수 또는 배열의 이름과 값을 얻어냄. print_r() 함수의 변형
function print_r2($var)
{
    ob_start();
    print_r($var);
    $str = ob_get_contents();
    ob_end_clean();
    $str = preg_replace("/ /", "&nbsp;", $str);
    echo nl2br("<span style='font-family:Tahoma, 굴림; font-size:9pt;'>$str</span>");
}


// 메타태그를 이용한 URL 이동
// header("location:URL") 을 대체
function goto_url($url)
{
    /*
    if (preg_match("/MSIE/", $_SERVER[HTTP_USER_AGENT]))
        echo "<meta http-equiv='Refresh' content='0;url=$url'>";
    else
        echo "<script language='JavaScript'> document.location.href = '$url'; </script>";
    */
    //header("Location:$url");
    //flush();
    //if (!headers_sent())
    //    header("Location:$url");
    //else
    //echo "<script language='JavaScript'> document.location.href = '$url'; </script>";
    echo "<script language='JavaScript'> location.replace('$url'); </script>";
    exit;
}


// 세션변수 생성
function set_session($session_name, $value)
{
    session_register($session_name);
    // PHP 버전별 차이를 없애기 위한 방법
    $$session_name = $_SESSION["$session_name"] = $value;
}


// 세션변수값 얻음
function get_session($session_name)
{
    return $_SESSION[$session_name];
}

function sql2json($sql)
{
	$result = sql_query($sql,false);
	$row    = sql_fetch_array($result);
		return json_encode($row);		
}

function failEnd($msg)
{
	echo "{'msg':'".$msg."','err':true}";
	exit;
}

function succEnd($msg)
{
	echo "{'msg':'".$msg."','err':false}";
	exit;
}
function cmdEnd($sql)
{
	
	$result = sql_query($sql,false);
	consoleLog("===============================>".$result);
	if($result!=1){
		failEnd("오류가 발생했습니다.데이터를 확인하세요"); 
	}else{
		succEnd("성공적으로 되었습니다");
	}
}
	


function getData($sql)
{
	$result = sql_query($sql,true);
	$rStr = "{\"rows\":[";
	for ($i=0; $row=sql_fetch_array($result); $i++) 
	{
		if($i!=0) $rStr=$rStr.",";
		$rStr = $rStr.json_encode($row);
	}
	$rStr = $rStr."]}";				

	return $rStr;
}

function dataEnd($sql)
{
	echo getData($sql);
	exit;
}
	




?>