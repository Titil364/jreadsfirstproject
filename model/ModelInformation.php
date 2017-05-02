<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelInformation extends Model{

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
}