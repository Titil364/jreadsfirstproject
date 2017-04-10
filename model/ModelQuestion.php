<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelQuestion extends Model{

	private $questionId;
	private $questionName;
	private $applicationId;
	private $questionTypeId;
	
    protected static $object = "Question";
    protected static $primary = "questionId";
	
    public function getQuestionId(){return $this->questionId;}    
	public function setQuestionId($questionId){$this->questionId = $questionId;}

    public function getQuestionName(){return $this->questionName;} 
	public function setQuestionName($questionName){$this->questionName = $questionName;}
	
    public function getApplicationId(){return $this->applicationId;}
	public function setApplicationId($applicationId){$this->applicationId = $applicationId;}
	
	public function getQestionTypeId(){return $this->questionTypeId;}
	public function setQestionTypeId($questionTypeId){$this->questionTypeId = $questionTypeId;}



    public function __construct($qid, $qn, $aid, $qtid){
        if (!is_null($qid) && !is_null($qn) && !is_null($aid)&& !is_null($qtid)) {
        	$this->questionId = $qid;
        	$this->questionName = $qn;
        	$this->applicationId = aid;
			$this->questionTypeId = qtid;
        }
    }
}

