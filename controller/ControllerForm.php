<?php
require_once File::build_path(array('model', 'ModelForm.php'));


require_once File::build_path(array('model', 'ModelAgainAgain.php'));

require_once File::build_path(array('model', 'ModelSortApplication.php'));

use Dompdf\Dompdf;


class ControllerForm {
    /*
     * desc Prepare the display of the fillable form
     * additional information Getting all data from DB into arrays 
     */
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
			
			$visitorId = $formId . "Example";
			
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
                $questions_arrayFromModel = ModelQuestion::getQuestionByApplicationIdAndPre($application_array[$i]->getApplicationId(),"1"); // getting questions
                array_push($questionsPre_array_list, $questions_arrayFromModel);
                
                array_push($answersPre_array_list, []);
                array_push($questionTypePre_list, []);
                
                for($j=0; $j < count($questions_arrayFromModel);$j++){
					
					$qType = ModelQuestionType::select($questions_arrayFromModel[$j]->getQuestionTypeId());
                    $answersPre_array = ModelAnswerType::getAnswerTypeByQuestionId($qType->getQuestionTypeId()); //getting answers
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
    
	/* desc Opening creation view
     * 
     */
	public static function create(){
		
		if(Session::is_connected()){
			$view = 'createForm';
			$controller = 'form';
			$pagetitle = 'Create Form';
			$jscript = "createForm";
			
			$formId = "newForm";
			
			$defaultInfo = ModelPersonnalInformation::getDefaultPersonnalInformation();
			$defaultFS = ModelFSQuestion::getDefaultFSQuestion();
			
			
			$create = true;
			
			require File::build_path(array('view', 'view.php'));	
		}

	}
	
	public static function update(){
		
		if(isset($_GET["id"])){
			$formId = $_GET["id"];
			$form = ModelForm::select($formId);
			if(!$form){
			$data["message"] = "The form doesn't exist. ";
			$data["pagetitle"] = "Form error";
			
			ControllerDefault::message($data);
			return null;
			}
			if($_SESSION['nickname'] == $form->getUserNickname() || Session::is_admin()){
				$formName = $form->getFormName();
				$view = 'createForm';
				$controller = 'form';
				$pagetitle = 'Update Form ' . $formId;
				$jscript = "updateForm";
				
				$create = false;
				$folder = $_SESSION['nickname'];
				
				$selectPlaceholders = ModelQuestionType::getQuestionTypeForUser($form->getUserNickname());
				
				//Collect the personnal information (default and custom)
				$defaultInfo = ModelPersonnalInformation::getDefaultPersonnalInformation();
				$personnalInformation = ModelAssocFormPI::getAssocFormPIByFormId($formId);
				
				//Collect the FS questions (default and custom)
				$defaultFS = ModelFSQuestion::getDefaultFSQuestion();
				$fsQuestion = ModelFSQuestion::getFSQuestionByFormId($formId);
				
				//Collect the applications
				$applications = ModelApplication::getApplicationByFormId($formId);
				
				//Collect the questions pre and post by applications
				$questions_pre = [];
				$questions_post = [];
				$answer_pre = [];
				$answer_post = [];
				foreach($applications as $a){
					$appliId = $a->getApplicationId();
					$questions_pre[$appliId] = ModelQuestion::getQuestionByApplicationIdAndPre($appliId, 1);
					$questions_post[$appliId] = ModelQuestion::getQuestionByApplicationIdAndPre($appliId, 0);
					
					//Collect the answer for the pre questions
					//foreach question of the application 
					/*foreach($questions_pre[$appliId] as $q){
						$questionId = $q->getQuestionId();
						$questionTypeId = $q->getQuestionTypeId();
						//$answer_pre[$appliId][$questionId] = ModelAnswerType::getAnswerTypeByQuestionId($questionTypeId);
					}*/
					//Collect the answer for the post questions
					//foreach question of the application 
					/*foreach($questions_post[$appliId] as $q){
						$questionId = $q->getQuestionId();
						$questionTypeId = $q->getQuestionTypeId();
						//$answer_post[$appliId][$questionId] = ModelAnswerType::getAnswerTypeByQuestionId($questionTypeId, 1);
					}*/
					
				}
	
				
				require File::build_path(array('view', 'view.php'));
			}else{
				$data["message"] = "You are not the owner of the form. ";
				$data["pagetitle"] = "Owner error";
				
				ControllerDefault::message($data);
			}
			

		}else{
			$data["message"] = "The form doesn't exist. ";
			$data["pagetitle"] = "Form error";
			
			ControllerDefault::message($data);
		}

	}
	
	/*desc getting post info from filled form, save them into DB
	 * 
	 */
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
                                                // if the question has custom answers, saving them + corresponding new QuestionType
                                                    $customAns = $qPre[$i][$y]["customAns"];
                                                    
                                                    $questionType = array(
                                                        "questionTypeName" => $customAns[0], //title choose by user
                                                        "userNickname" => $userNickname
                                                    );
                                                    if(!ModelQuestionType::save($questionType)){
							$abort = true;
							break;
                                                    }                                                    
                                                    
                                                    $questionTypeId = ModelQuestionType::getLastInsert(); //answerType will be linked to the qType juste created
                                                    $questionTypeName = $customAns[0];
                                                    
                                                    //getting questionType which new questionType is based on
                                                    //its name will be used to construct image name to have same images
                                                    $original = ModelQuestionType::select($qPre[$i][$y]["type"]); 
                                                    $originalName = $original->getQuestionTypeName();
                                                    
                                                    for($j = 1; $j < sizeof($customAns); $j++){
                                                        $answerType = array(
                                                            "answerTypeName" => $customAns[$j],
                                                            "answerTypeImage" => $originalName . $j ."image", //construction of image name ex : smiley2image
                                                            "questionTypeId" => $questionTypeId

                                                        );
                                                    if(!ModelAnswerType::save($answerType)){
							$abort = true;
							break;
                                                    }
                                                    }
                                                    //searching questionTypeId with $q[$i][$y]["questionType"]
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
                                                
                                                    //searching questionTypeId with $q[$i][$y]["questionType"]
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
                                        //same for post questions
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
				
				//AATable
				
			
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
	
	public static function saveAA(){ //Function called on change of AATable
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
	
	public static function saveFS(){	//Function called on change of the funsorter
		$visitorId = json_decode($_POST['visitorId']);
		$FSQuestionName = json_decode($_POST['FSQuestionName']);
		$applicationOrder = json_decode($_POST['applicationOrder']);
		
		$data = array (
			"visitorId" => $visitorId,
			"FSQuestionName" => $FSQuestionName,
			"applicationRatingOrder" => $applicationOrder
		);
		var_dump($data);
		echo json_encode(ModelSortApplication::update($data));
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
	
	public static function completedPost(){
		$visitorId = json_decode($_POST['visitorId']);
		$dataV = array(
			"visitorId" => $visitorId,
			"dateCompletePost" => date('Y/m/d H:i:s')
		);
		echo json_encode(ModelVisitor::update($dataV));
	}
	
	//This function is now outdated with the saveOnchange functions
	/*public static function completeForm(){
		
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
			$visitor = array(
				"visitorId"=> $visitorId,
				"visitorSecretName" => $secretName
			);
			ModelVisitor::update($visitor);
			
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
	} */

    /* desc making the pdf for paper version
     * 
     * making the pdf from all the pages of the differents activities
     */        
    public static function toPDF() {
        $formId = $_GET['id'];
       
        $tabPages = self::preparePDF($formId);//getting the pages
        
        $html=""; //initializing html content str
        
        $html.=$tabPages[0]; //to have 2 first pages in one
        
        for($pageCpt = 1;$pageCpt < count($tabPages)-2;$pageCpt++){ 
            $html.=$tabPages[$pageCpt];                                 //adding page
            $html.= '<div style="page-break-before: always;"></div>';   //adding page break
        }
        $html.=$tabPages[count($tabPages)-1]; //adding last page without page break (putting white page at the end otherwise

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();
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
                        $stylesheet = 'admin';
			
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
	
	public static function analytics(){
		if(Session::is_connected()){
			$view = 'displayAnalytics';
			$controller = 'form';
			//$jscript = "myScriptSheet";
		
			
			$formId = $_GET['id'];
			$pagetitle = 'Answer anaylics';
			$full = true;
			
			$f = ModelForm::select($formId);
			
			$folder = $f->getUserNickname();
			
			$complete = ModelForm::getCompletedFormByForm($formId);
			if(sizeof($complete) !=0){
				$completed = $complete[0]['nb'];
			} else {
				$completed = 0;
			}
			
			$questionsTable = ModelQuestion::getQuestionByFormId($formId);
			$allAnswers =[];
			foreach($questionsTable as $qt){
				$answers = $qt->getAnswerArrayByQuestionId();
				$allAnswers[$qt->getQuestionId()] = $answers;
				$qaz = ModelAnswer::getAnswerByQuestionId($qt->getQuestionId());
				$allAnswers[$qt->getQuestionId()]["nb"] = sizeof($qaz);
			}
			
			$applicationTable = ModelApplication::getApplicationByFormId($formId);
			$appResults=[];
			foreach($applicationTable as $at){
				$appId = $at->getApplicationId();
				$appResults[$appId]= ModelAgainAgain::getAgainAgainByApplicationId($appId);
			}
			//var_dump($appResults);
			
		
			
			
			
			
			
			
			
			
			$field_array = [];
			$application_array  = ModelApplication::getApplicationByFormId($f->getFormID());
			
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
				
				//AATable
				
			
			require File::build_path(array('view', 'view.php'));
		}
	}
    /* desc preparing the pages for the toPDF version
     * param -id the form id
     * return an array of all the pages of the paper form
     *      first page = personnals information
     *      1 page per pre or post activity
     *       
     */          
    public static function preparePDF($id = NULL) {
        
        //same part as read with some simplifications
        if(isset($_GET['id'])){
            $formId = $_GET['id'];
        }else{
            $formId = $id;
        }
        $f = ModelForm::select($formId);
        $tabPages = [];

        if (!$f) {
            $data["message"] = "The form doesn't exist. ";
            $data["pagetitle"] = "Read form error";

            ControllerDefault::message($data);
        } else {

            $folder = $f->getUserNickname();
            $application_array = ModelApplication::getApplicationByFormId($f->getFormID());

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
            foreach ($assoc_array as $assoc) {
                $perso_inf_id = $assoc->getPersonnalInformationName();
                $perso_inf = ModelPersonnalInformation::select($perso_inf_id); //get PersonnalInformation of Asooctiation $assoc

                array_push($field_array, $perso_inf);
            }

            //PRE Questions
            for ($i = 0; $i < count($application_array); $i++) {
                $questionAndAnswer = [];
                $questions_arrayFromModel = ModelQuestion::getQuestionByApplicationIdAndPre($application_array[$i]->getApplicationId(), "1"); // getting questions
                array_push($questionsPre_array_list, $questions_arrayFromModel);

                array_push($answersPre_array_list, []);
                array_push($questionTypePre_list, []);

                for ($j = 0; $j < count($questions_arrayFromModel); $j++) {

                    $qType = ModelQuestionType::select($questions_arrayFromModel[$j]->getQuestionTypeId());
                    $answersPre_array = ModelAnswerType::getAnswerTypeByQuestionId($qType->getQuestionTypeId()); //getting answers
                    array_push($answersPre_array_list[$i], $answersPre_array);
                    array_push($questionTypePre_list[$i], $qType);
                }
            }

            //POST Questions
            for ($i = 0; $i < count($application_array); $i++) {
                $questionAndAnswer = [];
                $questions_arrayFromModel = ModelQuestion::getQuestionByApplicationIdAndPre($application_array[$i]->getApplicationId(), "0");
                array_push($questionsPost_array_list, $questions_arrayFromModel);

                array_push($answersPost_array_list, []);
                array_push($questionTypePost_list, []);

                for ($j = 0; $j < count($questions_arrayFromModel); $j++) {
                    $qType = ModelQuestionType::select($questions_arrayFromModel[$j]->getQuestionTypeId());

                    $answersPost_array = ModelAnswerType::getAnswerTypeByQuestionId($qType->getQuestionTypeId());

                    array_push($answersPost_array_list[$i], $answersPost_array);
                    array_push($questionTypePost_list[$i], $qType);
                }
            }

            $alphabet = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

            $FSQuestionTable = ModelFSQuestion::getFSQuestionByFormId($formId);
            $applicationTable = ModelApplication::getApplicationByFormId($formId);
            
            //============ STARTING PAGE GENERATION ===========
            
            //----------- page 1 personnal info
            $page1 = "";
            
            $formName = htmlspecialchars($f->getFormName());

            //displaying form  informations
            $page1 .= "<h1> $formName </h1><br><br>";
            foreach ($field_array as $field) {
                $fieldName = htmlspecialchars($field->getPersonnalInformationName());
                    $page1 .= '<div>';
                    $page1 .= '<label for="field' . $fieldName . '">' . $fieldName . ' : </label>';
                    $page1 .= '<input id="field' . $fieldName . '" name="' . $fieldName . '"  type="text">';
                    $page1 .= '</div>';

            }
            array_push($tabPages, $page1);
           
            //---------- Next pages : activities : pre post, pre post...
            	//displaying tasks
                for ($i = 0; $i < count($application_array); $i++) {
                    
                    $currentPage=""; //current page var 
                    $taskName = htmlspecialchars($application_array[$i]->getApplicationName());
                    $taskDesc = htmlspecialchars($application_array[$i]->getApplicationDescription());
                    $img = "media/" . $folder . "/" . $application_array[$i]->getApplicationId() . "Img.png";

                    $currentPage.= "<h2>$taskName</h2>";
                    if (file_exists($img)) {
                        $currentPage.= "<img src = $img >";
                    }
                    $currentPage.="<br>";


                    $questionPre_array = $questionsPre_array_list[$i];

                    for ($j = 0; $j < count($questionPre_array); $j++) {
                        //adding title to page
                        $currentPage.= "<h3> ";
                        $currentPage.= htmlspecialchars($questionPre_array[$j]->getQuestionName());
                        $currentPage.= " </h3><br>";
                        
                        $qType = $questionTypePre_list[$i][$j];
                        $answers_array = $answersPre_array_list[$i][$j];
                        
                        //diplaying answers
                        if (!is_null($answers_array[0])) {
                            switch ($answers_array[0]['answerTypeName']) {
                                case "textarea":

                                    $currentPage.="<br><br><br><br><br><br>";
                                    break;
                                default :
                                    
                                    $currentPage.='<table style="width:100%"><tbody><tr>'; //opening answers tab
                                    foreach ($answers_array as $a) {
                                        $currentPage.='<th>'; //opening answers case
                                        
                                            $answerName = htmlspecialchars($a['answerTypeName']);
                                            $answerImage = htmlspecialchars($a['answerTypeImage']);
                                            $questionTypeId = htmlspecialchars($questionPre_array[$j]->getQuestionTypeId());
                                            $answerTypeId = htmlspecialchars($a['answerTypeId']);
                                            $id = "Applic" . $i . "question" . $j . $answerName;
                                            $name = "Applic" . $i . "question" . $j;
                                            
                                            $currentPage.='<table style="width:100%"><tbody>'; //sub table
                                                $currentPage.="<tr><th>"; //opening answers subcase
                                                    $currentPage.=$answerName; 
                                                $currentPage.='</th></tr>'; //closing answers subcase

                                                $currentPage.="<tr><th>"; //opening answers subcase
                                                    $currentPage.="<img src=\"media/$answerImage.png\" class=\"answerIcon\">"; 
                                                $currentPage.='</th></tr>'; //closing answers subcase

                                                $currentPage.="<tr><th>"; //opening answers subcase
                                                    $currentPage.="<input type =\"radio\" name=\"$name\" value =\"$answerName\" id=\"$id\">"; 
                                                $currentPage.='</th></tr>'; //closing answers subcase   
                                            $currentPage.='</tbody></table>'; //closing sub table

                                        
                                        $currentPage.='</th>'; //closing answers case
                                    }
                                    $currentPage.='</tr></tbody></table>'; //closing answers tab
                                    break;
                            }
                        }



                    }
                    array_push($tabPages, $currentPage); //pushing page to array
                    
                    //post questions
                    $currentPage="";
                    $questionPost_array = $questionsPost_array_list[$i];

                    for ($j = 0; $j < count($questionPost_array); $j++) {
                        //displaying questions
                        $currentPage.= "<h3> ";
                        $currentPage.= htmlspecialchars($questionPost_array[$j]->getQuestionName());
                        $currentPage.= " </h3><br>";
                        
                        $qType = $questionTypePost_list[$i][$j];

                        $answers_array = $answersPost_array_list[$i][$j];
  
                        if (!is_null($answers_array[0])) {
                            switch ($answers_array[0]['answerTypeName']) {
                                case "textarea":

                                    $currentPage.="<br><br><br><br><br><br>";
                                    break;
                                default :
                                    
                                    $currentPage.='<table style="width:100%"><tbody><tr>'; //opening answers tab
                                    foreach ($answers_array as $a) {
                                        $currentPage.='<th>'; //opening answers case
                                        
                                            $answerName = htmlspecialchars($a['answerTypeName']);
                                            $answerImage = htmlspecialchars($a['answerTypeImage']);
                                            $questionTypeId = htmlspecialchars($questionPre_array[$j]->getQuestionTypeId());
                                            $answerTypeId = htmlspecialchars($a['answerTypeId']);
                                            $id = "Applic" . $i . "question" . $j . $answerName;
                                            $name = "Applic" . $i . "question" . $j;
                                            
                                            $currentPage.='<table style="width:100%"><tbody>'; //sub table
                                                $currentPage.='<tr><th style = "text-align : center">'; //opening answers subcase
                                                    $currentPage.=$answerName; 
                                                $currentPage.='</th></tr>'; //closing answers subcase

                                                $currentPage.="<tr><th>"; //opening answers subcase
                                                    $currentPage.="<img src=\"media/$answerImage.png\" class=\"answerIcon\" >"; 
                                                $currentPage.='</th></tr>'; //closing answers subcase

                                                $currentPage.='<tr><th style = "">'; //opening answers subcase
                                                    $currentPage.="<input type =\"radio\" name=\"$name\" value =\"$answerName\" id=\"$id\">"; 
                                                $currentPage.='</th></tr>'; //closing answers subcase   
                                            $currentPage.='</tbody></table>'; //closing sub table

                                        
                                        $currentPage.='</th>'; //closing answers case
                                    }
                                    $currentPage.='</tr></tbody></table>'; //closing answers tab
                                    break;
                            }
                        }



                    }
                    array_push($tabPages, $currentPage); //pushing page to array                    
                    

                }
                return $tabPages;

            }
    }

}
?>