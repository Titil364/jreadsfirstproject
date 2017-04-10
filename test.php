<?php
	//$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	require_once "./lib/File.php";
	$a = json_decode($_GET["applications"], true);
	$q = json_decode($_GET["questions"], true);
	//var_dump($q);
	
	$form = array(
				"formId" => 0,
				"formName" => json_decode($_GET["form"], true),
				"userId" => 0,
				"completeForm" => 0			
			);
        require_once File::build_path(array('model', 'ModelForm.php'));                                                 
        ModelForm::save($form);
        
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
                require_once File::build_path(array('model', 'ModelApplication.php'));
                ModelApplication::save($application);
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
                        //require_once File::build_path(array('model', 'ModelQueston.php'));
			//###################################
			//Enregistrer la question
			//###################################
		}
	}


	
	echo json_encode("########Success");

?>