<?php


class SearchCriteria extends CComponent {
    
    protected $_text = null;
    protected $_limit = null;

    public function __construct() {
        
    }
    
    public function setText($text) {
        $this->_text = $text;
    }
    
    public function getText() {
        return $this->_text;
    }
    
    public function setLimit($limit) {
        $this->_limit = $limit;
    }
    
    public function getLimit() {
        return $this->_limit;
    }
    
    public function notUseText() {
        $this->_text = null;
    }
     
    public function notUseLimit() {
        $this->_limit = null;
    }
    
}
