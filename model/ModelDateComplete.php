<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelDateComplete extends Model{

	private $dateCompletePre;
	private $dateCompletePost;
	private $visitorId;
	private $formId;
	
    protected static $object = "DateComplete";
    protected static $primary = "visitorId";


    public function getDateCompletePre(){return $this->dateCompletePre;} 
	public function setDateCompletePre($dateCompletePre){$this->dateCompletePre = $dateCompletePre;}    
	
	public function getDateCompletePost(){return $this->dateCompletePost;} 
	public function setDateCompletePost($dateCompletePost){$this->dateCompletePost = $dateCompletePost;}
	
	public function getVisitorId(){return $this->visitorId;} 
	public function setVisitorId($visitorId){$this->visitorId = $visitorId;}
	
	public function getFormId(){return $this->formId;} 
	public function setFormId($formId){$this->formId = $formId;}


    public function __construct($qpre = NULL, $qpost = NULL, $qn = NULL, $u = NULL){
        if (!is_null($qpre) && !is_null($qpost) && !is_null($qn) && !is_null($u)) {
        	$this->dateCompletePre = $qpre;
        	$this->dateCompletePost = $qpost;
        	$this->visitorId = $qn;
        	$this->formId = $u;
        }
    }
	
	public static function update($data) {
        try {
            $table_name = static::$object;
            $class_name = 'Model' . $table_name;
			$sql = "UPDATE DateComplete SET dateCompletePost=:dateCompletePost WHERE ";
			$sql = $sql . "visitorId=:visitorId and formId=:formId;";
			
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

