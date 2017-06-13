<?php

require_once File::build_path(array('model', 'ModelApplication.php'));

class ControllerApplication {
	
	/* desc Save the file which has been sent to the current user folder
	 * trigger Use when ?
	 */
	public static function saveImg(){
		if(Session::is_connected()){
			if(isset($_GET['formId'])){
				$f = ModelForm::select($_GET['formId']);
				$folder = $f->getUserNickname();
			}else{
				$folder = $_SESSION['nickname'];
			}
			//var_dump("media/".$folder."/".$_FILES['file']['name']);
			echo move_uploaded_file($_FILES['file']['tmp_name'], "media/".$folder."/".$_FILES['file']['name']);
		}		
    }
	
	
	//JSON
	/* @author Alexandre Comas
	 * function used to count the application in the JS
	 */
	public static function getApplicationCount(){
		$formId = json_decode($_GET['formId']);
		$application = ModelApplication::getApplicationByFormId($formId);
		$ApplicationName = array();
		foreach($application as $value){
			$name = $value->getApplicationName();
			$ApplicationName[] = $name;
		}
		echo json_encode($ApplicationName);
	}
	
	
}
?>