<?php

require_once File::build_path(array('model', 'ModelPersonnalInformation.php'));

class ControllerPersonnalInformation {
	public static function predefinedInformation(){
		$var = ModelPersonnalInformation::getDefaultPersonnalInformation();
		echo json_encode($var);
	}
}
?>