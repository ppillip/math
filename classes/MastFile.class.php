<?
class MastFile extends Mast {

  /*유형디렉터리 생성*/
  function createTypeDir($t_id)
  {
    	$_QUESTION_PATH_ = $this->MastHome.$this->MastQuest."/";
      if( is_dir($_QUESTION_PATH_.$t_id)){
        MastUtil::_c("유형 디렉터리 이미존재");
      }else{
        @mkdir($_QUESTION_PATH_.$t_id, 0777);
        @chmod($_QUESTION_PATH_.$t_id, 0777);
      }
      return true;
  }


  /*문제디렉터리 생성*/
  function createQuestionDir($t_id,$q_id)
  {

    $_QUESTION_PATH_ = $this->MastHome.$this->MastQuest."/";

        //일단 유형 디렉터리 먼저 생성
        $this->createTypeDir($t_id);

          //consoleLog("##### 문제 디렉터리 체크후 생성");
        if( is_dir($_QUESTION_PATH_.$t_id."/".$q_id)){
          consoleLog("#####4 문제 디렉터리 이미존재");
        }else{
          @mkdir($_QUESTION_PATH_.$t_id."/".$q_id, 0777);
          @chmod($_QUESTION_PATH_.$t_id."/".$q_id, 0777);
        }

        //consoleLog("##### 문제 텍스");
        if( is_dir($_QUESTION_PATH_.$t_id."/".$q_id."/cache")){
          consoleLog("##### 문제 이미지 디렉터리 이미존재");
        }else{
          @mkdir($_QUESTION_PATH_.$t_id."/".$q_id."/cache", 0777);
          @chmod($_QUESTION_PATH_.$t_id."/".$q_id."/cache", 0777);
        }

        //consoleLog("##### 문제 텍스 템프");
        if( is_dir($_QUESTION_PATH_.$t_id."/".$q_id."/cache/tmp")){
          consoleLog("#####5 문제 이미지 디렉터리 이미존재");
        }else{
          @mkdir($_QUESTION_PATH_.$t_id."/".$q_id."/cache/tmp", 0777);
          @chmod($_QUESTION_PATH_.$t_id."/".$q_id."/cache/tmp", 0777);
        }

        //consoleLog("##### 문제 이미지 업로드 화일 디렉터리 체크후 생성");
        if( is_dir($_QUESTION_PATH_.$t_id."/".$q_id."/images")){
          consoleLog("##### 문제 이미지 디렉터리 이미존재");
        }else{
          @mkdir($_QUESTION_PATH_.$t_id."/".$q_id."/images", 0777);
          @chmod($_QUESTION_PATH_.$t_id."/".$q_id."/images", 0777);
        }

        //consoleLog("##### 문제의 문제 부분 이미지 저장소");
        if( is_dir($_QUESTION_PATH_.$t_id."/".$q_id."/images/content")){
          consoleLog("##### 문제 이미지 디렉터리 이미존재");
        }else{
          @mkdir($_QUESTION_PATH_.$t_id."/".$q_id."/images/content", 0777);
          @chmod($_QUESTION_PATH_.$t_id."/".$q_id."/images/content", 0777);
        }
        //consoleLog("##### 객관식 문제 선택지 업로드 화일 디렉터리 체크후 생성");
        if( is_dir($_QUESTION_PATH_.$t_id."/".$q_id."/images/selects")){
          consoleLog("##### 문제 이미지 디렉터리 이미존재");
        }else{
          @mkdir($_QUESTION_PATH_.$t_id."/".$q_id."/images/selects", 0777);
          @chmod($_QUESTION_PATH_.$t_id."/".$q_id."/images/selects", 0777);
        }

 return true;
  }
}
?>
