<?
	header("Content-Type: text/html; charset=UTF-8");
	header("Expires: 0"); 
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate"); 
	header("Cache-Control: pre-check=0, post-check=0, max-age=0");
	header("Pragma: no-cache");

@session_start();

@extract($_GET);
@extract($_POST);
@extract($_SERVER); 


	include_once($_SERVER['DOCUMENT_ROOT']."/math/classes/ImportClasses.php");

?>