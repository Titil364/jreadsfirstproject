<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelAgainAgain extends Model{
        
	private $visitorId;
	private $applicationId;
	private $again;
	
    protected static $object = "AgainAgain";
    protected static $primary1 = "visitorId";
	protected static $primary2 = "applicationId";
    
    public function getVisitorId(){return $this->visitorId;}
        public function setVisitorId($visitorId){$this->visitorId = $visitorId;}
	
	public function getAgain(){return $this->again;}
        public function setAgain($again){$this->again = $again;}

    public function getApplicationId(){return $this->applicationId;}
        public function setApplicationId($applicationId){$this->applicationId= $applicationId;}


    public function __construct($visitorId = NULL, $applicationId = NULL, $ao = NULL){
        if (!is_null($visitorId) && !is_null($applicationId) &&!is_null($ao)) {
			$this->visitorId = $visitorId;
        	$this->applicationId = $applicationId;
			$this->again = $ao;
        }
    }
	
	/* desc This update replaces the generic update because this table has a two-component primary key
	 * param data This shall be an array containing as key exactly the same name as the column in the data ase
	 *
	 */
	public static function update($data) {
        try {
            $table_name = static::$object;
            $class_name = 'Model' . $table_name;
			
            $sql = "UPDATE $table_name SET ";
            foreach ($data as $cle => $valeur) {
                $sql = $sql . $cle . "=:" . $cle . ", ";
            }
            $sql = rtrim($sql, ' ,');
			$primary_key1 = static::$primary1;
			$primary_key2 = static::$primary2;
            $sql = $sql . " WHERE $primary_key1=:$primary_key1 AND $primary_key2=:$primary_key2;";
            $req_prep = Model::$pdo->prepare($sql);
            $req_prep->execute($data);
            return true;
        } catch (PDOException $ex) {
            if (Conf::getDebug()) {
                echo $ex->getMessage();
            } else {
                echo "une erreur est survenue lors de la mise à jour de l'objet.";
            }
            return false;
        }
    }
	
	public static function getAgainAgainByVisitorId($visitorId){
		try{
			$sql  = "SELECT * FROM AgainAgain WHERE visitorId=:visitorId";
			$prep = Model::$pdo->prepare($sql);
                        
			$values = array(
				"visitorId" => $visitorId
				);
                        
			$prep-> execute($values);
			$prep->setFetchMode(PDO::FETCH_CLASS,'ModelAgainAgain');
                        
			$question_array = $prep->fetchAll();

			return $question_array;

		}catch (PDOException $ex) {
            if (Conf::getDebug()) {
                echo $ex->getMessage();
            } else {
                echo "Error";
            }
            return false;
        }
	}
	
	public static function getAgainAgainByApplicationId($applicationId){
		try{
			$sql = "SELECT applicationId, again, count(again) as 'nbAnswer' FROM AgainAgain WHERE applicationId=:applicationId AND again is not null Group By (again)";
			$prep = Model::$pdo->prepare($sql);
                        
			$values = array(
				"applicationId" => $applicationId
				);
                        
			$prep-> execute($values);
			$prep->setFetchMode(PDO::FETCH_ASSOC);
                        
			$question_array = $prep->fetchAll();

			return $question_array;

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
			
			
            $sql = "DELETE FROM $table_name WHERE visitorId=:v AND applicationId =:a";
			
            $req_prep = Model::$pdo->prepare($sql);
			
            $values = array(
                "v" => $primary1,
                "a" => $primary2
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