<?php

require_once File::build_path(array('model', 'ModelForm.php'));

class ControllerForm {
    public static function welcome() {
        $view = 'index';
        $controller = 'default';
        $pagetitle = 'Create Form';
        require File::build_path(array('view', 'view.php'));
    }

    
    public static function read(){
        $f = ModelForm::select($_GET['id']);
        if (!$f){
            // error page
        }else{
            $pagetitle = 'Form';
            $view='displayForm';
            $controller = 'form';
            require File::build_path(array('view','view.php'));
        }
    }
       
	
	public static function created(){	
		$a = json_decode($_POST["applications"], true);
		$q = json_decode($_POST["questions"], true);
		//var_dump($q);
		$abort = false;
		
		$form = array(
					"formName" => json_decode($_POST["form"], true),
					"userId" => 0,
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


		
	}
}
?>