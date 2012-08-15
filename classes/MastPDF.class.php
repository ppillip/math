<?
require_once($_SERVER['DOCUMENT_ROOT'].'/tcpdf/config/lang/eng.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/tcpdf/tcpdf.php');

/**
 * Extend TCPDF to work with multiple columns
 */
class MastPDF extends TCPDF {

	/**
	 * Print chapter
	 * @param $num (int) chapter number
	 * @param $title (string) chapter title
	 * @param $file (string) name of the file containing the chapter body
	 * @param $mode (boolean) if true the chapter body is in HTML, otherwise in simple text.
	 * @public
	 */
	public function PrintChapter($num, $title, $file, $mode=false) {

		//챕터 글꼴 설정
		$this->SetFont('arialunicid0', '', 14);

		// disable existing columns
		$this->setEqualColumns();
		// add a new page
		$this->AddPage();
		// reset margins
		$this->selectColumn();
		// print chapter title
		// $this->ChapterTitle($num, $title); 주석처리 해버림 
		// set columns
		$this->setEqualColumns(2, 103); /*A4 : 87 , A3 : 180 , B4:103?*/
		// print chapter body  ChapterBody 에서 변경함 string 통째로 받아서 처리
		$this->ChapterBodyByText($file, $mode);
	}

	/**
	 * Set chapter title
	 * @param $num (int) chapter number
	 * @param $title (string) chapter title
	 * @public
	 */
	public function ChapterTitle($num, $title) {
		$this->SetFont('arialunicid0', '', 14);
		$this->SetFillColor(200, 220, 255);
		$this->Cell(180, 6, 'Chapter '.$num.' : '.$title, 0, 1, '', 1);
		$this->Ln(4);
	}

	/**
	 * Print chapter body
	 * @param $file (string) name of the file containing the chapter body
	 * @param $mode (boolean) if true the chapter body is in HTML, otherwise in simple text.
	 * @public
	 */
	public function ChapterBody($file, $mode=false) {
		$this->selectColumn();
		// get esternal file content
		$content = file_get_contents($file, false);
		// set font
		$this->SetFont('arialunicid0', '', 9);
		$this->SetTextColor(50, 50, 50);
		// print content
		if ($mode) {
			// ------ HTML MODE ------
			$this->writeHTML($content, true, false, true, false, 'J');
		} else {
			// ------ TEXT MODE ------
			$this->Write(0, $content, '', 0, 'J', true, 0, false, true, 0);
		}
		$this->Ln();
	}
	
	public function ChapterBodyByText($content, $mode=false) {
		$this->selectColumn();
		$this->SetFont('arialunicid0', '', 9);
		$this->SetTextColor(50, 50, 50);
		$this->writeHTML($content, true, false, true, false, 'J');
		$this->Ln();
	}

} // end of extended class



/*
  Helper function 
  input : html
*/
