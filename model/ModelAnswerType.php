<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelAnswertype extends Model{

	private $answerTypeId;
	private $answerTypeName;
        private $answerTypeImage;
        private $questionTypeId;
	
    protected static $object = "AnswerType";
    protected static $primary = "answerTypeId";
    
    public function getAnswerTypeId(){return $this->answerTypeId;}
        public function setAnswerTypeId($answerTypeId){$this->answerTypeId = $answerTypeId;}
        
    public function getAnswerTypeImage(){return $this->answerTypeImage;}
        public function setAnswerTypeImage($answerTypeImage){$this->answerTypeImage = $answerTypeImage;}
        
    public function getAnswerTypeName(){return $this->answerTypeName;} 
        public function setAnswerTypeName($answerTypeName){$this->answerTypeName = $questionTypeName;}    

    public function getQuestionTypeId(){return $this->questionTypeId;}    
	public function setQuestionTypeId($questionTypeId){$this->questionTypeId = $questionTypeId;}


	


    public function __construct($atId = NULL, $atIm = NULL, $atN = NULL, $qtId =NULL ){
        if (!is_null($atId) && !is_null($atIm) && !is_null($atN) && !is_null($qtId)) {
        	$this->answerTypeId = $atId;
        	$this->answerTypeImage = $atIm;
                $this->answerTypeName = $atN;
                $this->questionTypeId = $qtId;
        }
    }

    public function getAnswerTypeByQuestionTypeId ($id){
		try{
			$sql  = "SELECT * FROM AnswerType WHERE questionTypeId=:id";
			$prep = Model::$pdo->prepare($sql);
                        
			$values = array(
				"id" => $id
				);
                        
			$prep-> execute($values);
			$prep->setFetchMode(PDO::FETCH_CLASS,'ModelAnswerType');
                        
			$answerType_array = $prep->fetchAll();

			return $answerType_array;

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

