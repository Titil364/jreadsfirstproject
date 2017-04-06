<?php

require_once File::build_path(array('model', 'ModelForm.php'));

class ControllerForm {
	
    public static function welcome() {
        $view = 'index';
        $controller = 'default';
        $pagetitle = 'Create Form';
        require File::build_path(array('view', 'view.php'));
    }
	
}
?>