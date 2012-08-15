<?
  include_once("lcmsSVC.php");

  $_d = new MastJson();

  $appHome = $_SERVER['DOCUMENT_ROOT'].'/ImageMagick';
  $appPath = $appHome.'/convert.exe';

  if($_method=="")
  {
  }
  /*컨텐츠 생성*/
  else if($_method == "L001")
  {
    
    $web_path = "/"."files"."/"."contents"."/".$crcr_id."/".$bunt_id;
    $dir = $_SERVER['DOCUMENT_ROOT'].$web_path;
    
    $files = scandir($dir);


    $SQL = "DELETE FROM MST_QUST WHERE BUNT_ID = ".$bunt_id;
          
    $_d->sql_query($SQL,false);


    //1. PDF->DB;
    foreach ($files as $file){
      if(substr($file, -3, 3)=='pdf'){
        $fArr = explode('_',str_replace('.pdf','',$file));
        $QUST_NUM       = $fArr[0];
        $QUST_BUNT_ID   = $bunt_id;
        $QUST_SURC_CD   = $fArr[1];
        $QUST_POINT     = $fArr[2];
        
        $SQL = "
            INSERT INTO MST_QUST
            ( QUST_NUM     ,QUST_BUNT_ID
             ,QUST_SURC_CD ,QUST_POINT
             ,QUST_STAT_CD ,QUST_REG_DT 
            ) VALUES (
             '".$QUST_NUM."'     ,".$QUST_BUNT_ID."
            ,'".$QUST_SURC_CD."' ,".$QUST_POINT."
            ,'10',SYSDATE()
            )";
            
       $_d->sql_query($SQL,false);
        
      }
    }

    //2. PDF->Image
    foreach ($files as $file){
      if(substr($file, -3, 3)=='pdf'){
        
        $pdfFile = $dir."/".$file;
        $fullImg = $dir."/".str_replace('.pdf','.jpg',$file);
        $command = $appPath.' -density 200 -trim -transparent #FFFFFF '.$pdfFile.' '.$fullImg;
        exec($command);
        MastUtil::_c($command);
      }
    }
    
    //3. FullImage -> Each (left & right)
    foreach ($files as $file){
      if(substr($file, -3, 3)=='pdf'){
        $fullImg = $dir."/".str_replace('.pdf','.jpg',$file);
        $leftImg = $dir."/".str_replace('.pdf','_left.jpg',$file);
        $rightImg = $dir."/".str_replace('.pdf','_right.jpg',$file);
        
        $command = $appPath.' '.$fullImg.' -crop 907x2202+2+2 -fuzz 50% -trim +repage '.$leftImg;
        exec($command);
        MastUtil::_c($command);
        
        $command = $appPath.' '.$fullImg.' -crop 906x2202+911+2 -fuzz 50% -trim +repage '.$rightImg;
        exec($command);
        MastUtil::_c($command);
      }
    }
    
    
    $_d->succEnd("작업이 완료 되었습니다.");


   
    
  }
?>