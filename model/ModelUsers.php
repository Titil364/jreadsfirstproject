<?php
require_once File::build_path(array('model', 'Model.php'));


class ModelUsers extends Model{
    private $userId;
	private $userMail;
	private $userPassword;
    private $suerNickname;
    private $userSurname;
    private $userForname;
    private $userNonce;
	private $isAdmin;
    protected static $object = "Users";
    protected static $primary = 'userId';
	
	
	public function getId(){return $this->userId;}
	
    public function getNonce(){return $this->userNonce;}
	public function setNonce($nonce){$this->userNonce = $nonce;}
    
    public function getPassword(){return $this->userPassword;}
	
	
    public function getNickname(){return $this->userNickname;}
    public function setNickname($nickName){$this->userNickname = $nickName;}	
	
    public function getSurname() {return $this->userSurname;}
	public function setSurname($firstName){$this->userSurname = $firstName;}
	
    public function getForname(){return $this->userForname;}
	public function setForname($lastName){$this->userForname = $lastName;}
	
    public function getMail(){return $this->userMail;}
	public function setMail($mail){$this->userMail = $mail;}
    


	public function getIsAdmin(){return $this->isAdmin;}
    public function setIsAdmin($isAdmin){$this->isAdmin = $isAdmin;}
    

	
    public static function getSeed() {
        return self::$seed;
    }
    public function __construct($id = NULL, $mail = NULL, $pwd = NULL, $nickName = NULL, $surName = NULL, $forName = NULL, $nonce = NULL, $isAdmin = NULL) {
        if (!is_null($id) && !is_null($nickName) && !is_null($forName) && !is_null($surName) && !is_null($mail)&& !is_null($pwd) && !is_null($nonce) && !is_null($isAdmin)) {
            $this->userId = $id;
			$this->userNickname = $nickName;
            $this->userSurname= $surName;
            $this->userForname = $forName;
            $this->userMail = $mail;
            $this->userPassword = $pwd;
            $this->userNonce = $nonce;
			$this->isAdmin = $isAdmin;
        }
    }
	
	public static function checkExistingUser($nickname){
		try{	
			$sql = "SELECT COUNT(*) FROM Users WHERE userNickname=:nickname";
			$prep = Model::$pdo->prepare($sql);
			$values = array(
				'nickname' => $nickname
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
    
    public static function checkPassword($nick, $pass) {
        try {
			$query = "SELECT userNickname, userNonce FROM Users WHERE userNickname=:nickn and userPassword=:pwd";
            $prep = Model::$pdo->prepare($query);
            $values = array(
                'nickn' => $nick,
                'pwd' => $pass
            );
            $prep->execute($values);
            $result = $prep->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $ex) {
            if (Conf::getDebug()) {
                echo $ex->getMessage();
            } else {
                echo "Error";
            }
            return false;
        }
    }
    public static function connect($nick, $pass) {
        $result = ModelUsers::checkPassword($nick, $pass);
        if ($result['userNickname'] == $nick){// && $result['userNonce'] == NULL) {
           
            try {
			    $query = "Select * From Users Where userNickname=:nickn and userPassword=:pwd";
                $prep = Model::$pdo->prepare($query);
                $values = array(
                    'nickn' => $nick,
                    'pwd' => $pass,
                );
                $prep->execute($values);
                $prep->setFetchMode(PDO::FETCH_CLASS,'ModelUsers');
                $res = $prep->fetch();
                return $res;
            } catch (PDOException $ex) {
                if (Conf::getDebug()) {
                    echo $ex->getMessage();
                } else {
                    echo "une erreur est survenue.";
                }
                return NULL;
            }
        } else{
            return NULL;
        }
    }
}
?>