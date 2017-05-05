<main>
	
	<?php
		$secureVisitorId = rawurlencode($visitorId);
		$protectedVisitorId = htmlspecialchars($visitorId);
		$secureFormId = rawurldecode($f->getFormId());
		
		echo "<input type=\"hidden\" id=\"visitorId\" value=\"$protectedVisitorId\">";
		
		$protectedFormName = htmlspecialchars($f->getFormName());
		
		$protectedApplicationName = htmlspecialchars($application->getApplicationName());
		$protectedDesc = htmlspecialchars($application->getApplicationDescription());
		$img =  htmlspecialchars("media/" . $folder . "/" . $application->getApplicationId() . "Img.png");
		
		$secureApplicationId = rawurlencode($application->getApplicationId());
		$protectedApplicationId = htmlspecialchars($application->getApplicationId());
		
		echo "<input type=\"hidden\" id=\"applicationId\" value=\"$protectedApplicationId\">";
		echo "<input type=\"hidden\" id=\"post\" value=\"$pre\">";
		
		//center pourra être remplacé par du css
		echo "<center><legend>$protectedFormName</legend></center>";
		
		//Return to the previous page
		echo "<a href=\"index.php?controller=visitor&action=read2&formId=$secureFormId&visitorId=$secureVisitorId\"><button id=\"return\">Return to the previous page</button></a>";
		echo "<center><h1>$protectedApplicationName</h1></center>";
		if(file_exists($img)){
				echo "<img src =\"$img\" >";
		}
		if($protectedDesc != ""){
			echo "<p>$protectedDesc</p>";
		}

		//For each question 
		//question counter
			$i = 0;
		foreach($questions as $q){
			//var_dump($q);
			$protectedQuestionId = htmlspecialchars($q->getQuestionId());
			$protectedQuestionName = htmlspecialchars($q->getQuestionName());
			echo "<div class=\"question\" id=\"$protectedQuestionId\">";
				echo "<h2>$protectedQuestionName</h2>";			
				echo "<div class=\"answerArea\">";
				
				//For each possible answer				
				$ans_array = $question_answers[$i];
				//$ans_array will be an array composed of the different possible answer to the question_answers
				//Therefore, if there is only one element in the tab and if his name is "textarea"
				//a textarea will be displayed
				if(count($ans_array) == 1 && $ans_array[0]['answerTypeName'] == "textarea"){
					$protectedVisitorAnswer = htmlspecialchars($visitorAnswers[$i]->getAnswer());
					echo "<div>";
						echo "<textarea name=\"$protectedQuestionId\">$protectedVisitorAnswer</textarea>";
					echo "</div>";
				}else{
					echo "<input class=\"shortcut\" type=\"radio\" name=\"$protectedQuestionId\" style=\"display:none\">";
					foreach($ans_array as $ans){
						//var_dump($ans);
						$protectedImageName = htmlspecialchars($ans['answerTypeImage']);
						$protectedName = htmlspecialchars($ans['answerTypeName']);
						
						$protectedAnswerId = $protectedQuestionId . $protectedName;
						$checked = ($visitorAnswers[$i]->getAnswer()==$ans['answerTypeName']?"checked":"");
						echo "<div>";
							echo "<input type=\"radio\" name=\"$protectedQuestionId\" value=\"$protectedName\" id=\"$protectedAnswerId\" $checked>";
							echo "<label for=\"$protectedAnswerId\">";
							echo "<img src=\"media/$protectedImageName.png\" class=\"answerIcon\"><div style=\"text-align:center\">$protectedName</div></label>";
						echo "</div>";
					}
				}
				echo "</div>";
			echo "</div>";
			$i++;
		}
	?>
	<button id="submit">Submit my answer</button>
</main>
