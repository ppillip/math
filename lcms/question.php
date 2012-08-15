<?
  include_once("lcmsSVC.php");

  $_d = new MastJson();

  $docRoot = $_SERVER['DOCUMENT_ROOT'];

  $appHome = $docRoot.'/ImageMagick';
  $appPath = $appHome.'/convert.exe';
  
  $pdfDir = $docRoot."/math/upload/server/php/files";
  $outputDir = $docRoot."/files/temp";
  $contentWebBase = "/files/contents";
  $contentBase = $docRoot.$contentWebBase;

  if($_method=="q01")
  {

    $sql = "
        SELECT
         *
        FROM
            MST_CRCR,MST_BUNT,MST_QUST QUST
        WHERE CRCR_ID = BUNT_CRCR_ID
          AND BUNT_ID = QUST_BUNT_ID
          AND QUST_BUNT_ID = '".$bunt_id."'
        ORDER BY QUST_NUM
        ";
	
	$spath = $_SERVER['DOCUMENT_ROOT'];
	
    $__trn = "";    
    $result = $_d->sql_query($sql,true);
    for ($i=0; $row=$_d->sql_fetch_array($result); $i++)
    {
        $qfile = $spath."/".$row["QUST_FILE_PATH"]."/".$row["QUST_A_FILE"];
        $afile = $spath."/".$row["QUST_FILE_PATH"]."/".$row["QUST_Q_FILE"];
        if (file_exists($qfile)) {
	        $info1 = getimagesize($qfile);
	        $row["AWIDTH"] = $info1[0];
	        $row["AHEIGHT"] = $info1[1];
	        $info2 = getimagesize($afile);
	        $row["QWIDTH"] = $info2[0];
	        $row["QHEIGHT"] = $info2[1];    		
        }
        $row["IDX"] = $i;
    	$__trn->rows[$i] = $row;
    }
    $_d->sql_free_result($result);

	  echo json_encode($__trn);

      	
  }
  else if($_method == "q02")
  {

      $sql = "UPDATE MST_QUST SET QUST_BUNT_ID='".$BUNT_ID."' WHERE QUST_ID IN ('".str_replace( ",","','",$QUST_IDS )."')";
      $result = $_d->sql_query($sql,false);
      if($result<1){
          $_d->failEnd("오류 발생. 데이터확인.");
      }else{
          $_d->succEnd("성공적 이동.");
      }

  }
  else if($_method == "q03")
  {
      /*1. 화일삭제 대상건 조회*/
      $sql = "SELECT * FROM MST_QUST WHERE QUST_ID IN ('".str_replace( ",","','",$QUST_IDS )."')";
      $result = $_d->sql_query($sql,false);

      /*2. 디비삭제*/
      $delSql = "DELETE FROM MST_QUST WHERE QUST_ID IN ('".str_replace( ",","','",$QUST_IDS )."')";
      $dresult = $_d->sql_query($delSql,false);
      if($result<1){
          $_d->failEnd("디비삭제 오류, 확인요망.");
      }

      /*3. 화일삭제*/
      while( $row = $_d->sql_fetch_array($result) ){
        $qfile = $_SERVER['DOCUMENT_ROOT']."/".$row["QUST_FILE_PATH"]."/".$row["QUST_Q_FILE"];
        $afile = $_SERVER['DOCUMENT_ROOT']."/".$row["QUST_FILE_PATH"]."/".$row["QUST_A_FILE"];
        if(is_file($qfile)==true){
           MastUtil::_c($afile);
           MastUtil::_c($qfile);
           unlink($qfile);
           unlink($afile);
        }
      }

      $_d->succEnd("삭제 작업이 끝났습니다.");

  }


  /*화일업로드 및 컨텐츠 생성에 관한 부분*/
  else if($_method == "qc01")
  {
    //1. PDF->Big Images
    MastUtil::_c($file_name);
    
	  if($file_name=="") {
	    $_d->failEnd("에러:화일명,확인요망.");
	  }

    $pdfFile = $pdfDir."/".$file_name;
    $fullImg = $outputDir."/big_".$file_name.".jpg";
    $command = $appPath.' -density 200 -trim -transparent #FFFFFF '.$pdfFile.' '.$fullImg;
    exec($command);
    
    $_d->succEnd("서버:PDF에서 문제 추출 완료");
  }
  else if($_method == "qc02")
  {
    //2. PDF Remove
    MastUtil::_c($file_name);
    
	  if($file_name=="") {
	    $_d->failEnd("화일명, 확인요망.");
	  }
	  
    unlink($pdfDir."/".$file_name);
    $_d->succEnd("서버:PDF 파일삭제 완료");

  }
  else if($_method == "qc03")
  {
  	//3. FullImage -> Each (left & right)
  	$fullImgfiles = scandir($outputDir);
  	foreach ($fullImgfiles as $file){
  	  if(substr($file,0,40) != "big_".$file_name) continue;
  	    
  	    $fullImg = $outputDir."/".$file;
  	    
  	    $UUID = str_replace("}","",str_replace("{","",com_create_guid()));
  	    
  	    $leftImg = $outputDir."/".$UUID.'_q.jpg';
  	    $rightImg = $outputDir."/".$UUID.'_a.jpg';
  	    
  	    $command = $appPath.' '.$fullImg.' -crop 907x2202+2+2 -fuzz 50% -trim +repage '.$leftImg;
  	    //echo $command ;
  	    exec($command);
  	    
  	    $command = $appPath.' '.$fullImg.' -crop 906x2202+911+2 -fuzz 50% -trim +repage '.$rightImg;
  	    //echo $command ;
  	    exec($command);
  	}   
    $_d->succEnd("서버:문제/정답 이미지 추출 완료");
    
  }
  else if($_method == "qc04")
  {
  	//4. FullImage 삭제
  	$fullImgfiles = scandir($outputDir);
  	foreach ($fullImgfiles as $file){
  		if(substr($file,0,40) != "big_".$file_name) continue;
  	    unlink($outputDir."/".$file);
  	}
    $_d->succEnd("서버:임시화일 삭제 완료");
    
  }
  else if($_method=="t01"){
    $Imgfiles = scandir($outputDir);
    $i=0;
    $webPath = "/files/temp";
    foreach ($Imgfiles as $file){
      if($file[0] == ".") continue;

      if(substr($file,0,4) == "big_") continue;
      //if(substr($file,40,5) == "_a.jpg") echo $file;
      if(substr($file,36,6)=="_q.jpg")
      {
        $info1 = getimagesize($outputDir."/".$file);
        $rows[$i]["QUST_ID"] = str_replace("_q.jpg","",$file);
        $rows[$i]["QFILE_PATH"] = $webPath."/".$file;
        $rows[$i]["QWIDTH"] = $info1[0]      ;
        $rows[$i]["QHEIGHT"] =  $info1[1]   ;

        $info2 = getimagesize($outputDir."/".str_replace("_q.jpg","_a.jpg",$file));
        $rows[$i]["AFILE_PATH"] = $webPath."/".str_replace("_q.jpg","_a.jpg",$file);
        $rows[$i]["AWIDTH"] = $info2[0]      ;
        $rows[$i]["AHEIGHT"] =  $info2[1]   ;

        $i++;
      }
    }
    $rtn["rows"] = $rows;
    echo json_encode($rtn);
  }

  else if($_method == "qt01")
  {
  	$tempfiles = explode(",",$QUST_IDS);
    $i=0;
    foreach ($tempfiles as $file){
      if(is_file($outputDir."/".$file."_q.jpg")){
        unlink($outputDir."/".$file."_q.jpg");
      }
      if(is_file($outputDir."/".$file."_a.jpg")){
        unlink($outputDir."/".$file."_a.jpg");
      }
      $i++;
  	}
    $_d->succEnd("서버:삭제 완료"."[".$i."]x2");
  }

  else if($_method == "mk01")
  {
    $today = getdate();
    $folderPath = $contentBase."/".$today["year"]."/".str_pad($today["mon"], 2, "0", STR_PAD_LEFT)."/".$today["mday"];
    if(!file_exists($folderPath)){
      mkdir($folderPath, 0777, true);
    }
    $webPath = $contentWebBase."/".$today["year"]."/".str_pad($today["mon"], 2, "0", STR_PAD_LEFT)."/".$today["mday"];

    if($BUNT_ID=="") $_d->failEnd("서버:단원을 선택 필요");
    $tempFiles = explode(",",$QUST_IDS);
    $i=0;
    foreach ($tempFiles as $f_info){
      $questionInfo = explode("#",$f_info);
      $file = str_replace("undefined","",$questionInfo[0]);
      $point = str_replace("undefined","",$questionInfo[1]);
      $src_cd = str_replace("undefined","",$questionInfo[2]);

      if($file=="" || $point=="" || $src_cd==""){
        MastUtil::_c("error:정보부족".$questionInfo);
        continue;
      }
      $sql = "insert into MST_QUST (     QUST_ID
                                      ,QUST_NUM
                                      ,QUST_BUNT_ID
                                      ,QUST_SURC_CD
                                      ,QUST_POINT
                                      ,QUST_STAT_CD
                                      ,QUST_REG_DT
                                      ,QUST_FILE_PATH
                                      ,QUST_Q_FILE
                                      ,QUST_A_FILE
                                      ) VALUES (
                                      '".$file."'
                                      ,'0'
                                      ,'".$BUNT_ID."'
                                      ,'".$src_cd."'
                                      ,".$point."
                                      ,'10'
                                      ,SYSDATE()
                                      ,'".$webPath."'
                                      ,'".$file."_q.jpg"."'
                                      ,'".$file."_a.jpg"."'
                                      )";
      $result = $_d->sql_query($sql,false);
      if($result<1){
        $_d->failEnd("오류 발생. 데이터확인.");
      }else{
        rename($outputDir."/".$file."_q.jpg",$folderPath."/".$file."_q.jpg");
        rename($outputDir."/".$file."_a.jpg",$folderPath."/".$file."_a.jpg");
      }
    }
    $_d->succEnd("서버:작업완료");
  }

?>