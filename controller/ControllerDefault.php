<?php
class ControllerDefault {
	
    public static function welcome() {
        $view = 'createForm';
        $controller = 'default';
        $pagetitle = 'Create Form';
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