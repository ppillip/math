<?
include_once("lcmsSVC.php");
$rootFolder = $_SERVER["DOCUMENT_ROOT"];

function makePDF($contents,$_title01,$_title02) {
$pdf = new MastPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'B4' /*PDF_PAGE_FORMAT*/, true, 'UTF-8', false);
//echo PDF_PAGE_ORIENTATION."<br>".PDF_UNIT."<br>".PDF_PAGE_FORMAT;
//exit;
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Math2357');
$pdf->SetTitle(' ');
$pdf->SetSubject(' ');
$pdf->SetKeywords(' ');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '중간고사 시험지라고 생각해요', PDF_HEADER_STRING);
$pdf->SetHeaderData('', '', $_title01 /*'시험 : '*/,$_title02 /*'반 :                         이름 : '*/);

// set header and footer fonts
$pdf->setHeaderFont(Array('arialunicid0', '', 15));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', 15 /*PDF_FONT_SIZE_DATA*/));
//$pdf->SetHeaderFont('arialunicid0', '', 14);//폰트 설정 넣어 보자



// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// print HTML
$pdf->PrintChapter(1, '', $contents, true);

//$pdf->PrintChapter(2, '여기는 정답 일때야', $contents2, true);
// ---------------------------------------------------------

//Close and output PDF document
//$pdf->Output('example_010.pdf', 'D'); //바로다운
$pdf->Output('exam.pdf', 'I'); //보이기

//============================================================+
// END OF FILE
//============================================================+
}

  ob_start();
  
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
			      ORDER BY CRCR_ID , BUNT_ID , QUST_ID
         ";

  $result = $_d->sql_query($sql);
?>

<?
  $i = 1;
  while( $row = $_d->sql_fetch_array($result) )
  {
/*  	
    $QustFile = $rootFolder."\\files\\contents\\"
                           .$row["CRCR_ID"]."\\".$row["BUNT_ID"]."\\"
                           .$row["QUST_NUM"]."_".$row["QUST_SURC_CD"]."_".$row["QUST_POINT"]."_left.jpg";

    $SolFile = $rootFolder."\\files\\contents\\"
                           .$row["CRCR_ID"]."\\".$row["BUNT_ID"]."\\"
                           .$row["QUST_NUM"]."_".$row["QUST_SURC_CD"]."_".$row["QUST_POINT"]."_right.jpg";
*/
		$QustFile = $rootFolder.str_replace("/","\\",$row["QUST_FILE_PATH"]."/".$row["QUST_Q_FILE"]);
		$SolFile  = $rootFolder.str_replace("/","\\",$row["QUST_FILE_PATH"]."/".$row["QUST_A_FILE"]);


  
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

  
    $q_Width = $q_W * (400/880) ;
    
    $s_Width = $s_W * (400/880) ;
    
    //양식지 사용?

    $qspace = "<p></p>";
    
    for($x=0;$x < $psize;$x++){
      $qspace = $qspace."<p></p>";
    }
    
    $sspace = "<p></p><p></p>";
    
    //echo '<p><img src="'.$QustFile.'" width="'.$q_Width.'"></p>'.$pspace;  //A4 ---> 
    
    if($q_W != 0 ){
      $QustImgHtml = '<img src="'.$QustFile.'" width="'.$q_Width.'">';
    }else{
      $QustImgHtml = 'No QustionFile';
    }
    
    if($s_W == 0 ){
      $SolImgHtml = 'Solution File Error';
    }else if($s_W == 1 ){
      $SolImgHtml = 'No Solution File';
    }else{
      $SolImgHtml = '<img src="'.$SolFile.'" width="'.$s_Width.'">';
    }
    
    
    if($ptype=="qust"){
      //문제 출력
      echo '<p nobr="true">'.$i.'.'.$QustImgHtml.'</p>'.$qspace;  //A4 ---> 
    }else{    
      //해설 출력
      echo '<p nobr="true">'.$i.'.'.$SolImgHtml.'</p>'.$sspace;  //A4 --->
    }
    
    
    $i++;
  }
?>

<?
$content = ob_get_clean();
//echo $content;exit;
makePDF($content,$title01,$title02);//$content
?>