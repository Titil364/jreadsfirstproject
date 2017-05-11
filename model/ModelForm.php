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
	
    /* desc Return all the form created by the user 
	 * param userId The nickname of the user
	 */
    public function getFormByUserId($userId){
		try{
			$sql  = "SELECT * FROM Form WHERE userNickname=:userNickname";
			$prep = Model::$pdo->prepare($sql);

			$values = array(
				"userNickname" => $userId,
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
	
	public function getApplicationNumberByFormId($formId){
		try{
			$sql = "SELECT count(*) FROM Application WHERE Application.formId=:formId";
			$prep = Model::$pdo->prepare($sql);

			$values = array(
				"formId" => $formId,
				);

			$prep-> execute($values);
			$prep->setFetchMode(PDO::FETCH_NUM);
			
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
	
	/* desc Return all the visitor of the form
	 * param formId tThe id of the form
	 */
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
	
	public static function getCompletedFormByForm($formId){
		try{
			$sql  = "SELECT ApplicationDateComplete.visitorId, count(ApplicationDateComplete.visitorId)=:applicationNumber as 'nb' FROM Application, ApplicationDateComplete WHERE Application.applicationId =ApplicationDateComplete.applicationId AND Application.formId=:formId AND ApplicationDateComplete.applicationDateCompletePost is not null GROUP BY (ApplicationDateComplete.visitorId)";
			$prep = Model::$pdo->prepare($sql);

			
			$appNumber =  ModelForm::getApplicationNumberByFormId($formId);
			$values = array(
				"applicationNumber" => $appNumber[0][0],
				"formId" => $formId
				);

			$prep-> execute($values);
			$prep->setFetchMode(PDO::FETCH_ASSOC);
			
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
        
        public static function deleteAllFormContent($formId) {
            
            $visitor_array = ModelVisitor::getVisitorByFormId($formId);
            foreach ($visitor_array as $v){
                $vId = $v->getVisitorId();
                ModelVisitor::deleteAllVisitorContent($vId);
            }
            
            
            $app_Array = ModelApplication::getApplicationByFormId($formId);
            
            foreach ($app_Array as $app){ //app
                $appId = $app->getApplicationId();
                $question_array = ModelQuestion::getQuestionByApplicationId($appId);
                    
                foreach ($question_array as $q){ //quest
                    $qId = $q->getQuestionId();
                    ModelQuestion::delete($qId);
                }
                ModelApplication::delete($appId);

            }
            $affs_array = ModelAssocFormFS::getAssocFormFSByFormId($formId);  //assocFormFS
            foreach ($affs_array as $affs){
                $FSQuestionName = $affs->getFSQuestionName();
                ModelAssocFormFS::delete($formId, $FSQuestionName);
            }
            
            $afpi_array = ModelAssocFormPI::getAssocFormPIByFormId($formId); //assocFormPI
            
            foreach ($afpi_array as $afpi){
                $personnalInformationName = $afpi->getPersonnalInformationName();
                ModelAssocFormPI::delete($formId, $personnalInformationName);
            }
            
            ModelForm::delete($formId);
        }
}

