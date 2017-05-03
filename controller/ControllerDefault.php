<?php
class ControllerDefault {
	
	/* desc Display the welcome page
	 *
	 * additional information A hide-and-seek between 3 blocs. 
	 */
    public static function welcome() {
        $view = 'welcome';
        $controller = 'default';
        $pagetitle = 'Welcome';
		$stylesheet = "welcome";
		$jscript = "welcome";
		if(Session::is_connected()){
			ControllerUsers::displaySelf();
		}else{
			require File::build_path(array('view', 'view.php'));
		}
    }
	
	/* desc Display a custom message
	 *
	 * param $data - a tab you can custom : <<pagetitle>> the title of the page
	 *										<<message>> the message to be displayed 
	 *										<<url>> the url for the redirection (optional)
	 *										<<button>> the text of the button (optional)
	 * additional information Used either for normal message and error message
	 * 						  You can custom the url of the redirection button and the text in the button
	 * 						  Redirect to the home page by default
	 */
	public static function message($data){
		$view = "message";
		$controller = "default";
		$pagetitle = $data["pagetitle"];
		
		$message = htmlspecialchars($data["message"]);
		
		//Setting the default url
		if(!isset($data["url"])){
			$data["url"] = "index.php";
		}
		
		//Setting the default button text
		if(!isset($data["button"])){
			$data["button"] = "Return to the home page";
		}
		
		$url = htmlspecialchars($data["url"]);
		$button = htmlspecialchars($data["button"]);
		
		require File::build_path(array('view', 'view.php'));
	}
	
}
?>