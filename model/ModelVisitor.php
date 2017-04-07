<?php
require_once File::build_path(array('model', 'Model.php'));


class ModelVisitor extends Model{
	private $visitorId;
	private $visitorGroupId;
	private $visitorName;
	private $visitorSecretName;
	private $visitorSchool;
	private $visitorAge;
	private $visitorClass;

    protected static $object = "Visitor";
    protected static $primary = 'visitorSecretName';

    public function getVisitorId() {
   		return $this->visitorId;
    }    

    public function getVisitorGroupId() {
   		return $this->visitorGroupId;
    }

    public function getVisitorName(){
    	return $this->visitorName;
    }

    public function getVisitorSecretName(){
    	return $this->visitorSecretName;
    }
	
    public function getVisitorSchool(){
    	return $this->visitorSchool;
    }
	
    public function getVisitorAge(){
    	return $this->visitorAge;
    }

    public function getVisitorClass(){
    	return $this->visitorClass;
    }

    public function setVisitorId($visitorGroupId) {
   		$this->visitorId = $visitorId ;
    }

    public function setVisitorGroupId($visitorGroupId) {
   		$this->visitorGroupId = $visitorGroupId ;
    }

    public function setVisitorName($visitorName){
    	$this->visitorName = $visitorName ;
    }

    public function setVisitorSecretName($visitorSecretName){
    	$this->visitorSecretName = $visitorSecretName ;
    }
	
    public function setVisitorSchool($visitorSchool){
    	$this->visitorSchool = $visitorSchool ;
    }
	
    public function setVisitorAge($visitorAge){
    	$this->visitorAge = $visitorAge ;
    }

    public function setVisitorClass($visitorClass){
    	$this->visitorClass = $visitorClass ;
    }

    public function __construct( $visitorGroupId= NULL, $visitorName = NULL, $visitorSecretName = NULL, $visitorSchool = NULL, $visitorAge = NULL, $visitorClass = NULL) {
        if (!is_null($visitorGroupId) && !is_null($visitorName) && !is_null($visitorSecretName) && !is_null($visitorSchool) && !is_null($visitorAge) && !is_null($visitorClass)) {

        	$this->visitorGroupId = $visitorGroupId;
			$this->visitorName = $visitorName;
			$this->visitorSecretName = $visitorSecretName;
			$this->visitorSchool = $visitorSchool;
			$this->visitorAge = $visitorAge;
			$this->visitorClass = $visitorClass;        	
        }
    }

	public static function checkExistingVisitor($visitorSecretName){
		try{	
			$sql = "SELECT COUNT(*) FROM Visitors WHERE visitorSecretName=:visitorSecretName";
			$prep = Model::$pdo->prepare($sql);
			$values = array(
				':visitorSecretName' => $visitorSecretName
			);
			$prep -> execute($values);
			$prep -> setFetchMode(PDO::FETCH_NUM);
			$result = $prep->fetchAll();
			if($result[0][0]>=1){
				return 1;
			}else{
				return 0;
			}
		} catch (PDOException $ex) {
            if (Conf::getDebug()) {
                echo $ex->getMessage();
            } else {
                echo "Error";
            }
            return false;
        }
	}
/* The generic model will provide this function
	public static function findVisitorById($id){
		try{
			$sql  = "SELECT * FROM Visitors WHERE visitorId=:id";
			$prep = Model::$pdo->prepare($sql);

			$values = array(
				"id" => $id,
				);

			$prep-> execute($values);
			$prep->setFetchMode(PDO::FETCH_CLASS,'ModelVisitor');
			$visitor_array = $prep->fetchAll();
			
			return $visitor_array[0];
		}catch (PDOException $ex) {
            if (Conf::getDebug()) {
                echo $ex->getMessage();
            } else {
                echo "Error";
            }
            return false;
    */
	}