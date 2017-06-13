<main>

    <h1>Answers Analytics</h1>
    <?php
        $formName = htmlspecialchars($f->getFormName());
        echo '<div class="formCss">';
        echo "<h1> $formName </h1>";
		echo "Answers completed for the from : ";
		echo '2'; //Problem
    
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
                        $k = $j+1;
                        $name = "Applic".$i."Q".$k."pre";
                        $qId = $formId.$name;
                        $total = $allAnswers[$qId]["nb"];
					//displaying questions
			echo '<div id="Applic'.$i.'Q'.$j.'" class = "question">'; //question div, id example : "Applic0Q1" for app 0 question 1
			echo "<h3> ";
			echo htmlspecialchars($questionPre_array[$j]->getQuestionName());
                        echo "    (Answers : ".$total." )";
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

                            echo '<div>';
                            echo '<div>';
							$nb = 0;
						
                            foreach($allAnswers[$qId] as $t){
								if($t["answer"] == $answerName){
									$nb = $t["nbAnswer"];
									break;
								}
                            }
							echo $nb;
							echo '</br>';
							$percentage = ($total!=0)?($nb/$total*100):0; //to avoid division by 0 if nbdy answered
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
                        $k = $j+1;
                        $name = "Applic".$i."Q".$k."post";
                        $qId = $formId.$name;
                        $total = $allAnswers[$qId]["nb"];
					//displaying questions
			echo '<div id="Applic'.$i.'Q'.$j.'" class = "question">'; //question div, id example : "Applic0Q1" for app 0 question 1
			echo "<h3> ";
			echo htmlspecialchars($questionPost_array[$j]->getQuestionName());
                        echo "    (Answers : ".$total." )";
			echo " </h3>";
			$qType = $questionTypePost_list[$i][$j];
			//$answers_array = ModelAnswerType::getAnswerTypeByQuestionTypeId($qType->getQuestionTypeId());
			$answers_array = $answersPost_array_list[$i][$j];
			//diplaying answers
			/*
			foreach($answers_array as $a){
				
			}*/
			if(!is_null($answers_array[0])){
				switch ($answers_array[0]['answerTypeName']){
					case "textarea":
						echo"TextArea, no Analytics available.";
						echo "</textarea>";
						break;
					default :
						echo '<div class = "answerArea">';
						foreach($answers_array as $a){							
                            $answerName = htmlspecialchars($a['answerTypeName']);
                            $answerImage = htmlspecialchars($a['answerTypeImage']);
                            $questionTypeId = htmlspecialchars($questionPost_array[$j]->getQuestionTypeId());
                            $answerTypeId = htmlspecialchars($a['answerTypeId']);
                            
                            $id = "Applic".$i."question".$j.$answerName;

                            echo '<div>';
                            echo '<div>';
							$nb = 0;
							
                            foreach($allAnswers[$qId] as $t){
								if($t["answer"] == $answerName){
									$nb = $t["nbAnswer"];
									break;
								}
                            }
							echo $nb;
							echo '</br>';
							$percentage = ($total!=0)?($nb/$total*100):0; //to avoid division by 0 if nobody answered
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
			   <tbody>
			<?php
				foreach($applicationTable as $at){
					$appliId = $at->getApplicationId();
					$varY = 0;
					$varM = 0;
					$varN = 0;
					//var_dump($appResults);
					foreach($appResults[$appliId] as $aid){					
						if($aid["again"] == "0"){
							$varN+= $aid["nbAnswer"];
						}
						if($aid["again"] == "1"){
							$varM+= $aid["nbAnswer"];
						}
						if($aid["again"] == "2"){
							$varY+= $aid["nbAnswer"];
						}
					}
					$tot =  $varM+$varN+$varY;
                                        
                                        echo '<tr>';
					echo '<td>';
					echo $at->getApplicationName();
                                        echo "    (Answers : ".$tot." )";
					echo '</td>';
                                        
                                        if($tot!=0){
                                            echo '<td>'.$varY;
                                            echo '</br>'.round($varY/$tot*100,2)."%";
                                            echo '</td>';
                                            echo '<td>'.$varM;
                                            echo '</br>'.round($varM/$tot*100,2)."%";
                                            echo '</td>';
                                            echo '<td>'.$varN;
                                            echo '</br>'.round($varN/$tot*100,2)."%";
                                            echo '</td>';
                                            echo '</tr>';
                                        }else{
                                            echo '<td>'.$varY;
                                            echo '</br>'."0%";
                                            echo '</td>';
                                            echo '<td>'.$varM;
                                            echo '</br>'."0%";
                                            echo '</td>';
                                            echo '<td>'.$varN;
                                            echo '</br>'."0%";
                                            echo '</td>';
                                            echo '</tr>';
                                        }

				}
			?>
			   </tbody>
		   </table>
	   </div>
	   <p></p>
</div>
</main>
    
