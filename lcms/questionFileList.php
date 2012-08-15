<?
	include_once("lcmsUI.php");
  $_d = new MastData();
  $_d->connect();
  $row = $_d->sql_fetch("SELECT * FROM MST_CRCR,MST_BUNT WHERE CRCR_ID = BUNT_CRCR_ID AND  BUNT_ID = ".$bunt_id);
  $l_type = $row["CRCR_NM"]." &gt ".$row["BUNT_NM"];
  echo $l_type;
  echo "<br>";
  $web_path = "/"."files"."/"."contents"."/".$row["CRCR_ID"]."/".$row["BUNT_ID"];
  $dir = $_SERVER['DOCUMENT_ROOT'].$web_path;
  
  
  $files = scandir($dir);

  $PdfList = array();

  foreach ($files as $file) if(substr($file, -3, 3)=='pdf') $PdfList[] = $file; 
  
?>

<html>
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script language="JavaScript" src="/math/common/js/jquery-1.4.1.js"></script>
    <script language="JavaScript" src="questionFileList.js"></script>
</head>
<style>


ul,li{
	margin:0;
	padding:0;
}
li{
	list-style:none;
	float:left;
	display:inline;
	margin-right:10px;
}

/*  */

#preview{
	position:absolute;
	border:1px solid #ccc;
	background:#333;
	padding:5px;
	display:none;
	color:#fff;
	}

/*  */
</style>

<script language="javascript">

/*
 * Image preview script 
 * powered by jQuery (http://www.jquery.com)
 * 
 * written by Alen Grakalic (http://cssglobe.com)
 * 
 * for more info visit http://cssglobe.com/post/1695/easiest-tooltip-and-image-preview-using-jquery
 *
 */
 

 var _bunt_id = '<?=$bunt_id?>';
 var _crcr_id = '<?=$row["CRCR_ID"]?>';
 
</script>

<body>
<?
  foreach ($PdfList as $file)
  {
    echo "원본 화일명 : ".$file;
    echo "<p>
           <a href='".$web_path."/".str_replace('.pdf','_left.jpg',$file)."' class='preview'><img border=0 width='200' height='100' src='".$web_path."/".str_replace('.pdf','_left.jpg',$file)."'/></a>
           <a href='".$web_path."/".str_replace('.pdf','_right.jpg',$file)."' class='preview'><img border=0 style='margin-left:30px' width='200' height='100' src='".$web_path."/".str_replace('.pdf','_right.jpg',$file)."'/></a>
         <!--  <a href='".$web_path."/".str_replace('.pdf','.jpg',$file)."' class='preview'><img border=0 style='margin-left:30px' width='200' height='100' src='".$web_path."/".str_replace('.pdf','.jpg',$file)."'/></a> -->
         </p>
         <hr>";
    
  }
  
?>
<input type=button id="dbProcess" value="디비처리하기">
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
</body>
</html>