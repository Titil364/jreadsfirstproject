<?php

require_once File::build_path(array('model', 'ModelPersonnalInformation.php'));

class ControllerPersonnalInformation {
	
	/* desc Send the default predefined information encoded in JSON
	 * trigger Use when ?
	 * additional information Use for what ?
	 */
	public static function predefinedInformation(){
		$var = ModelPersonnalInformation::getDefaultPersonnalInformation();
		echo json_encode($var);
	}
}
?>