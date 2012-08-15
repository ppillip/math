<?
/**
 * @class  latexrender
 * @author HNO3 <wdlee91@gmail.com>
 * @brief  LaTeX Code Renderer
 **/

class MastLatex extends Mast
{
	var $editor_sequence = 0;
	var $component_path = '';

	var $font_size = "20";
	var $latex_path = '/usr/bin/latex';
	var $dvips_path = '/usr/bin/dvips';
	var $convert_path = '/usr/bin/convert';
	var $latex_tags_blacklist = array(
		'include', 'def', 'command', 'loop', 'repeat', 'open', 'toks', 'output', 'input',
		'catcode', 'name', '^^',
		'\\every', '\\errhelp', '\\errorstopmode', '\\scrollmode', '\\nonstopmode', '\\batchmode',
		'\\read', '\\write', 'csname', '\\newhelp', '\\uppercase', '\\lowercase', '\\relax', '\\aftergroup',
		'\\afterassignment', '\\expandafter', '\\noexpand', '\\special'
	);
	var $translationTable;
	var $home_path = "";   //       '/home/nksoft';
	var $web_path  = "";   //       '/math/files/shortcut/cache';
	var $tmp_path  = "";   //       '/math/files/shortcut/cache/tmp';
	var $density = "120";
	/**
	 * @brief 생성자를 잘받아야함 Q: Question / S: ShortCut
	 **/
	function MastLatex($Mode="Q", $a="" , $b="")
	{
		if     ($Mode=="S") /* 단축키 */
		{

			$this->home_path = $this->MastHome;
			$this->web_path  = $this->MastShortCut."/cache";
			$this->tmp_path  = $this->web_path."/tmp";

		}elseif($Mode=="Q") /* 문제 : $a=유형id $b=문제id*/
		{

			$this->home_path = $this->MastHome;
			$this->web_path  = $this->MastQuest."/".$a."/".$b."/cache";
			$this->tmp_path  = $this->web_path."/tmp";

		}elseif($Mode=="SB") /* 신타발타 */
		{

			$this->home_path = $this->MastHome;
			$this->web_path  = $this->MastSinBal."/cache";
			$this->tmp_path  = $this->web_path."/tmp";
		
		}elseif($Mode=="SBT") /* 신타발타 연습*/
		{

			$this->home_path = $this->MastHome;
			$this->web_path  = $this->MastSinBalT."/cache";
			$this->tmp_path  = $this->web_path."/tmp";
			
		}else
		{

			$this->home_path = "";
			$this->web_path  = "";
			$this->tmp_path  = "";

		}

//		MastUtil::_c("<<경로\n".$this->home_path."\n".$this->web_path."\n".$this->tmp_path."\n경로>>");


  }

	/**
	 * @brief tex 컴파일에 필요한 가장 기본적인 문서 구조를 추가
	 **/
	function wrapFormula($formula) {
		$string  = '\documentclass[' . $this->font_size . 'pt]{article}' . "\n";
		$string .= '\usepackage[hangul,nonfrench,finemath]{kotex}' . "\n";
		$string .= '\usepackage[default]{dhucs-interword}' . "\n";
		$string .= '\usehangulfontspec{ut}' . "\n";
		$string .= '\usepackage[hangul]{dhucs-setspace}' . "\n";
		$string .= '\usepackage{dhucs-gremph}' . "\n";
		$string .= '\usepackage[unicode,dvipdfm,colorlinks]{hyperref}' . "\n";

		//심볼 설치
		$string .= '\usepackage{amssymb}[amsmath]' . "\n";

		$string .= '\pagestyle{empty}' . "\n";
		$string .= '\begin{document}' . "\n";
		$string .= '$' . "\n";
		$string .= '\displaystyle' . "\n";
		$string .= '{' . "\n";
		$string .= $formula . "\n";
		$string .= '}' . "\n";
		$string .= '$' . "\n";
		$string .= '\end{document}' . "\n";

		return $string;
	}

	/**
	 * @brief 경로의 디렉토리 구분자를 OS에 따라 \ 또는 /로 일괄 변경
	 **/
	function getCommandFilePath($path)
	{
		if(DIRECTORY_SEPARATOR == '\\')
			return str_replace('/', '\\', $path);
		return str_replace('\\', '/', $path);
	}

	/**
	 * @brief HTML 엔티티(&nbsp;, &#233;, &#xAC00; 등)를 UTF-8 문자로 치환
	 **/
	function entityDecodeCallback($matches)
	{
		$code = 0;
		if(!empty($matches[3]))
			$code = hexdec($matches[3]);
		elseif(!empty($matches[2]))
			$code = intval($matches[2]);
		elseif(array_key_exists($matches[0], $this->translationTable))
			$code = ord($this->translationTable[$matches[0]]);

		if(!$code)
			return '';

		$lower = $code & 0xFF;
		$upper = ($code & 0xFF00) >> 8;

		$utf16str = chr($lower) . chr($upper);

		return iconv('UTF-16LE', 'UTF-8', $utf16str);
	}

