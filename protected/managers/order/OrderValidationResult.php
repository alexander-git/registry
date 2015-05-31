<?php


Yii::import('constant.validation.MakeOrderErrorConst');

class OrderValidationResult extends CComponent {

    protected $_firstnameError = null;
    protected $_surnameError = null;
    protected $_patronymicError = null;
    protected $_phoneError = null;
    protected $_timeError = null;
    protected $_commonError = null;
    
    public function setFirstnameError($value) {
        $this->_firstnameError = $value; 
    }
    
    public function setSurnameError($value) {
        $this->_surnameError = $value; 
    }
    
    public function setPatronymicError($value) {
        $this->_patronymicError = $value; 
    }
    
    public function setPhoneError($value) {
        $this->_phoneError = $value; 
    }
      
    public function setTimeError($value) {
        $this->_timeError = $value; ;
    }
    
    public function setCommonError($value) {
        $this->_commonError =  $value;
    }
    
    public function getFirstnameError() {
        return $this->_firstnameError;
    }
    
    public function getSurnameError() {
        return $this->_surnameError;
    }
    
    public function getPatronymicError() {
        return $this->_patronymicError;
    }
    
    public function getPhoneError() {
        return $this->_phoneError;
    }
    
    public function getTimeError() {
        return $this->_timeError;
    }
    
    public function getCommonError() {
        return $this->_commonError;
    }
    
    public function getHasErrors() {
        return (
            ($this->_firstnameError !== null) ||
            ($this->_surnameError !== null) ||
            ($this->_patronymicError !== null) ||
            ($this->_phoneError !== null) ||
            ($this->_timeError !== null) ||
            ($this->_commonError !== null)
        );
    }
    
    public function setPhoneIsNotCorrectError() {
        $this->_phoneError = MakeOrderErrorConst::PHONE_IS_NOT_CORRECT_MSG;
    }
    
    public function setErrorOnTimeStateIfNeed($timeState) {
        if ($timeState === null) {
            $this->setDefaultCommonError();   
        } else if ($timeState === WorkTime::STATE_BUSY) {
            $this->setTimeError(MakeOrderErrorConst::TIME_IS_BUSY_MSG);      
        } else if ($timeState === WorkTime::STATE_RECORD_IMPOSSIBLE) {
            $this->setTimeError(MakeOrderErrorConst::TIME_RECORD_IMPOSSIBLE_MSG); 
        }
    }
    
    public function setDefaultCommonError() {
        $this->_commonError = MakeOrderErrorConst::COMMON_ERROR_MSG;
    }
    
    public function getErrorsAsArray() {
        if (!$this->getHasErrors() ) {
            return null;
        }
        
        $errors = array();
        if ($this->_firstnameError !== null) {
            $errors['firstname'] = $this->_firstnameError;
        }
        if ($this->_surnameError !== null) {
            $errors['surname'] = $this->_surnameError;
        }
        if ($this->_patronymicError !== null) {
            $errors['patronymic'] = $this->_patronymicError;
        }
        if ($this->_phoneError !== null) {
            $errors['phone'] = $this->_phoneError;
        }
        if ($this->_timeError !== null) {
            $errors['time'] = $this->_timeError;
        }
        if ($this->_commonError !== null) {
            $errors['common']= $this->_commonError; 
        }
        
        return $errors;
    }
    
    public function __construct() {
 
    }
    
}