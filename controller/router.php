<?php
//Importation pattern
//require_once File::build_path(array('folder','file.php'));
require_once File::build_path(array('lib','Security.php'));
require_once File::build_path(array('lib','Session.php'));
require_once FILE::build_path(array('lib', 'TCPDFImport.php'));

require_once File::build_path(array('controller','ControllerDefault.php'));

require_once File::build_path(array('controller','ControllerUsers.php'));
require_once File::build_path(array('controller','ControllerForm.php'));
require_once File::build_path(array('controller','ControllerApplication.php'));
require_once File::build_path(array('controller','ControllerQuestion.php'));
require_once File::build_path(array('controller','ControllerQuestionType.php'));
require_once File::build_path(array('controller','ControllerAnswerType.php'));
require_once File::build_path(array('controller','ControllerFSQuestion.php'));
require_once File::build_path(array('controller','ControllerVisitor.php'));
require_once File::build_path(array('controller','ControllerAnswer.php'));

require_once File::build_path(array('controller','ControllerInformation.php'));
require_once File::build_path(array('controller','ControllerPersonnalInformation.php'));
require_once File::build_path(array('controller','ControllerAssocFormPI.php'));
require_once File::build_path(array('controller','ControllerAssocFormFS.php'));





$action = "";

if(isset($_GET['action'])){
	$action = $_GET['action'];
}else if(isset
($_POST['action'])){
	$action = $_POST['action'];
}
else{
	//default action
	$action = 'welcome';
}

$controller = "";
if(isset($_GET['controller'])){
	$controller = $_GET['controller'];
}else if(isset($_POST['controller'])){
	$controller = $_POST['controller'];
}
else{
	//default controller
	$controller = 'default';
}


//Checking if the controller or the action is in JSON format just in case
if(File::isJson($controller) && File::isJson($action)){
	$controller = json_decode($controller);
	$action = json_decode($action);
}

$controllerClass = 'Controller' . ucfirst($controller);

	//echo $controllerClass . "<br>" . $action;		
if(class_exists($controllerClass)){

	if(in_array($action,  get_class_methods($controllerClass))){

		$controllerClass::$action();
	}
	else{
		$data["message"] = "The action doesn't exist. ";
		$data["pagetitle"] = "Action not found";
		
		ControllerDefault::message($data);	
	}
}else{
	$data["message"] = "The controller doesn't exist. ";
	$data["pagetitle"] = "Controller not found";
	
	ControllerDefault::message($data);	
}

?>