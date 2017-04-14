<?php

require_once File::build_path(array('model', 'ModelFSQuestion.php'));

class ControllerFSQuestion {
    
    public static function FSQuestionName(){
        $formId = json_decode($_GET['formId']);
        $FSQuestion = ModelFSQuestion::getFSQuestionByFormId($formId);
        $FSQuestionName = array();
        foreach($FSQuestion as $fs){
            $name = $fs->getFSQuestionName();
            $FSQuestionName[] = $name;
        }        
        echo json_encode($FSQuestionName);
    }
    
}
?>