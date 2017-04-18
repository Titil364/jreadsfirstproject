<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelFSQuestion extends Model{
    private $FSQuestionId;
    private $FSQuestionName;
	private $defaultFSQuestion;
    
    protected static $object = "FSQuestion";
    protected static $primary = 'FSQuestionId';
    
    public function getFSQuestionId(){return $this->FSQuestionId;}
    public function setFSQuestionId($FSQuestionId){$this->FSQuestionId = $FSQuestionId;} 
    
    public function getFSQuestionName(){return $this->FSQuestionName;}
    public function setFSQuestionName($FSQuestionName){$this->FSQuestionName = $FSQuestionName;} 

    public function __construct ($FSQuestionId = NULL, $FSQuestionName = NULL, $fs = NULL){
        if (!is_null($FSQuestionId) && !is_null($FSQuestionName)&& !is_null(fs)){
            $this->FSQuestionId = $FSQuestionId;
            $this->FSQuestionName = $FSQuestionName;
			$this->defaultFSQuestion = $fs;
        }
    }
    
    public static function getFSQuestionByFormId($formId){
		try{
			$sql  = "SELECT * FROM FSQuestion, Donnerunnom WHERE Donnerunnom.formId= '1' AND FSQuestion.FSQuestionId = Donnerunnom.FSQuestionId ";
			$prep = Model::$pdo->prepare($sql);
			
			$values = array(
				"formId" => $formId,
				);

			$prep-> execute($values);
			$prep-> setFetchMode(PDO::FETCH_CLASS, 'ModelFSQuestion');
            
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
	public static function getDefaultFSQuestion(){
		try{
			$sql  = "SELECT FSQuestionName FROM FSQuestion WHERE defaultFSQuestion=:d";
			$prep = Model::$pdo->prepare($sql);
                        
			$values = array(
				"d" => 1
				);
                        
			$prep-> execute($values);
			$prep->setFetchMode(PDO::FETCH_NUM);
                        
			$default_info = $prep->fetchAll();

			return $default_info;

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