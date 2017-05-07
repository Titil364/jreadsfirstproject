<?php
require_once File::build_path(array('model', 'Model.php'));


class ModelVisitor extends Model{
	private $visitorId;
	private $visitorSecretName;
	private $dateCompletePre;
	private $dateCompletePost;
	private $formId;
	private $applicationOrder;

    protected static $object = "Visitor";
    protected static $primary = 'visitorId';

    public function getVisitorId(){return $this->visitorId;}
    public function setVisitorId($visitorGroupId){$this->visitorId = $visitorId;}
	
    public function getVisitorSecretName(){return $this->visitorSecretName;}
    public function setVisitorSecretName($visitorSecretName){$this->visitorSecretName = $visitorSecretName ;}
	
    public function getDateCompletePre(){return $this->dateCompletePre;}
    public function setDateCompletePre($dateCompletePre){$this->dateCompletePre = $dateCompletePre ;}
	
	public function getDateCompletePost(){return $this->dateCompletePost;}
    public function setDateCompletePost($dateCompletePost){$this->dateCompletePost = $dateCompletePost;}
	
	public function getFormId(){return $this->formId;}
    public function setFormId($formId){$this->formId = $formId;}
	
	public function getApplicationOrder(){return $this->applicationOrder;}
    public function setApplicationOrder($applicationOrder){$this->applicationOrder = $applicationOrder;}
	
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



    public function __construct($visitorId = NULL, $visitorSecretName = NULL, $dateCompletePre = NULL, $dateCompletePost = NULL, $formId = NULL, $applicationOrder = NULL) {
        if (!is_null($visitorId) && !is_null($visitorSecretName) && !is_null($dateCompletePre) && !is_null($dateCompletePost) && !is_null($formId) && !is_null($applicationOrder)){
			$this->visitorId = $visitorId;
			$this->visitorSecretName = $visitorSecretName;
			$this->dateCompletePre = $dateCompletePre;
			$this->dateCompletePost = $dateCompletePost;
			$this->formId = $formId;
			$this->applicationOrder = $applicationOrder;
        }
    }
	
	/* desc Return if a visitor already exists (checking if the secret name is already in the database)
	 *
	 * return 1 if the visitor exists, else 0
	 */
	public static function checkExistingVisitor($visitorSecretName){
		try{	
			$sql = "SELECT COUNT(*) FROM Visitors WHERE visitorSecretName=:visitorSecretName";
			$prep = Model::$pdo->prepare($sql);
			$values = array(
				'visitorSecretName' => $visitorSecretName
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
	
	/* desc Return 0, 1 or -1 if the visitor has completed the application
	 *
	 * return 0 if he doesn't fill the pre, 1 for the post and -1 if he has finished to fill the two parts
	 */
	public function getApplicationPreOrPost($applicationId){
		try{	
			$sql = "SELECT * FROM ApplicationDateComplete WHERE applicationId=:applicationId and visitorId=:visitorId";
			$prep = Model::$pdo->prepare($sql);
			$values = array(
				'applicationId' => $applicationId,
				'visitorId' => $this->visitorId
			);
			$prep -> execute($values);
			$prep -> setFetchMode(PDO::FETCH_CLASS, "ModelApplicationDateComplete");
			$result = $prep->fetchAll();
			$result = $result[0];
			if($result != null){
				if($result->getApplicationDateCompletePre() != null){
					if($result->getApplicationDateCompletePost() != null){
						return -1;
					}else{
						return 0;
					}
				}else{
					return 1;
				}
			}else{
				return false;
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