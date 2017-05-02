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
	
	public static function delete() {
		if(Session::is_connected() && Session::is_admin()){

			if(isset($_GET['userId']) && isset($_SESSION['users'])){
				$u = unserialize($_SESSION['users']);
				if(ModelUsers::delete($u[$_GET["userId"]]->getNickname()))
					echo "Success";	
				else
					echo "Error";
			}
			else{
				echo "Error";
			}

		}else{
			echo "You are not allowed to do this action. ";
		}  
    }
	
    public static function create() {
        $view = 'updateUsers';
        $controller = 'users';
        $pagetitle = 'Sign in';
		$jscript = "myScriptSignin";
		$create = true;
		$data = array(
				"userNickname" => null,
				"userSurname" =>  null,
                "userForename" => null,
                "userMail"  => null
			);
        require File::build_path(array('view', 'view.php'));
    }
	
	public static function created(){
		$view = 'createdUsers';
        $controller = 'users';
        $pagetitle = 'User Created !';
		
		$hashpass = Security::encrypt($_POST['userPassword']);
        $nonce = Security::generateRandomHex();
		
		$user = array(
				"userMail" => $_POST['userMail'],
				"userPassword" => $hashpass,
				"userNickname" => $_POST['userNickname'],
				"userSurname" => $_POST['userSurname'],
				"userForename" => $_POST['userForename'],
				"userNonce" => $nonce,
				"isAdmin" => 0,
				"numberCreatedForm" => 0
			);
		
		//Double format validation for the mail. 
		if(!filter_var($user["userMail"], FILTER_VALIDATE_EMAIL)){
			echo "Error, the email is not valid. ";
			return null;
		}
			
		if(ModelUsers::checkExistingUser($user["userNickname"]) == 1){
			echo "Error, the user exist";
			return null;
		}

		if(ModelUsers::save($user)){
			//Creation of the user's folder which will store the image he uploads
			$path = "./media/".$user['userNickname'];
			if (!mkdir($path, 0777)) {
				die('The creation of the user folder failed. ');
			}
			
			//Sending the mail to activate the account
			$secureNick = rawurldecode($user["userNickname"]);
			$actual_link = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";
			echo $actual_link;
            $mail = "<!DOCTYPE html><body><a href={$actual_link}?action=validate&controller=users&userNickname={$secureNick}&nonce=$nonce>Please click on thelink to active your account. </a></body>";
            mail($user["userMail"], "Please confirm your email", $mail);
		}
		
		require File::build_path(array('view', 'view.php'));
	}
	
	public static function update() {
		if (Session::is_connected()) {
            //$checkBoxAdmin = ControllerUsers::setCheckBox();
            $view = 'updateUsers';
            $pagetitle = 'Update';
            $controller = 'users';
			$jscript = "myScriptSignin";
			$create	= false; 
			
			$data = array(
				"userNickname" => htmlspecialchars($_SESSION['nickname']),
				"userSurname" =>  htmlspecialchars($_SESSION['surname']),
                "userForename" => htmlspecialchars($_SESSION['forename']),
                "userMail"  => htmlspecialchars($_SESSION['mail'])
			);
			
			

			require File::build_path(array('view', 'view.php'));

		} else {
		//echo "pas connecté";

			$data = array();
			$data['error'] = "Please log in";
			$data['view'] = 'connectUsers';
			$data['controller'] = 'users';
            ControllerDefault::error($data);
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
			Session::connect($nickname, $userForename, $userSurname, $userMail, $_SESSION['numberCreatedForm']);
			
			require File::build_path(array('view', 'view.php'));
		}
	}
	
	public static function displaySelf() {
        $view = 'userProfil';
        $controller = 'users';
        $pagetitle = 'Profil';
		if(Session::is_connected()){
			$data = array(
				"userNickname" => $_SESSION['nickname'],
				"userSurname" =>  $_SESSION['surname'],
				"userForename" => $_SESSION['forename'],
				"userMail"  => $_SESSION['mail']
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
            if ($user->getIsAdmin() == 1) {
                $_SESSION['admin'] = 1;
            } else {
                $_SESSION['admin'] = 0;
            }
            $nickname = $user->getNickname();
            $surname = $user->getSurname();
            $forename = $user->getForename();
            $mail = $user->getMail();
			$nb = $user->getNumberCreatedForm();
            Session::connect($nickname, $forename, $surname, $mail, $nb);
			ControllerDefault::welcome();

        } else {
			$data = array();
			$data['error'] = "Problème de connexion";
			$data['view'] = 'connect';
			$data['controller'] = 'users';
			$data['login'] = $_POST['nickname'];
            ControllerDefault::error($data);
			require File::build_path(array('view','view.php'));
        }
		
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
	
	public static function administrate(){
		if(Session::is_admin()){
			$view = 'administrationPanel';
			$controller = 'users';
			$pagetitle = 'Connect';

			require File::build_path(array('view','view.php'));
		}
	}
	
	public static function readAll(){
		if(Session::is_admin()){
			$view = 'seeAllUsers';
			$controller = 'users';
			$pagetitle = 'Connect';
			
			$jscript = "allUsers";
			
			$users = ModelUsers::selectAll();

			$_SESSION['users'] = serialize($users);
			
			require File::build_path(array('view','view.php'));
		}
	}
	
	public static function changeUser(){
		
		if(Session::is_admin() && isset($_POST['name']) && isset($_POST['val']) && isset($_POST['userPosition'])){
			$name = $_POST['name'];
			
			$val = json_decode($_POST['val']);			
			$userPosition = json_decode($_POST['userPosition']);
			$users = unserialize($_SESSION['users']);
			
			if($name == "userNonce" && $val == 0){
				$val = "";
			}
			$data[$name] = $val;
			$data['userNickname'] = $users[$userPosition]->getNickname();
			
			ModelUsers::update($data);
			
			echo json_encode("Success");
		}
		else{
			echo json_encode("Error");
		}
		
	}
	
	
	public static function deleteSessionUser(){
		if(isset($_SESSION['users']))
			unset($_SESSION['users']);
	}
	
	public static function validate() {
        $login = $_GET['userNickname'];
        $nonce = $_GET['nonce'];
        $user = ModelUsers::select($login);
        if($user != false){
            if($user->getNonce() == $nonce){
                $data = array(
				"userNickname" => $login,
				"userNonce" => "");
                
                ModelUsers::update($data);
				
                $view = 'validated';
                $controller = 'users';
                $pagetitle = 'Bienvenue';
                require_once(File::build_path(array('view','view.php')));
            }else{
				$data = array();
				$data['error'] = "Problème de confirmation du mail";
				$data['view'] = 'error';
				$data['controller'] = 'default';
				ControllerDefault::error($data);
            }
        }else{
			$data = array();
			$data['error'] = "FATAL ERROR";
			$data['view'] = 'error';
			$data['controller'] = 'default';
			ControllerDefault::error($data);
        }
    }
	
	public static function retrieveAccount(){
		$view = 'retrieveAccount';
		$controller = 'users';
		$pagetitle = 'Bienvenue';
		require_once(File::build_path(array('view','view.php')));
	}
	
	public static function retrieveAccountByLogin(){
		
		$nonce = Security::generateRandomHex();
		$user = array(
			"userNickname" => $_POST['userNickname'],
			"userNonce" => $nonce
		);
		$u = ModelUsers::select($user["userNickname"]);
		if(!$u){
			echo "Error, the use doesn't exist. ";
			return null;
		}
		$user["userMail"] = $u->getMail();
		if(ModelUsers::update($user)){
			$secureNick = rawurldecode($user["userNickname"]);
			$actual_link = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";
			echo $actual_link;
			$mail = "<!DOCTYPE html><body><a href={$actual_link}?action=changePassword&controller=users&userNickname={$secureNick}&nonce=$nonce>Click here to reset your password. </a></body>";
			mail($user["userMail"], "Password forgot", $mail);	
			
			$view = 'retrieveAccountByLogin';
			$controller = 'users';
			$pagetitle = 'Bienvenue';
			require_once(File::build_path(array('view','view.php')));
			
		}else{
			echo "Error in the DB";
		}
	}
	
	public static function changePassword(){
		$nick = $_GET['userNickname'];
        $nonce = $_GET['nonce'];		
		$user = ModelUsers::select($nick);
        if($user != false && $nonce == $user->getNonce()){
			
			$nick = htmlspecialchars($nick);
			$nonce = htmlspecialchars($nonce);
			
			$view = 'changePassword';
			$controller = 'users';
			$pagetitle = 'Retrieve password';
			require_once(File::build_path(array('view','view.php')));
		}
	}
	
	public static function changedPassword(){
		$nick = $_POST['userNickname'];
        $nonce = $_POST['nonce'];		
		$user = ModelUsers::select($nick);
        if($user != false && $nonce == $user->getNonce()){
			
			$hashpass = Security::encrypt($_POST['userPassword']);
			
			$data =  array(
				"userNickname" => $nick,
				"userPassword" => $hashpass,
				"userNonce" => ""
			);
			
			ModelUsers::update($data);
			
			$view = 'changedPassword';
			$controller = 'users';
			$pagetitle = 'Password changed';
			require_once(File::build_path(array('view','view.php')));
		}
	}
}
?>