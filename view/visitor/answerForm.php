

<main>
	<div id="pdf">
<?php

	//opening form
	echo '<div id ="form-'.$formId.'" class= "formCss">';
	//call this view with $f the form to display
	
	$formName = htmlspecialchars($f->getFormName());
	
	//displaying form  informations
	echo "<h1> $formName </h1>";
        
        //displaying fields
        echo '<div id="userInformation">';
        foreach ($field_array as $field){
                $fieldName = htmlspecialchars($field->getPersonnalInformationName());
            echo '<div>';
                echo '<label for="field'.$fieldName.'">'.$fieldName.' : </label>';
                echo '<input id="field'.$fieldName.'" name="'.$fieldName.'"  type="text">';
            echo '</div>';
        }
        echo '</div>';
	
	//displaying tasks
	
	//$task_array  = ModelApplication::getApplicationByFormId($f->getFormID());
	echo"<div id=\"applications\">"; // div of all app
	for($i=0; $i < count($application_array);$i++){
		//dispalying task informations
		echo '<div id="Applic'.$i.'" class="application" >'; // current app div
		
			echo '<div id="Applic'.$i.'Info">'; //app info div
				$taskName = htmlspecialchars($application_array[$i]->getApplicationName());
				$taskDesc = htmlspecialchars($application_array[$i]->getApplicationDescription());
				$img =  "media/". $folder ."/". $application_array[$i]->getApplicationId() . ".png";
	
				echo "<h2>$taskName</h2>";
				echo $taskDesc;
				if (file_exists($img)){
					echo "<img src =\"$img\" >";              
				}
				
			
			echo '</div>';
		//displaying questions
	
		
		$question_array = $questionsPre_array_list[$i];
	for($j=0; $j < count($question_array);$j++){
					//displaying questions
				$idAppli = 'Applic'.$i.'Q'.$j;
			echo "<div id=\"$idAppli\" class = \"question\">"; //question div, id example : "Applic0Q1" for app 0 question 1
			echo "<h3> ";
			echo htmlspecialchars($question_array[$j]->getQuestionName());
			echo " </h3>";
	
			
			$qType = $questionTypePre_list[$i][$j]->getQuestionTypeName();
			$answers_array = $answersPre_array_list[$i][$j];

			if(!is_null($answers_array[0])){
				$name = $question_array[$j]->getQuestionId();
				switch ($answers_array[0]['answerTypeName']){
					case "textarea":
						echo "<textarea name=\"$name\" rows=\"5\" cols =\"50\"></textarea>";
						break;
					default :
						echo '<div class = "answerArea">';

						echo "<input class=\"shortcut\" type =\"radio\" name=\"$name\" style=\"display:none\">";
						foreach($answers_array as $a){
							$answerName = htmlspecialchars($a['answerTypeName']);
							$answerImage = htmlspecialchars($a['answerTypeImage']);
							$questionTypeId = htmlspecialchars($question_array[$j]->getQuestionTypeId());
							$answerTypeId = htmlspecialchars($a['answerTypeId']);

							$id = "Applic".$i."question".$j.$answerName;
							echo '<div>';
							echo "<input type =\"radio\" name=\"$name\" value =\"$answerName\" id=\"$id\">" ;
							echo "<label for=\"$id\"><img src=\"media/$answerImage.png\" class=\"answerIcon\">$answerName</label>";    
							echo '</div>';
						}
						echo '</div>';
						break;
				}
				
			}
			
			
		  echo '</div>'; //closing current question div  
			
		}
		echo '</div>'; //closing current application div
	}

 ?>
 
   </div> <!-- applications -->
		</div> <!-- form -->
	</div> <!-- pdf -->
	<input type="submit" value="Submit" id="submit">
</main>
