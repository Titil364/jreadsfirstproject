<?php

require_once File::build_path(array('model', 'ModelApplication.php'));

class ControllerApplication {
	
    public static function created(){
        $view = 'index';
        $controller = 'default';
        $pagetitle = 'Create Form';
        require File::build_path(array('view', 'view.php'));
    }
	public static function saveImg(){
		if(Session::is_connected())
			echo move_uploaded_file($_FILES['file']['tmp_name'], "media/".$_SESSION['nickname']."/".$_FILES['file']['name']);
    }
	
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