<?php
require_once File::build_path(array('model', 'Model.php'));


class ModelUsers extends Model{
	private $userMail;
	private $userPassword;
    private $userNickname;
    private $userSurname;
    private $userForename;
    private $userNonce;
	private $isAdmin;
    protected static $object = "Users";
    protected static $primary = 'userNickname';
	
	
	public function getId(){return $this->userId;}
	
    public function getNonce(){return $this->userNonce;}
	public function setNonce($nonce){$this->userNonce = $nonce;}
	
	
    public function getNickname(){return $this->userNickname;}
    public function setNickname($nickName){$this->userNickname = $nickName;}	
	
    public function getSurname() {return $this->userSurname;}
	public function setSurname($firstName){$this->userSurname = $firstName;}
	
    public function getForename(){return $this->userForename;}
	public function setForename($lastName){$this->userForename = $lastName;}
	
    public function getMail(){return $this->userMail;}
	public function setMail($mail){$this->userMail = $mail;}
    


	public function getIsAdmin(){return $this->isAdmin;}
    public function setIsAdmin($isAdmin){$this->isAdmin = $isAdmin;}
    

	
    public static function getSeed() {
        return self::$seed;
    }
    public function __construct($id = NULL, $mail = NULL, $pwd = NULL, $nickname = NULL, $surname = NULL, $forename = NULL, $nonce = NULL, $isAdmin = NULL) {
        if (!is_null($id) && !is_null($nickname) && !is_null($forename) && !is_null($surname) && !is_null($mail)&& !is_null($pwd) && !is_null($nonce) && !is_null($isAdmin)) {
            $this->userId = $id;
			$this->userNickname = $nickname;
            $this->userSurname= $surname;
            $this->userForename = $forename;
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
			    $query = "SELECT * FROM Users WHERE userNickname=:nickn AND userPassword=:pwd";
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
	public static function getMyForms($nick) {           
		try {
			$query = "SELECT * FROM Form WHERE userNickname=:nickn";
			$prep = Model::$pdo->prepare($query);
			$values = array(
				'nickn' => $nick
			);
			$prep->execute($values);
			$prep->setFetchMode(PDO::FETCH_CLASS,'ModelForm');
			$res = $prep->fetchAll();
			return $res;
		} catch (PDOException $ex) {
			if (Conf::getDebug()) {
				echo $ex->getMessage();
			} else {
				echo "une erreur est survenue.";
			}
			return NULL;
		}
    }
	
	public static function getCreatorUsers(){

		try {
			$query = "SELECT U.userNickname, U.userSurname, U.userForename FROM Users U JOIN Form F ON F.userNickname = U.userNickname;";
			$prep = Model::$pdo->prepare($query);
			$prep->execute();
			$prep->setFetchMode(PDO::FETCH_CLASS,'ModelUsers');
			$res = $prep->fetchAll();
			return $res;
		} catch (PDOException $ex) {
			if (Conf::getDebug()) {
				echo $ex->getMessage();
			} else {
				echo "une erreur est survenue.";
			}
			return NULL;
		}
	}
}
?>