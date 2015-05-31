<?php

require_once 'OrderValidationResult.php';

class MakeNewOrderResult extends CComponent {
    
    protected $_model;
    protected $_isSuccess;
    protected $_validationResult;
    
    public function __construct($model, $validationResult, $isSuccess) {
        $this->_model = $model;
        $this->_validationResult = $validationResult;
        $this->_isSuccess = $isSuccess;
    }
    
    public function setIsSuccess($isSuccess) {
        $this->_isSuccess = $isSuccess;
    }
    
    public function getIsSuccess() {
        return $this->_isSuccess;
    }
    
    public function setModel($model) {
        $this->_model = $model;
    }
    
    public function getModel() {
        return $this->_model;
    }
    
    public function setValidationResult($validationResult) {
        $this->_validationResult = $validationResult;
    }
    
    public function getValidationResult() {
        return $this->_validationResult;
    }
    
}
