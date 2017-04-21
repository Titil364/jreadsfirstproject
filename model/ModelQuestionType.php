<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelQuestionType extends Model{

	private $questionTypeId;
	private $questionTypeName;
	private $userNickname;
	
    protected static $object = "QuestionType";
    protected static $primary = "questionTypeId";
	


    public function getQuestionTypeId(){return $this->questionTypeId;} 
	public function setQuestionTypeId($questionTypeId){$this->questionTypeId = $questionTypeId;}
	
	public function getQuestionTypeName(){return $this->questionTypeName;} 
	public function setQuestionTypeName($questionTypeName){$this->questionTypeName = $questionTypeName;}
	
	public function getUserNickname(){return $this->userNickname;} 
	public function setUserNickname($userNickname){$this->userNickname = $userNickname;}


    public function __construct($qid = NULL, $qn = NULL, $u = NULL){
        if (!is_null($qn)) {
        	$this->questionTypeId = $qid;
        	$this->questionTypeName = $qn;
        	$this->userNickname = $u;
        }
    }
	
	//FAUX TO FIX
	public static function getQuestionTypeForUser($user){
		try{
			$sql  = "SELECT * FROM QuestionType WHERE userNickname=:u OR userNickname IS NULL;";
			$prep = Model::$pdo->prepare($sql);
			$values = array(
				"u" => $user
				);

			$prep-> execute($values);
			$prep->setFetchMode(PDO::FETCH_CLASS,'ModelQuestionType');

			
			return $prep->fetchAll();

		}catch (PDOException $ex) {
            if (Conf::getDebug()) {
                echo $ex->getMessage();
            } else {
                echo "Error";
            }
            return false;
        }
	}
	
}