	/**
	 * @brief 화일에 저장 되어 있던것을 리턴 해 준다.. 작성자가 작성한 원본을 주는것
	 **/
	function getUserTypeTextFile($filenm)
	{
		$data = file($this->home_path.$this->tmp_path."/".$filenm.'.text');
		return $data[0];
	}
	/**
	 * @brief 에디터 컴포넌트의 고유 코드를 html로 변경
	 **/
	function transHTML($obj,$rtnType)
	{
//		consoleLog($obj);
		$description = '';  //$obj->attrs->description; //이거는 단순 설명
		
		MastUtil::_c("[".$obj."]");
		
		$content = str_replace('\\\\', '\\', $obj);    //$obj->body;   url로 넘어 올때 "//" 가 넘어 와서 처리

		$content = strip_tags(preg_replace('/<br\s*\/?>\n?/i', "\n", $content)); // br을 /n으로 바꾼다..



		$file_dir = $this->home_path.$this->web_path;
		$file_name = sha1($content) . dechex(crc32($content)); //화일명 만들기.. 참 복잡시럽기도 하다..


		$image_name = $file_name . '.png';
		$file_path = $file_dir . '/' . $image_name;

		$tmp_dir = $this->home_path.$this->tmp_path;


//해쉬값으로 전체 수식을 변경하여 화일명으로 하고.. 그 화일이 존재 할경우는 png 화일을 만들지 않는다..
// -_-;;

/***************** debug *************************/
//echo "png 저장 디렉터리 :[".$file_path."]<br>";
/*************************************************/

		if(!@file_exists($file_path))
		{
			if(!function_exists('exec'))
				return ' LaTeXRender: Cannot use "exec" function. "exec" must be enabled. ';

			$formula = preg_replace_callback('/\&([A-Za-z]+|#([0-9]+|x([0-9A-Fa-f]+)));/i', array($this, 'entityDecodeCallback'), $content);

			reset($this->latex_tags_blacklist);
			foreach($this->latex_tags_blacklist as $tag)
			{
				if(preg_match('/' . preg_quote($tag) . '/i', $formula))
					return ' LaTeXRender: There are blacklist tags in the latex code ';
			}

			$formula = $this->wrapFormula($formula);

			$formula = preg_replace(  '!(['.'\x{1100}-\x{11FF}\x{3130}-\x{318F}\x{AC00}-\x{D7AF}'.']+)!u', '\textrm{ $1}', $formula);
			$formula = str_replace('\\\\', '\\', $formula);      //슬레쉬 2개 제거

			if(!$this->font_size)
				$this->font_size = 10;

      
			$cwd = getcwd();

			chdir($tmp_dir);




			$tex_file = $file_name . '.tex';
			$fp = fopen($tex_file,"w");
        	fputs($fp,$formula);
	        fclose($fp);

			$tex_org_file = $file_dir."/".$file_name . '.text';  //이미지랑 같은 경로로 함
//					MastUtil::_c("현재여기[".$tex_org_file);
	        $fp = fopen($tex_org_file,"w");
        	fputs($fp,$content);
	        fclose($fp);
			@chmod($tex_org_file,0777);
			
			MastUtil::_c("[".$tex_org_file."]");
			

/***************** 100. tex 컴파일  시작 ************************************************/
			$cmd = $this->latex_path . ' --interaction=nonstopmode ' . $tmp_dir.'/'.$tex_file;
			//MastUtil::_c("[".$cmd."]");
			$status = @exec($cmd);
/***************** 100. tex 컴파일  종료 ************************************************/
			if(!$status)
			{
				//@unlink($tex_file);
				chdir($cwd);
				return ' LaTeXRender: tex compile failed ';
			}
			@unlink($file_name . '.log');
			@unlink($file_name . '.aux');
			@unlink($file_name . '.out');
			$dvi_file = $file_name . '.dvi';
			$ps_file = $file_name . '.ps';
/***************** 200. dvi to ps 시작 ************************************************/
			$cmd = $this->dvips_path . ' -E ' . $dvi_file . ' -o ' . $ps_file;
			//MastUtil::_c("[".$cmd."]");
			$status = @exec($cmd);
/***************** 200. dvi to ps 종료 ************************************************/
			if(!$status && !file_exists($ps_file))
			{
				@unlink($dvi_file);
				chdir($cwd);
				return ' LaTeXRender: dvi to ps convert failed ';
			}
			chdir($cwd);
			$tex_path = $tmp_dir . '/' . $tex_file;
			$dvi_path = $tmp_dir . '/' . $dvi_file;
			@unlink($dvi_path);
			$ps_path = $tmp_dir . '/' . $ps_file;
/***************** 300. ps to img 시작 ************************************************/
			$cmd = $this->convert_path . ' -density '.$this->density.' -trim -transparent "#FFFFFF" ' . $this->getCommandFilePath($ps_path) . ' ' . $this->getCommandFilePath($file_path);
			//MastUtil::_c("[".$cmd."]");
			$status = @exec($cmd);
/***************** 300. ps to img 종료 ************************************************/
			if(!$status && !@file_exists($file_path))
			{
				@unlink($ps_path);
				return ' LaTeXRender: Image convert failed CMD: ' . $cmd;
			}

			@unlink($ps_path);
		}else{
//			MastUtil::_c("화일이 존재 합니다");
		}

		$html	= '<img class="_latex_" src="'. $this->web_path.'/'. $image_name . '" alt="' . $content . '" name="' . $file_name . '" />'; //의미가 아주 중요함 html 의 name 속성을 바꾸거나 하지 말것
		if($rtnType=="html")
		{
			$rtnString = $html;
		}else if($rtnType=="system")
		{
			$rtnString = $file_path;
		}else if($rtnType=="webpath")
		{
			$rtnString = $this->web_path.'/'. $image_name;
		}else if($rtnType=="json")
		{
			$rtnString = json_encode(array(
			  "hash"=>$file_name,
			  "image"=>$this->web_path.'/'. $image_name,
			  "tag"=>$html
			));
		}else if($rtnType=="xml")
		{
			$rtnString ="<xml>";
			$rtnString =$rtnString."<hash><![CDATA[".$file_name."]]></hash>";
			$rtnString =$rtnString."<image><![CDATA[".$this->web_path."/". $image_name."]]></image>";
			$rtnString =$rtnString."<tag><![CDATA[".$html."]]></tag>";
			$rtnString =$rtnString."</xml>";
		}
		return $rtnString;
	}
}
?>