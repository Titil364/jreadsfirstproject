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
	
	public static function select($data){
		        try {
            $table_name = static::$object;
            $class_name = 'Model' . $table_name;

			$primary_key1 = static::$primary1;
			$primary_key2 = static::$primary2;
			
            $sql = "SELECT * FROM Answer WHERE $primary_key1=:$primary_key1 AND $primary_key2=:$primary_key2;";

            $req_prep = Model::$pdo->prepare($sql);
            $req_prep->execute($data);
            $req_prep->setFetchMode(PDO::FETCH_CLASS, $class_name);
            $tab_p = $req_prep->fetchAll();
			
            if(empty($tab_p)){
                return false;
            }
            return $tab_p[0];
        } catch (PDOException $ex) {
            if (Conf::getDebug()) {
                echo $ex->getMessage();
            }
            return false;
        }
	}
}

