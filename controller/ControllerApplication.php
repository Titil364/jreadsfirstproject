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
			echo move_uploaded_file($_FILES['file']['tmp_name'], "media/".$_FILES['file']['name']);
    }
	
	public static function getApplicationCount($fromId){
		
		$application = ModelApplication::getApplicationByFormId($formId);
		$rep = 0;
		foreach($application as $value){
			$rep++;
		}
		echo($rep);
		echo json_encode($rep);
	}
	
	
}
?>