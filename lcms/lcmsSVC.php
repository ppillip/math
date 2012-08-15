<?
	header('Cache-Control: no-cache, must-revalidate');
  	header('Expires: 0');
//  header('Content-type: application/json ; charset=UTF-8');
//	header('Content-type: text/html ; charset=UTF-8');
	@session_start();
	@extract($_GET);
	@extract($_POST);
	@extract($_SERVER); 
	
  include_once($_SERVER['DOCUMENT_ROOT']."/math/classes/ImportClasses.php");
  
?>