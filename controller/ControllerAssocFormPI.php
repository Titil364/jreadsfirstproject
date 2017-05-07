<?php

require_once File::build_path(array('model', 'ModelAssocFormPI.php'));

class ControllerAssocFormPI{
	
	//JSON
	/* desc Unbind a form and a personnal information
	 *
	 */
	public static function delete(){
		if(isset($_POST['formId']) && isset($_POST['personnalInformationName'])){
			$data = array(
				"formId" =>  $_POST['formId'],
				"personnalInformationName" =>  $_POST['personnalInformationName']
			);
			echo json_encode(ModelAssocFormPI::delete($data));
		}else{
			echo json_encode(false);
		}
	}

}
?>