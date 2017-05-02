<?php
require_once File::build_path(array('model', 'Model.php'));


class ModelVisitor extends Model{
	private $visitorId;
	private $visitorSecretName;
	private $dateCompletePre;
	private $dateCompletePost;
	private $preDone;
	private $formId;

    protected static $object = "Visitor";
    protected static $primary = 'visitorId';

    public function getVisitorId() {
   		return $this->visitorId;
    }
	
    public function getVisitorSecretName(){
    	return $this->visitorSecretName;
    }
	
    public function getDateCompletePre(){
		return $this->dateCompletePre;
	}
	
	public function getDateCompletePost(){
		return $this->dateCompletePost;
	}
	
	public function getFormId(){
		return $this->formId;
	}
	public function getPreDone(){
		return $this->preDone;
	}
	
	public function getVisitorA($a){
		switch ($a){
			case "Id":
				return $this->visitorId;
			case "SecretName":
				return $this->visitorSecretName;
			case "dateCompletePre":
				return $this->dateCompletePre;
			case "dateCompletePost":
				return $this->dateCompletePost;
			case "formId":
				return $this->formId;
		}
	}

    public function setVisitorId($visitorGroupId) {
   		$this->visitorId = $visitorId ;
    }

    public function setVisitorSecretName($visitorSecretName){
    	$this->visitorSecretName = $visitorSecretName ;
    }
	
    public function setDateCompletePre($dateCompletePre){
    	$this->dateCompletePre = $dateCompletePre ;
    }
	
    public function setDateCompletePost($dateCompletePost){
    	$this->dateCompletePost = $dateCompletePost ;
    }

    public function setFormId($formId){
    	$this->formId = $formId ;
    }
	public function setPreDone($preDone){
    	$this->preDone= $preDone;
    }
	

    public function __construct($visitorId = NULL, $visitorSecretName = NULL, $dateCompletePre = NULL, $dateCompletePost = NULL, $formId = NULL, $preDone = NULL) {
        if (!is_null($visitorId) && !is_null($visitorSecretName) && !is_null($dateCompletePre) && !is_null($dateCompletePost) && !is_null($formId) && !is_null($preDone)) {

			$this->visitorId = $visitorId;
			$this->visitorSecretName = $visitorSecretName;
			$this->dateCompletePre = $dateCompletePre;
			$this->dateCompletePost =$dateCompletePost;
			$this->formId =$formId;
			$this->preDone= $preDone;
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
}