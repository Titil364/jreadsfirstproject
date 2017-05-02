<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelAnswer extends Model{

	private $visitorId;
	private $questionId;
	private $answer;
	
    protected static $object = "Answer";
    protected static $primary1 = "questionId";
	protected static $primary2 = "visitorId";
    
    public function getVisitorId(){return $this->visitorId;}
	public function setVisitorId($visitorId){$this->visitorId = $visitorId;}

    public function getQuestionId(){return $this->questionId;}    
	public function setQuestionId($questionId){$this->questionId = $questionId;}

    public function getAnswer(){return $this->answer;}
	public function setAnswer($answer){$this->answer = $answer;}
	
    public function __construct($atId = NULL, $atIm = NULL, $ans = NULL){
        if (!is_null($atId) && !is_null($atIm) && !is_null($ans)){
        	$this->visitorId = $atId;
        	$this->questionId = $atIm;
			$this->answer = $ans;
        }
   }
   
	public static function getAnswerByVisitorId($visitorId){
		try {
			$sql = "SELECT * FROM Answer WHERE Answer.visitorId=:visitorId"; 
			$prep = Model::$pdo->prepare($sql);
			
			$values = array(
			"visitorId" => $visitorId,
			);

			$prep-> execute($values);
			$prep->setFetchMode(PDO::FETCH_CLASS,'ModelAnswer');
			
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

