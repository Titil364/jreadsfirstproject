<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelAgainAgain extends Model{
        
	private $visitorId;
	private $applicationId;
	private $again;
	
    protected static $object = "AgainAgain";
    protected static $primary = "formId"; //temporary
    
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
}