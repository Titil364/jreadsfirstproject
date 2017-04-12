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

            echo "<h2>$taskName</h2>";
            echo $taskDesc;
        
        echo '</div>';
    //displaying questions

    
    $question_array = $questions_array_list[$i];
    
    
for($j=0; $j < count($questions_array);$j++){
                //displaying questions
        echo '<div id="Applic'.$i.'Q'.$j.'" class = "question">'; //question div, id example : "Applic0Q1" for app 0 question 1
        echo "<h3> ";
        echo htmlspecialchars($questions_array[$j]->getQuestionName());
        echo " </h3>";

        
        $qType = $questionType_list[$i][$j]->getQuestionTypeId();
        //var_dump($questionType_list[$i][$j]->getQuestionTypeId());
        //$answers_array = ModelAnswerType::getAnswerTypeByQuestionTypeId($qType->getQuestionTypeId());
        $answers_array = $answers_array_list[$i][$j];
        //diplaying answers
        /*
        foreach($answers_array as $a){
            
        }*/
        if(!is_null($answers_array[0])){
            switch ($answers_array[0]->getAnswerTypeName()){
                case "textarea":
                    echo "<textarea rows=\"5\" cols =\"50\"></textarea>";
                    break;
                /*case "yes" or "no":
                    echo "<input type = \"radio\" name = \"yesno\" value = \"yes\"> Yes <br>";
                    echo "<input type = \"radio\" name = \"yesno\" value = \"no\"> No <br>";
                    break;*/
                default :
                    foreach($answers_array as $a){
                        $answerName = htmlspecialchars($a->getAnswerTypeName());
                        $answerImage = htmlspecialchars($a->getAnswerTypeImage());
                        $questionTypeId = htmlspecialchars($questions_array[$j]->getQestionTypeId());
                        $answerTypeId = htmlspecialchars($a->getAnswerTypeId());
                    
                        echo '<div class = "answerArea">';
                        echo '<label id="'.$answerName .'"><img src="media/'. $answerImage.'.png"></label>';
                        echo '<input type = "radio" name = "question'.$questionTypeId.'" value = "answer'.$answerTypeId.'"> '.$answerName.' <br>';
                        echo '</div>';
                    }
                    break;
            }
            
        }
        
        
      echo '</div>'; //closing current question div  
        
    }
    echo '</div>'; //closing current application div
}
    echo "</div>"; //closing applications div    
echo "</div>";  // closing form div
 ?>
</main>