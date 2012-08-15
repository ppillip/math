<?

	class	ShortCut extends MastData
	{

		function deleteShortCut($string){
			$del_sql = "DELETE FROM	MST_CTSK WHERE CTSK_QUST_ID	=	".$string	;
			$del_result	=	sql_query($shkt_sql,false);
		}


		function makeShortCut($string){
			$sql = " select	*	from MST_QUST	where	QUST_ID	=	".$string;
			$result	=	sql_query($sql,false);
			$row		=	sql_fetch_array($result);
			//echo strpos($row["QUST_TXT"],"cache");

			$shkt_sql	=	"SELECT	*	FROM MST_SHKT" ;
			$shkt_result = sql_query($shkt_sql,false);


			//echo htmlspecialchars_decode($row["QUST_SOL_TXT"],ENT_QUOTES)."<br>";

			$arrM	=	split("/cache/",$row["QUST_SOL_TXT"]); //	해설로	하느냐	문제로	하느냐	차이가좀 있음	그냥 해설로함

			/*for	문의 0부터 하지	않는다..	cache로 나눴으니깐 0번째 배열에는	원하는게 없다*/
			for($i=1;$i< sizeof($arrM);$i++){

				$file_name = "/home/nksoft/math/files/questions/".$row["QUST_FILE_DIR"]."/".$row["QUST_ID"]."/cache/".substr($arrM[$i],0,strpos($arrM[$i],".png")).".text";
				$data	=	file($file_name);

				for	($j=0; $shkt_row=sql_fetch_array($shkt_result);	$j++){
					if(	is_numeric(strpos($data[0],$shkt_row["SHKT_SCHWORD"])) ==	1	)
					{
						/*
						echo "<br>=========================================================================================================";
						echo "<br>".strpos($data[0],$shkt_row["SHKT_SCHWORD"])."있어요	[".$data[0]."][".$shkt_row["SHKT_SCHWORD"]."]";
						echo "<br>단축키ID:".$shkt_row["SHKT_ID"];
						echo "<br>문제ID:".$row["QUST_ID"];
						echo "<br>화일명:".$file_name;
						*/
						$this->deleteShortCut($string);


						$insSql	=	"INSERT	INTO MST_CTSK	(CTSK_QUST_ID,CTSK_SHKT_ID)	VALUES ( ".$row["QUST_ID"].",".$shkt_row["SHKT_ID"]."	)";

						sql_query($insSql,false);

					}else{
						//echo "<br>".strpos($data[0],$shkt_row["SHKT_SCHWORD"])."없어요	[".$data[0]."][".$shkt_row["SHKT_SCHWORD"]."]";
					}
				}
			}
		}
	}


?>