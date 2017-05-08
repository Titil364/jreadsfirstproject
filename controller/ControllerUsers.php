<?php

require_once File::build_path(array('model', 'ModelUsers.php'));


class ControllerUsers {
	/* desc Display a tab containing all the current user form
	 * 
	 */
         
	public static function readAllMyForm() {

		
		if(Session::is_connected()){
			$view = 'displayAllMyForms';
			$controller = 'users';
			$pagetitle = 'Create Form';
                        $stylesheet = 'admin';

			
			//Collect all the current user form
			$form = ModelUsers::getMyForms($_SESSION['nickname']);
			
			require File::build_path(array('view', 'view.php'));
		}
		//Error the user is not connected
		else{
			$data["message"] = "Please log in to display all your form. ";
			$data["pagetitle"] = "Read my form error";
			
			ControllerDefault::message($data);	
		}
        
    }
	
	/* desc Connected and admin user are allowed to delete users
	 * 
	 * additional desc This action can be used only in the readAll view because a $_SESSION['users'] variable
	 * 					has been setted to avoid showing the raw nickname in the view and in the html code
	 */
	
	public static function delete() {
		
		//Checking if the user is connected and he is an admin
		if(Session::is_connected() && Session::is_admin()){

			//Checking if the user id and the list of users are setted. 
			if(isset($_GET['userId']) && isset($_SESSION['users'])){
				$u = unserialize($_SESSION['users']);
				
				//Maybe we should check if the user still exists in the db before deleting it
				
				if(ModelUsers::delete($u[$_GET["userId"]]->getNickname())){
					$data["message"] = $u[$_GET["userId"]]->getNickname() . " has been deleted in the database. ";
					$data["pagetitle"] = "Delete user success";
					
					ControllerDefault::message($data);	
				}
				//Error in the databse while deleting
				else{
					$data["message"] = "Error in the database while deleting " . $u[$_GET["userId"]]->getNickname() .". ";
					$data["pagetitle"] = "Delete user error";
					
					ControllerDefault::message($data);
				}
					
			}
			//The 2 variables $_GET['userId'] or $_SESSION['users'] haven't been setted (either one of them or both)
			else{
				$data["message"] = "The information have not been send properly. Please try again. ";
				$data["pagetitle"] = "Delete user error";
				
				ControllerDefault::message($data);
			}

		}
		// The user is not an admin or is not connected
		else{
			if(Session::is_connected())
				$data["message"] = "Regular users are not allowed to delete users. ";
			else
				$data["message"] = "Please connect to your account to do this action. ";
			
			$data["pagetitle"] = "Delete user error";
			
			ControllerDefault::message($data);
		}  
    }
	
	/* desc Display the two-in-one update/create page for creating an user
	 * 
	 */
    public static function create() {
        $view = 'updateUsers';
        $controller = 'users';
        $pagetitle = 'Sign in';
        $stylesheet = 'admin';
		$jscript = "myScriptSignin";
		$create = true;
		
		//$data is setted because of the two-in-one update/create page
		//we are creating so they are no information to display
		$data = array(
				"userNickname" => null,
				"userSurname" =>  null,
                "userForename" => null,
                "userMail"  => null
			);
			
        require File::build_path(array('view', 'view.php'));
    }
	/* desc Capturing all the user information to create the user
	 * 
	 * additional information Hashing the password and creating the nonce
	 *						  Double check if the mail is valide and if the user already exists
	 *						  Also create a folder in the server for saving his picture
	 *						  And send an email to the user if it has been properly saved to activate his account
	 */
	public static function created(){

		//Encrypting the password 
		$hashpass = Security::encrypt($_POST['userPassword']);
		
		//Creating a random nonce 
        $nonce = Security::generateRandomHex();
		
		//Capturing the user's information
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
			$data["message"] = "Error, invalid email. Please try again. ";
			$data["pagetitle"] = "Creating user";
			
			ControllerDefault::message($data);
			return null;
		}
		
		//Double verification, if the nickname (the account) already exists
		if(ModelUsers::checkExistingUser($user["userNickname"]) == 1){
			$data["message"] = "Error, the user does exist";
			$data["pagetitle"] = "Creating user";
			
			ControllerDefault::message($data);
			return null;
		}

