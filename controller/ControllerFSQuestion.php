<?php

require_once File::build_path(array('model', 'ModelFSQuestion.php'));

class ControllerFSQuestion {
    
	/* @author Alexandre Comas
	 * desc Create a table of questions Name
	 */
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
	
	/* desc Send the list of FS Question already existing by default
	 * trigger <<onload>> when creating a form 
	 * additional information Use to give to the creator FSQuestions that already exist. He doesn't need to create it, he just needs to tick the box
	 */
	public static function predefinedFSQuestions(){
		$var = ModelFSQuestion::getDefaultFSQuestion();
		echo json_encode($var);
	}
    
}
?>