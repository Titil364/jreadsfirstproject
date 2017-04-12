<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelFSQuestion extends Model{
    private $FSQuestionId;
    private $FSQuestionName;
    
    protected static $object = "FSQuestion";
    protected static $primary = 'FSQuestionId';
    
    public function getFSQuestionId(){return $this->FSQuestionId};
    public function setFSQuestionId($FSQuestionId){$this->FSQuestionId = $FSQuestionId;} 
    
    public function getFSQuestionName(){return $this->FSQuestionName};
    public function setFSQuestionName($FSQuestionName){$this->FSQuestionName = $FSQuestionName;} 

    public function __construct ($FSQuestionId = NULL, $FSQuestionName = NULL){
        if (!is_null($FSQuestionId) && !is_null($FSQuestionName)){
            $this->FSQuestionId = $FSQuestionId;
            $this->FSQuestionName = $FSQuestionName;
        }
    }
}