<?php

require_once File::build_path(array('model', 'ModelApplication.php'));

class ControllerApplication {
	
    public static function created(){
        $view = 'index';
        $controller = 'default';
        $pagetitle = 'Create Form';
        require File::build_path(array('view', 'view.php'));
    }
	
}
?>