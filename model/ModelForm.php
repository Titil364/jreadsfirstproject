<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelForm extends Model{

	private $formId;
	private $formName;
	private $userId;
	private $completedForm;
	
    protected static $object = "Form";
    protected static $primary = 'formId';
	
    public function getFormId(){return $this->formId;}
	public function setFormId($formId){$this->formId = $formId;}     

    public function getFormName(){return $this->formName;}       
    public function setFormName($formName){$this->formName = $formName;}
	
	public function getUserId(){return $this->userId;}
    public function setUserId($userId){$this->userId = $userId;}
 

	public function getCompletedForm(){return $this->completedForm;}






    public function __construct( $formID = NULL, $formName = NULL, $userId = NULL, $completedForm = NULL) {
        if (!is_null($formID) && !is_null($formName) && !is_null($userId) && !is_null($completedForm)){
        	$this->formId = $formId;
        	$this->formName = $formName;
        	$this->userId = $userId;
			$this->completedForm = $completedForm;
        }
    }

    public function getFormByUserId($userId){
		try{
			$sql  = "SELECT * FROM Form WHERE userId=:userId";
			$prep = Model::$pdo->prepare($sql);

			$values = array(
				"userId" => $userId,
				);

			$prep-> execute($values);
			$prep->setFetchMode(PDO::FETCH_CLASS,'ModelForm');
			
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
	
    public static function getLastInsert(){
		try{
			// Doesn't work on all the data base
			return Model::$pdo->lastInsertId();

		}catch (PDOException $ex) {
            if (Conf::getDebug()) {
                echo $ex->getMessage();
            } else {
                echo "Error";
            }
            return false;
        }
    }
	
	public static function getNbFSQuestionByFormId($formId){
		try{
			$sql  = "SELECT COUNT(*) FROM Donnerunnom WHERE Donnerunnom.formId=:formId";
			$prep = Model::$pdo->prepare($sql);
			
			$values = array(
				"formId" => $formId,
				);

			$prep-> execute($values);
			$prep-> setFetchMode(PDO::FETCH_NUM);
			
			return $prep->fetch();
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

