<?php
require_once File::build_path(array('model', 'ModelAssoc.php'));

class ModelSortApplication extends ModelAssoc{
        
	private $visitorId;
	private $FSQuestionName;
	private $applicationRatingOrder;
	
    protected static $object = "SortApplication";
    protected static $primary1 = "visitorId"; //temporary
	protected static $primary2 = "FSQuestionName";
    
    public function getVisitorId(){return $this->visitorId;}
        public function setVisitorId($visitorId){$this->visitorId = $visitorId;}
	
	public function getApplicationRatingOrder(){return $this->applicationRatingOrder;}
        public function setApplicationRatingOrder($applicationOrder){$this->applicationRatingOrder = $applicationOrder;}

    public function getFSQuestionName(){return $this->FSQuestionName;}
        public function setFSQuestionName($FSQuestionName){$this->FSQuestionName= $FSQuestionName;}


    public function __construct($visitorId = NULL, $FSQuestionName = NULL, $ao = NULL){
        if (!is_null($visitorId) && !is_null($FSQuestionName) &&!is_null($ao)) {
			$this->visitorId = $visitorId;
        	$this->FSQuestionName = $FSQuestionName;
			$this->applicationRatingOrder = $ao;
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
