<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelQuestion extends Model{

	private $questionId;
	private $questionName;
	private $applicationId;
	private $questionTypeId;
	private $questionPre;
	
    protected static $object = "Question";
    protected static $primary = "questionId";
	
    public function getQuestionId(){return $this->questionId;}    
	public function setQuestionId($questionId){$this->questionId = $questionId;}

    public function getQuestionName(){return $this->questionName;} 
	public function setQuestionName($questionName){$this->questionName = $questionName;}
	
    public function getApplicationId(){return $this->applicationId;}
	public function setApplicationId($applicationId){$this->applicationId = $applicationId;}
	
    public function getQuestionTypeId(){return $this->questionTypeId;}
	public function setQuestionTypeId($questionTypeId){$this->questionTypeId = $questionTypeId;}

	public function getQuestionPre(){return $this->questionPre;}
	public function setQuestionPre($questionPre){$this->questionPre = $questionPre;}




    public function __construct($questionId = NULL, $questionName = NULL, $applicationId=  NULL, $questionTypeId = NULL, $questionPre = NULL){
        if (!is_null($questionId) && !is_null($questionName) && !is_null($applicationId)&& !is_null($questionTypeId)&& !is_null($questionPre)) {
        	$this->questionId = $questionId;
        	$this->questionName = $questionName;
        	$this->applicationId = $applicationId;
            $this->questionTypeId = $questionTypeId;
			$this->questionPre = $questionPre;

        }
    }

	
	/* desc Return all the questions of the application no matter if the question is a post or a pre question
	 * param id The id of the application
	 *
	 */
    public static function getQuestionByApplicationId($id){
		try{
			$sql  = "SELECT * FROM Question WHERE applicationId=:id";
			$prep = Model::$pdo->prepare($sql);
                        
			$values = array(
				"id" => $id
				);
                        
			$prep-> execute($values);
			$prep->setFetchMode(PDO::FETCH_CLASS,'ModelQuestion');
                        
			$question_array = $prep->fetchAll();

			return $question_array;

		}catch (PDOException $ex) {
            if (Conf::getDebug()) {
                echo $ex->getMessage();
            } else {
                echo "Error";
            }
            return false;
        }
    }
	
	
	/* desc Return all the pre or post questions of the application
	 * param id The id of the application
	 * param pre Nature of the question (0 for pre and 1 for post)
	 *
	 */
	public static function getQuestionByApplicationIdAndPre($id, $pre){
		try{
			$sql  = "SELECT * FROM Question WHERE applicationId=:id AND questionPre=:pre";
			$prep = Model::$pdo->prepare($sql);
                        
			$values = array(
				"id" => $id,
				"pre" => $pre
				);
                        
			$prep-> execute($values);
			$prep->setFetchMode(PDO::FETCH_CLASS,'ModelQuestion');
                        
			$question_array = $prep->fetchAll();

			return $question_array;

		}catch (PDOException $ex) {
            if (Conf::getDebug()) {
                echo $ex->getMessage();
            } else {
                echo "Error";
            }
            return false;
        }
    }
	
	public static function getQuestionByFormId($formId){
		$app = ModelApplication::getApplicationByFormId($formId);
		$questionTable=[];
		foreach($app as $a){
			$question = ModelQuestion::getQuestionByApplicationId($a->getApplicationId());
			foreach($question as $q){
				array_push($questionTable, $q);
			}
		}
		return $questionTable;
	}
}

