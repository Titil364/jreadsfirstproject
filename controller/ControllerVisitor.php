<?php
require_once File::build_path(array('model', 'ModelVisitor.php'));

class ControllerVisitor{
    
    public static function read(){
		$formId = $_GET['id'];
        $f = ModelForm::select($formId);
        if (!$f){
			echo "This form doesn't exist";
            // error page
        }else{
			
				$pre = true;
				$FSQuestionTable = ModelFSQuestion::getFSQuestionByFormId($formId);

				if($pre){
					$jscript = "answers";	
					$visitor = true;
					$folder = $f->getUserNickname();
					$application_array  = ModelApplication::getApplicationByFormId($f->getFormID());
					
					$questions_array_list = [];
					$answers_array_list = [];
					$questionType_list = [];
					
					$field_array = [];
					
					$assoc_array = ModelAssocFormPI::getAssocFormPIByFormId($formId); //get associations Form PersonnalInformation
					foreach ($assoc_array as $assoc){
						$perso_inf_id = $assoc->getPersonnalInformationName();
						$perso_inf = ModelPersonnalInformation::select($perso_inf_id); //get PersonnalInformation of Asooctiation $assoc
						
						array_push($field_array, $perso_inf);
					   
						
					}
					
					
					for($i=0; $i < count($application_array);$i++){
						$questionAndAnswer = [];
						$questions_arrayFromModel = ModelQuestion::getQuestionByApplicationId($application_array[$i]->getApplicationId());
						array_push($questions_array_list, $questions_arrayFromModel);
						
						array_push($answers_array_list, []);
						array_push($questionType_list, []);
						
						for($j=0; $j < count($questions_arrayFromModel);$j++){
							$qType = ModelQuestionType::select($questions_arrayFromModel[$j]->getQuestionTypeName());
												
							$answers_array = ModelAnswerType::getAnswerTypeByQuestionTypeName($qType->getQuestionTypeName());
							
							array_push($answers_array_list[$i], $answers_array);
							array_push($questionType_list[$i], $qType);  
						}
						
					}
					$pagetitle = 'Welcome visitor X';
					$view='answerForm';
					$controller = 'visitor';				
				}else{
					
					$jscript = "answers";
					$alphabet = array('A', 'B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
					$applicationTable = ModelApplication::getApplicationByFormId($formId);
					
					$pagetitle = 'Welcome back visitor X';
					$view='lastPage';
					$controller = 'visitor';
				}

            require File::build_path(array('view','view.php'));
		}
    }
	
}
?>