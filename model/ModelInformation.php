<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelInformation extends Model{

	private $informationId;
	private $informationName;
        private $personnalInformationId;
	
    protected static $object = "Information";
    protected static $primary = "informationId";
    
    public function getInformationId(){return $this->InformationId;}
        public function setInformationId($informationId){$this->informationId = $informationId;}

    public function getPersonnalInformationName(){return $this->personnalInformationName;}
        public function setPersonnalInformationName($personnalInformationName){$this->personnalInformationName = $personnalInformationName;}
        
    public function getPersonnalInformationId(){return $this->personnalInformationId;}
        public function setPersonnalInformationId($personnalInformationId){$this->personnalInformationId = $personnalInformationId;}


    public function __construct($informationId = NULL,$informationName  = NULL, $personnalInformationId = NULL){
        if (!is_null($informationId) && !is_null($informationName) && !is_null($personnalInformationId)) {
        	$this->informationId = $informationId;
        	$this->informationName = $informationName;
                $this->personnalInformationId = $personnalInformationId;
        }
    }
}