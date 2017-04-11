<?php
require_once File::build_path(array('model', 'Model.php'));


class ModelUsers extends Model{
    private $id;
	private $mail;
	private $password;
    private $nickName;
    private $surName;
    private $forName;
    private $nonce;
    protected static $object = "Users";
    protected static $primary = 'userId';
	
	
	public function getId(){
		return $this->id;
	}
    public function getNonce() {
        return $this->nonce;
    }
    
    public function getPassword() {
        return $this->password;
    }
    public function getNickName() {
        return $this->nickName;
    }
    public function getSurName() {
        return $this->surName;
    }
    public function getForName() {
        return $this->forName;
    }
    public function getMail() {
        return $this->mail;
    }
    public function getBirthDate() {
        return $this->birthDate;
    }
    public function getIsAdmin() {
        return $this->isAdmin;
    }
    public function setNickName($nickName) {
        $this->nickName = $nickName;
    }
    public function setSurName($firstName) {
        $this->surName = $firstName;
    }
    public function setForName($lastName) {
        $this->ForName = $lastName;
    }
    public function setMail($mail) {
        $this->mail = $mail;
    }
    public function setBirthDate($birthDate) {
        $this->birthDate = $birthDate;
    }
    public function setIsAdmin($isAdmin) {
        $this->isAdmin = $isAdmin;
    }
    
    public function setNonce($nonce) {
        $this->nonce = $nonce;
    }
    public static function getSeed() {
        return self::$seed;
    }
    public function __construct($id = NULL, $mail = NULL, $pwd = NULL, $nickName = NULL, $surName = NULL, $forName = NULL, $nonce = NULL) {
		echo $id;
		echo $mail;
		echo $pwd;
		echo $nickName;
		echo $surName;
		echo $forName;
		echo $nonce;
        if (!is_null($id) && !is_null($nickName) && !is_null($forName) && !is_null($surName) && !is_null($mail)&& !is_null($pwd) && !is_null($nonce)) {
            $this->id = $id;
			$this->nickName = $nickName;
            $this->surName = $surName;
            $this->forName = $forName;
            $this->mail = $mail;
            $this->password = $pwd;
            $this->nonce = $nonce;
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
			$query = "SELECT nickName,nonce FROM Users WHERE nickName=:nickn and password=:pwd";
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
        if ($result['nickName'] == $nick && $result['nonce'] == NULL) {
           
            try {
			    $query = "Select * From Users Where nickName=:nickn and password=:pwd";
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