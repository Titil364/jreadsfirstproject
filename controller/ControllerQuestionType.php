<?php

require_once File::build_path(array('model', 'ModelQuestionType.php'));

class ControllerQuestionType {

	/* desc Send what ?
	 * trigger Onload when creating a form
	 * additional information Use for what ?
	 */
	public static function answersPlaceholder(){
		
		if(Session::is_connected()){
			$questionType = ModelQuestionType::getQuestionTypeForUser($_SESSION["nickname"]);
			$placeholders = array();
			foreach($questionType as $q){
				$name = $q->getQuestionTypeName();
				$placeholders[$name] = ModelAnswerType::getAnswerTypeByQuestionId($q->getQuestionTypeId());
			}
		
			echo json_encode($placeholders);			
		}else{
			echo json_encode("Not connected");
		}

	}
        
        /* desc Check if the questionTypeTitle is already used by the current user
         * return : true if existing, false else
         */
        
        public static function existingQuestionType(){
			if(Session::is_connected()){
				$questionTypeTitle = $_POST['questionTypeTitle'];
				$var = json_decode($questionTypeTitle);
				$rep = ModelQuestionType::checkExistingQuestionType($var);
                                $user = $_SESSION['nickname'];
				echo json_encode($rep);
			}
        }
}
?>