<?php

require_once File::build_path(array('model', 'ModelUsers.php'));

class ControllerUsers {
	public static function readAllMyForm() {
        $view = 'displayAllMyForms';
        $controller = 'users';
        $pagetitle = 'Create Form';
		
		if(Session::is_connected()){
			$form = ModelUsers::getMyForms($_SESSION['nickname']);
		}
        require File::build_path(array('view', 'view.php'));
    }
	
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
		
		$hashpass = Security::encrypt($_POST['userPassword']);
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
            $view = 'updateUsers';
            $pagetitle = 'Update';
            $controller = 'users';
			
			
			$data = array(
				"userNickname" => htmlspecialchars($_SESSION['nickname']),
				"userSurname" =>  htmlspecialchars($_SESSION['surname']),
                "userForename" => htmlspecialchars($_SESSION['forename']),
                "userMail"  => htmlspecialchars($_SESSION['mail'])
			);
			
			

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
	public static function updated() {
		
		if (Session::is_connected()) {
            $view = 'userProfil';
            $pagetitle = 'Updated';
            $controller = 'users';		
			
			$nickname = $_POST['userNickname'];
			$userForename = $_POST['userForename'];
			$userSurname = $_POST['userSurname'];
			$userMail = $_POST['userMail'];
			
			$hashpass = Security::encrypt($_POST['userPassword']);
			
			$data =  array(
				"userNickname" => $nickname,
				"userSurname" => $userSurname,
				"userForename" => $userForename,
				"userMail" => $userMail,
				"userPassword" => $hashpass
			);
			
			ModelUsers::update($data);
			Session::connect($nickname, $userForename, $userSurname, $userMail);
			
			require File::build_path(array('view', 'view.php'));
		}
	}
	
	public static function displaySelf() {
        $view = 'userProfil';
        $controller = 'users';
        $pagetitle = 'Profil';
		if(Session::is_connected()){
			$data = array(
				"nickname" => htmlspecialchars($_SESSION['nickname']),
				"surname" =>  htmlspecialchars($_SESSION['surname']),
				"forename" => htmlspecialchars($_SESSION['forename']),
				"mail"  => htmlspecialchars($_SESSION['mail'])
			);
		}
		else{
			echo "Error";
		}
        require File::build_path(array('view', 'view.php'));
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
            $controller = 'users';
            $pagetitle = 'Connecté';
            if ($user->getIsAdmin() == 1) {
                $_SESSION['admin'] = 1;
            } else {
                $_SESSION['admin'] = 0;
            }
            $nickname = $user->getNickname();
            $surname = $user->getSurname();
            $forename = $user->getForename();
            $mail = $user->getMail();
            Session::connect($nickname, $forename, $surname, $mail);

        } else {
			$data = array();
			$data['error'] = "Problème de connexion";
			$data['view'] = 'connect';
			$data['controller'] = 'users';
			$data['login'] = $_POST['nickname'];
            ControllerDefault::error($data);	
        }
		require File::build_path(array('view', 'view.php'));
    }
	
	public static function disconnect() {
        session_unset();
        session_destroy();
		ControllerDefault::welcome();
    }
	
	//JSON
	public static function existingUser(){
		$nick = $_POST['userNickname'];
		$var = json_decode($nick);
		$rep = ModelUsers::checkExistingUser($var);
		$return = json_encode($rep);
		echo $return;
	}
}
?>