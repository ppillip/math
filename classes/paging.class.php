<?
class CPaging {

	private $rowCnt;
	private $rowMax;
	private $page;
	private $pageCnt;
	private $pageLast;
	
	private $pageStart =0;
	private $pageCntMax = 0;
	
	private $param = "";
	private $imgLf = "<img src='/math/borad_img/but_prev.gif' width='41' height='9' border='0'>"; // 이전 페이지
	private $imgRt = "<img src='/math/borad_img/but_next.gif' width='41' height='9' border='0'>"; // 다음 페이지
	//private $imgLfLf = "<img src='/images/board/prev_btn01.gif' width='41' height='9' border='0'>"; // 처음 페이지
	//private $imgRtRt = "<img src='/images/board/next_btn02.gif' width='41' height='9' border='0'>"; // 마지막 페이지
	
	private $flagType = 0;	//페이징 타입 : 0 - [이전] 123... [다음] // 1 - [처음] [이전] 123... [다음] [끝]
	
	/*현재 페이지번호, 전체 레코드수, 페이지당 출력 레코드수, 출력 페이징갯수*/
	public function __construct($page, $rowMax, $rowCnt = 10, $pageCnt = 10){
		$this->page = $page;
		$this->rowMax = $rowMax;
		$this->rowCnt = $rowCnt;
		$this->pageCnt = $pageCnt;
		$this->pageLast = ceil($rowMax / $rowCnt);
	}
	public function __destruct(){
	}
	
	public function __get($name){
		return $this->$name;
	}
	public function __set($name, $value){
		$this->$name = $value;
	}
	
	private function pageCntMax(){
		if($this->pageCntMax==0){
			return ceil($this->rowMax / $this->rowCnt);
		}
	}
	private function pageStart(){
		return floor(($this->page - 1 ) / $this->pageCnt) * $this->pageCnt + 1;
	}
	private function pageEnd(){
		return $this->pageStart() + ($this->pageCnt - 1);
	}
	private function printScript(){		
		print("<script>\n");
		print("function movePage(pNum){\n");
		print("	location.href = location.href.split('?')[0]+'?page='+pNum+'&".$this->param."';\n");
		print("}\n");
		print("</script>\n");
	}
	
	public function write(){
		
		$this->printScript();
		
		$pgStart = $this->pageStart();
		$pgEnd = $this->pageEnd();
		
		if($this->flagType > 1){
			print(" <a href='javascript:movePage(1)'>".$this->imgLfLf."</a> ");
		}
		if($this->page > $this->pageCnt){
			print(" <a href='javascript:movePage(".($pgStart-$this->pageCnt).")'>".$this->imgLf."</a> ");
		}
		
		for($i=$pgStart;$i<=$pgEnd;$i++){
			if($i > $this->pageLast)
				break;
				
			if($i == $this->page)
				print(" <b>".$i."</b>");
			else
				print(" <a href='javascript:movePage(".$i.");'>[".$i."]</a> ");
		}
		
		if($this->pageCntMax() > $pgEnd){
			print(" <a href='javascript:movePage(".($pgStart+$this->pageCnt).")'>".$this->imgRt."</a> ");
			if($this->flagType > 0){
				print(" <a href='javascript:movePage(".$this->pageCntMax().")'>".$this->imgRtRt."</a> ");
			}
		}
				
	}
	
}
/* 사용법	
//현재 페이지번호, 전체 레코드수, 페이지당 출력 레코드수, 출력 페이징갯수
$paging = new CPaging(1,123,10,10);	//현재 1페이지고.. 총 123개의 레코드가 있고.. 페이지당 10개의 게시물이 출력.. 10개 단위의 페이징

	$paging->flagType = 0;	//페이징 타입 : 0 - [이전] 123... [다음] // 1 - [처음] [이전] 123... [다음] [끝]
	$paging->param = "abc=value&bcd=value";	//게시물 이동시에 지정 될 파라미터 지정
	$paging->write();	//페이징 출력

$paging = null;
*/
?>