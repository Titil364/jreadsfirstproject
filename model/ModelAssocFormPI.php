<?php
require_once File::build_path(array('model', 'ModelAssoc.php'));

class ModelAssocFormPI extends ModelAssoc{
        
	private $formId;
	private $personnalInformationName;
	
    protected static $object = "AssocFormPI";
    protected static $primary1 = "formId"; 
    protected static $primary2 = "personnalInformationName"; 
    
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
    
        public static function delete($primary1,$primary2) {
        try {
            $table_name = static::$object;
            $class_name = 'Model' . $table_name;
			
			
            $sql = "DELETE FROM $table_name WHERE formId=:f AND personnalInformationName =:p";
			
            $req_prep = Model::$pdo->prepare($sql);
			
            $values = array(
                "f" => $primary1,
                "p" => $primary2
            );
			
            $req_prep->execute($values);
            return true;
			
        } catch (PDOException $ex) {
            if (Conf::getDebug()) {
                echo $ex->getMessage();
            } else {
                echo "Error while deleting the object";
            }
            return false;
        }
    }
}