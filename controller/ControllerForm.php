<?php
require_once File::build_path(array('model', 'ModelForm.php'));


require_once File::build_path(array('model', 'ModelAgainAgain.php'));

require_once File::build_path(array('model', 'ModelSortApplication.php'));


class ControllerForm {
    
    public static function read(){
		$formId = $_GET['id'];
        $f = ModelForm::select($formId);
		$jscript = "myScriptSheet";
		$full = false;
        if (!$f){
			$data["message"] = "The form doesn't exist. ";
			$data["pagetitle"] = "Read form error";
			
			ControllerDefault::message($data);	
        }else{
			$folder = $f->getUserNickname();
            $application_array  = ModelApplication::getApplicationByFormId($f->getFormID());
            
            $questionsPre_array_list = [];
			$questionsPost_array_list = [];
			
            $answersPre_array_list = [];
			$answersPost_array_list = [];
			
            $questionTypePre_list = [];
			$questionTypePost_list = [];
            
			$answer = [];
			
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
					
					$qType = ModelQuestionType::select($questions_arrayFromModel[$j]->getQuestionTypeId());
                    $answersPre_array = ModelAnswerType::getAnswerTypeByQuestionId($qType->getQuestionTypeId());
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
					$qType = ModelQuestionType::select($questions_arrayFromModel[$j]->getQuestionTypeId());
										
                    $answersPost_array = ModelAnswerType::getAnswerTypeByQuestionId($qType->getQuestionTypeId());
                    
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
			//var_dump($qPre);
			$qPost = json_decode($_POST["questionsPost"], true);
			$info = json_decode($_POST["information"], true);
			$fs = json_decode($_POST["FSQuestions"], true);
                        
			//var_dump($q);	
			$abort = false;
			
			$userNickname = $_SESSION['nickname'];
			
			/*
			for($i = 0; $i < sizeof($a); $i++){
				$formId = $formId . ucfirst(substr($a[$i]["name"], 0, 1));
			}*/
			
			
			$form = array(
						"formName" => json_decode($_POST["form"], true),
						"userNickname" => $userNickname,
						"completedForm" => 0,
						"fillable" => -1
					);
			$form["formId"] = "FO". ucfirst(substr($_SESSION["surname"], 0, 1)) . ucfirst(substr($_SESSION["forename"], 0, 1)) . $_SESSION["numberCreatedForm"] . strtoupper(substr($form['formName'], 0, 2));
			//ModelForm::beginTransaction();
			//var_dump($form);
			if(ModelForm::save($form)){
				$_SESSION["numberCreatedForm"]++;
				//$form['formId'] = ModelForm::getLastInsert();
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

                                                
                                                if(isset($qPre[$i][$y]["customAns"])){
                                                    $customAns = $qPre[$i][$y]["customAns"];
                                                    
                                                    $questionType = array(
                                                        "questionTypeName" => $customAns[0],
                                                        "userNickname" => $userNickname
                                                    );
                                                    if(!ModelQuestionType::save($questionType)){
							$abort = true;
							break;
                                                    }                                                    
                                                    
                                                    $questionTypeId = ModelQuestionType::getLastInsert();
                                                    $questionTypeName = $customAns[0];
                                                    
                                                    $original = ModelQuestionType::select($qPre[$i][$y]["type"]);
                                                    $originalName = $original->getQuestionTypeName();
                                                    
                                                    for($j = 1; $j < sizeof($customAns); $j++){
                                                        $answerType = array(
                                                            "answerTypeName" => $customAns[$j],
                                                            "answerTypeImage" => $originalName . $j ."image",
                                                            "questionTypeId" => $questionTypeId

                                                        );
                                                    if(!ModelAnswerType::save($answerType)){
							$abort = true;
							break;
                                                    }
                                                    }
                                                    //chercher questionTypeId grace à $q[$i][$y]["questionType"]
                                                    //$qTypeId
                                                    $question = array(
                                                            "questionId" => $form['formId'] . $qPre[$i][$y]["id"],
                                                            "questionName" => $qPre[$i][$y]["label"],
                                                            "applicationId" => $application["applicationId"],
                                                            "questionTypeId" => $questionTypeId,
                                                            "questionPre" => $qPre[$i][$y]["pre"]
                                                    );
                                                    if(!ModelQuestion::save($question)){
                                                            $abort = true;
                                                            break;
                                                    }
                                                    
                                                }else{
                                                
                                                    //chercher questionTypeId grace à $q[$i][$y]["questionType"]
                                                    //$qTypeId
                                                    $question = array(
                                                            "questionId" => $form['formId'] . $qPre[$i][$y]["id"],
                                                            "questionName" => $qPre[$i][$y]["label"],
                                                            "applicationId" => $application["applicationId"],
                                                            "questionTypeId" => $qPre[$i][$y]["type"],
                                                            "questionPre" => $qPre[$i][$y]["pre"]
                                                    );
                                                    if(!ModelQuestion::save($question)){
                                                            $abort = true;
                                                            break;
                                                    }
                                                }
					}

					for($y = 0; $y < sizeof($qPost[$i]); $y++){
                                                if(isset($qPost[$i][$y]["customAns"])){
                                                    $customAns = $qPost[$i][$y]["customAns"];
                                                    
                                                    $questionType = array(
                                                        "questionTypeName" => $customAns[0],
                                                        "userNickname" => $userNickname
                                                    );
                                                    if(!ModelQuestionType::save($questionType)){
							$abort = true;
							break;
                                                    }                                                    
                                                    
                                                    $questionTypeId = ModelQuestionType::getLastInsert();
                                                    $questionTypeName = $customAns[0];
                                                    
                                                    $original = ModelQuestionType::select($qPost[$i][$y]["type"]);
                                                    $originalName = $original->getQuestionTypeName();
                                                    
                                                    for($j = 1; $j < sizeof($customAns); $j++){
                                                        $answerType = array(
                                                            "answerTypeName" => $customAns[$j],
                                                            "answerTypeImage" => $originalName . $j ."image",
                                                            "questionTypeId" => $questionTypeId

                                                        );
                                                    if(!ModelAnswerType::save($answerType)){
							$abort = true;
							break;
                                                    }
                                                    }
                                                    //chercher questionTypeId grace à $q[$i][$y]["questionType"]
                                                    //$qTypeId
                                                    $question = array(
                                                            "questionId" => $form['formId'] . $qPost[$i][$y]["id"],
                                                            "questionName" => $qPost[$i][$y]["label"],
                                                            "applicationId" => $application["applicationId"],
                                                            "questionTypeId" => $questionTypeId,
                                                            "questionPre" => $qPost[$i][$y]["pre"]
                                                    );
                                                    if(!ModelQuestion::save($question)){
                                                            $abort = true;
                                                            break;
                                                    }
                                                    
                                                }else{
                                                
						//chercher questionTypeId grace à $q[$i][$y]["questionType"]
						//$qTypeId
						$question = array(
							"questionId" => $form['formId'] . $qPost[$i][$y]["id"],
							"questionName" => $qPost[$i][$y]["label"],
							"applicationId" => $application["applicationId"],
							"questionTypeId" => $qPost[$i][$y]["type"],
							"questionPre" => $qPost[$i][$y]["pre"]
						);
						if(!ModelQuestion::save($question)){
							$abort = true;
							break;
						}
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
		$view = 'sheet2View';
		$controller ='form';
		$pagetitle='Sheet 2';
		
		
		require File::build_path(array('view', 'view.php'));
	}
	/* desc Send the formId passed throught the url
	 * trigger Use when ?
	 * additional information Use for what ?
	 */
	public static function returnFormId(){
		$formId = json_decode($_GET['formId']);
		echo json_encode($formId);
	}
	
	/* desc Display a page containing all the persons who answered to the form (as a tab) and all the visitorID available
	 * 
	 * additional information 
	 */
	public static function whoAnswered(){
		if(Session::is_connected()){
			
			$controller ='form';
			$view = 'whoAnswered';
			$jscript = "whoAnswered";
			
			$formId = $_GET['id'];
			$pagetitle='Who answered '.$formId;
			$visitor = ModelForm::getVisitorsByFormId($formId);
			$questions = ModelAssocFormPI::getAssocFormPIByFormId($formId);
			$array = array();
			$i = 0;
			foreach($visitor as $v){
				$array[$i][0] = $v->getDateCompletePre();
				$array[$i][1] = ModelInformation::getInformationByVisitorId($v->getVisitorId());
				$array[$i][2] = $v->getVisitorSecretName();
				$array[$i][3] = $v->getVisitorId();
				$i++;
			}
			require File::build_path(array('view', 'view.php'));
		}else{
			$data["message"] = "Please log in to have access to this action. ";
			$data["pagetitle"] = "Not connectied";
			
			ControllerDefault::message($data);	
		}
	}
	
	/* desc Display the form with the answer of the visitor
	 * 
	 * additional information Display the pre and post questions, and all the tabs
	 */
	public static function readAnswer(){
		$controller = 'form';
		$view = 'displayForm';
		$jscript = "myScriptSheet";
		
		$visitorId = $_GET['visitorId'];
		$formId = $_GET['formId'];
		$pagetitle = 'Answer'.$visitorId;
		$full = true;
		
		$answer = ModelAnswer::getAnswerByVisitorId($visitorId);
		if($answer == null){
			$data["message"] = "The visitor hasn't answer to the form yet. ";
			$data["pagetitle"] = "No answer available";
			
			ControllerDefault::message($data);	
		}else {
			$toSplit = $answer[0]->getQuestionId();	
			$f = explode("A",$toSplit);
			$f = ModelForm::select($formId);
			
			$folder = $f->getUserNickname();
			
			$field_array = [];
			$application_array  = ModelApplication::getApplicationByFormId($f->getFormID());
			$informationTable = ModelInformation::getInformationByVisitorId($visitorId);
			$applicationTable = ModelApplication::getApplicationByFormId($formId);
			$alphabet = array('A', 'B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	
			
			$questionsPre_array_list = [];
			$questionsPost_array_list = [];
				
			$answersPre_array_list = [];
			$answersPost_array_list = [];
				
			$questionTypePre_list = [];
			$questionTypePost_list = [];
			
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
					
					$reponses = array();
					for($j=0; $j < count($questions_arrayFromModel);$j++){
						
						$qType = ModelQuestionType::select($questions_arrayFromModel[$j]->getQuestionTypeId());
						$answersPre_array = ModelAnswerType::getAnswerTypeByQuestionId($qType->getQuestionTypeId());
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
						$qType = ModelQuestionType::select($questions_arrayFromModel[$j]->getQuestionTypeId());
											
						$answersPost_array = ModelAnswerType::getAnswerTypeByQuestionId($qType->getQuestionTypeId());
						
						array_push($answersPost_array_list[$i], $answersPost_array);
						array_push($questionTypePost_list[$i], $qType);  
					}                
				}
			
			require File::build_path(array('view', 'view.php'));
		}
	}
	/*public static function completeFormBis(){
		
	}*/
	public function createVisitor(){
		$secretName = json_decode($_POST['secretName']);
		$visitorId = json_decode($_POST['visitorId']);
		$formId = json_decode($_POST['formId']);
		$visitor = array(
				"visitorId"=> $visitorId,
				"visitorSecretName" => $secretName
			);
		ModelVisitor::update($visitor);		
	}
	
	
	//JSON
	/* desc Save the personnal information
	 * trigger <<onchange>> event on each personnal information input (text)
	 * additional information An information is automaticly saved with the <<onchange>> event
	 */
	public static function saveInformation(){
		$personnalInformationName = json_decode($_POST['personnalInformationName']);
		$visitorId = json_decode($_POST['visitorId']);
		$informationName = json_decode($_POST['informationName']);
		$info = array(
			"personnalInformationName" => $personnalInformationName,
			"informationName" => $informationName,
			"visitorId" => $visitorId
		);
		//var_dump($info);
		ModelInformation::update($info);
	}
	
	
	//JSON
	/* desc Save the answer of a question 
	 * trigger <<onchange>> event on each question input (text, radiobutton)
	 * additional information An answer is automaticly saved with the <<onchange>> event
	 */
	public static function saveAnswer(){
		$visitorId = json_decode($_POST['visitorId']);
		$questionId = json_decode($_POST['questionId']);
		$answer = json_decode($_POST['answer']);
		
		$data = array(
			"visitorId" => $visitorId,
			"questionId" => $questionId,
			"answer" => $answer
		);
		echo json_encode(ModelAnswer::update($data));
	}
	
	public static function saveAA(){
		$visitorId = json_decode($_POST['visitorId']);
		$applicationId = json_decode($_POST['applicationId']);
		$value = json_decode($_POST['value']);
		
		$data = array(
			"visitorId" => $visitorId,
			"applicationId" => $applicationId,
			"again" => $value
		);
		echo json_encode(ModelAgainAgain::update($data));
	}
	//JSON
	/* desc Update the visitor dateCompletePre filling it with the current date
	 * trigger Click on the submit button on the completed form page
	 * additional information It means that the visitor has completed the PRE form and submit ALL the answers (and that he clicked on the submit button)
	 */
	public static function completedPre(){
		$visitorId = json_decode($_POST['visitorId']);
		$dataV = array(
			"visitorId" => $visitorId,
			"dateCompletePre" => date('Y/m/d H:i:s')
		);
		echo json_encode(ModelVisitor::update($dataV));
	}
	
	public static function completeForm(){
		
		$answers = json_decode($_POST['answers'], true);
		$formId = $_POST['formId'];
		$f = ModelForm::select($formId);
		$pre = $_POST['pre'];
		$secretName = json_decode($_POST['secretName']);
		$visitorId = json_decode($_POST['visitorId']);
		var_dump( $visitorId);
		if($pre == 0){

		//Create the visitor
			$visitorInfo = json_decode($_POST['visitorInfo'], true);
			//var_dump($visitorInfo);
		/*	$visitor = array(
				"visitorId"=> $visitorId,
				"visitorSecretName" => $secretName
			);
			ModelVisitor::update($visitor);*/
			
			foreach($visitorInfo as $f){
				$f["visitorId"] = $visitorId;
				ModelInformation::save($f);
			}
			
			$date = array(
				"dateCompletePre" => date('Y/m/d H:i:s'),
				"visitorId" => $visitorId
			);
			//var_dump($date);
			ModelVisitor::update($date);
		}
		else{
			$id = $_POST['visitorId'];
			$date = array(
				"dateCompletePost" => date('Y/m/d H:i:s'),
				"visitorId" => $visitorId,
				"formId" => $formId
			);
			//var_dump($date);
			//ModelDateComplete::update($date);
			
			$fs = json_decode($_POST['fs'], true);
			//var_dump($fs);
			foreach($fs as $f){
				$data = array(
					"visitorId" => $id,
					"FSQuestionName" => $f["name"],
					"applicationOrder" => json_encode($f["tab"])
				);
				ModelSortApplication::save($data);
			}
			$aa = json_decode($_POST['aa'], true);
			$answer = ["No", "Maybe", "Yes"];
			var_dump($aa);
			foreach($aa as $a){
				$test = $formId."Applic".$a["applicationId"];
				echo $test;
				$data = array(
					"visitorId" => $id,
					"applicationId" => $test,
					"again" => $answer[$a["again"]]
				);
				ModelAgainAgain::save($data);
			}
		}
		
		for($i = 0; $i < count($answers); $i++){
			$ans = $answers[$i];
			$ans['visitorId'] = $visitorId;
			//var_dump($ans);
			//ModelAnswer::save($ans);
		}
	}

    public static function toPDF(){
        
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        ob_start(); 
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('ChiCl');
        $pdf->SetTitle('exported form');
        $pdf->SetSubject('form');
        $pdf->SetKeywords('');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        // ---------------------------------------------------------

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('dejavusans', '', 14, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // set text shadow effect
        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

        // Set some content to print

        $html = file_get_contents('http://localhost/www/tests/index.php?controller=form&action=read&id=1');
        //echo $html;
        /*$html = <<<EOD

        EOD;*/

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        //Close and output PDF document
        $pdf->Output('form.pdf', 'I');
    }
	
	public static function changeFillable(){
		if(Session::is_connected()){
			$form = json_decode($_POST["form"], true);
			$newFill = json_decode($_POST["newFill"], true);
			
			$selectForm = ModelForm::select($form);
			//var_dump($selectForm);
			$selectForm->setFillable($newFill);
			//var_dump($selectForm);
			$form = array(
						"formId" => $selectForm->getFormId(),
						"formName" => $selectForm->getFormName(),
						"userNickname" => $selectForm->getUserNickname(),
						"completedForm" => $selectForm->getCompletedForm(),
						"fillable" => $selectForm->getFillable()
					);
			if(ModelForm::update($form)){
				echo json_encode("Success");
			}
			else{
				echo json_encode("Error");
			}
		}else{
			echo json_encode("Error, not connected. ");
		}
	}
	/* desc Display a page containing all the forms created by any users for the admin
	 *
	 */
	public static function readAll(){
		if(Session::is_connected() && Session::is_admin()){
			$view = 'displayAllMyForms';
			$controller = 'users';
			$pagetitle = 'All the user forms';
			
			$form = ModelForm::selectAll();
			$tmp = ModelUsers::getCreatorUsers();
			
			//Create an associative array with the nickname of the creator as key and a concatenation of the forename and the surname as value
			foreach($tmp as $u){
				$readAll[$u->getNickname()] = $u->getForename() . " " . $u->getSurname();
			}

			require File::build_path(array('view','view.php'));	
		}else{
			$data["message"] = "Regular users are not allowed to see all the user forms. ";
			$data["pagetitle"] = "Persmission denied";
			
			ControllerDefault::message($data);	
		}
	}
}
?>