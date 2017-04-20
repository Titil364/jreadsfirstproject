<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelAnswer extends Model{

	private $visitorId;
	private $questionId;
	private $answer;
	
    protected static $object = "Answer";
    protected static $primary = "questionId";
    
    public function getVisitorId(){return $this->visitorId;}
	public function setVisitorId($visitorId){$this->visitorId = $visitorId;}

    public function getQuestionId(){return $this->questionId;}    
	public function setQuestionId($questionId){$this->questionId = $questionId;}

    public function getAnswer(){return $this->answer;}
	public function setAnswer($answer){$this->answer = $answer;}
	
    public function __construct($atId = NULL, $atIm = NULL, $ans = NULL){
        if (!is_null($atId) && !is_null($atIm) && !is_null($ans)){
        	$this->visitorId = $atId;
        	$this->questionId = $atIm;
			$this->answer = $ans;
        }
   }

}

