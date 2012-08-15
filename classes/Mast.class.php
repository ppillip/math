<?
class Mast
{

	var $MastHome       = '/home/upsoft/www';

	var $MastShortCut   = '/math/files/shortcut';

	var $MastQuest      = '/math/files/questions';
	
	var $MastSinBal     = '/math/files/sinbal';
	
	var $MastSinBalT    = '/math/files/sinbalT';

	var $mysql_host     = 'localhost';

	var $mysql_user     = 'exam';

	var $mysql_password = 'dnflemf';

	var $mysql_db       = 'exam_db';

	public function __get($propName){

		return $this->$propName;

	}
}
?>