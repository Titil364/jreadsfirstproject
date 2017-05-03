<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelPersonnalInformation extends Model{

	private $personnalInformationName;
	private $defaultPersonnalInformation;
	
    protected static $object = "PersonnalInformation";
    protected static $primary = "personnalInformationName";
   

    public function getPersonnalInformationName(){return $this->personnalInformationName;}
        public function setPersonnalInformationName($personnalInformationName){$this->personnalInformationName = $personnalInformationName;}


    public function __construct($personnalInformationName  = NULL, $def = NULL){
        if (!is_null($personnalInformationName) && !is_null($def)) {
        	$this->personnalInformationName = $personnalInformationName;
			$this->defaultPersonnalInformation = $def;
        }
    }
	
	/* desc Return the default personnal information the user (predefined fields when creating the form)
	 *
	 */
	public static function getDefaultPersonnalInformation(){
		try{
			$sql  = "SELECT personnalInformationName FROM PersonnalInformation WHERE defaultPersonnalInformation=:d";
			$prep = Model::$pdo->prepare($sql);
                        
			$values = array(
				"d" => 1
				);
                        
			$prep-> execute($values);
			$prep->setFetchMode(PDO::FETCH_NUM);
                        
			$default_info = $prep->fetchAll();

			return $default_info;

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