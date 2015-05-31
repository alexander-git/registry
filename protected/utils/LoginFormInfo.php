<?php

Yii::import('constant.validation.LoginFormConst');
Yii::import('utils.SessionCounter');

class LoginFormInfo {
   
    const INVALID_INPUTS_SESSION_COUNTER_NAME = 'loginFormInvalidInputCounter';
    
    private static $instance = null;
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new LoginFormInfo();
        }
        return self::$instance;
    }
    
    
    public function invalidInputOccured() {
       SessionCounter::inc(self::INVALID_INPUTS_SESSION_COUNTER_NAME); 
    }
    
    public function validInputOccured() {
        SessionCounter::delete(self::INVALID_INPUTS_SESSION_COUNTER_NAME);
    }
    
    public function isNeedShowCaptcha() {
        $numberOfInvalidInputs = SessionCounter::get(self::INVALID_INPUTS_SESSION_COUNTER_NAME);
        if ($numberOfInvalidInputs === 0) {
            return false;
        }
        return $numberOfInvalidInputs >= LoginFormConst::MAX_INVALID_INPUTS_BEFORE_SHOW_CAPTCHA;
    }
    
    private function __construct() {
    
    }
    
}
