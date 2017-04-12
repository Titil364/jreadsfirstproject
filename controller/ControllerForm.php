<?php

require_once File::build_path(array('model', 'ModelForm.php'));

class ControllerForm {

    
    public static function read(){
	$formId = $_GET['id'];	
        $f = ModelForm::select($formId);
        if (!$f){
            // error page
        }else{
            $application_array  = ModelApplication::getApplicationByFormId($f->getFormID());
            
            $questions_array_list = [];
            $answers_array_list = [];
            $questionType_list = [];
            
            for($i=0; $i < count($application_array);$i++){
                $questionAndAnswer = [];
                $questions_array = ModelQuestion::getQuestionByApplicationId($application_array[$i]->getApplicationId());

                array_push($questions_array_list, $questions_array);
                
                array_push($answers_array_list, []);
                array_push($questionType_list, []);
                

                for($j=0; $j < count($questions_array);$j++){
					$qType = ModelQuestionType::select($questions_array[$j]->getQestionTypeId());

                    $answers_array = ModelAnswerType::getAnswerTypeByQuestionTypeId($qType->getQuestionTypeId());
                    
                    array_push($answers_array_list[$i], $answers_array);
                    array_push($questionType_list[$i], $qType);  
                }
                
            }
            
            $pagetitle = 'Form';
            $view='displayForm';
            $controller = 'form';
            require File::build_path(array('view','view.php'));
        }
    }
       
	
	public static function created(){
		if(Session::is_connected()){
			$a = json_decode($_POST["applications"], true);
			$q = json_decode($_POST["questions"], true);
			//var_dump($q);
			$abort = false;
			
			$userNickname = $_SESSION['nickname'];
			
			$form = array(
						"formName" => json_decode($_POST["form"], true),
						"userNickname" => $userNickname,
						"completedForm" => 0		
					);
			ModelForm::beginTransaction();
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
						$qTypeId = ModelQuestiontype::getQuestionTypeByName($q[$i][$y]["type"]);
						$qTypeId = $qTypeId->getQuestionTypeId();

						$question = array(
							"questionId" => $form['formId'] . $q[$i][$y]["id"],
							"questionName" => $q[$i][$y]["label"],
							"applicationId" => $application["applicationId"],
							"questionTypeId" => $qTypeId
						);
						if(!ModelQuestion::save($question)){
							$abort = true;
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
		}else{
			echo json_encode(false);
		}
		
	}
	public static function displaySheet2(){
		$controller ='form';
		$view = 'sheet2View';
		$pagetitle='postPostView';
		
		$nbFSQuestions = 5;
		$applicationTable = ModelApplication::getApplicationByFormId('1');
		
		require File::build_path(array('view', 'view.php'));
	}
}
?>