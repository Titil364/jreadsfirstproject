<?php
require_once File::build_path(array('model', 'ModelAssoc.php'));

class ModelApplicationDateComplete extends ModelAssoc{
        
	private $applicationId;
	private $visitorId;
	private $applicationDateCompletePre;
	private $applicationDateCompletePost;
	
    protected static $object = "ApplicationDateComplete";
    protected static $primary1 = "applicationId"; //temporary
    protected static $primary2 = "visitorId"; //temporary
    
    public function getApplicationId(){return $this->applicationId;}
        public function setApplicationId($applicationId){$this->applicationId = $applicationId;}

    public function getVisitorId(){return $this->visitorId;}
        public function setVisitorId($visitorId){$this->visitorId = $visitorId;}
		
public function getApplicationDateCompletePost(){return $this->applicationDateCompletePost;}
        public function setApplicationDateCompletePost($applicationDateCompletePost){$this->applicationDateCompletePost = $applicationDateCompletePost;}
		
	public function getApplicationDateCompletePre(){return $this->applicationDateCompletePre;}
        public function setApplicationDateCompletePre($applicationDateCompletePre){$this->applicationDateCompletePre = $applicationDateCompletePre;}


    public function __construct($applicationId = NULL, $visitorId = NULL, $dpre = NULL, $dpost = NULL){
        if (!is_null($applicationId) && !is_null($visitorId)&& !is_null($dpre)&& !is_null($dpost)) {
			$this->applicationId = $applicationId;
        	$this->visitorId = $visitorId;
        	$this->applicationDateCompletePre = $dpre;
        	$this->applicationDateCompletePost = $dpost;

        }
    }
}