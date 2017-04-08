<?php
class ControllerDefault {
	
    public static function welcome() {
        $view = 'createForm';
        $controller = 'default';
        $pagetitle = 'Create Form';
        require File::build_path(array('view', 'view.php'));
    }
	
}
?>