<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelAssocFormPI extends Model{
        
	private $formId;
	private $personnalInformationName;
	
    protected static $object = "AssocFormPI";
    protected static $primary = "formId"; //temporary
    
    public function getFormId(){return $this->formId;}
        public function setFormId($formId){$this->formId = $formId;}

    public function getPersonnalInformationName(){return $this->personnalInformationName;}
        public function setPersonnalInformationName($personnalInformationName){$this->personnalInformationName = $personnalInformationName;}


    public function __construct($formId = NULL, $personnalInformationId = NULL){
        if (!is_null($formId) && !is_null($personnalInformationId)) {
			$this->formId = $formId;
        	$this->personnalInformationName = $personnalInformationName;

        }
    }
    
	/*
	 *
	 */
	public static function getAssocFormPIByFormId($id){
		try{
			$sql  = "SELECT * FROM AssocFormPI WHERE formId=:id";
			$prep = Model::$pdo->prepare($sql);
                        
			$values = array(
				"id" => $id
				);
                        
			$prep-> execute($values);
			$prep->setFetchMode(PDO::FETCH_CLASS,'ModelAssocFormPI');
                        
			$assoc_array = $prep->fetchAll();

			return $assoc_array;

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