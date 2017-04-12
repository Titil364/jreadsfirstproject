<?php
class ControllerDefault {
	
    public static function welcome() {
        $view = 'welcome';
        $controller = 'default';
        $pagetitle = 'Welcome';
		$stylesheet = "welcome";
        require File::build_path(array('view', 'view.php'));
    }
	
	public static function error($data){
		$view = $data['view'];
		$controller = $data['controller'];
		$view = $view.'.php';
		require File::build_path(array('view',$controller,$view));
	}
	
}
?>