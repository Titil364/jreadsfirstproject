<?php

require_once File::build_path(array('model', 'ModelFSQuestion.php'));

class ControllerFSQuestion {
    
    public static function FSQuestionName(){
        
        $FSQuestion = ModelFSQuestion::getFSQuestionByFormId('1');
        $FSQuestionName = array();
        foreach($FSQuestion as $fs){
            $name = $fs->getFSQuestionName();
            $FSQuestionName[] = $name;
        }        
        echo json_encode($FSQuestionName);
    }
    
}
?>