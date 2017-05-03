<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelFSQuestion extends Model{
    private $FSQuestionName;
	private $defaultFSQuestion;
    
    protected static $object = "FSQuestion";
    protected static $primary = 'FSQuestionName';
     
    public function getFSQuestionName(){return $this->FSQuestionName;}
    public function setFSQuestionName($FSQuestionName){$this->FSQuestionName = $FSQuestionName;} 

    public function __construct ($FSQuestionName = NULL, $fs = NULL){
        if (!is_null($FSQuestionName)&& !is_null(fs)){
            $this->FSQuestionName = $FSQuestionName;
			$this->defaultFSQuestion = $fs;
        }
    }
	
    /* desc Return all the FS questions associated to the form 
	 * param formId The id of the form
	 */
    public static function getFSQuestionByFormId($formId){
		try{
			$sql  = "SELECT * FROM FSQuestion, AssocFormFS WHERE AssocFormFS.formId=:formId AND FSQuestion.FSQuestionName = AssocFormFS.FSQuestionName ";
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
	
    /* desc Return the default FS questions (predefined FS questions) when creating the form
	 * 
	 */
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