<?
  include_once("lcmsSVC.php");

  $_d = new MastJson();

  $appHome = $_SERVER['DOCUMENT_ROOT'].'/ImageMagick';
  $appPath = $appHome.'/convert.exe';

  if($_method=="")
  {
  }
  /*단원별 생성*/
  else if($_method == "m001")
  {
    MastUtil::_c("##".$qust_count."##".$qust_type."##".$qust_points."##".$qust_bunts."##");

    $srcSql = "";
    if($qust_type=="ALL"){
      $srcSql = "";
    } else {
      $srcSql = "AND QUST_SURC_CD = '".$qust_type."'";
    }

    $sql = "
          SELECT GROUP_CONCAT(QUST_ID ORDER BY CRCR_ID , BUNT_ID) QUSTS
          FROM 
          (
            SELECT 
            /*
               CRCR_ID
              ,BUNT_ID 
              ,CRCR_NM 
              ,BUNT_NM 
              ,CRCR_USE_YN
              ,BUNT_USE_YN
              ,X.* 
            */  
              QUST_ID
              ,CRCR_ID
              ,BUNT_ID 
            FROM
            	MST_CRCR , MST_BUNT , MST_QUST X
            WHERE
            	BUNT_CRCR_ID = CRCR_ID
            AND QUST_BUNT_ID = BUNT_ID
            AND QUST_POINT IN (".$qust_points.")
            ".$srcSql."
            AND BUNT_ID IN (".$qust_bunts.")
            ORDER BY RAND()
            LIMIT 0,".$qust_count."
          ) X
           ";
    $row = $_d->sql_fetch($sql);
    
    $_d->succEnd($row["QUSTS"]);
    
    //$_d->failEnd($row["QUSTS"]);
    
  }
  else if($_method == "m002")
  {

    $sql = "
         
            SELECT 
              *
            FROM
            	MST_CRCR , MST_BUNT , MST_QUST 
            WHERE
            	BUNT_CRCR_ID = CRCR_ID
            AND QUST_BUNT_ID = BUNT_ID
            AND CRCR_ID = ".$crcr_id."
            AND BUNT_ID = ".$bunt_id."
            AND QUST_SURC_CD = '".$qust_surc_cd."'
            AND QUST_POINT   = ".$qust_point."
            AND QUST_ID NOT IN (".$qusts.")
            ORDER BY RAND()
            LIMIT 0,1
           ";
    $_d->dataEnd($sql);
  }
  else if($_method == "m003")
  {

    $sql = "
         
           ";
    $_d->dataEnd($sql);    
  }  
  $_d = null;
?>