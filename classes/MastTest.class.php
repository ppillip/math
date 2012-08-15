<?
	class MastTest extends MastData
	{
		function get01($string){
			$del_sql = "SELECT * FROM MST_CTSK WHERE CTSK_QUST_ID = ".$string ;
			$del_result = $this->sql_query($shkt_sql,false);
		}


	}
?>