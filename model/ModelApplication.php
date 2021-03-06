<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelApplication extends Model{

	private $applicationId;
	private $applicationName;
	private $applicationDescription;
    private $formId;
	
    protected static $object = "Application";
    protected static $primary = 'applicationId';

    public function getApplicationId(){return $this->applicationId;}    
    public function setApplicationId($applicationId){$this->applicationId = $applicationId;}    
	
    
	public function getApplicationName(){return $this->applicationName;}       
    public function setApplicationName($applicationName){$this->applicationName = $applicationName;}

	
    public function getApplicationDescription(){return $this->applicationDescription;}
    public function setApplicationDescription($applicationDescription){$this->applicationDescription ->$applicationDescription;}

	public function getFormId(){return $this->formId;}    
    public function setFormId($formId){$this->formId = $formId;}    
	
	
    public function __construct( $applicationId= NULL, $applicationName = NULL, $applicationDescription = NULL, $formId = NULL) {
        if (!is_null($applicationId) && !is_null($applicationName) && !is_null($applicationDescription) && !is_null($formId)) {
        	$this->applicationId = $applicationId;
        	$this->applicationName = $applicationName;
        	$this-> $applicationDescription = $applicationDescription;
            $this->formId = $formId;
  	
        }
    }

	/* desc Return all the applications associated with the form
	 * param formId The id of the form
	 *
	 */
    public static function getApplicationByFormId($formId){
		try{
			$sql  = "SELECT * FROM Application WHERE formId=:id";
			$prep = Model::$pdo->prepare($sql);

			$values = array(
				"id" => $formId
				);

			$prep-> execute($values);
			$prep->setFetchMode(PDO::FETCH_CLASS,'ModelApplication');
			$application_array = $prep->fetchAll();
			
			return $application_array;

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


