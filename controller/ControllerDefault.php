<?php
class ControllerDefault {
	
    public static function welcome() {
        $view = 'welcome';
        $controller = 'default';
        $pagetitle = 'Welcome';
		$stylesheet = "welcome";
		$jscript = "welcome";
		if(Session::is_connected()){
			ControllerUsers::displaySelf();
		}else{
			require File::build_path(array('view', 'view.php'));
		}
    }
	
	public static function message($data){
		$view = "message";
		$controller = "default";
		$pagetitle = $data["pagetitle"];
		
		$message = htmlspecialchars($data["message"]);
		
		if(!isset($data["url"])){
			$data["url"] = "index.php";
		}
		
		if(!isset($data["button"])){
			$data["button"] = "Return to the home page";
		}
		
		$url = htmlspecialchars($data["url"]);
		$button = htmlspecialchars($data["button"]);
		
		require File::build_path(array('view', 'view.php'));
	}
	
}
?>