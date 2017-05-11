<?php
require_once File::build_path(array('model', 'ModelAssoc.php'));

class ModelAgainAgain extends ModelAssoc{
        
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
}
