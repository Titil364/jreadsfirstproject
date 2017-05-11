<?php
require_once File::build_path(array('model', 'ModelAssoc.php'));

class ModelAnswer extends ModelAssoc{

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

    /* desc Return the form quesiton's answer of a visitor
	 * param visitorId The id of the visitor 
	 *
	 */
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
	
	public static function getAnswerByQuestionId($questionId){
		try {
			$sql = "SELECT answer FROM Answer WHERE questionId=:questionId AND answer is not null";
			$prep = Model::$pdo->prepare($sql);
			
			$values = array(
			"questionId" => $questionId,
			);

			$prep-> execute($values);
			$prep->setFetchMode(PDO::FETCH_BOTH);
			
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
        
            public static function delete($primary1,$primary2) {
        try {
            $table_name = static::$object;
            $class_name = 'Model' . $table_name;
			
			
            $sql = "DELETE FROM $table_name WHERE visitorId=:v AND questionId =:q";
			
            $req_prep = Model::$pdo->prepare($sql);
			
            $values = array(
                "v" => $primary1,
                "q" => $primary2
            );
			
            $req_prep->execute($values);
            return true;
			
        } catch (PDOException $ex) {
            if (Conf::getDebug()) {
                echo $ex->getMessage();
            } else {
                echo "Error while deleting the object";
            }
            return false;
        }
    }

}

