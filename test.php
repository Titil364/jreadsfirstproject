<?php
	//$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	$a = json_decode($_GET["applications"], true);
	$q = json_decode($_GET["questions"], true);
	//var_dump($q);
	
	$form = array(
				"formId" => 0,
				"formName" => json_decode($_GET["form"], true),
				"userId" => 0,
				"completeForm" => 0			
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

?>