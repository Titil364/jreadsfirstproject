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
			$q = json_decode($_POST["questions"], true);
			$info = json_decode($_POST["informations"], true);
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
					for($y = 0; $y < sizeof($q[$i]); $y++){
						//chercher questionTypeId grace à $q[$i][$y]["questionType"]
						//$qTypeId

						$question = array(
							"questionId" => $form['formId'] . $q[$i][$y]["id"],
							"questionName" => $q[$i][$y]["label"],
							"applicationId" => $application["applicationId"],
							"questionTypeName" => $q[$i][$y]["type"]
						);
						if(!ModelQuestion::save($question)){
							$abort = true;
							break;
						}
					}
				}
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
		}else{
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
	
}
?>