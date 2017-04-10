<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelForm extends Model{

	private $formId;
	private $formName;
	private $userId;
	
    protected static $object = "Form";
    protected static $primary = 'formId';
	
    public function getFormId() {
   		return $this->formId;
    }    

    public function getFormName() {
   		return $this->formName;
    }       

    public function setFormId($formId) {
   		$this->formId = $formId;
    }    

    public function setFormName($formName){
   		$this->formName = $formName;
    }

    public function getUserId(){
    	return $this->userId;
    }

    public function setUserId($userId){
    	$this->userId = $userId;
    }


    public function __construct( $formID= NULL, $formName = NULL, $userId = NULL) {
        if (!is_null($formID) && !is_null($formName) && !is_null($userId)) {
        	$this->formId = $formId;
        	$this->formName = $formName;
        	$this-> $userId = $userId;
  	
        }
    }
/* The generic model will provide this function
    public function getFormById($id){
		try{
			$sql  = "SELECT * FROM Form WHERE formId=:id";
			$prep = Model::$pdo->prepare($sql);

			$values = array(
				"id" => $id,
				);

			$prep-> execute($values);
			$prep->setFetchMode(PDO::FETCH_CLASS,'ModelForm');
			$form_array = $prep->fetchAll();
			
			return $form_array[0];

		}catch (PDOException $ex) {
            if (Conf::getDebug()) {
                echo $ex->getMessage();
            } else {
                echo "Error";
            }
            return false;
        }
    }
*/
    public function getFormByUserId($userId){
		try{
			$sql  = "SELECT * FROM Form WHERE formId=:id";
			$prep = Model::$pdo->prepare($sql);

			$values = array(
				"id" => $userId,
				);

			$prep-> execute($values);
			$prep->setFetchMode(PDO::FETCH_CLASS,'ModelForm');
			$form_array = $prep->fetchAll();
			
			return $form_array;

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

