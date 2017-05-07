<main>

    <h1>Answers Analytics</h1>
    <?php
        $formName = htmlspecialchars($f->getFormName());
        echo "<h1> $formName </h1>";
		echo "Answers completed for the from : ";
		echo $completed;
    
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
						echo '<div class = "answerArea">';
						foreach($answers_array as $a){							
                            $answerName = htmlspecialchars($a['answerTypeName']);
                            $answerImage = htmlspecialchars($a['answerTypeImage']);
                            $questionTypeId = htmlspecialchars($questionPre_array[$j]->getQuestionTypeId());
                            $answerTypeId = htmlspecialchars($a['answerTypeId']);
                            
                            $id = "Applic".$i."question".$j.$answerName;
                            $k = $j+1;
                            $name = "Applic".$i."Q".$k."pre";
							$qId = $formId.$name;
                            echo '<div>';
                            echo '<div>';
							$nb = 0;
							$total = $allAnswers[$qId]["nb"];
                            foreach($allAnswers[$qId] as $t){
								if($t["answer"] == $answerName){
									$nb = $t["nbAnswer"];
									break;
								}
                            }
							echo $nb;
							echo '</br>';
							$percentage = $nb/$total*100;
							echo $percentage."%";
                            echo '</div>';
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
                            $questionTypeId = htmlspecialchars($questionPre_array[$j]->getQuestionTypeId());
                            $answerTypeId = htmlspecialchars($a['answerTypeId']);
                            
							$id = "Applic".$i."question".$j.$answerName;
                            $k = $j+1;
                            $name = "Applic".$i."Q".$k."post";
							$qId = $formId.$name;
                            echo '<div>';
                            echo '<div>';
							$nb = 0;
							$total = $allAnswers[$qId]["nb"];
                            foreach($allAnswers[$qId] as $t){
								if($t["answer"] == $answerName){
									$nb = $t["nbAnswer"];
									break;
								}
                            }
							echo $nb;
							echo '</br>';
							$percentage = $nb/$total*100;
							echo $percentage."%"; 
                            echo '</div>';
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
    ?>
	
	<div id="AAtable">
		   <p>
			   Would you like to do these activities again ? Tick a box for each ?
		   </p>
		   <table id="aa">
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
</main>
    