<?php
require_once File::build_path(array('model', 'ModelAssoc.php'));

class ModelInformation extends ModelAssoc{

	private $personnalInformationName;
	private $informationName;
	private $visitorId;
	
    protected static $object = "Information";
    protected static $primary1 = "personnalInformationName";
	protected static $primary2 = "visitorId";
    
    public function getPersonnalInformationName(){return $this->personnalInformationName;}
        public function setInformationId($personnalInformationName){$this->informationId = $personnalInformationName;}

    public function getInformationName(){return $this->informationName;}
        public function setInformationName($informationName){$this->informationName = $informationName;}
        
    public function getVisitorId(){return $this->visitorId;}
        public function setVisitorId($visitorId){$this->visitorId = $visitorId;}


    public function __construct($personnalInformationName = NULL,$informationName  = NULL, $visitorId = NULL){
        if (!is_null($personnalInformationName) && !is_null($informationName) && !is_null($visitorId)) {
        	$this->personnalInformationName = $personnalInformationName;
        	$this->informationName = $informationName;
            $this->visitorId = $visitorId;
        }
    }
	
	/* desc Return the information the visitor gave through the form
	 * param visitorId The id of the visitor
	 */
	public static function getInformationByVisitorId($visitorId){
		try{
			$sql = "Select * From Information Where Information.visitorId=:visitorId";
			$prep = Model::$pdo->prepare($sql);

			$values = array(
				"visitorId" => $visitorId,
				);

			$prep-> execute($values);
			$prep->setFetchMode(PDO::FETCH_CLASS, 'ModelInformation');
			
			return $prep->fetchAll();
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
