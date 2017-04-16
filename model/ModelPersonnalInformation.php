<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelPersonnalInformation extends Model{

	private $personnalInformationId;
	private $personnalInformationName;
	
    protected static $object = "PersonnalInformation";
    protected static $primary = "personnalInformationId";
    
    public function getPersonnalInformationId(){return $this->personnalInformationId;}
        public function setPersonnalInformationId($personnalInformationId){$this->personnalInformationId = $personnalInformationId;}

    public function getPersonnalInformationName(){return $this->personnalInformationName;}
        public function setPersonnalInformationName($personnalInformationName){$this->personnalInformationName = $personnalInformationName;}


    public function __construct($personnalInformationId = NULL,$personnalInformationName  = NULL){
        if (!is_null($personnalInformationId) && !is_null($personnalInformationName)) {
        	$this->personnalInformationId = $personnalInformationId;
        	$this->personnalInformationName = $personnalInformationName;
        }
    }
}