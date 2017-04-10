<?php

require_once File::build_path(array('model', 'ModelUsers.php'));

class ControllerUsers {
	
    public static function welcome() {
        $view = 'createUsers';
        $controller = 'users';
        $pagetitle = 'Sign in';
		
        require File::build_path(array('view', 'view.php'));
    }
	
	public static function	created(){
		$view = 'createdUsers';
        $controller = 'users';
        $pagetitle = 'User Created !';
	}
	
	public static function existingUser($user){
		alert("niquetamere");
		echo(json_encode("salut"));
	}
}
?>