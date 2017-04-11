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
		
		$users = array(
				"userMail" => $_POST['userMail'],
				"userPassword" => $_POST['userPassword'],
				"userNickname" => $_POST['userNickname'],
				"userSurname" => $_POST['userSurname'],
				"userForname" => $_POST['userForname']
			);
		ModelUsers::save($users);
		require File::build_path(array('view', 'view.php'));
	}
	
	/*public static function update() {
        $view = 'profileUsers';
        $controller = 'users';
        $pagetitle = 'Profile';
		
		$information = ModelUsers::select('1');
		foreach ($information as $value){
			echo $value;
		}
        require File::build_path(array('view', 'view.php'));
    }*/
	public static function update() {
       // if (isset($_SESSION[''])) {
            //$checkBoxAdmin = ControllerUsers::setCheckBox();
            $view = 'profileUsers';
            $pagetitle = 'Update';
            $controller = 'users';
			$information = ModelUsers::select('17');
			$data = array(
				"nickname" => $information->getNickName(),
				"surname" => $information->getSurName(),
                "forname" => $information->getForName(),
                "mail"  => $information->getMail()
			);
			echo $data["nickname"];
			require File::build_path(array('view', 'view.php'));
			/*
            $data = array(
                "nickName" => htmlspecialchars($information['nickname']),
                "fName" => htmlspecialchars($information['firstName']),
                "lName" => htmlspecialchars($information['lastName']),
                "mail"  => htmlspecialchars($information['mail'])
            );
            require File::build_path(array('view', 'view.php'));
      /*} else {
			$data = array();
			$data['error'] = "Please log in";
			$data['view'] = 'connectUsers';
			$data['controller'] = 'users';
            ControllerDefault::error($data);
        }*/
    }
	
	public static function connect(){
		$view = 'connectUsers';
        $controller = 'users';
        $pagetitle = 'Connect';
		
        require File::build_path(array('view', 'view.php'));
	}
	
	public static function existingUser(){
		$nick = $_POST['userNickname'];
		$var = json_decode($nick);
		$rep = ModelUsers::checkExistingUser($var);
		$return = json_encode($rep);
		echo($return);
	}
}
?>