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
require_once File::build_path(array('model', 'ModelApplication.php'));
$task_array  = ModelApplication::getApplicationByFormId($f->getFormID());

foreach ($task_array as $t)
    //dispalying task informations
    echo"<div id=\"applications\">";
    $taskName = htmlspecialchars($t->getApplicationName());
    $taskDesc = htmlspecialchars($t->getApplicationDescription());
    
    echo "<h2>$taskName</h2>";
    echo $taskDesc;

    
    //displaying questions
    require_once File::build_path(array('model', 'ModelQuestion.php'));
    
    $question_array = ModelQuestion::getQuestionByApplicationId($t->getApplicationId());
    
    foreach ($question_array as $q){
                //displaying questions 
        echo "<h3> ";
        echo $q->getQuestionName();
        echo " </h3>";

        
        $qType = ModelQuestionType::select($q->getQestionTypeId());
        
        require_once File::build_path(array('model', 'ModelAnswerType.php'));
        $answers_array = ModelAnswerType::getAnswerTypeByQuestionTypeId($qType->getQuestionTypeId());
        
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
                        echo '<input type = "radio" name = "question'.$q->getQestionTypeId().'" value = "answer'.$a->getAnswerTypeId().'"> '.$a->getAnswerTypeName().' <br>';
                    }
                    break;
            }
            
        }
        
        
        
        
    }
echo "</div>";    

 ?>
</main>