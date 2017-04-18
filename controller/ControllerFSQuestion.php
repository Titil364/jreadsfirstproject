<?php

require_once File::build_path(array('model', 'ModelFSQuestion.php'));

class ControllerFSQuestion {
    
    public static function FSQuestionName(){
        $formId = json_decode($_GET['formId']);
        $FSQuestion = ModelFSQuestion::getFSQuestionByFormId($formId);
		//pourquoi ne pas créer directement une méthode renvoyant uniqement le nom des FSQuestion ?
        $FSQuestionName = array();
        foreach($FSQuestion as $fs){
            $name = $fs->getFSQuestionName();
            $FSQuestionName[] = $name;
        }        
        echo json_encode($FSQuestionName);
    }
	public static function predefinedFSQuestions(){
		$var = ModelFSQuestion::getDefaultFSQuestion();
		echo json_encode($var);
	}
    
}
?>