		//Saving the user
		if(ModelUsers::save($user)){
			$view = 'createdUsers';
			$controller = 'users';
			$pagetitle = 'User Created !';
			
			//Creation of the user's folder which will store the image he uploads
			$path = "./media/".$user['userNickname'];
			if (!mkdir($path, 0777)) {
				die('The creation of the user folder failed. ');
			}
			
			//Sending the mail to activate the account
			$secureNick = rawurldecode($user["userNickname"]);
			
			//Capture the adresse of the website to make it portable
			$actual_link = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";
            $mail = "<!DOCTYPE html><body><a href={$actual_link}?action=validate&controller=users&userNickname={$secureNick}&nonce=$nonce>Please click on thelink to active your account. </a></body>";
            mail($user["userMail"], "Please confirm your email", $mail);
			
			require File::build_path(array('view', 'view.php'));
		}
		//Error while saving the user in the database
		else{
			$data["message"] = "Error while saving the account. Please try again. ";
			$data["pagetitle"] = "Creating user";
			
			ControllerDefault::message($data);
		}
	}
	/* desc Display the two-in-one update/create page for updating an user filling the input with the current user's information if he is connrected
	 * 
	 */
	public static function update() {
		if (Session::is_connected()) {
            //$checkBoxAdmin = ControllerUsers::setCheckBox();
            $view = 'updateUsers';
            $pagetitle = 'Update';
            $controller = 'users';
            $stylesheet = 'admin';
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
			$data["message"] = "Please log in to update your profile. ";
			$data["pagetitle"] = "Update profil error";
			
			ControllerDefault::message($data);
        }
    }
	
	/* desc Capturing all the user's information to update the user
	 * 
	 * additional information The password is hashed and the session regarding the user is updated
	 */
	public static function updated() {
		
		if (Session::is_connected()) {

            $view = 'userProfil';

            $pagetitle = 'Updated';
            $controller = 'users';
            $stylesheet = 'admin';
			
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
		}else{
			$data["message"] = "Please log in to update your profile. ";
			$data["pagetitle"] = "Update profil error";
			
			ControllerDefault::message($data);
		}
	}
	
	
	/* desc Display the user profil using the information in the user session
	 * 
	 */
	public static function displaySelf() {
		if(Session::is_connected()){
			$view = 'userProfil';
			$controller = 'users';
			$pagetitle = 'Profil';
                        $stylesheet = 'admin';
			$data = array(
				"userNickname" => $_SESSION['nickname'],
				"userSurname" =>  $_SESSION['surname'],
				"userForename" => $_SESSION['forename'],
				"userMail"  => $_SESSION['mail']
			);
			require File::build_path(array('view', 'view.php'));
		}
		else{
			$data["message"] = "Please log in to check your profile. ";
			$data["pagetitle"] = "Profil error";
			
			ControllerDefault::message($data);
		}
    }
	
	
	/* desc Display the connection page 
	 * 
	 */
	public static function connect(){
		$view = 'connect';
        $controller = 'users';
        $pagetitle = 'Connect';
		
        require File::build_path(array('view', 'view.php'));
	}
	
	
	/* desc Collect all the information regarding the user connection and connect the user
	 * 
	 * additional information Set the user session. 
	 */
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
			$data["message"] = "Cannot connect to the account please try again. ";
			$data["pagetitle"] = "Connection error";
			
			ControllerDefault::message($data);
        }
		
    }
	/* desc Deconnect the current user
	 * 
	 * additional information Destroy the current session. 
	 */
	public static function disconnect() {
        session_unset();
        session_destroy();
		ControllerDefault::welcome();
    }
	
	//JSON
	/* desc Check if the user exists in the database
	 * 
	 * return The true/1 if the user exists, else false/0
	 */
	public static function existingUser(){
		if(isset($_POST['userNickname'])){
			$nick = $_POST['userNickname'];
			$var = json_decode($nick);
			$rep = ModelUsers::checkExistingUser($var);
			$return = json_encode($rep);
			echo $return;
		}else{
			echo json_encode("Error");
		}

	}
	
	
	/* desc Display the administration panel for the administrator
	 * 
	 */
	public static function administrate(){
		if(Session::is_connected() && Session::is_admin()){
			$view = 'administrationPanel';
			$controller = 'users';
			$pagetitle = 'Administration';
                        $stylesheet = 'admin';

			require File::build_path(array('view','view.php'));
		}else{
			$data["message"] = "Regular users are not allowed to do this action. ";
			$data["pagetitle"] = "Administration error";
			
			ControllerDefault::message($data);
		}
	}
	
	
	/* desc Display all the users to the administrator
	 * 
	 * additional information The admin can delete users, activate users and ...
	 */
	public static function readAll(){
		if(Session::is_connected() && Session::is_admin()){
			$view = 'seeAllUsers';
			$controller = 'users';
			$pagetitle = 'See all users';
                        $stylesheet = 'admin';
			
			$jscript = "allUsers";
			
			$users = ModelUsers::selectAll();

			//Create a session containing all the users in order to avoid
			// showing raw nickname in the html code
			$_SESSION['users'] = serialize($users);
			
			require File::build_path(array('view','view.php'));
		}else{
			$data["message"] = "Regular users are not allowed to do this action. ";
			$data["pagetitle"] = "See all users error";
			
			ControllerDefault::message($data);
		}
	}
	
	//JSON 
	/* desc Change on a user by the administrator
	 * 
	 * additional information The admin can delete users, activate users and ...
	 */
	public static function changeUser(){
		
		if(Session::is_connected() && Session::is_admin() && isset($_POST['name']) && isset($_POST['val']) && isset($_POST['userPosition'])){
			$name = $_POST['name'];
			
			//The value of the <select>
			$val = json_decode($_POST['val']);
			
			//The user position in the session users (containing all the users currently displayed)
			$userPosition = json_decode($_POST['userPosition']);
			
			//Collecting the users in the session
			$users = unserialize($_SESSION['users']);
			
			//Vérifier que cela soit pertinent
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

	
	//JSON
	/* desc When exiting the users admistration panel, the $_SESSION['users'] is destroyed/unset
	 * 
	 */
	public static function deleteSessionUser(){
		if(isset($_SESSION['users']))
			unset($_SESSION['users']);
	}

	
	/* desc Validate the user (deleting the nonce in the database)
	 * 
	 */
	public static function validate() {
        $login = $_GET['userNickname'];
        $nonce = $_GET['nonce'];
		
		//Collect the user by his login
        $user = ModelUsers::select($login);
		
		//If the user exists
        if($user != false){
            if($user->getNonce() == $nonce){
                $data = array(
				"userNickname" => $login,
				"userNonce" => "");
                
                ModelUsers::update($data);
				
                $view = 'validated';
                $controller = 'users';
                $pagetitle = 'Welcome';
				
                require_once(File::build_path(array('view','view.php')));
            }
			//The nonce in the url and in the database doesn't match
			else{
				$data["message"] = "Error, the link doesn't match. ";
				$data["pagetitle"] = "Validation error";
				
				ControllerDefault::message($data);
            }
        }
		//The user doesn't exists -> error
		else{
			$data = array();
			$data["message"] = "Error, the user doesn't exist. ";
			$data["pagetitle"] = "Validation error";
			
			ControllerDefault::message($data);
        }
    }
	
	
	/* desc Display the retrieve account page
	 * 
	 */
	public static function retrieveAccount(){
		$view = 'retrieveAccount';
		$controller = 'users';
		$pagetitle = 'Bienvenue';
                $stylesheet = 'admin';
		
		require_once(File::build_path(array('view','view.php')));
	}
	
	
	/* desc Collect the user information to send him an email
	 * 
	 * additional information Create a new nonce used to reset the user password by mail
	 */
	public static function retrieveAccountByLogin(){
		
		//Creating a nonce which will be used to reset the user password
		$nonce = Security::generateRandomHex();
		
		$user = array(
			"userNickname" => $_POST['userNickname'],
			"userNonce" => $nonce
		);
		//Pickng up the user from the database
		$u = ModelUsers::select($user["userNickname"]);
		
		//if the user doesn't exist -> error
		if(!$u){
			$data["message"] = "Error, the user doesn't exist. ";
			$data["pagetitle"] = "Retrieve account error";
			
			ControllerDefault::message($data);
			return null;
		}
		
		//Collecting the user mail
		$user["userMail"] = $u->getMail();
		
		//Updating the user with the new nonce
		if(ModelUsers::update($user)){
			
			$secureNick = rawurldecode($user["userNickname"]);
			$actual_link = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";

			//Sending the mail to the user
			$mail = "<!DOCTYPE html><body><a href={$actual_link}?action=changePassword&controller=users&userNickname={$secureNick}&nonce=$nonce>Click here to reset your password. </a></body>";
			mail($user["userMail"], "Password forgot", $mail);	
			
			$view = 'retrieveAccountByLogin';
			$controller = 'users';
			$pagetitle = 'Bienvenue';
			require_once(File::build_path(array('view','view.php')));
			
		}
		//Error while udpating the user
		else{
			$data["message"] = "Error in the database. ";
			$data["pagetitle"] = "Retrieve account error";
			
			ControllerDefault::message($data);
		}
	}
	
	
	/* desc Display the changing password page if the user and the nonce match
	 * 
	 */
	public static function changePassword(){
		$nick = $_GET['userNickname'];
        $nonce = $_GET['nonce'];
		
		//Picking up the user 
		$user = ModelUsers::select($nick);
		
		//If the user is found and the nonces matche
        if($user != false && $nonce == $user->getNonce()){
			
			//The nick and the nonce are passed through hidden input the form to double check
			//at the next step (modifying the form)

			$nick = htmlspecialchars($nick);
			$nonce = htmlspecialchars($nonce);
			
			$view = 'changePassword';
			$controller = 'users';
			$pagetitle = 'Retrieve password';
			require_once(File::build_path(array('view','view.php')));
		}
		else{
			if(user == false )
				$data["message"] = "Error in the user doesn't exist. ";
			else
				$data["message"] = "Error. Please click on the link in send to your email adress. ";
				
			$data["pagetitle"] = "Change password error";
			
			ControllerDefault::message($data);
		}
	}
	
	
	/* desc DCollect the information and change the user password
	 * 
	 * additional information Double check the user and the nonce
	 *						  The user nonce is setted to ""
	 */
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
		else{
			if(user == false )
				$data["message"] = "Error in the user doesn't exist. ";
			else
				$data["message"] = "Error. Please click on the link in send to your email adress. ";
				
			$data["pagetitle"] = "Change password error";
			
			ControllerDefault::message($data);	
		}
	}
}
?>