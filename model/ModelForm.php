<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelForm extends Model{

	private $formId;
	private $formName;
	private $userNickname;
	private $completedForm;
	private $fillable;
	
    protected static $object = "Form";
    protected static $primary = 'formId';
	
    public function getFormId(){return $this->formId;}
	public function setFormId($formId){$this->formId = $formId;}     

    public function getFormName(){return $this->formName;}       
    public function setFormName($formName){$this->formName = $formName;}
	
	public function getUserNickname(){return $this->userNickname;}
    public function setUserNickname($userNickname){$this->userId = $userNickname;}
 
	public function getCompletedForm(){return $this->completedForm;}

	public function getFillable(){return $this->fillable;}
	public function setFillable($fillable){$this->fillable = $fillable;}





    public function __construct( $formID = NULL, $formName = NULL, $userId = NULL, $completedForm = NULL, $fillable = NULL) {
        if (!is_null($formID) && !is_null($formName) && !is_null($userId) && !is_null($completedForm)&& !is_null($fillable)){
        	$this->formId = $formId;
        	$this->formName = $formName;
        	$this->userNickname = $userId;
			$this->completedForm = $completedForm;
			$this->fillable = $fillable;
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
	
	
	public static function getVisitorsByFormId($formId){
		try{
			$sql  = "SELECT * FROM Visitor WHERE Visitor.formId=:formId";
			$prep = Model::$pdo->prepare($sql);

			$values = array(
				"formId" => $formId,
				);

			$prep-> execute($values);
			$prep->setFetchMode(PDO::FETCH_CLASS,'ModelVisitor');
			
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

