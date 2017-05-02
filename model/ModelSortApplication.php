<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelSortApplication extends Model{
        
	private $visitorId;
	private $FSQuestionName;
	private $applicationOrder;
	
    protected static $object = "SortApplication";
    protected static $primary = "formId"; //temporary
    
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
}