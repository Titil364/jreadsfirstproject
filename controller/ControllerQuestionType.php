<?php

require_once File::build_path(array('model', 'ModelQuestionType.php'));

class ControllerQuestionType {

	public static function answersPlaceholder(){
		
		$questionType = ModelQuestionType::selectAll();
		$placeholders = array();
		foreach($questionType as $q){
			$name = $q->getQuestionTypeName();
			$placeholders[$name] = ModelAnswerType::getAnswerTypeByQuestionTypeName($name);
		}
		//var_dump($placeholders);
	
		echo json_encode($placeholders);
	}
}
?>