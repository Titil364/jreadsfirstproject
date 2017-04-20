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

    public static function toPDF(){
        
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        ob_start(); 
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('ChiCI');
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

        $html =file_get_contents('http://localhost/www/tests/index.php?controller=form&action=read&id=1');
        //echo $html;
        /*$html = <<<EOD

        EOD;*/

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        //Close and output PDF document
        $pdf->Output('form.pdf', 'I');
    }
}
?>