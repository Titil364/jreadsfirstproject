<?php
require_once File::build_path(array('model', 'ModelVisitor.php'));

class ControllerVisitor{
    
    public static function read(){
		if(!isset($_GET['visitorId'])){
			$data["message"] = "There are not enough information.  ";
			$data["pagetitle"] = "Read form error";
			
			ControllerDefault::message($data);
			return null;
		}
		
		$visitorId = $_GET['visitorId'];
		$visitor = ModelVisitor::select($visitorId);
		
		if(!$visitor){
			$data["message"] = "Your id doesn't exist. Please try make sure your id is valid. ";
			$data["pagetitle"] = "Read form error";
			
			ControllerDefault::message($data);
			return null;
		}
		$formId = $visitor->getFormId();
		
        $f = ModelForm::select($formId);
        if (!$f){
			$data["message"] = "This form doesn't exist. ";
			$data["pagetitle"] = "Read form error";
			
			ControllerDefault::message($data);	
        }else{		
			if($visitor->getDateCompletePre() == null){
				$pre = 0;
			}else{
				$pre = 1;
			
			}
			$FSQuestionTable = ModelFSQuestion::getFSQuestionByFormId($formId);

			if($pre === 0){
				$jscript = "answers";	
				//$visitor = true;
				$folder = $f->getUserNickname();
				$application_array  = ModelApplication::getApplicationByFormId($f->getFormID());
				
				$secretName = $visitor->getVisitorSecretName();
				
				$information = ModelInformation::getInformationByVisitorId($visitorId);
				$informationEmpty = ModelAssocFormPI::getAssocFormPIByFormId($formId);
				$infoFilled = [];
				
				$answersFilled = [];
				$answers = ModelAnswer::getAnswerByVisitorId($visitorId);
				$applicationsEmpty = ModelApplication::getApplicationByFormId($formId);
				$answersEmpty =[];
				foreach($applicationsEmpty as $app){
					$questionsEmpty = ModelQuestion::getQuestionByApplicationId($app->getApplicationId());
					array_push($answersEmpty,$questionsEmpty);
				}									
				foreach($information as $i){
					array_push($infoFilled,$i->getInformationName());
				}
				foreach($answers as $a){
					$ans = array(
						"questionId" => $a->getQuestionId(),
						"answer" => $a->getAnswer()
					);
					array_push($answersFilled, $ans);
				}
				
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
				// ==================================================
				$answersFilled = [];
				$answers = ModelAnswer::getAnswerByVisitorId($visitorId);
				$applicationsEmpty = ModelApplication::getApplicationByFormId($formId);
				$answersEmpty =[];
				foreach($applicationsEmpty as $app){
					$questionsEmpty = ModelQuestion::getQuestionByApplicationId($app->getApplicationId());
					array_push($answersEmpty,$questionsEmpty);
				}
				foreach($answers as $a){
					$ans = array(
						"questionId" => $a->getQuestionId(),
						"answer" => $a->getAnswer()
					);
					array_push($answersFilled, $ans);
				}
				
				// ==================================================
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
	
	public static function addVisitor(){
		$return = true;
		$visitorId = json_decode($_POST['visitorId']); 
		$formId = json_decode($_POST['formId']);
		$data = array(
				"visitorId" => $visitorId,
				"formId" => $formId
			);
		if(!(ModelVisitor::save($data))){
			$return = false;
		}
		
		$form = ModelForm::select($formId);
		$applications = ModelApplication::getApplicationByFormId($formId);
		foreach($applications as $a){
			$questions = ModelQuestion::getQuestionByApplicationId($a->getApplicationId());
			foreach ($questions as $q){
				$questionSave = array (
					"visitorId" => $visitorId,
					"questionId" => $q->getQuestionId()
				);
				if(!(ModelAnswer::save($questionSave) == 1)){
					$return = false;
				}
			}
		}
		$information = ModelAssocFormPI::getAssocFormPIByFormId($formId);
		foreach($information as $i){
			$info = array(
				"personnalInformationName"=>$i->getPersonnalInformationName(),
				"informationName" =>null,
				"visitorId" => $visitorId
			);
			if(!(ModelInformation::save($info))){
				$return = false;
			}			
		}
		foreach($applications as $app){
			$datAA = array(
				"visitorId" => $visitorId,
				"applicationId" => $app->getApplicationId()
			);
			if(!(ModelAgainAgain::save($datAA))){
				$return = false;
			}
		}
		//////////////////////////////
		$FSQ = ModelFSQuestion::getFSQuestionByFormId($formId);
		foreach($FSQ as $f){
			$dataFS = array (
				"visitorId" => $visitorId,
				"FSQuestionName" => $f->getFSQuestionName()
			);
			if(!(ModelSortApplication::save($dataFS))){
				$return = false;
			}
		}
		echo json_encode($return);
	}
	
	public static function getFormIdByVisitor(){
		$visitorId = json_decode($_POST['visitorId']);
		echo json_encode(ModelVisitor::Select($visitorId)->getformId());
	}
	
	public static function getAgainAgainByVisitorId(){
		$visitorId = json_decode($_POST['visitorId']);
		$AA = ModelAgainAgain::getAgainAgainByVisitorId($visitorId);
		$return = [];
		foreach($AA as $a){
			$data = array(
				"applicationId" => $a->getApplicationId(),
				"again" => $a->getAgain()
			);
			array_push($return, $data);
		}
		echo json_encode($return);
	}
	
	public static function getFSByVisitorId(){
		$visitorId = json_decode($_POST['visitorId']);
		$AA = ModelSortApplication::getFSByVisitorId($visitorId);
		$return = [];
		foreach($AA as $a){
			$data = array(
				"FSQuestionName" => $a->getFSQuestionName(),
				"applicationOrder" => $a->getApplicationOrder()
			);
			array_push($return, $data);
		}
		echo json_encode($return);
	}
	
	//I wrote this function but i'm not sure if it will be usefull or not
	public static function getVisitorSecretName(){
		$visitorId = json_decode($_POST['visitorId']);
		$s = ModelVisitor::Select($visitorId)->getVisitorSecretName();
		if ($s == null){
			echo json_encode(false);
		} else {
		echo json_encode(true);
		}
	}
}
?>