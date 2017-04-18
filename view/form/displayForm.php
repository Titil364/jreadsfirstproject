<main>
	<div id="pdf">
<h1>Answer the form</h1>

		   <input type ="button" id="create_pdf" value ="Create PDF">
<?php

	//opening form
	echo '<div id ="form'.$formId.'" class= "formCss">';
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
				$img =  "media/". $application_array[$i]->getApplicationId() . ".png";
	
				echo "<h2>$taskName</h2>";
				echo $taskDesc;
				if (file_exists($img)){
					echo "<img src = $img >";              
				}
				
			
			echo '</div>';
		//displaying questions
	
		
		$question_array = $questions_array_list[$i];
		
	for($j=0; $j < count($question_array);$j++){
					//displaying questions
			echo '<div id="Applic'.$i.'Q'.$j.'" class = "question">'; //question div, id example : "Applic0Q1" for app 0 question 1
			echo "<h3> ";
			echo htmlspecialchars($question_array[$j]->getQuestionName());
			echo " </h3>";
	
			
			$qType = $questionType_list[$i][$j]->getQuestionTypeName();
			//var_dump($questionType_list[$i][$j]->getQuestionTypeId());
			//$answers_array = ModelAnswerType::getAnswerTypeByQuestionTypeId($qType->getQuestionTypeId());
			$answers_array = $answers_array_list[$i][$j];
			//diplaying answers
			/*
			foreach($answers_array as $a){
				
			}*/
			if(!is_null($answers_array[0])){
				switch ($answers_array[0]['answerTypeName']){
					case "textarea":
						echo "<textarea rows=\"5\" cols =\"50\"></textarea>";
						break;
					/*case "yes" or "no":
						echo "<input type = \"radio\" name = \"yesno\" value = \"yes\"> Yes <br>";
						echo "<input type = \"radio\" name = \"yesno\" value = \"no\"> No <br>";
						break;*/
					default :
						$count = 0;
						echo '<div class = "answerArea">';
						foreach($answers_array as $a){
							$answerName = htmlspecialchars($a['answerTypeName']);
							$answerImage = htmlspecialchars($a['answerTypeImage']);
							$questionTypeId = htmlspecialchars($question_array[$j]->getQuestionTypeName());
							$answerTypeId = htmlspecialchars($a['answerTypeId']);
						
							$id = "Applic".$i."question".$j.$answerName;
							//Le nom d'un input radio permet de lier les radio button entre eux
							//Ainsi si le boutton 1 est coché, et que tu coches le boutton 5
							//Le bouton 5 se coche MAIS le boutton 1 se décoche. Principe des radios buttons. 
							$name = "Applic".$i."question".$j;
							echo '<div>';
							echo "<input type =\"radio\" name=\"$name\" value =\"$answerName\" id=\"$id\">" ;
							//Si tu passes par la : les label permettent de link son block à un ID grâce à l'attribut FOR
							//et non en mettant l'attribut ID. Il faut cela dit que le FOR soit associé à l'ID de ton input
							//Le label est de plus la pour entouré du texte ou une image, mettre le nom $answerName en dehors
							//Ne permet pas de cocher la case en cliquant sur le texte. 
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
	<div id="AAtable">
		   <p>
			   Would you like to do these activities again ? Tick a box for each ?
		   </p>
		   <table id="aa">
			   <caption>Again Again table</caption>
			   <thead>
				  <tr>
					  <th></th>
					  <th>Yes</th>
					  <th>Maybe</th>
					  <th>No</th>
				  </tr>
			   </thead>
		   </table>
	   </div>
	   <p></p>
	   <div id="FunSorter">
		   <p>
			   Write the activities in the boxes to show your preferences. The first is an example
		   </p>
		   <table id="fs">
			   <caption>Fun Sorter</caption>
			   <thead>
				  <tr>
					  <th>Newest</th>
					  <?php
						   $i = 0;
						   foreach($applicationTable as $value){
							   echo "<th>".$value->getApplicationName()." : ".$alphabet[$i]."</th>";
							   $i++;
						   }
					  ?>
					  <th>Oldest</th>
				  </tr>
			   </thead>
		   </table>
	   </div>
	   <script src="script/myScriptSheet2.js"></script>
	   <script src="script/html2canvas.min.js"></script>
		<script src="script/jspdf.min.js"></script>
	   </div>
	</div>
	<div>
		   <input type ="button" id="print" value="Printable">
	   </div>
	</div>
</main>
