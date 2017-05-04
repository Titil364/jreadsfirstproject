<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelSortApplication extends Model{
        
	private $visitorId;
	private $FSQuestionName;
	private $applicationOrder;
	
    protected static $object = "SortApplication";
    protected static $primary1 = "visitorId"; //temporary
	protected static $primary2 = "FSQuestionName";
    
    public function getVisitorId(){return $this->visitorId;}
        public function setVisitorId($visitorId){$this->visitorId = $visitorId;}
	
	public function getApplicationOrder(){return $this->applicationOrder;}
        public function setApplicationOrder($applicationOrder){$this->applicationOrder = $applicationOrder;}

    public function getFSQuestionName(){return $this->FSQuestionName;}
        public function setFSQuestionName($FSQuestionName){$this->FSQuestionName= $FSQuestionName;}


    public function __construct($visitorId = NULL, $FSQuestionName = NULL, $ao = NULL){
        if (!is_null($visitorId) && !is_null($FSQuestionName) &&!is_null($ao)) {
			$this->visitorId = $visitorId;
        	$this->FSQuestionName = $FSQuestionName;
			$this->applicationOrder = $ao;
        }
    }
	
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
	
	public static function getFSByVisitorId($visitorId){
		try{
			$sql  = "SELECT * FROM SortApplication WHERE visitorId=:visitorId";
			$prep = Model::$pdo->prepare($sql);
                        
			$values = array(
				"visitorId" => $visitorId
				);
                        
			$prep-> execute($values);
			$prep->setFetchMode(PDO::FETCH_CLASS,'ModelSortApplication');
                        
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
}