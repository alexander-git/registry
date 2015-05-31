<?php


class FlashMessageHelper {
    
    public static function setSuccessMessage($message) {
        Yii::app()->user->setFlash('success', $message);
    }
    
    public static function getSuccessMessage() {
        return Yii::app()->user->getFlash('success');      
    }
    
     public static function hasSuccessMessage() {
        return Yii::app()->user->hasFlash('success');      
    }
    
    public static function setErrorMessage($message) {
        Yii::app()->user->setFlash('error', $message);
    }
    
    public static function getErrorMessage() {
        return Yii::app()->user->getFlash('error');      
    }
    
    public static function hasErrorMessage() {
        return Yii::app()->user->hasFlash('error');      
    }
    
    private function __construct() {
    
    }
    
}
