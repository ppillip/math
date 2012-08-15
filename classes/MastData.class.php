<?
class MastData extends Mast {

	var $connect_db = "";
	var $select_db  = "";

	function connect2()
	{
$time_start = microtime(true);
		
		if(is_resource($this->connect_db)){
			return true;
		}
		
		$this->connect_db = @mysql_connect($this->mysql_host, $this->mysql_user, $this->mysql_password);
		
		if(!is_resource($this->connect_db))
		{
			MastUtil::_c("디비연결 실패");
			return false;
		}

$time_end = microtime(true);
$time = $time_end - $time_start;
MastUtil::_d("connect $this->connect_db ###################################################".$time,true);


		return @mysql_select_db($this->mysql_db, $this->connect_db);
	}

	function connect()
	{
		if(is_resource($this->connect_db)){
			return true;
		}
		
		$this->connect_db = @mysql_connect($this->mysql_host, $this->mysql_user, $this->mysql_password);
		
		if(!is_resource($this->connect_db))
		{
			MastUtil::_c("디비연결 실패");
			return false;
		}
		//MastUtil::_c("디비연결");
		return @mysql_select_db($this->mysql_db, $this->connect_db);
	}

	// DB 연결
	function sql_connect($host, $user, $pass)
	{
		
		  @mysql_query(" set names utf8 ");
	    return @mysql_connect($host, $user, $pass);
	}
	
	
	// DB 선택
	function sql_select_db($db, $connect)
	{
	
	    @mysql_query(" set names utf8 ");
	    return @mysql_select_db($db, $connect);
	}
	
	
	// mysql_query 와 mysql_error 를 한꺼번에 처리
	function sql_query($sql, $error=TRUE)
	{
	    MastUtil::_c("EXCUTE QUERY[".$sql."]");
	    $result = @mysql_query($sql,$this->connect_db);// or die("<p>$sql<p>" . mysql_errno() . " : " .  mysql_error() . "<p>error file : $_SERVER[PHP_SELF]");
		
		//$returnMsg = $returnMsg."{ \"err\": true , \"msg\": \"" . mysql_error() . " :: " . $sql. "\" }"; echo $returnMsg; exit;
	    if(mysql_errno() > 0) MastUtil::_c("########################MYSQL ERROR########################\n"
	                                ."SQL:::[".$sql."]\n"
	                                ."MSG:::[".mysql_errno() . ":" . mysql_error()
	                                ."\n###########################################################");
	    return $result;
	}
	
	
	// 쿼리를 실행한 후 결과값에서 한행을 얻는다.
	function sql_fetch($sql, $error=TRUE)
	{
	    $result = $this->sql_query($sql, $error);
	    $row = $this->sql_fetch_array($result);
	    return $row;
	}
	
	
	// 결과값에서 한행 연관배열(이름으로)로 얻는다.
	function sql_fetch_array($result)
	{
	    $row = @mysql_fetch_assoc($result);
	    return $row;
	}
	
	
	// $result에 대한 메모리(memory)에 있는 내용을 모두 제거한다.
	// sql_free_result()는 결과로부터 얻은 질의 값이 커서 많은 메모리를 사용할 염려가 있을 때 사용된다.
	// 단, 결과 값은 스크립트(script) 실행부가 종료되면서 메모리에서 자동적으로 지워진다.
	function sql_free_result($result)
	{
	    return @mysql_free_result($result);
	}
	
	
	function sql_password($value)
	{
	    // mysql 4.0x 이하 버전에서는 password() 함수의 결과가 16bytes
	    // mysql 4.1x 이상 버전에서는 password() 함수의 결과가 41bytes
	    $row = $this->sql_fetch(" select password('$value') as pass ");
	    return $row[pass];
	}


}
?>
