<?php
require_once File::build_path(array('model', 'ModelForm.php'));
class ControllerForm {
    
    public static function read(){
		$formId = $_GET['id'];
        $f = ModelForm::select($formId);
        if (!$f){
			echo "ca passe pas";
            // error page
        }else{
            $application_array  = ModelApplication::getApplicationByFormId($f->getFormID());
            
            $questionsPre_array_list = [];
			$questionsPost_array_list = [];
			
            $answersPre_array_list = [];
			$answersPost_array_list = [];
			
            $questionTypePre_list = [];
			$questionTypePost_list = [];
            
            $field_array = [];
            //Personnal information
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
                
                for($j=0; $j < count($questions_arrayFromModel);$j++){
					$qType = ModelQuestionType::select($questions_arrayFromModel[$j]->getQuestionTypeName());
										
                    $answersPre_array = ModelAnswerType::getAnswerTypeByQuestionTypeName($qType->getQuestionTypeName());
                    
                    array_push($answersPre_array_list[$i], $answersPre_array);
                    array_push($questionTypePre_list[$i], $qType);  
                }                
            }
			
			//POST Questions
			for($i=0; $i < count($application_array);$i++){
                $questionAndAnswer = [];
                $questions_arrayFromModel = ModelQuestion::getQuestionByApplicationIdAndPre($application_array[$i]->getApplicationId(),"0");
                array_push($questionsPost_array_list, $questions_arrayFromModel);
                
                array_push($answersPost_array_list, []);
                array_push($questionTypePost_list, []);
                
                for($j=0; $j < count($questions_arrayFromModel);$j++){
					$qType = ModelQuestionType::select($questions_arrayFromModel[$j]->getQuestionTypeName());
										
                    $answersPost_array = ModelAnswerType::getAnswerTypeByQuestionTypeName($qType->getQuestionTypeName());
                    
                    array_push($answersPost_array_list[$i], $answersPost_array);
                    array_push($questionTypePost_list[$i], $qType);  
                }                
            }
			
			$alphabet = array('A', 'B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		
			$FSQuestionTable = ModelFSQuestion::getFSQuestionByFormId($formId);
	
			$applicationTable = ModelApplication::getApplicationByFormId($formId);
            
            $pagetitle = 'Form';
            $view='displayForm';
            $controller = 'form';
            require File::build_path(array('view','view.php'));
        }
    }
    
	public static function create(){
        $view = 'createForm';
        $controller = 'form';
        $pagetitle = 'Create Form';
        require File::build_path(array('view', 'view.php'));
	}
	public static function created(){
		if(Session::is_connected()){
			$a = json_decode($_POST["applications"], true);
			$qPre = json_decode($_POST["questionsPre"], true);
			var_dump($qPre);
			$qPost = json_decode($_POST["questionsPost"], true);
			$info = json_decode($_POST["information"], true);
			$fs = json_decode($_POST["FSQuestions"], true);
			//var_dump($q);	
			$abort = false;
			
			$userNickname = $_SESSION['nickname'];
			
			$form = array(
						"formName" => json_decode($_POST["form"], true),
						"userNickname" => $userNickname,
						"completedForm" => 0		
					);
			//ModelForm::beginTransaction();
			//var_dump($form);
			if(ModelForm::save($form)){
				$form['formId'] = ModelForm::getLastInsert();
				for($i = 0; $i < sizeof($a); $i++){
					$application = array(
						"applicationId" => $form['formId'] . $a[$i]["id"],
						"applicationName" => $a[$i]["name"],
						"applicationDescription" => $a[$i]["description"],
						"formId" => $form['formId']
					);
					if(!ModelApplication::save($application)){
						$abort = true;
						break;
					}
					//$q[$i] the array containing the question of the application $i
					for($y = 0; $y < sizeof($qPre[$i]); $y++){
						//chercher questionTypeId grace à $q[$i][$y]["questionType"]
						//$qTypeId
						$question = array(
							"questionId" => $form['formId'] . $qPre[$i][$y]["id"],
							"questionName" => $qPre[$i][$y]["label"],
							"applicationId" => $application["applicationId"],
							"questionTypeName" => $qPre[$i][$y]["type"],
							"questionPre" => $qPre[$i][$y]["pre"]
						);
						if(!ModelQuestion::save($question)){
							$abort = true;
							break;
						}
					}

					for($y = 0; $y < sizeof($qPost[$i]); $y++){
						//chercher questionTypeId grace à $q[$i][$y]["questionType"]
						//$qTypeId
						$question = array(
							"questionId" => $form['formId'] . $qPost[$i][$y]["id"],
							"questionName" => $qPost[$i][$y]["label"],
							"applicationId" => $application["applicationId"],
							"questionTypeName" => $qPost[$i][$y]["type"],
							"questionPre" => $qPost[$i][$y]["pre"]
						);
						if(!ModelQuestion::save($question)){
							$abort = true;
							break;
						}
					}
				}
				if($info){
					for($i = 0; $i < sizeof($info); $i++){
						$information = array(
							"formId" => $form['formId'],
							"personnalInformationName" => $info[$i]
						);
						if(!ModelAssocFormPI::save($information)){
							$abort = true;
							break;
						}
					}	
				}
				if($fs){
					for($i=0; $i < sizeof($fs);$i++){
						$fsQuestion = array(
							"formId" => $form['formId'],
							"FSQuestionName" => $fs[$i]
						);
						if(!ModelAssocFormFS::save($fsQuestion)){
							$abort = true;;
							break;
						}
					}
				}
			}
			else{
				$abort = true;
			}
			if($abort){
				//ModelForm::rollback();
				echo json_encode(false);
			}
			else{
				//ModelForm::commit();
				echo json_encode($form['formId']);			
			}
		}
		else{
			echo json_encode(false);
		}
		
	}
	public static function displaySheet2(){
		$controller ='form';
		$view = 'sheet2View';
		$pagetitle='Sheet 2';
		
		
		require File::build_path(array('view', 'view.php'));
	}
	public static function returnFormId(){
		$formId = json_decode($_GET['formId']);
		echo json_encode($formId);
		
	}
	public static function whoAnswered(){
		$controller ='form';
		$view = 'whoAnswered';
		
		$formId = $_GET['id'];
		$pagetitle='Who answered '.$formId;
		

		if(Session::is_connected()){
			$visitor = ModelForm::getVisitorsByFormId($formId);			
		}
		require File::build_path(array('view', 'view.php'));
	}
	
}
?>