<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelQuestionType extends Model{

	private $questionTypeId;
	private $questionTypeName;
	
    protected static $object = "QuestionType";
    protected static $primary = "questionTypeId";
	
    public function getQuestionTypeId(){return $this->questionTypeId;}    
	public function setQuestionTypeId($questionTypeId){$this->questionTypeId = $questionTypeId;}

    public function getQuestionTypeName(){return $this->questionTypeName;} 
	public function setQuestionTypeName($questionTypeName){$this->questionTypeName = $questionTypeName;}
	


    public function __construct($qid = NULL, $qn = NULL){
        if (!is_null($qid) && !is_null($qn)) {
        	$this->questionTypeId = $qid;
        	$this->questionTypeName = $qn;
        }
    }

	public static function getQuestionTypeByName($name){
		try{
			$sql  = "SELECT questionTypeId FROM QuestionType WHERE questionTypeName=:n";
			$prep = Model::$pdo->prepare($sql);

			$values = array(
				"n" => $name,
				);

			$prep-> execute($values);
			$prep->setFetchMode(PDO::FETCH_CLASS,'ModelQuestionType');

			
			return $prep->fetchAll()[0];

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

