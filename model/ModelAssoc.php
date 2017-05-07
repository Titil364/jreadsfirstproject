<?php
require_once File::build_path(array('config', 'config.php'));

class ModelAssoc extends Model {
	

	
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

	
    public static function delete($data) {
        try {
            $table_name = static::$object;
			
 			$primary_key1 = static::$primary1;
			$primary_key2 = static::$primary2;
			
			
            $sql = "DELETE FROM $table_name WHERE $primary_key1=:$primary_key1 and $primary_key2=:$primary_key2;";
			
            $req_prep = Model::$pdo->prepare($sql);

			
            $req_prep->execute($data);
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

?>