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
		/* desc This update replaces the generic update because this table has a two-component primary key
	 * param data This shall be an array containing as key exactly the same name as the column in the data ase
	 *
	 */
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
            }
            return false;
        }
    }
	
	public static function getApplicationDateCompleteByVisitorId($visitorId){
		try{
			$sql  = "SELECT applicationId FROM ApplicationDateComplete WHERE visitorId=:visitorId";
			$prep = Model::$pdo->prepare($sql);
			

			$values = array(
				"visitorId" => $visitorId
				);

			$prep-> execute($values);
			$prep->setFetchMode(PDO::FETCH_ASSOC);
			
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
