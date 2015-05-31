<?php

Yii::import('application.helpers.DateFormatHelper');

class DateInCommonTextViewCorrect extends CValidator {
    
    protected function validateAttribute($object, $attribute) { 
        
        if (!DateFormatHelper::checkDateInCommonTextView($object->$attribute) ) {
             $this->addError($object, $attribute, $this->message);
        }  
    }
}