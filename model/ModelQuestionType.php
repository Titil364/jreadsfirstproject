<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelQuestionType extends Model{


	private $questionTypeName;
	
    protected static $object = "QuestionType";
    protected static $primary = "questionTypeName";
	


    public function getQuestionTypeName(){return $this->questionTypeName;} 
	public function setQuestionTypeName($questionTypeName){$this->questionTypeName = $questionTypeName;}
	


    public function __construct($qn = NULL){
        if (!is_null($qn)) {
        	$this->questionTypeName = $qn;
        }
    }
	//FAUX TO FIX
	public static function getQuestionTypeByName($name){
		try{
			$sql  = "SELECT questionTypeId FROM QuestionType WHERE questionTypeName=:name";
			$prep = Model::$pdo->prepare($sql);

			$values = array(
				"name" => $name,
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

