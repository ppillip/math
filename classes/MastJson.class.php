<?
class MastJson extends MastData
{

  function MastJson()
  {
    parent::connect();
  }

  function sql2json($sql)
  {
    $result = $this->sql_query($sql,false);
    $row    = $this->sql_fetch_array($result);
    return json_encode($row);
  }

  function failEnd($msg)
  {
    echo "{\"msg\":\"".$msg."\",\"err\":true}";
    exit;
  }

  function succEnd($msg)
  {
    echo "{\"msg\":\"".$msg."\",\"err\":false}";
    exit;
  }

  function cmdEnd($sql)
  {

    $result = $this->sql_query($sql,false);
    MastUtil::_c("===============================>".$result);
    if($result!=1){
      $this->failEnd("오류가 발생했습니다.데이터를 확인하세요");
    }else{
      $this->succEnd("성공적으로 되었습니다");
    }
  }

  function getDataOld($sql)
  {
    $result = $this->sql_query($sql,true);
    $rStr = "{\"rows\":[";
    for ($i=0; $row=$this->sql_fetch_array($result); $i++)
    {
      if($i!=0) $rStr=$rStr.",";
      $rStr = $rStr.json_encode($row);
    }
    $rStr = $rStr."]}";

    $this->sql_free_result($result);

    return $rStr;
  }

  function getData($sql)
  {
    $__trn = "";    
    $result = $this->sql_query($sql,true);
    for ($i=0; $row=$this->sql_fetch_array($result); $i++)
    {
			$__trn->rows[$i] = $row;
    }
    $this->sql_free_result($result);
    return json_encode($__trn);
  }


  function dataEnd($sql)
  {
    $result = $this->getData($sql);
    echo $result;
    exit;
  }

}
?>