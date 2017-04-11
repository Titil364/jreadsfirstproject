<header>
<h1>Answer the form.</h1>
<!-- This is supposed to be empty is there are no forms on this account-->
</header> 
<main>


<?php 
//call this view with $f the form to display

$name = htmlspecialchars($f->getFormName());

//displaying form  informations
echo "<h1> $name </h1>";

//displaying tasks

//$task_array  = ModelApplication::getApplicationByFormId($f->getFormID());

for($i=0; $i < count($application_array);$i++){
    //dispalying task informations
    echo"<div id=\"applications\">";
    $taskName = htmlspecialchars($application_array[$i]->getApplicationName());
    $taskDesc = htmlspecialchars($application_array[$i]->getApplicationDescription());
    
    echo "<h2>$taskName</h2>";
    echo $taskDesc;

    
    //displaying questions

    
    $question_array = $questions_array_list[$i];
    
    
for($j=0; $j < count($questions_array);$j++){
                //displaying questions 
        echo "<h3> ";
        echo $questions_array[$j]->getQuestionName();
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
                        echo '<div class = "answerArea">';
                        echo '<label id="'. $a->getAnswerTypeName() .'"><img src="media/'. $a->getAnswerTypeImage().'.png"></label>';
                        echo '<input type = "radio" name = "question'.$questions_array[$j]->getQestionTypeId().'" value = "answer'.$a->getAnswerTypeId().'"> '.$a->getAnswerTypeName().' <br>';
                    }
                    break;
            }
            
        }
        
        
        
        
    }
}
echo "</div>";    

 ?>
</main>