<?
/*
	header("Content-Type: text/html; charset=UTF-8");
	header("Expires: 0");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: pre-check=0, post-check=0, max-age=0");
	header("Pragma: no-cache");
*/
//-------------------------------------------
// SESSION
//-------------------------------------------
//ini_set("session.use_trans_sid", 0);    // PHPSESSID
//ini_set("url_rewriter.tags",""); // PHPSESSID
//
	session_save_path($_SERVER['DOCUMENT_ROOT']."/logs");
//
//if (isset($SESSION_CACHE_LIMITER))
//    @session_cache_limiter($SESSION_CACHE_LIMITER);
//else
//    @session_cache_limiter("no-cache, must-revalidate");

//
//ini_set("session.cache_expire", 180);
//ini_set("session.gc_maxlifetime", 10800); // session dataG gabage collection xg
//
//session_set_cookie_params(0, "/");
//ini_set("session.cookie_domain", $g4['cookie_domain']);

	@session_start();
	@extract($_GET);
	@extract($_POST);
	@extract($_SERVER);

	date_default_timezone_set('Asia/Seoul');

	set_error_handler("PHPErrorHandler",E_ALL);

	include_once($_SERVER['DOCUMENT_ROOT']."/math/classes/Mast.class.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/math/classes/MastData.class.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/math/classes/MastContent.class.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/math/classes/MastJson.class.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/math/classes/MastLatex.class.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/math/classes/MastShortCut.class.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/math/classes/MastUtil.class.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/math/classes/MastTest.class.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/math/classes/MastFile.class.php");

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
		$text = str_replace("# :line()\n","",$text);
		fwrite($file_pointer, $text);
		fclose($file_pointer);
	}
?>