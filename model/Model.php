<?php
require_once File::build_path(array('config', 'config.php'));

class Model {
	
	public static $pdo;
    private static $hostname;
    private static $database_name;
    private static $login;
    private static $password;
	
    public static function Init() {
        $hostname = Conf::getHostName();
        $database_name = Conf::getDatabaseName();
        $login = Conf::getLogin();
        $password = Conf::getPassword();
        try {
            self::$pdo = new PDO("mysql:host=$hostname;dbname=$database_name", $login, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage(); // affiche un message d'erreur
            } else {
                echo 'Error. ';
            }
            die();
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
            $primary_key = static::$primary;
            $sql = $sql . " WHERE $primary_key=:$primary_key;";
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
	
    public static function selectAll() {
        try {
            $table_name = static::$object;
            $class_name = 'Model' . $table_name;
			
            $sql = "SELECT * FROM $table_name;";
            $req_prep = Model::$pdo->query($sql);
            $req_prep->setFetchMode(PDO::FETCH_CLASS, $class_name);
            $tab_p = $req_prep->fetchAll();
            if (empty($tab_p)) {
                return false;
            }
            return $tab_p;
        }catch (PDOException $ex) {
            if (Conf::getDebug()) {
                echo $ex->getMessage();
            } else {
                echo "Error. We can not find the objects. ";
            }
            return false;
        }
    }
    public static function select($primary) {
        try {
            $table_name = static::$object;
            $class_name = 'Model' . $table_name;
            
            
            $primary_key = static::$primary;

            $sql = "SELECT * FROM $table_name WHERE $primary_key=:p;";
            $req_prep = Model::$pdo->prepare($sql);
			
            $values = array(
                "p" => $primary
            );
			
            $req_prep->execute($values);
            $req_prep->setFetchMode(PDO::FETCH_CLASS, $class_name);
            $tab_p = $req_prep->fetchAll();
			
            if (empty($tab_p)) {
                return false;
            }
            return $tab_p[0];
			
        } catch (PDOException $ex) {
            if (Conf::getDebug()) {
                echo $ex->getMessage();
            } else {
                echo "Error. We can not find the object. ";
            }
            return false;
        }
    }
    public static function delete($primary) {
        try {
            $table_name = static::$object;
            $class_name = 'Model' . $table_name;
			
            $primary_key = static::$primary;
			
            $sql = "DELETE FROM $table_name WHERE $primary_key=:p";
			
            $req_prep = Model::$pdo->prepare($sql);
			
            $values = array(
                "p" => $primary
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
	
    public static function save($data) {
        try {
            $table_name = static::$object;
        
            $class_name = 'Model' . $table_name;
            $sql = "INSERT INTO $table_name (";
            
            foreach ($data as $cle => $valeur) {
                $sql = $sql . $cle . ", ";
            }
            
            $sql =  rtrim($sql, " ,") . ") VALUES(";
            foreach ($data as $cle => $valeur) {
                $sql = $sql . ":" . $cle . ", ";
            }
            $sql = rtrim($sql, " ,") . ");";
            
			
            $req_prep = Model::$pdo->prepare($sql);
            $req_prep->execute($data);
            return true;
        } catch (PDOException $ex) {
            if (Conf::getDebug()) {
                echo $ex->getMessage();
            } else {
                echo "Error while saving the object. ";
            }
            return false;
        }
    }
	public static function beginTransaction(){
		self::$pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, false);	
		return Model::$pdo->beginTransaction();
	}
	public static function commit() {
		$ans = Model::$pdo->commit();
		self::$pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, true);
		return $ans;
	}
	public static function rollback(){
		$ans = Model::$pdo->rollback();
		self::$pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, true);
		return $ans;
	}
	
	public static function getLastInsert(){
		try{
			// Doesn't work on all the data base
			return Model::$pdo->lastInsertId();

		}catch (PDOException $ex) {
            if (Conf::getDebug()) {
                echo $ex->getMessage();
            } else {
                echo "Error";
            }
            return false;
        }
    }
}
Model::Init();


?>