<main>
<h1>Answer the form</h1>

<?php
	//opening form
	echo '<div id ="form'.$formId.'" class= "formCss">';
	//call this view with $f the form to display
	
	$name = htmlspecialchars($f->getFormName());
	
	//displaying form  informations
	echo "<h1> $name </h1>";
	
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
	   <div>
		   <input type ="button" id="print" value="Printable">
	   </div>
	   <script src="script/myScriptSheet2.js"></script>
	   </div>
	</div>

<?php
	require_once('tcpdf_include.php');
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	
	if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		require_once(dirname(__FILE__).'/lang/eng.php');
		$pdf->setLanguageArray($l);
	}
	$pdf->SetFont('helvetica', '', 9);
	$pdf->AddPage();
	$html = '<h1>Example of HTML text flow</h1>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. <em>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur?</em> <em>Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</em><br /><br /><b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i><br /><br /><b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u>';
	$pdf->writeHTML($html, true, 0, true, 0);
	$pdf->lastPage();
	$pdf->Output('example_021.pdf', 'I');
?>
</main>