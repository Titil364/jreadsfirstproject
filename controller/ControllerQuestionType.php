<?php

require_once File::build_path(array('model', 'ModelQuestionType.php'));

class ControllerQuestionType {

	public static function answersPlaceholder(){
		
		$questionType = ModelQuestionType::getQuestionTypeForUser($_SESSION["nickname"]);
		$placeholders = array();
		foreach($questionType as $q){
			$name = $q->getQuestionTypeName();
			$placeholders[$name] = ModelAnswerType::getAnswerTypeByQuestionId($q->getQuestionTypeId());
		}
	
		echo json_encode($placeholders);
	}
}
?>