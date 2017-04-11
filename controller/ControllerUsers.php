<?php

require_once File::build_path(array('model', 'ModelUsers.php'));

class ControllerUsers {
	
    public static function create() {
        $view = 'createUsers';
        $controller = 'users';
        $pagetitle = 'Sign in';
		
        require File::build_path(array('view', 'view.php'));
    }
	
	public static function created(){
		$view = 'createdUsers';
        $controller = 'users';
        $pagetitle = 'User Created !';
		
		$hashpass = Security::encrypt($_POST['password']);
        $nonce = Security::generateRandomHex();
		
		$users = array(
				"userMail" => $_POST['userMail'],
				"userPassword" => $hashpass,
				"userNickname" => $_POST['userNickname'],
				"userSurname" => $_POST['userSurname'],
				"userForname" => $_POST['userForname'],
				"userNonce" => $nonce,
				"isAdmin" => 0
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
		if (Session::is_connected()) {
            //$checkBoxAdmin = ControllerUsers::setCheckBox();
            $view = 'profileUsers';
            $pagetitle = 'Update';
            $controller = 'users';
			$information = ModelUsers::select('17');
			$data = array(
				"nickname" => $information->getNickname(),
				"surname" => $information->getSurname(),
                "forname" => $information->getForname(),
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
    }
	
	public static function connect(){
		$view = 'connect';
        $controller = 'users';
        $pagetitle = 'Connect';
		
        require File::build_path(array('view', 'view.php'));
	}
	
	 public static function connected() {
		 
        $hashpass = Security::encrypt($_POST['password']);
        $user = ModelUsers::connect($_POST['nickname'], $hashpass);
		
        if ($user != NULL) {
            $view = 'connected';
            $controller = 'user';
            $pagetitle = 'Connecté';
            if ($user->getIsAdmin() == 1) {
                $_SESSION['admin'] = 1;
            } else {
                $_SESSION['admin'] = 0;
            }
            $nickname = $user->getNickname();
            $surname = $user->getSurname();
            $forname = $user->getForname();
            $mail = $user->getMail();
            Session::connect($nickname,$surname,$forname,$mail);

        } else {
			$data = array();
			$data['error'] = "Problème de connexion";
			$data['view'] = 'connect';
			$data['controller'] = 'user';
			$data['login'] = $_POST['nickname'];
            ControllerDefault::error($data);	
        }
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