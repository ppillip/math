<?
  include_once("lcmsUI.php");
  $rootFolder = $_SERVER["DOCUMENT_ROOT"];

  $quests = "'".str_replace( ",","','",$quests )."'";
  $_d = new MastJson();
  $sql = "
            SELECT 
				      *
            FROM
            	MST_CRCR , MST_BUNT , MST_QUST
            WHERE
            	BUNT_CRCR_ID = CRCR_ID
            AND QUST_BUNT_ID = BUNT_ID
			      AND QUST_ID IN (".$quests.")
         ";

  $result = $_d->sql_query($sql);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>2xMath</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="/assets/css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      };

    </style>
    <link href="/assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="/assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="/assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>
    <div id="progress01" style="position:absolute;top:100px;left:350px;display:none;"><img src="/math/images/ajax-loader.gif"/></div>
    
    <div class="navbar navbar-fixed-top" id="naviMenu">
    </div>
    
    <div class="container">

		<div class="alert alert-error" id="topInfo">
			<button class="close" data-dismiss="alert">×</button>
			<h1>PDF 만들기 Classic 2단계</h1>
      <p>1. 출력할 단원을 결정 한후 <b>선택</b> 아래에 네모난 체크 박스클릭 (여러개 가능)</p>
			<p>2. 점수별 문제수를 선택한다</p>
			<p>3. <b>PDF 만들기 2단계</b> 버튼클릭</p>
		</div>      

  <table class="table table-bordered table-condensed">
		<thead>
      <tr>
        <th width=40 align=center>No</th>
        <th align=center>문제</th>
        <th align=center>해설</th>
      </tr>
	</thead>
<?
  $i = 1;
  while( $row = $_d->sql_fetch_array($result) )
  {

    $QustFile = $rootFolder.$row["QUST_FILE_PATH"]."/".$row["QUST_Q_FILE"];
    $SolFile = $rootFolder.$row["QUST_FILE_PATH"]."/".$row["QUST_A_FILE"];
    
    if(file_exists($QustFile)){
      list($q_W  ,$q_H   ,$q_type  ,$q_attr)     = getimagesize($QustFile);  
    }else{
      $q_W = 0;
      $q_H = 0;
      $q_type = 0;
      $q_attr = 0;
    }

    if(file_exists($SolFile)){
      list($s_W  ,$s_H   ,$s_type  ,$s_attr)     = getimagesize($SolFile);  
    }else{
      $s_W = 0;
      $s_H = 0;
      $s_type = 0;
      $s_attr = 0;
    }

  
    $q_Width = $q_W * (500/880) ;
    
    $s_Width = $s_W * (500/880) ;
    

    $QustURL = $row["QUST_FILE_PATH"]."/".$row["QUST_Q_FILE"];

    $SolURL  = $row["QUST_FILE_PATH"]."/".$row["QUST_A_FILE"];

    $QustImgHtml = '<img name="qust" qust_id="'.$row["QUST_ID"].'" crcr_id="'.$row["CRCR_ID"].'" bunt_id="'.$row["BUNT_ID"].'" qust_surc_cd="'.$row["QUST_SURC_CD"].'" qust_point="'.$row["QUST_POINT"].'" id="'.$row["QUST_ID"].'" src="'.$QustURL.'" width="'.$q_Width.'">';

    $SolImgHtml = '<img name="sol" src="'.$SolURL.'" width="'.$s_Width.'">';
    ?>
    
    <tr>
      <td align='center'><?=$i?></td>
      <td valign='top'><p><?=$QustImgHtml?></p>
        <p align="center">
           <button class="btn btn-large" name="changeImage"><i class="icon-refresh"></i> Change</button>
           <button class="btn btn-large" name="removeImage"><i class="icon-remove"></i> Remove</button>
        </p>
      </td>
      <td valign='top'><?=$SolImgHtml?></td>
    </tr>

    
    <?
    
    $i++;
  }
  ?>
</table>  
<div class="alert alert-error">
<p>* 특수문자나 기호는 삼가 하시고 한글/영문만 입력하세요.</p>
<p align=center>타이틀 첫번째줄  : <input type="text" style="width:380px;height:40px;color:#050;font: bold 184% 'trebuchet ms',helvetica,sans-serif;"  name=buf_title01 value="       고사">
<p align=center>타이틀 두번째줄  : <input type="text" style="width:380px;height:40px;color:#050;font: bold 184% 'trebuchet ms',helvetica,sans-serif;"  name=buf_title02 value="반:           성명:">
<p align=center>문자사이 공백수  : <select style="width:380px;height:40px;color:#050;font: bold 184% 'trebuchet ms',helvetica,sans-serif;"  name=buf_psize>
                                <option value="1" > 1칸<option>
                                <option value="3" > 3칸<option>
                                <option value="5" > 5칸<option>
                                <option value="6" > 6칸<option>
                                <option value="7" > 7칸<option>
                                <option value="9" > 9칸<option>
                                <option value="11" selected>11칸<option>
                                <option value="13">13칸<option>
                                <option value="15">15칸<option>
                                <option value="17">17칸<option>
                                <option value="19">19칸<option>
                                <option value="21">21칸<option>
                                <option value="23">23칸<option>
                                </select>
<p align=center style="margin-top:20px">
  <button class="btn btn-primary btn-large" name="makePdf"><i class="icon-ok icon-white"></i> PDF 화일 만들기</button>
</p>
</div>
    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/assets/js/jquery.js"></script>
    <script src="/assets/js/bootstrap-transition.js"></script>
    <script src="/assets/js/bootstrap-alert.js"></script>
    <script src="/assets/js/bootstrap-modal.js"></script>
    <script src="/assets/js/bootstrap-dropdown.js"></script>
    <script src="/assets/js/bootstrap-scrollspy.js"></script>
    <script src="/assets/js/bootstrap-tab.js"></script>
    <script src="/assets/js/bootstrap-tooltip.js"></script>
    <script src="/assets/js/bootstrap-popover.js"></script>
    <script src="/assets/js/bootstrap-button.js"></script>
    <script src="/assets/js/bootstrap-collapse.js"></script>
    <script src="/assets/js/bootstrap-carousel.js"></script>
    <script src="/assets/js/bootstrap-typeahead.js"></script>
    <script src="../common/js/php.js"></script>
    <script src="compositionClassic.js"></script>

  </body>
</html>

<?
mysql_close();
?>