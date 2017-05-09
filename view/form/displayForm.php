<main>
	<div id="pdf">
<h1>Answer the form</h1>

		   <input type ="button" id="create_pdf" value ="Create PDF">
<?php

	//opening form
	echo '<div id ="form-'.$formId.'" class= "formCss">';
	//call this view with $f the form to display
	
	$formName = htmlspecialchars($f->getFormName());
	
	//displaying form  informations
	echo "<h1> $formName </h1>";
	echo '<input id="visitorId" value="'.$visitorId.'"type="hidden" readonly>';
        
        //displaying fields
        echo '<div id="userInformation">';
        foreach ($field_array as $field){
                $fieldName = htmlspecialchars($field->getPersonnalInformationName());
			if(!$full){
				echo '<div>';
					echo '<label for="field'.$fieldName.'">'.$fieldName.' : </label>';
					echo '<input id="field'.$fieldName.'" name="'.$fieldName.'"  type="text">';
				echo '</div>';
			}else{
				echo'<div>';
				foreach($informationTable as $it){
					if($it->getPersonnalInformationName() == $field->getPersonnalInformationName()){
						$valueInfo = $it->getInformationName();
					}
				}
				/*foreach($answer as $a){
					if($a->getQuestionId() ==$field_array[$j]->getQuestionId()){
						$ret = $a->getAnswer();
					}
				}*/
					echo '<label for="field'.$fieldName.'">'.$fieldName.' : </label>';
					echo '<input id="field'.$fieldName.'" name="'.$fieldName.'"  type="text" value="'.$valueInfo.'"  readonly>';
				echo'</div>';
			}
        }
        echo '</div>';
	
	//displaying tasks
	echo "<h1>Pre Questions</h1>";
	//$task_array  = ModelApplication::getApplicationByFormId($f->getFormID());
	echo"<div id=\"applications\">"; // div of all app
	for($i=0; $i < count($application_array);$i++){
		//dispalying task informations
		echo '<div id="Applic'.$i.'" class="application" >'; // current app div
		
			echo '<div id="Applic'.$i.'Info">'; //app info div
				$taskName = htmlspecialchars($application_array[$i]->getApplicationName());
				$taskDesc = htmlspecialchars($application_array[$i]->getApplicationDescription());
				$img =  "media/" . $folder . "/" . $application_array[$i]->getApplicationId() . "Img.png";
	
				echo "<h2>$taskName</h2>";
				echo $taskDesc;
				if (file_exists($img)){
					echo "<img src = $img >";              
				}
				
			
			echo '</div>';
		//displaying questions
	
		
	$questionPre_array = $questionsPre_array_list[$i];
		
	for($j=0; $j < count($questionPre_array);$j++){
					//displaying questions
			echo '<div id="Applic'.$i.'Q'.$j.'" class = "question">'; //question div, id example : "Applic0Q1" for app 0 question 1
			echo "<h3> ";
			echo htmlspecialchars($questionPre_array[$j]->getQuestionName());
			echo " </h3>";
			$qType = $questionTypePre_list[$i][$j];
			//var_dump($questionType_list[$i][$j]->getQuestionTypeId());
			//$answers_array = ModelAnswerType::getAnswerTypeByQuestionTypeId($qType->getQuestionTypeId());
			$answers_array = $answersPre_array_list[$i][$j];
			//diplaying answers
			/*
			foreach($answers_array as $a){
				
			}*/
			if(!is_null($answers_array[0])){
				switch ($answers_array[0]['answerTypeName']){
					case "textarea":
						if(!$full){
							echo "<textarea rows=\"5\" cols =\"50\"></textarea>";
						}
						else{
							echo "<textarea rows=\"5\" cols =\"50\"readonly>";
							foreach($answer as $a){
								if($a->getQuestionId() ==$questionPre_array[$j]->getQuestionId()){
									echo $a->getAnswer();
								}
							}
						}
						echo "</textarea>";
						break;
					default :
						$count = 0;
						echo '<div class = "answerArea">';
						foreach($answer as $a){
							if($a->getQuestionId() ==$questionPre_array[$j]->getQuestionId()){
								$ret = $a->getAnswer();
							}
						}
						foreach($answers_array as $a){
							if(!$full){
								$answerName = htmlspecialchars($a['answerTypeName']);
								$answerImage = htmlspecialchars($a['answerTypeImage']);
								$questionTypeId = htmlspecialchars($questionPre_array[$j]->getQuestionTypeId());
								$answerTypeId = htmlspecialchars($a['answerTypeId']);
							
								$id = "Applic".$i."question".$j.$answerName;
								$name = "Applic".$i."question".$j;
								echo '<div>';
								echo "<input type =\"radio\" name=\"$name\" value =\"$answerName\" id=\"$id\">" ;
								echo "<label for=\"$id\"><img src=\"media/$answerImage.png\" class=\"answerIcon\">$answerName</label>";    
								echo '</div>';
							}else{
								$answerName = htmlspecialchars($a['answerTypeName']);
								$answerImage = htmlspecialchars($a['answerTypeImage']);
								$questionTypeId = htmlspecialchars($questionPre_array[$j]->getQuestionTypeId());
								$answerTypeId = htmlspecialchars($a['answerTypeId']);
								if($ret == $answerName){
									$id = "Applic".$i."question".$j.$answerName;
									$name = "Applic".$i."question".$j;
									echo '<div>';
									echo "<input type =\"radio\" name=\"$name\" value =\"$answerName\" id=\"$id\" checked readonly>";
									echo "<label for=\"$id\"><img src=\"media/$answerImage.png\" class=\"answerIcon\">$answerName</label>";    
									echo '</div>';
								} else{
									$id = "Applic".$i."question".$j.$answerName;
									$name = "Applic".$i."question".$j;
									echo '<div>';
									echo "<input type =\"radio\" name=\"$name\" value =\"$answerName\" id=\"$id\" disabled readonly>";
									echo "<label for=\"$id\"><img src=\"media/$answerImage.png\" class=\"answerIcon\">$answerName</label>";    
									echo '</div>';
								}
							}
						}
						echo '</div>';
						break;
				}
				
			}
			
			
		  echo '</div>'; //closing current question div  
			
		}
		echo '</div>'; //closing current application div
	}
	echo '</div>'; //Closing pre questions Div
	
	//displaying tasks
	echo "<h1>Post Questions</h1>";
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
					echo "<img src = $img >";              
				}
				
			
			echo '</div>';
		//displaying questions
	
		
	$questionPost_array = $questionsPost_array_list[$i];
		
	for($j=0; $j < count($questionPost_array);$j++){
					//displaying questions
				$idAppli = 'Applic'.$i.'Q'.$j;
			echo '<div id="$idAppli" class = "question">'; //question div, id example : "Applic0Q1" for app 0 question 1
			echo "<h3> ";
			echo htmlspecialchars($questionPost_array[$j]->getQuestionName());
			echo " </h3>";
	
			
			$qType = $questionTypePost_list[$i][$j]->getQuestionTypeName();
			$answers_array = $answersPost_array_list[$i][$j];

			if(!is_null($answers_array[0])){
				switch ($answers_array[0]['answerTypeName']){
					case "textarea":
						echo "<textarea name=\"$idAppli\" rows=\"5\" cols =\"50\"></textarea>";
						break;
					/*case "yes" or "no":
						echo "<input type = \"radio\" name = \"yesno\" value = \"yes\"> Yes <br>";
						echo "<input type = \"radio\" name = \"yesno\" value = \"no\"> No <br>";
						break;*/
					default :
						echo '<div class = "answerArea">';
						foreach($answers_array as $a){
							$answerName = htmlspecialchars($a['answerTypeName']);
							$answerImage = htmlspecialchars($a['answerTypeImage']);
							$questionTypeId = htmlspecialchars($questionPost_array[$j]->getQuestionTypeId());
							$answerTypeId = htmlspecialchars($a['answerTypeId']);
						
							$id = "Applic".$i."question".$j.$answerName;
							$name = "Applic".$i."question".$j;
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
	echo '</div>'; // Closing post question div
	
	echo "<h1 class=\"fsAndAa\">Again again table and Fun Sorter</h1>";
	//$task_array  = ModelApplication::getApplicationByFormId($f->getFormID());
	echo"<div id=\"applications\" class=\"fsAndAa\" >"; // div of all app
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
			<tbody>
			<?php
				for($i = 0; $i<$nb ;$i++){
					$trId = $formId;
					$trId .= "Applic";
					$trId .=  $randomTable[$i]-1;
					echo '<tr id='.$trId.'>';
					echo'<td>';
					echo $application_array[$randomTable[$i]-1]->getApplicationName();
					echo '</td>';
					for($j = 2; $j>=0; $j--){
						echo '<td>';
						echo  '<input type="radio" class="radioButtonFS" name="radio'.$i.'" value = "'.$j.'"';
						foreach($AAFilled as $af){
							if($af->getApplicationId() == $trId && $af->getAgain() == $j){
								echo 'checked';
							}
						}
						echo '>';
						echo '</td>';
					}
					echo '</tr>';
				}
			?>
			</tbody>
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
			<tbody>
			<?php
				for($i = 0; $i<$nbFS ;$i++){
					$alphabeta = $alphabet;
					$f = $FS[$randomFS[$i]-1];
					$name = split("/",$f->getFSQuestionName());
					$nameLeft = $name[0];
					$nameRight = $name[1];
					foreach($FSFilled as $fsf){
						if($fsf->getFSQuestionName() == $f->getFSQuestionName() && $fsf->getApplicationRatingOrder() !=null){
							$alphabeta = str_split($fsf->getApplicationRatingOrder());
						}
					}
					echo '<tr>';
						echo '<td>'.$nameLeft.'</td>';
						$j = 0;
						foreach($applicationTable as $value){
							$divId = "FSmove";
							$divId .= $randomFS[$i]-1;
							echo '<td><div class='.$divId.'>';
							echo $alphabeta[$j];
							echo '</div></td>';
							$j++;
						}
						echo '<td>'.$nameRight.'</td>';
					echo '</tr>';
				}
			?>
			</tbody>
		</table>
	</div>
	<?php
	if(!($full)){
		echo '<div>
			   <input type ="button" id="print" value="Printable">
		</div>';
	}
	?>
	</div>
</main>
