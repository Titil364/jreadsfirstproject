<?php

require_once File::build_path(array('model', 'ModelAnswer.php'));

class ControllerAnswer{
	//JSON
	/* desc Save the answer of a question 
	 * trigger <<onchange>> event on each question input (text, radiobutton)
	 * additional information An answer is automaticly saved with the <<onchange>> event
	 */
	public static function saveAnswer(){
		if(!isset($_POST['visitorId']) || !isset($_POST['questionId'])){
			echo json_encode(false);
			
		}
		$visitorId = $_POST['visitorId'];
		$questionId = $_POST['questionId'];
		$answer = json_decode($_POST['answer']);
		
		$data = array(
			"visitorId" => $visitorId,
			"questionId" => $questionId,
			"answer" => $answer
		);
		echo json_encode(ModelAnswer::update($data));
	}
}
?>