<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelAnswerType extends Model{

	private $answerTypeId;
	private $answerTypeName;
	private $answerTypeImage;
	private $questionTypeName;
	
    protected static $object = "AnswerType";
    protected static $primary = "answerTypeId";
    
    public function getAnswerTypeId(){return $this->answerTypeId;}
        public function setAnswerTypeId($answerTypeId){$this->answerTypeId = $answerTypeId;}
        
    public function getAnswerTypeImage(){return $this->answerTypeImage;}
        public function setAnswerTypeImage($answerTypeImage){$this->answerTypeImage = $answerTypeImage;}
        
    public function getAnswerTypeName(){return $this->answerTypeName;} 
        public function setAnswerTypeName($answerTypeName){$this->answerTypeName = $answerTypeName;}    

    public function getQuestionTypeName(){return $this->questionTypeName;}    
	public function setQuestionTypeName($questionTypeName){$this->questionTypeName = $questionTypeName;}


	


    public function __construct($atId = NULL, $atIm = NULL, $atN = NULL, $qtId =NULL ){
        if (!is_null($atId) && !is_null($atIm) && !is_null($atN) && !is_null($qtId)) {
        	$this->answerTypeId = $atId;
        	$this->answerTypeImage = $atIm;
                $this->answerTypeName = $atN;
                $this->questionTypeName = $qtId;
        }
    }

    public static function getAnswerTypeByQuestionTypeName($id){
		try{
			$sql  = "SELECT * FROM AnswerType WHERE questionTypeName=:id";
			$prep = Model::$pdo->prepare($sql);
                        
			$values = array(
				"id" => $id
				);
                        
			$prep-> execute($values);
			$prep->setFetchMode(PDO::FETCH_ASSOC);
                        
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

