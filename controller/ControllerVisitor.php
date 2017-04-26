<?php
require_once File::build_path(array('model', 'ModelVisitor.php'));

class ControllerVisitor{
    
    public static function read(){
		$formId = $_GET['id'];
		if($_GET['visitorId'] == null){
			$pre = 0;
		}else{
			$pre = 1;
			$visitorId = $_GET['visitorId'];
		}
        $f = ModelForm::select($formId);
        if (!$f){
			echo "This form doesn't exist";
			// error page
        }else{
			
				$FSQuestionTable = ModelFSQuestion::getFSQuestionByFormId($formId);

				if($pre === 0){
					$jscript = "answers";	
					$visitor = true;
					$folder = $f->getUserNickname();
					$application_array  = ModelApplication::getApplicationByFormId($f->getFormID());
					
					$questionsPre_array_list = [];
						
					$answersPre_array_list = [];
						
					$questionTypePre_list = [];
					
					$field_array = [];
					
					$assoc_array = ModelAssocFormPI::getAssocFormPIByFormId($formId); //get associations Form PersonnalInformation
					foreach ($assoc_array as $assoc){
						$perso_inf_id = $assoc->getPersonnalInformationName();
						$perso_inf = ModelPersonnalInformation::select($perso_inf_id); //get PersonnalInformation of Asooctiation $assoc
						
						array_push($field_array, $perso_inf);					
					}
					
					//PRE Questions
					for($i=0; $i < count($application_array);$i++){
						$questionAndAnswer = [];
						$questions_arrayFromModel = ModelQuestion::getQuestionByApplicationIdAndPre($application_array[$i]->getApplicationId(),"1");
						array_push($questionsPre_array_list, $questions_arrayFromModel);
						
						array_push($answersPre_array_list, []);
						array_push($questionTypePre_list, []);
						
						$reponses = array();
						for($j=0; $j < count($questions_arrayFromModel);$j++){							
							$qType = ModelQuestionType::select($questions_arrayFromModel[$j]->getQuestionTypeId());
							$answersPre_array = ModelAnswerType::getAnswerTypeByQuestionId($qType->getQuestionTypeId());
							array_push($answersPre_array_list[$i], $answersPre_array);
							array_push($questionTypePre_list[$i], $qType);
						}
						
					}
					$pagetitle = 'Welcome visitor';
					$view='answerForm';
					$controller = 'visitor';				
				} elseif($pre ===1){
					
					
					$alphabet = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
					$applicationTable = ModelApplication::getApplicationByFormId($formId);
					
					$folder = $f->getUserNickname();
					$application_array  = ModelApplication::getApplicationByFormId($f->getFormID());
					
					$questionsPost_array_list = [];
						
					$answersPost_array_list = [];
						
					$questionTypePost_list = [];
					
					$field_array = [];
					$informationTable = ModelInformation::getInformationByVisitorId($visitorId);
					
					$assoc_array = ModelAssocFormPI::getAssocFormPIByFormId($formId); //get associations Form PersonnalInformation
					foreach ($assoc_array as $assoc){
						$perso_inf_id = $assoc->getPersonnalInformationName();
						$perso_inf = ModelPersonnalInformation::select($perso_inf_id); //get PersonnalInformation of Asooctiation $assoc
						
						array_push($field_array, $perso_inf);					
					}
					
					//PRE Questions
					for($i=0; $i < count($application_array);$i++){
						$questionAndAnswer = [];
						$questions_arrayFromModel = ModelQuestion::getQuestionByApplicationIdAndPre($application_array[$i]->getApplicationId(),"0");
						array_push($questionsPost_array_list, $questions_arrayFromModel);
						
						array_push($answersPost_array_list, []);
						array_push($questionTypePost_list, []);
						
						$reponses = array();
						for($j=0; $j < count($questions_arrayFromModel);$j++){							
							$qType = ModelQuestionType::select($questions_arrayFromModel[$j]->getQuestionTypeId());
							$answersPost_array = ModelAnswerType::getAnswerTypeByQuestionId($qType->getQuestionTypeId());
							array_push($answersPost_array_list[$i], $answersPost_array);
							array_push($questionTypePost_list[$i], $qType);
						}
						
					}
					$jscript = "answers";
					$pagetitle = 'Welcome back visitor';
					$view='lastPage';
					$controller = 'visitor';
				} //Put a default view if form is not available yet

            require File::build_path(array('view','view.php'));
		}
    }
	
}
?>