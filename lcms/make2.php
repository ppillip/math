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
    $i = 0;
    $rows = explode("#R",$qust_bunts);
    foreach($rows as $key) {
      
      $cols = explode("#C",$key);
      if($cols[0]=="") continue;
      
      $bunt_id      = $cols[0];
      $qust_surc_cd = $cols[1];
      $points       = $cols[2];
      $count        = $cols[3];

      $SRC_SQL = "";
      
      if($qust_surc_cd != "ALL") $SRC_SQL = "AND QUST_SURC_CD = '".$qust_surc_cd."'";
      
      $cm = "," ;
      if($i==0) $cm = "";
      
      $sql = 
      "SELECT IFNULL(GROUP_CONCAT(QUST_ID),0) AS QUSTS FROM ( 
        SELECT 
               QUST_ID
        FROM   MST_QUST 
        WHERE  QUST_BUNT_ID = '".$bunt_id."'
           ".$SRC_SQL."
           AND QUST_POINT = ".$points."
        ORDER BY RAND()
        LIMIT 0,".$count."
       ) X
      ";
      $i=1;
      
      $result = $_d->sql_fetch($sql);
      
      if($result["QUSTS"]!="") $RTN = $RTN.$cm.$result["QUSTS"];
      
      
      MastUtil::_c($RTN);
      

    }
    $_d->succEnd($RTN);

    //$_d->dataEnd($sql);    
  }  
  
   else if($_method == "m004")
  {
    $i = 0;
    $rows = explode("#R",$qust_bunts);
    foreach($rows as $key) {
      
      $cols = explode("#C",$key);
      if($cols[0]=="") continue;
      
      $bunt_id      = $cols[0];
      $qust_surc_cd = $cols[1];
      $points       = $cols[2];
      $count        = $cols[3];

      $SRC_SQL = "";
      
      if($qust_surc_cd != "ALL") $SRC_SQL = "AND QUST_SURC_CD = '".$qust_surc_cd."'";
      
      $cm = "," ;
      if($i==0) $cm = "";
      
      $sql = 
      "SELECT IFNULL(GROUP_CONCAT(QUST_ID),0) AS QUSTS FROM ( 
        SELECT 
               QUST_ID
        FROM   MST_QUST 
        WHERE  QUST_BUNT_ID = ".$bunt_id."
           ".$SRC_SQL."
           AND QUST_POINT = ".$points."
        ORDER BY RAND()
        LIMIT 0,".$count."
       ) X
      ";
      $i=1;
      
      $result = $_d->sql_fetch($sql);
      
      if($result["QUSTS"]!="") $RTN = $RTN.$cm.$result["QUSTS"];
      
      
      MastUtil::_c($RTN);
      

    }
    
    $_d->dataEnd("SELECT * FROM MST_QUST WHERE QUST_ID IN ('".str_replace( ",","','",$RTN )."')");

    //$_d->dataEnd($sql);
  }
  
  $_d = null;
?>