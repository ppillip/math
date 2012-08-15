<?
    ini_set("session.cache_expire", 3600);  
    ini_set("session.gc_maxlifetime", 3600);  // 세션 만료시간을 한시간으로 설정

	include_once($_SERVER['DOCUMENT_ROOT']."/math/classes/Mast.class.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/math/classes/MastData.class.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/math/classes/MastContent.class.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/math/classes/MastJson.class.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/math/classes/MastUtil.class.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/math/classes/MastFile.class.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/math/classes/MastFunc.class.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/math/classes/MastPDF.class.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/math/classes/Image.class.php");
	
?>