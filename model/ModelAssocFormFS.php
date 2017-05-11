<?php
require_once File::build_path(array('model', 'ModelAssoc.php'));

class ModelAssocFormFS extends ModelAssoc{
        
	private $formId;
	private $FSQuestionName;
	
    protected static $object = "AssocFormFS";
    protected static $primary1 = "formId"; //temporary
    protected static $primary2 = "FSQuestionName"; //temporary
    
    public function getFormId(){return $this->formId;}
        public function setFormId($formId){$this->formId = $formId;}

    public function getFSQuestionName(){return $this->FSQuestionName;}
        public function setFSQuestionName($FSQuestionName){$this->FSQuestionName= $FSQuestionName;}


    public function __construct($formId = NULL, $FSQuestionName = NULL){
        if (!is_null($formId) && !is_null($FSQuestionName)) {
			$this->formId = $formId;
        	$this->FSQuestionName = $FSQuestionName;

        }
    }
    
	public static function getAssocFormFSByFormId($id){
		try{
			$sql  = "SELECT * FROM AssocFormFS WHERE formId=:id";
			$prep = Model::$pdo->prepare($sql);
                        
			$values = array(
				"id" => $id
				);
                        
			$prep-> execute($values);
			$prep->setFetchMode(PDO::FETCH_CLASS,'ModelAssocFormFS');
                        
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
			
			
            $sql = "DELETE FROM $table_name WHERE formId=:f AND FSQuestionName =:fs";
			
            $req_prep = Model::$pdo->prepare($sql);
			
            $values = array(
                "f" => $primary1,
                "fs" => $primary2
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