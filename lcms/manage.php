<?
include_once("lcmsSVC.php");

function makeUuidKey(){
    $rtnValue = str_replace("}","",str_replace("{","",com_create_guid()));
    return $rtnValue;
}

$_d = new MastJson();

$appHome = $_SERVER['DOCUMENT_ROOT'].'/ImageMagick';
$appPath = $appHome.'/convert.exe';

if($_method=="")
{
}
else if($_method == "m001")
{
    $_d->dataEnd("
    SELECT CRCR_ID,CRCR_NM,CRCR_SRT
    ,(SELECT COUNT(*) FROM MST_BUNT WHERE BUNT_CRCR_ID = CRCR_ID ) AS CNT
    FROM MST_CRCR ORDER BY CRCR_SRT
  ");
}
else if($_method == "m002")
{
    $sql = "UPDATE MST_CRCR SET CRCR_SRT=".$CRCR_SRT." WHERE CRCR_ID = '".$CRCR_ID."'";
    $result = $_d->sql_query($sql,false);
    if($result!=1){
        $_d->failEnd("오류 발생. 데이터확인.");
    }else{
        $_d->succEnd("성공적 저장.");
    }
}
else if($_method == "m0021")
{
    $sql = "UPDATE MST_BUNT SET BUNT_SRT=".$BUNT_SRT." WHERE BUNT_ID = '".$BUNT_ID."'";
    $result = $_d->sql_query($sql,false);
    if($result!=1){
        $_d->failEnd("오류 발생. 데이터확인.");
    }else{
        $_d->succEnd("성공적 저장.");
    }
}
else if($_method == "m003")
{
    $_d->dataEnd("
    SELECT CRCR_NM, BUNT_ID,BUNT_NM,BUNT_SRT
    ,(SELECT COUNT(*) FROM MST_QUST WHERE QUST_BUNT_ID = BUNT_ID ) AS CNT
    FROM MST_BUNT , MST_CRCR
    WHERE BUNT_CRCR_ID = '".$CRCR_ID."'
    AND CRCR_ID = '".$CRCR_ID."'
    ORDER BY BUNT_SRT
  ");
}
else if($_method == "m004")
{
    $CRCR_ID = makeUuidKey();
    $sql = "INSERT INTO MST_CRCR (CRCR_ID,CRCR_NM,CRCR_SRT,CRCR_USE_YN)
           VALUES ('".$CRCR_ID."','".$CRCR_NM."',".$CRCR_SRT.",'Y') ";
    $result = $_d->sql_query($sql,false);
    if($result!=1){
        $_d->failEnd("오류 발생! 데이터확인");
    }else{
        $_d->succEnd("생성 성공.");
    }
}
else if($_method == "m005")
{
    $BUNT_ID = makeUuidKey();
    $sql = "INSERT INTO MST_BUNT (BUNT_ID,BUNT_CRCR_ID,BUNT_NM,BUNT_SRT,BUNT_USE_YN)
           VALUES ('".$BUNT_ID."','".$BUNT_CRCR_ID."','".$BUNT_NM."',".$BUNT_SRT.",'Y') ";
    $result = $_d->sql_query($sql,false);
    if($result!=1){
        $_d->failEnd("오류 발생! 데이터확인");
    }else{
        $_d->succEnd("생성 성공!");
    }
}
else if($_method == "m006")
{
    $sql = "DELETE FROM MST_CRCR WHERE CRCR_ID = '".$CRCR_ID."'";
    $result = $_d->sql_query($sql,false);
    if($result!=1){
        $_d->failEnd("오류 발생. 데이터확인.");
    }else{
        $_d->succEnd("삭제성공");
    }
}
else if($_method == "m007")
{
    $sql = "DELETE FROM  MST_BUNT WHERE BUNT_ID = '".$BUNT_ID."'";
    $result = $_d->sql_query($sql,false);
    if($result!=1){
        $_d->failEnd("오류 발생. 데이터확인.");
    }else{
        $_d->succEnd("삭제성공");
    }
}

else if($_method == "m008")
{
    $_d->dataEnd("SELECT CONCAT(CRCR_NM ,' > ',BUNT_NM) AS FULL_NM, BUNT_ID FROM MST_CRCR,MST_BUNT WHERE BUNT_CRCR_ID = CRCR_ID ORDER BY CRCR_SRT , BUNT_SRT");
}

$_d = null;
?>