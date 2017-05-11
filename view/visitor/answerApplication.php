<main>
	
	<?php
		$secureVisitorId = rawurlencode($visitorId);
		$protectedVisitorId = htmlspecialchars($visitorId);
		$secureFormId = rawurldecode($f->getFormId());
		$protectedFormId = htmlspecialchars($f->getFormId());
		
		echo "<input type=\"hidden\" id=\"visitorId\" value=\"$protectedVisitorId\">";
		echo "<input type=\"hidden\" id=\"formId\" value=\"$protectedFormId\">";
		
		$protectedFormName = htmlspecialchars($f->getFormName());
				
		
		if(!$fullDate){
			$protectedDesc = htmlspecialchars($application->getApplicationDescription());
			$img =  htmlspecialchars("media/" . $folder . "/" . $application->getApplicationId() . "Img.png");
		
			$protectedApplicationId = htmlspecialchars($application->getApplicationId());
			$protectedApplicationName = htmlspecialchars($application->getApplicationName());
			$secureApplicationId = rawurlencode($application->getApplicationId());
			echo "<input type=\"hidden\" id=\"applicationId\" value=\"$protectedApplicationId\">";
			echo "<input type=\"hidden\" id=\"pre\" value=\"$pre\">";
			
			
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
			echo '<div id="pre">';
			if($pre == 1){
				echo "PRE Questions";
			}
			if($pre ==0){
				echo "POST Questions";
			}
			echo '</div>';
	
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
		} else {
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
						foreach($application_array as $value){
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
						foreach($application_array as $value){
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
	<?php } ?>
	<button id="submit">Submit my answer</button>

</main>
