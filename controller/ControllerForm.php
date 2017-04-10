<?php

require_once File::build_path(array('model', 'ModelForm.php'));

class ControllerForm {
    public static function welcome() {
        $view = 'index';
        $controller = 'default';
        $pagetitle = 'Create Form';
        require File::build_path(array('view', 'view.php'));
    }
    
    public static function read(){
        $f = ModelForm::select($_GET['id']);
        if (!$f){
            // error page
        }else{
            $pagetitle = 'Formulaire';
            $view='formDisplay';
            $controller = 'form';
            require File::build_path(array('view','view.php'));
        }
    }
       
	
}
?>