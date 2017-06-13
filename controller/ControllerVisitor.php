<?php
require_once File::build_path(array('model', 'ModelVisitor.php'));
require_once File::build_path(array('model', 'ModelApplicationDateComplete.php'));

class ControllerVisitor{
    /*@author Alexandre Comas
	 * desc : Display the form for the visitor, in order he to fill it
	 */
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
			//Test if the visitor has completed the Pre or not
			if($visitor->getDateCompletePre() == null){
				$pre = 0;
			}else{
				$pre = 1;
			}			
			$FSQuestionTable = ModelFSQuestion::getFSQuestionByFormId($formId);
			
			if($pre === 0){
				$jscript = "answers";
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
				
				//Randomize AATable
				$randomTable = [];
				$nb = count($application_array);
				for($i = 0; $i<$nb ;$i++){
					$tmp = rand(1,$nb); //Choose a number between 1 and $nb
					while(in_array($tmp,$randomTable)){
						$tmp = rand(1,$nb);
					}
					array_push($randomTable, $tmp);
				}
				$AAFilled = ModelAgainAgain::getAgainAgainByVisitorId($visitorId);
				
				//RandomizeFSTable
				$alphabet = Array ('A', 'B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

				$randomFS =[];
				$FS = ModelFSQuestion::getFSQuestionByFormId($formId);
				$nbFS = count($FS);
				for($i = 0; $i<$nbFS ;$i++){
					$tmp = rand(1,$nbFS);
					while(in_array($tmp,$randomFS)){
						$tmp = rand(1,$nbFS);
					}
					array_push($randomFS, $tmp);
				}				
				$FSFilled = ModelSortApplication::getFSByVisitorId($visitorId);
				
				$jscript = "answers";
				$pagetitle = 'Welcome back visitor';
				$view='lastPage';
				$controller = 'visitor';
			} //Put a default view if form is not available yet

            require File::build_path(array('view','view.php'));
		}
    }
	
	/* @author Alexandre Comas
	 * desc : Function called when the button addVisitor is pressed
	 */
	public static function addVisitor(){
		/* When a visitor is created, everything about him is created on the dataBase's tables
		 * -Visitor
		 * -Answers
		 * -Information
		 * -AgainAgainAnswers
		 * -FSQuestionsAnswers(SortApplication Table)
		 * Doing like this, nothing has to be created when you wanna save somethink, just to update, knowing the prmiary key(s)
		 */
		$return = true;
		$visitorId = json_decode($_POST['visitorId']); 
		$formId = json_decode($_POST['formId']);
		
		$form = ModelForm::select($formId);
		$applications = ModelApplication::getApplicationByFormId($formId);
		
		$applicationOrder = [];
		$nbApplications = count($applications);
		while($nbApplications != 0 ){
		  $nombre = mt_rand(0, count($applications)-1);
		  if(!in_array($nombre, $applicationOrder)){
			$applicationOrder[] = $nombre;
			$nbApplications--;
		  }
		}
		//Add a line in table Visitor
		$data = array(
				"visitorId" => $visitorId,
				"formId" => $formId,
				"applicationOrder" => json_encode($applicationOrder)
			);
			
		if(!(ModelVisitor::save($data))){
			$return = false;
		}
		
		//Foreach application add a line in ApplicationDateComplete	 and foreach question add a line to the table Answer with the answer null
		foreach($applications as $a){
			$applicationId = $a->getApplicationId();
			$questions = ModelQuestion::getQuestionByApplicationId($applicationId);
			$data = array(
					"visitorId" => $visitorId,
					"applicationId" => $applicationId
			);
			if(!ModelApplicationDateComplete::save($data)){
				$return = false;
			}
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
		
		//Foreach PersonnalInformation required in this form, add a line in Information
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
		//Foreach Application add a line in AgainAgain with the answer null
		foreach($applications as $app){
			$datAA = array(
				"visitorId" => $visitorId,
				"applicationId" => $app->getApplicationId()
			);
			if(!(ModelAgainAgain::save($datAA))){
				$return = false;
			}
		}
		//Foreach FSQuestion add a line in SortApplication with the answer null
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
	
	/* @author Alexandre Comas
	 * JSON
	 * desc : send the form if with a given form Id
	 */
	public static function getFormIdByVisitor(){
		$visitorId = json_decode($_POST['visitorId']);
		echo json_encod	(ModelVisitor::Select($visitorId)->getformId());
	}
	
	/* @author Alexandre Comas
	 * JSON
	 * desc : Return an array made of applicactionId and the related answer for a given visitorId
	 */
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
	
	
	//I wrote this function but i'm not sure if it will be usefull or not
	//Now I am pretty sure it is useless
	/*public static function getVisitorSecretName(){
		$visitorId = json_decode($_POST['visitorId']);
		$s = ModelVisitor::Select($visitorId)->getVisitorSecretName();
		if ($s == null){
			echo json_encode(false);
		} else {
		echo json_encode(true);
		}
	}*/
	
	public static function read2(){
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
		
		//Collecting the form from the bd
        $f = ModelForm::select($formId);
		
		//The form doesn't exist
        if (!$f){
			$data["message"] = "This form doesn't exist. ";
			$data["pagetitle"] = "Read form error";
			
			ControllerDefault::message($data);	
        }
		//The form does exist
		else{
			//Collection the list of applications
			$applications = ModelApplication::getApplicationByFormId($formId);
			$applicationOrder = json_decode($visitor->getApplicationOrder());
			
			//Collecting the name of the creator, name of the folder where the img might have beend saved
			$folder = $f->getUserNickname();
			
			
			//$jscript = "";
			$stylesheet = "welcomeVisitorApplication";
			$pagetitle = 'Welcome on board';
			//Le nom sera a changé, je ne savais pas comment appeler cette page
			$view='welcome';
			$controller = 'visitor';

            require File::build_path(array('view','view.php'));
		}
	}
	
	public static function answerApplication(){
		if(!isset($_GET['visitorId']) || !isset($_GET['formId'])){
			$data["message"] = "There are not enough information. ";
			$data["pagetitle"] = "Information missing";
			
			ControllerDefault::message($data);
			return null;
		}
		
		$formId = $_GET['formId'];
		$f = ModelForm::select($formId);
		if(!$f){
			$data["message"] = "The form doesn't exist. ";
			$data["pagetitle"] = "Unknown form";
			
			ControllerDefault::message($data);
			return null;
		}
		//Checking if the visitor exists
		$visitorId = $_GET['visitorId'];
		
		$visitor = ModelVisitor::select($visitorId);
		if(!$visitor){
			$data["message"] = "The visitor doesn't exist. ";
			$data["pagetitle"] = "Anonymous visitor";
			
			ControllerDefault::message($data);
			return null;	
		}
		if($visitor->getFormId() != $formId){
			$data["message"] = "The visitor doesn't belong to this form";
			$data["pagetitle"] = "Wrong form";
			
			ControllerDefault::message($data);
			return null;
		}
		
		
		$application_array  = ModelApplication::getApplicationByFormId($f->getFormID());
		
		$infoEmpty = false;
		$info = ModelInformation::getInformationByVisitorId($visitorId);
		foreach($info as $i){
			if($i->getInformationName() == NULL){
			$infoEmpty = true;
			}
		}
		if($infoEmpty){
			$field_array = [];
			
			$assoc_array = ModelAssocFormPI::getAssocFormPIByFormId($formId); //get associations Form PersonnalInformation
			foreach ($assoc_array as $assoc){
				$perso_inf_id = $assoc->getPersonnalInformationName();
				$perso_inf = ModelPersonnalInformation::select($perso_inf_id); //get PersonnalInformation of Asooctiation $assoc
				
				array_push($field_array, $perso_inf);					
			}
			$folder = $f->getUserNickname();
			
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
			$jscript = 'answers';
			$pagetitle = 'Welcome visitor';
			$view='answerForm';
			$controller = 'visitor';
			require File::build_path(array('view','view.php'));
			return;
		}
		
		
		//We will check if each application is completed for this visitorId and $full will get true if any date is null
		$fullDate = true;
		$appliComplete = ModelApplicationDateComplete::getApplicationDateCompleteByVisitorId($visitorId);
		foreach($appliComplete as $ac){
			$data = array(
				"applicationId" => $ac->getApplicationId(),
				"visitorId" => $visitorId
			);
			$s = ModelApplicationDateComplete::select($data);
			if($s->getApplicationDateCompletePre() == null || $s->getApplicationDateCompletePost() == null){
				$fullDate = false;
			}
		}
		if(!$fullDate){
			$visitor = ModelVisitor::select($visitorId);
			$appliOrder = $visitor->getApplicationOrder();
			$applicationOrder = json_decode($appliOrder);
			//Checking if the application does exist in the database
			
			
			$applicationId = $formId."Applic".$applicationOrder[0];
			$application = ModelApplication::select($applicationId);
			$pre = $visitor->getApplicationPreOrPost($applicationId);
			
			$i = 0;
			while($i<sizeOf($applicationOrder)-1 && $pre == 2){
				$i++;
				$applicationId = $formId."Applic".$applicationOrder[$i];
				$application = ModelApplication::select($applicationId);
				$pre = $visitor->getApplicationPreOrPost($applicationId);
			}
			if($application->getFormId() == $formId){
				//If there is a date in the dateCompletePre field that means the visitor has already 
				//answer the pre
				$pre = $visitor->getApplicationPreOrPost($applicationId);
				$questions = ModelQuestion::getQuestionByApplicationIdAndPre($applicationId, $pre);
				
				//This array will contain the answer of the question
				$question_answers = [];
				
				//This array will contain the answer of the visitor
				$visitorAnswers = [];
				
				foreach($questions as $q){
					array_push($question_answers, ModelAnswerType::getAnswerTypeByQuestionId($q->getQuestionTypeId()));
					$data = array(
						"visitorId" => $visitorId,
						"questionId" => $q->getQuestionId()
					);
					array_push($visitorAnswers, ModelAnswer::select($data));
				}
				//var_dump($visitorAnswers);
			}
			
		}else {
			//AATable
			$randomTable = [];
			$nb = count($application_array);
			for($i = 0; $i<$nb ;$i++){
				$tmp = rand(1,$nb);
				while(in_array($tmp,$randomTable)){
					$tmp = rand(1,$nb);
				}
				array_push($randomTable, $tmp);
			}
			$AAFilled = ModelAgainAgain::getAgainAgainByVisitorId($visitorId);
			
			//FSTable
			$alphabet = Array ('A', 'B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

			$randomFS =[];
			$FS = ModelFSQuestion::getFSQuestionByFormId($formId);
			$nbFS = count($FS);
			for($i = 0; $i<$nbFS ;$i++){
				$tmp = rand(1,$nbFS);
				while(in_array($tmp,$randomFS)){
					$tmp = rand(1,$nbFS);
				}
				array_push($randomFS, $tmp);
			}
			
			$FSFilled = ModelSortApplication::getFSByVisitorId($visitorId);
		}
		//var_dump($fullDate);
	
		
		
		$folder = $f->getUserNickname();
		$jscript = "answerApplication";
		$stylesheet = "answerApplication";
		$pagetitle = 'Welcome on board';
		//Le nom sera a changé, je ne savais pas comment appeler cette page
		$view='answerApplication';
		$controller = 'visitor';

		require File::build_path(array('view','view.php'));
	}
	
	public static function sendAnswer(){
		$applicationId = $_POST['applicationId'];
		$visitorId = $_POST['visitorId'];
		$post = ($_POST['pre'] == 0?"post":($_POST['pre'] == 1?"pre":"null"));

		$data = array(
				"visitorId" => $visitorId,
				"applicationId" => $applicationId, 
				"applicationDateComplete" . ucfirst($post) => date('Y/m/d H:i:s')
		);
		$return = true;
		if(!ModelApplicationDateComplete::update($data)){
			$return = false;
		}	
		echo json_encode($return);
	}
	public static function sendEnd(){
		$visitorId = $_POST['visitorId'];
		
		$data = array(
			"visitorId" => $visitorId,
			"dateCompletePost" => date('Y/m/d H:i:s')
		);
		$return = true;
		if(!ModelVisitor::update($data)){
			$return = false;
		}	
		echo json_encode($return);		
	}
	
	public static function ended(){
		$pagetitle = 'End of the form';
		$controller = 'visitor';
		$view = 'end';
		require File::build_path(array('view','view.php'));
	}
}
?>