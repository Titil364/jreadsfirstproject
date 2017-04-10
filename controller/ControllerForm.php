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
            $pagetitle = 'Formulaire';
            $view='formDisplay';
            $controller = 'form';
            require File::build_path(array('view','view.php'));
        }
    }
       
	
	public static function created(){
		$a = json_decode($_GET["applications"], true);
		$q = json_decode($_GET["questions"], true);
		//var_dump($q);
		
		$form = array(
					"formId" => 0,
					"formName" => json_decode($_GET["form"], true),
					"userId" => 0,
					"completedForm" => 0			
				);
			
		//###################################
		//Enregistrer le form 
		//###################################
		for($i = 0; $i < sizeof($a); $i++){
			$application = array(
				"applicationId" => $i,
				"applicationName" => $a[$i]["name"],
				"applicationDescription" => $a[$i]["description"],
				"formId" =>0
			);
			//###################################
			//Enregistrer l'application
			//###################################
			var_dump($q[$i]);
			//$q[$i] the array containing the question of the application $i
			for($y = 0; $y < sizeof($q[$i]); $y++){
				//chercher questionTypeId grace à $q[$i][$y]["questionType"]
				//$qTypeId
				$qTypeId = 0;
				$question = array(
					"questionId" => $q[$i][$y]["id"],
					"questionName" => $q[$i][$y]["label"],
					"applicationId" => $application["applicationId"],
					"questionTypeId" => $qTypeId
				);
				//###################################
				//Enregistrer la question
				//###################################
			}
		}

		
		echo json_encode("########Success");
	}
}
?>