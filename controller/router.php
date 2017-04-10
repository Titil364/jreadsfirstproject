<?php
//Importation pattern
//require_once File::build_path(array('folder','file.php'));
require_once File::build_path(array('controller','ControllerDefault.php'));
require_once File::build_path(array('controller','ControllerForm.php'));


$action = "";

if(isset($_GET['action'])){
	$action = $_GET['action'];
}else if(isset($_POST['action'])){
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

if(File::isJson($controller) && File::isJson($action)){
	$controller = json_decode($controller);
	$action = json_decode($action);
}

$controllerClass = 'Controller' . ucfirst($controller);

		
if(class_exists($controllerClass)){
	if(in_array($action,  get_class_methods($controllerClass))){

		$controllerClass::$action();
	}
	else{
		//The action doesn't exist
	}
}else{
	//The controller doesn't exist
}

?>